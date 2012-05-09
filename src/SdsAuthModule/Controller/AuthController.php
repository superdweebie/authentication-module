<?php
namespace SdsAuthModule\Controller;

use Zend\Mvc\Controller\ActionController,
    SdsAuthModule\AuthService,   
    Zend\View\Model\JsonModel;


class AuthController extends ActionController
{
    protected $authService;
    protected $activeUser;
    
    public function setAuthService(AuthService $authService)
    {
        $this->authService = $authService;
        return $this;
    }
    
    public function setActiveUser($activeUser)
    {
        $this->activeUser = $activeUser;
        return $this;
    }  
    
    public function loginAction()
    {
        $post = $this->getRequest()->post()->toArray();
        $username = $post['username'];
        $password = $post['password'];
        if($this->activeUser == $this->authService->getGuestUser())
        {
            $result = $this->authService->login($username, $password);
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
        $this->authService->logout();
        return new JsonModel(array(
            'user' => '', 
            'url' => '',
        ));  
    }    
}
