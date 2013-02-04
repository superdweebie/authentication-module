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
        $options = $serviceLocator->get('config')['sds']['authentication']['authenticationServiceOptions'];

        if (
            $options['enableGuestIdentity'] &&
            is_string($options['guestIdentity'])
        ){
            $options['guestIdentity'] = $serviceLocator->get($options['guestIdentity']);
        } else {
            unset($options['guestIdentity']);
        }

        if ($options['enablePerSession']){
            if (is_string($options['perSessionStorage'])){
                $options['perSessionStorage'] = $serviceLocator->get($options['perSessionStorage']);
            }
            if (is_string($options['perSessionAdapter'])){
                $options['perSessionAdapter'] = $serviceLocator->get($options['perSessionAdapter']);
            }
        } else {
            unset($options['perSessionStorage']);
            unset($options['perSessionAdapter']);
        }

        if (
            $options['enablePerRequest'] &&
            is_string($options['perRequestAdapter'])
        ){
            $options['perRequestAdapter'] = $serviceLocator->get($options['perRequestAdapter']);
        } else {
            unset($options['perRequestAdapter']);
        }


        if (
            $options['enableRememberMe'] &&
            is_string($options['rememberMeService'])
        ){
            $options['rememberMeService'] = $serviceLocator->get($options['rememberMeService']);
        } else {
            unset($options['rememberMeService']);
        }

        $return = new AuthenticationService();
        $return->setOptions($options);

        return $return;
    }
}
