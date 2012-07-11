<?php
/**
 * @package    SdsAuthModule
 * @license    MIT
 */
namespace Sds\AuthModule\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Sds\AuthModule\Controller\AuthController;

/**
 *
 * @since   1.0
 * @version $Revision$
 * @author  Tim Roediger <superdweebie@gmail.com>
 */
class AuthControllerFactory implements FactoryInterface
{
    /**
     *
     * @param \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator
     * @return \SdsAuthModule\Controller\AuthController
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $authController = new AuthController;
        $authController->setActiveUser($serviceLocator->get('sds.auth.activeUser'));
        $authController->setAuthService($serviceLocator->get('sds.auth.authService'));

        $serializerCallable = $serviceLocator->get('configuration')['sds']['auth']['serializerCallable'];
        if (!is_callable($serializerCallable)) {
            $serializerCallable[0] = $serviceLocator->get($serializerCallable[0]);
        }
        $authController->setSerializerCallable($serializerCallable);

        return $authController;
    }
}
