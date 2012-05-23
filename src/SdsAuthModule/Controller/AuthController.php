<?php
namespace SdsAuthModule\Controller;

use Zend\Mvc\Controller\ActionController;
use SdsAuthModule\Controller\Behaviour\ActiveUser;
use SdsAuthModule\Controller\Behaviour\AuthService;
use Zend\View\Model\JsonModel;


class AuthController extends ActionController
{
    use ActiveUser;
    use AuthService;
    
    public function loginAction()
    {
        $post = $this->getRequest()->post()->toArray();
        $username = $post['username'];
        $password = $post['password'];
        if($this->getActiveUser() == $this->getAuthService()->getGuestUser())
        {
            $result = $this->getAuthService()->login($username, $password);
            if ($result->isValid())
            {
                return new JsonModel(array(
                    'user' => $result->getIdentity()->jsonSerialize(), 
                    'url' => '',
                    //'preloadData' => 
                ));
            } else {
                $this->getResponse()->setStatusCode(500);
                return new JsonModel(array('message' => implode('. ', $result->getMessages())));                
            }
        }
        $this->getResponse()->setStatusCode(500);
        return new JsonModel(array('message' => 'You are aready logged in'));
    }
    
    public function logoutAction()
    {
        $this->getAuthService()->logout();
        return new JsonModel(array(
            'user' => '', 
            'url' => '',
        ));  
    }    
}
