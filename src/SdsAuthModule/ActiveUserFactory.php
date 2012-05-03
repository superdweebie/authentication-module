<?php

namespace SdsAuthModule;

class ActiveUserFactory
{
    public static function get(AuthService $authService)
    {
        return $authService->getIdentity();
    }
}
