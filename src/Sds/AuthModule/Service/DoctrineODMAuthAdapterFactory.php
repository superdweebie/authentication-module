<?php
/**
 * @package    Sds
 * @license    MIT
 */
namespace Sds\AuthModule\Service;

use DoctrineModule\Authentication\Adapter\ObjectRepository;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 *
 * @since   1.0
 * @version $Revision$
 * @author  Tim Roediger <superdweebie@gmail.com>
 */
class DoctrineODMAuthAdapterFactory implements FactoryInterface
{
    /**
     *
     * @param \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator
     * @return \DoctrineModule\Authentication\Adapter\DoctrineObjectRepository
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config')['sds']['auth']['user'];
        $documentManager = $serviceLocator->get('doctrine.documentmanager.odm_default');
        $userClass = $config['class'];

        $adapter = new ObjectRepository(array(
            'objectRepository' => $documentManager->getRepository($userClass),
            'identityProperty' => $config['identityProperty'],
            'credentialProperty' => $config['credentialProperty'],
            'credentialCallable' => $config['credentialCallable']
        ));

        return $adapter;
    }
}
