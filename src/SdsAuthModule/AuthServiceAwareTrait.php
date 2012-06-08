<?php

namespace SdsAuthModule;

trait AuthServiceAwareTrait {

    protected $authService;

    public function setAuthService(AuthService $authService){
        $this->authService = $authService;
    }    
}