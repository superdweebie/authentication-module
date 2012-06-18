<?php

namespace SdsAuthModule;

use Zend\Authentication\AuthenticationService as ZfAuthService;
use Zend\Authentication\Adapter\AdapterInterface as Adapter;

class AuthService extends AuthServiceBase
{
    protected $adapter;
    protected $adapterUsernameMethod;
    protected $adapterPasswordMethod;

    /**
     * @var object
     */       
    protected $returnDataObject;

    /**
     * @var string
     */       
    protected $returnDataMethod;
    
    public function __construct(
        ZfAuthService $authenticationService, 
        $defaultUser,
        Adapter $adapter,
        $adapterUsernameMethod,
        $adapterPasswordMethod
    ){
        parent::__construct($authenticationService, $defaultUser);
        $this->setAdapter($adapter);
        $this->setAdapterUsernameMethod($adapterUsernameMethod);
        $this->setAdapterPasswordMethod($adapterPasswordMethod);
    }
    
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
        $this->adapterUsernameMethod = (string) $adapterUsernameMethod;
    }

    public function getAdapterPasswordMethod() {
        return $this->adapterPasswordMethod;
    }

    public function setAdapterPasswordMethod($adapterPasswordMethod) {
        $this->adapterPasswordMethod = (string) $adapterPasswordMethod;
    }
    
    public function getReturnDataObject() {
        return $this->returnDataObject;
    }

    public function getReturnDataMethod() {
        return $this->returnDataMethod;
    }
    
    public function setReturnDataObject($returnDataObject) {
        $this->returnDataObject = $returnDataObject;
    }

    public function setReturnDataMethod($returnDataMethod) {
        $this->returnDataMethod = $returnDataMethod;
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

