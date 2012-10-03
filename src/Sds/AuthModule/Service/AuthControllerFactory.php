<?php
/**
 * @package    Sds
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
        $serviceLocator = $serviceLocator->getServiceLocator();

        $config = $serviceLocator->get('Config')['sds']['auth'];
        $authController = new AuthController;
        $authController->setAuthenticationService($serviceLocator->get($config['authenticationService']));

        $serializer = $config['serializer'];
        if (is_string($serializer)) {
            $serializer = $serviceLocator->get($serializer);
        }
        $authController->setSerializer($serializer);

        return $authController;
    }
}
