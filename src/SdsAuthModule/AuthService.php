<?php

namespace SdsAuthModule;

use Zend\Authentication\AuthenticationService as ZfAuthService,
    Zend\Authentication\Adapter\AdapterInterface as Adapter;

class AuthService
{
    protected $authenticationService;
    protected $adapter;
    protected $guestUser;

    public function setAuthenticationService(ZfAuthService $authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }

    public function setAdapter(Adapter $adapter)
    {       
        $this->adapter = $adapter;   
    }
    
    public function setGuestUser(Identity $guestUser)
    {
        $this->guestUser = $guestUser;
    }
    
    public function hasIdentity()
    {      
        return $this->authenticationService->hasIdentity();
    }

    public function getIdentity()
    {   
        if(!($identity = $this->authenticationService->getIdentity()))
        {
            return $this->guestUser;
        } else {
            return $identity;
        }
    }
    
    public function login($username, $password)
    {
        $this->adapter->setIdentity($username)->setCredential($password);
        $result  = $this->authenticationService->authenticate($this->adapter);
        return $result;
    }

    public function logout()
    {
        if (!$this->authenticationService->hasIdentity()) {
            return;
        }
        $this->authenticationService->clearIdentity();
    }
}
