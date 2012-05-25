<?php

namespace SdsAuthModule\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use SdsAuthModule\AuthServiceBase;

class AuthServiceBaseFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Configuration')['sds_auth_config'];         
        $instance = new AuthServiceBase();
        $instance->setAuthenticationService($serviceLocator->get($config['auth_service']));
        $instance->setGuestUser($serviceLocator->get($config['guest_user']));
        return $instance;        
    }
}