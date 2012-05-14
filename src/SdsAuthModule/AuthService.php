<?php

namespace SdsAuthModule;

use Zend\Authentication\AuthenticationService as ZfAuthService,
    Zend\Authentication\Adapter\AdapterInterface as Adapter;

class AuthService extends AuthServiceBase
{
    protected $adapter;
    protected $adapterUsernameMethod;
    protected $adapterPasswordMethod;

    public function setAdapter(Adapter $adapter)
    {       
        $this->adapter = $adapter;   
    }
    
    public function getAdapter() {
        return $this->adapter;
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

