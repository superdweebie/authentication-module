<?php
/**
 * @package    Sds
 * @license    MIT
 */
namespace Sds\AuthModule\Service;

use Sds\AuthModule\AuthenticationService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 *
 * @since   1.0
 * @version $Revision$
 * @author  Tim Roediger <superdweebie@gmail.com>
 */
class AuthenticationServiceFactory implements FactoryInterface
{
    /**
     *
     * @param \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator
     * @return \Zend\Authentication\AuthenticationService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('config')['sds']['auth'];

        if (is_string($config['authenticationStorage'])){
            $storage = $serviceLocator->get($config['authenticationStorage']);
        } else {
            $storage = $config['authenticationStorage'];
        }

        if (is_string($config['authenticationAdapter'])){
            $adapter = $serviceLocator->get($config['authenticationAdapter']);
        } else {
            $adapter = $config['authenticationAdapter'];
        }

        return new AuthenticationService($storage, $adapter);
    }
}
