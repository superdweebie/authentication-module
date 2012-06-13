<?php
/**
 * @package    SdsAuthModule
 * @license    MIT
 */
namespace SdsAuthModule\Controller;

use SdsJsonRpcModule\Controller\JsonRpcController;
use SdsCommon\ActiveUser\ActiveUserAwareInterface;
use SdsCommon\ActiveUser\ActiveUserAwareTrait;
use SdsAuthModule\AuthServiceAwareInterface;
use SdsAuthModule\AuthServiceAwareTrait;
use SdsAuthModule\Events;
use Zend\View\Model\JsonModel;

/**
 * Controller to handle login and logout actions
 * 
 * @since   1.0
 * @version $Revision$
 * @author  Tim Roediger <superdweebie@gmail.com>
 */
class AuthController extends JsonRpcController implements ActiveUserAwareInterface, AuthServiceAwareInterface
{
    
    use ActiveUserAwareTrait;
    use AuthServiceAwareTrait;
    
    public function registerRpcMethods(){
        return array(
            'login', 
            'logout', 
            'recoverPassword', 
            'register'
        );
    }

    /**
     * Checks the provided username and password against the authService and 
     * returns the active user
     *
     * @param string $username
     * @param string $password
     * @return object
     */      
    public function login($username, $password)
    {
        if($this->activeUser != $this->authService->getDefaultUser()){
            $this->getResponse()->setStatusCode(500);
            return array('message' => 'You are aready logged in');
        }
        $result = $this->authService->login($username, $password);
        if (!$result->isValid()){
            $this->getResponse()->setStatusCode(500);
            return array('message' => implode('. ', $result->getMessages()));                
        }            

        $activeUser = $result->getIdentity();
        $this->events->addIdentifiers(array(Events::IDENTIFIER));
        $collection = $this->events->trigger(Events::LOGIN, $activeUser);
        $data = array();
        foreach($collection as $response){
            $data = array_merge($data, $response);            
        }
        
        return array(
            'user' => $activeUser->jsonSerialize(),                    
            'data' => json_encode($data)
        );
    }
    
    /**
     * Clears the active user
     *
     * @return object
     */     
    public function logout()
    {
        $this->authService->logout();
        return array(
            'user' => '', 
            'url' => '',
        );  
    }  
    
    /**
     *
     * @param string $username
     * @param string $email
     * @return object
     */       
    public function recoverPassword($username = null, $email = null){

    }
    
    /**
     *
     * @param string $username
     * @param array $details
     * @return object
     */       
    public function register($username, array $details){
        
    }    
}
