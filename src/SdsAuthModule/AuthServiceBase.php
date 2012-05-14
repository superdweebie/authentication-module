<?php

namespace SdsAuthModule;

use Zend\Authentication\AuthenticationService as ZfAuthService;

class AuthServiceBase
{
    protected $authenticationService;
    protected $guestUser;
    
    public function setAuthenticationService(ZfAuthService $authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }
    
    public function setGuestUser($guestUser)
    {
        $this->guestUser = $guestUser;
    }
    
    public function getGuestUser() {
        return $this->guestUser;
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
}
