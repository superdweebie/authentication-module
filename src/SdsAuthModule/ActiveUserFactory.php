<?php

namespace SdsAuthModule;

class ActiveUserFactory
{
    public static function get(AuthServiceBase $authServiceBase)
    {
        return $authServiceBase->getIdentity();
    }
}