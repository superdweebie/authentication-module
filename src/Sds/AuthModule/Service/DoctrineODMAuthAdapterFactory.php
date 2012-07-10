<?php
/**
 * @package    Sds
 * @license    MIT
 */
namespace Sds\AuthModule\Service;

use DoctrineModule\Authentication\Adapter\DoctrineObjectRepository;
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
        $config = $serviceLocator->get('Configuration')['sds']['auth'];
        $documentManager = $serviceLocator->get('doctrine.documentmanager.odm_default');
        $userClass = $config['userClass'];

        return new DoctrineObjectRepository(
            $documentManager->getRepository($userClass),
            $userClass
        );
    }
}
