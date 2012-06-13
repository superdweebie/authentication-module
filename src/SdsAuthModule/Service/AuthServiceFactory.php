<?php

namespace SdsAuthModule\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use SdsAuthModule\AuthService;

class AuthServiceFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Configuration');
        $config = $config['sdsAuthConfig'];         
        $instance = new AuthService(
            $serviceLocator->get($config['authService']),
            $serviceLocator->get($config['defaultUser']),
            $serviceLocator->get($config['adapter']),
            $config['adapterUsernameMethod'],
            $config['adapterPasswordMethod']            
        );
        if(isset($config['returnDataObject'])){
            $instance->setReturnDataObject($serviceLocator->get($config['returnDataObject']));
            $instance->setReturnDataMethod($config['returnDataMethod']);        
        }
        return $instance;        
    }
}