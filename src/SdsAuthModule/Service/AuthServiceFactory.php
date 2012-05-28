<?php

namespace SdsAuthModule\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use SdsAuthModule\AuthService;

class AuthServiceFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Configuration')['sdsAuthConfig'];         
        $instance = new AuthService();
        $instance->setAuthenticationService($serviceLocator->get($config['authService']));
        $instance->setGuestUser($serviceLocator->get($config['guestUser']));
        $instance->setAdapter($serviceLocator->get($config['adapter']));
        $instance->setAdapterUsernameMethod($config['adapterUsernameMethod']);        
        $instance->setAdapterPasswordMethod($config['adapterPasswordMethod']); 
        if(isset($config['returnDataObject'])){
            $instance->setReturnDataObject($serviceLocator->get($config['returnDataObject']));
            $instance->setReturnDataMethod($config['returnDataMethod']);        
        }
        return $instance;        
    }
}