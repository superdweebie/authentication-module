<?php
/**
 * @package    Sds
 * @license    MIT
 */
namespace Sds\AuthenticationModule\Service;

use Sds\AuthenticationModule\HttpResolver;
use Sds\AuthenticationModule\HttpAdapter;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 *
 * @since   1.0
 * @version $Revision$
 * @author  Tim Roediger <superdweebie@gmail.com>
 */
class HttpAdapterServiceFactory implements FactoryInterface
{
    /**
     *
     * @param \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator
     * @return \Zend\Authentication\AuthenticationService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {

        $return = new HttpAdapter([
            'realm' => 'sds',
            'accept_schemes' => 'basic'
        ]);
        $return->setRequest($serviceLocator->get('request'));
        $return->setResponse($serviceLocator->get('response'));
        $return->setBasicResolver(new HttpResolver(
            $serviceLocator->get($serviceLocator->get('config')['sds']['authentication']['authenticationServiceOptions']['perSessionAdapter'])
        ));

        return $return;
    }
}
