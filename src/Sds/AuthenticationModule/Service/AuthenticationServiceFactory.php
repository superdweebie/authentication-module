<?php
/**
 * @package    Sds
 * @license    MIT
 */
namespace Sds\AuthenticationModule\Service;

use Sds\AuthenticationModule\AuthenticationService;
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
        $optionsArray = $serviceLocator->get('config')['sds']['authentication']['authenticationServiceOptions'];

        if (is_string($optionsArray['perSessionStorage'])){
            $optionsArray['perSessionStorage'] = $serviceLocator->get($optionsArray['perSessionStorage']);
        }

        if (is_string($optionsArray['perSessionAdapter'])){
            $optionsArray['perSessionAdapter'] = $serviceLocator->get($optionsArray['perSessionAdapter']);
        }

        if (is_string($optionsArray['perRequestAdapter'])){
            $optionsArray['perRequestAdapter'] = $serviceLocator->get($optionsArray['perRequestAdapter']);
        }

        if (is_string($optionsArray['rememberMeService'])){
            $optionsArray['rememberMeService'] = $serviceLocator->get($optionsArray['rememberMeService']);
        }

        $return = new AuthenticationService();
        $return->setOptions($optionsArray);

        return $return;
    }
}
