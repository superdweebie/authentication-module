<?php

namespace SdsAuthModule\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use SdsAuthModule\AuthServiceBase;

class AuthServiceBaseFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Configuration');
        $config = $config['sdsAuthConfig'];         
        $instance = new AuthServiceBase(
            $serviceLocator->get($config['authService']),
            $serviceLocator->get($config['guestUser'])            
        );
        return $instance;        
    }
}