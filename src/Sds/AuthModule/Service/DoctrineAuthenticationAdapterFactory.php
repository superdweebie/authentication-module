<?php
/**
 * @package    Sds
 * @license    MIT
 */
namespace Sds\AuthModule\Service;

use Sds\AuthModule\Authentication\Adapter\DoctrineAdapter;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 *
 * @since   1.0
 * @version $Revision$
 * @author  Tim Roediger <superdweebie@gmail.com>
 */
class DoctrineAuthenticationAdapterFactory implements FactoryInterface
{

    /**
     *
     * @param \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator
     * @return object
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new DoctrineAdapter($serviceLocator->get('doctrine.authenticationadapter.odm_default'));
    }
}