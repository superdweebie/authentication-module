<?php

namespace SdsAuthModule\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use SdsAuthModule\AuthService;

class AuthServiceFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Configuration')->sds_auth_config;         
        $instance = new AuthService();
        $instance->setAuthenticationService($serviceLocator->get($config['auth_service']));
        $instance->setGuestUser($serviceLocator->get($config['guest_user']));
        $instance->setAdapter($serviceLocator->get($config['adapter']));
        $instance->setAdapterUsernameMethod($config['adapterUsernameMethod']);        
        $instance->setAdapterPasswordMethod($config['adapterPasswordMethod']);               
        return $instance;        
    }
}