<?php

namespace SdsAuthModule;

interface AuthServiceAwareInterface{
    
    public function setAuthService(AuthService $authService);
}
