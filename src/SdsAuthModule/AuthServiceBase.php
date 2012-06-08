<?php

namespace SdsAuthModule;

use Zend\Authentication\AuthenticationService as ZfAuthService;

class AuthServiceBase
{
    protected $authenticationService;
    protected $defaultUser;
    
    public function __construct(ZfAuthService $authenticationService, $defaultUser){
        $this->setAuthenticationService($authenticationService);
        $this->setDefaultUser($defaultUser);
    }
    
    public function setAuthenticationService(ZfAuthService $authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }
    
    public function setDefaultUser($defaultUser)
    {
        $this->defaultUser = $defaultUser;
    }
    
    public function getDefaultUser() {
        return $this->defaultUser;
    }    
    
    public function hasIdentity()
    {      
        return $this->authenticationService->hasIdentity();
    }

    public function getIdentity()
    {   
        if(!($identity = $this->authenticationService->getIdentity()))
        {
            return $this->defaultUser;
        } else {
            return $identity;
        }
    }    
}
