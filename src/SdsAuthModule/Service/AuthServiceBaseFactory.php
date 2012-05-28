<?php

namespace SdsAuthModule\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use SdsAuthModule\AuthServiceBase;

class AuthServiceBaseFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Configuration')['sdsAuthConfig'];         
        $instance = new AuthServiceBase();
        $instance->setAuthenticationService($serviceLocator->get($config['authService']));
        $instance->setGuestUser($serviceLocator->get($config['guestUser']));
        return $instance;        
    }
}