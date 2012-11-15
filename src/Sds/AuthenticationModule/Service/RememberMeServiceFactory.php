<?php
/**
 * @package    Sds
 * @license    MIT
 */
namespace Sds\AuthenticationModule\Service;

use Sds\AuthenticationModule\RememberMeService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 *
 * @since   1.0
 * @version $Revision$
 * @author  Tim Roediger <superdweebie@gmail.com>
 */
class RememberMeServiceFactory implements FactoryInterface
{
    /**
     *
     * @param \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator
     * @return \Sds\AuthenticationModule\Adapter\RememberMeAdapter
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {

        $optionsArray = $serviceLocator->get('Config')['sds']['authentication']['rememberMeServiceOptions'];
        if (is_string($optionsArray['documentManager'])){
            $optionsArray['documentManager'] = $serviceLocator->get($optionsArray['documentManager']);
        }

        $rememberMeService =  new RememberMeService($optionsArray);
        $rememberMeService->setRequestHeaders($serviceLocator->get('request')->getHeaders());
        $rememberMeService->setResponseHeaders($serviceLocator->get('response')->getHeaders());

        return $rememberMeService;
    }
}
