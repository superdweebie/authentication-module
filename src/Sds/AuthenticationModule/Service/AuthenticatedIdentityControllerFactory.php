<?php
/**
 * @package    Sds
 * @license    MIT
 */

namespace Sds\AuthenticationModule\Service;

use Sds\AuthenticationModule\Controller\AuthenticatedIdentityController;
use Sds\AuthenticationModule\Options\AuthenticatedIdentityController as Options;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 *
 * @since   1.0
 * @version $Revision$
 * @author  Tim Roediger <superdweebie@gmail.com>
 */
class AuthenticatedIdentityControllerFactory implements FactoryInterface
{

    /**
     *
     * @param \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator
     * @return object
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {

        $options = new Options($serviceLocator->getServiceLocator()->get('config')['sds']['authentication']['authenticatedIdentityControllerOptions']);
        $options->setServiceLocator($serviceLocator->getServiceLocator());
        $instance = new AuthenticatedIdentityController($options);
        return $instance;
    }
}
