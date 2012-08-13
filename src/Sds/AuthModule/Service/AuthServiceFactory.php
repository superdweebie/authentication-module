<?php
/**
 * @package    SdsAuthModule
 * @license    MIT
 */
namespace Sds\AuthModule\Service;

use Sds\AuthModule\AuthService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 *
 * @since   1.0
 * @version $Revision$
 * @author  Tim Roediger <superdweebie@gmail.com>
 */
class AuthServiceFactory implements FactoryInterface
{
    /**
     *
     * @param \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator
     * @return \SdsAuthModule\AuthService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config')['sds']['auth'];
$adapter = $serviceLocator->get($config['adapter']);
        $instance = new AuthService(
            $serviceLocator->get($config['authService']),
            $serviceLocator->get('sds.auth.defaultUser'),
            $serviceLocator->get($config['adapter'])
        );
        return $instance;
    }
}