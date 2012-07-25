<?php
/**
 * @package    Sds
 * @license    MIT
 */
namespace Sds\AuthModule\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 *
 * @since   1.0
 * @version $Revision$
 * @author  Tim Roediger <superdweebie@gmail.com>
 */
class DefaultUserFactory implements FactoryInterface
{

    /**
     *
     * @param \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator
     * @return object
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config')['sds']['auth'];
        $userClass = $config['user']['class'];
        $user = new $userClass();
        $user->setUsername($config['defaultUser']['username']);
        $user->setRoles($config['defaultUser']['roles']);
        return $user;
    }
}