<?php
/**
 * @package    Sds
 * @license    MIT
 */

namespace Sds\AuthModule\Service;

use Zend\View\Helper\Identity;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Factory to create view helper that can fetch the authenticated identity.
 *
 * @since   1.0
 * @version $Revision$
 * @author  Tim Roediger <superdweebie@gmail.com>
 */
class ViewHelperFactory implements FactoryInterface
{
    /**
     *
     * @param \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator
     * @return \Zend\View\Helper\Identity
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $serviceLocator = $serviceLocator->getServiceLocator();
        $config = $serviceLocator->get('config')['sds']['auth'];
        $helper = new Identity;
        $helper->setAuthenticationService($serviceLocator->get($config['authenticationService']));
        return $helper;
    }
}
