<?php
/**
 * @package    SdsAuthModule
 * @license    MIT
 */
namespace Sds\AuthModule\Service;

use Sds\AuthModule\AuthServiceBase;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 *
 * @since   1.0
 * @version $Revision$
 * @author  Tim Roediger <superdweebie@gmail.com>
 */
class AuthServiceBaseFactory implements FactoryInterface
{
    /**
     *
     * @param \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator
     * @return \SdsAuthModule\AuthServiceBase
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Configuration')['sdsAuth'];
        $instance = new AuthServiceBase(
            $serviceLocator->get($config['authService']),
            $serviceLocator->get($config['defaultUser'])
        );
        return $instance;
    }
}