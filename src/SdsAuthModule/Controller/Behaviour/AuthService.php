<?php

namespace SdsAuthModule\Controller\Behaviour;

trait AuthService {

    protected $authService;
        
    protected function getAuthService(){
        if(!$this->authService){
            $this->authService = $this->locator->get('SdsAuthModule\AuthService');            
        }
        return $this->authService;
    }
}