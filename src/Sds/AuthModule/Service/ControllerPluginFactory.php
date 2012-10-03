<?php
/**
 * @package    Sds
 * @license    MIT
 */

namespace Sds\AuthModule\Service;

use Zend\Mvc\Controller\Plugin\Identity;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Factory to create controller plugin that can fetch the authenticated identity.
 *
 * @since   1.0
 * @version $Revision$
 * @author  Tim Roediger <superdweebie@gmail.com>
 */
class ControllerPluginFactory implements FactoryInterface
{
    /**
     *
     * @param \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator
     * @return \Zend\Mvc\Controller\Plugin\Identity
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $serviceLocator = $serviceLocator->getServiceLocator();
        $config = $serviceLocator->get('config')['sds']['auth'];
        $plugin = new Identity;
        $plugin->setAuthenticationService($serviceLocator->get($config['authenticationService']));
        return $plugin;
    }
}
