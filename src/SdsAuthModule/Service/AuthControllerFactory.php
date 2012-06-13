<?php

namespace SdsAuthModule\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use SdsAuthModule\Controller\AuthController;

class AuthControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {      
        $authController = new AuthController;
        $authController->setAuthService($serviceLocator->get('SdsAuthModule\AuthService'));
        return $authController;        
    }
}
