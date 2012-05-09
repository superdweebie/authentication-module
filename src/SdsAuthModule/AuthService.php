<?php

namespace SdsAuthModule;

use Zend\Authentication\AuthenticationService as ZfAuthService,
    Zend\Authentication\Adapter\AdapterInterface as Adapter;

class AuthService
{
    protected $authenticationService;
    protected $adapter;
    protected $guestUser;
    protected $adapterUsernameMethod;
    protected $adapterPasswordMethod;
    
    public function setAuthenticationService(ZfAuthService $authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }

    public function setAdapter(Adapter $adapter)
    {       
        $this->adapter = $adapter;   
    }
    
    public function getAdapter() {
        return $this->adapter;
    }
    
    public function setGuestUser($guestUser)
    {
        $this->guestUser = $guestUser;
    }
    
    public function getGuestUser() {
        return $this->guestUser;
    }
    
    public function getAdapterUsernameMethod() {
        return $this->adapterUsernameMethod;
    }

    public function setAdapterUsernameMethod($adapterUsernameMethod) {
        $this->adapterUsernameMethod = $adapterUsernameMethod;
    }

    public function getAdapterPasswordMethod() {
        return $this->adapterPasswordMethod;
    }

    public function setAdapterPasswordMethod($adapterPasswordMethod) {
        $this->adapterPasswordMethod = $adapterPasswordMethod;
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
        $adapter = $this->adapter;
        $adapter->{$this->adapterUsernameMethod}($username);
        $adapter->{$this->adapterPasswordMethod}($password);
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
