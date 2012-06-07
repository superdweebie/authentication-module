<?php
/**
 * @package    SdsAuthModule
 * @license    MIT
 */
namespace SdsAuthModule\Controller;

use SdsJsonRpcModule\Controller\JsonRpcController;
use SdsAuthModule\Controller\Behaviour\ActiveUser;
use SdsAuthModule\Controller\Behaviour\AuthService;
use Zend\View\Model\JsonModel;

/**
 * Controller to handle login and logout actions
 * 
 * @since   1.0
 * @version $Revision$
 * @author  Tim Roediger <superdweebie@gmail.com>
 */
class AuthController extends JsonRpcController
{
    
    use ActiveUser;
    use AuthService;
    
    /**
     * Checks the provided username and password against the authService and 
     * returns the active user
     *
     * @return \Zend\View\Model\JsonModel
     * @rpc
     */      
    public function login()
    {
        $request = $this->getRequest();
        $post = $request->post()->toArray();
        
        $username = $post['username'];
        $password = $post['password'];
        if($this->getActiveUser() == $this->getAuthService()->getGuestUser())
        {
            $result = $this->getAuthService()->login($username, $password);
            if ($result->isValid())
            {
                $data = null;
                if (isset($this->returnDataObject)){
                    $data = $this->returnDataObject->{$this->returnDataMethod}();
                }
                return new JsonModel(array(
                    'user' => $result->getIdentity()->jsonSerialize(),                    
                    'data' => $data
                ));
            } else {
                $this->getResponse()->setStatusCode(500);
                return new JsonModel(array('message' => implode('. ', $result->getMessages())));                
            }
        }
        $this->getResponse()->setStatusCode(500);
        return new JsonModel(array('message' => 'You are aready logged in'));
    }
    
    /**
     * Clears the active user
     *
     * @return \Zend\View\Model\JsonModel
     * @rpc
     */     
    public function logout()
    {
        $this->getAuthService()->logout();
        return new JsonModel(array(
            'user' => '', 
            'url' => '',
        ));  
    }    
}
