<?php
/**
 * @package    SdsAuthModule
 * @license    MIT
 */
namespace Sds\AuthModule;

use Zend\EventManager\Event;
use Sds\Common\User\ActiveUserAwareInterface;

/**
 *
 * @license MIT
 * @link    http://www.doctrine-project.org/
 * @since   0.1.0
 * @author  Tim Roediger <superdweebie@gmail.com>
 */
class Module
{
    /**
     *
     * @return array
     */
    public function getConfig(){
        return include __DIR__ . '/../../../config/module.config.php';
    }

    /**
     *
     * @param \Zend\EventManager\Event $event
     */
    public function onBootstrap(Event $event){
        $app = $event->getTarget();
        $serviceManager = $app->getServiceManager();

        $activeUserInitalizer =
            function ($instance) use ($serviceManager) {
                if ($instance instanceof ActiveUserAwareInterface){
                    $instance->setActiveUser($serviceManager->get('sds.auth.activeUser'));
                }
            }
        ;

        $serviceManager->addInitializer($activeUserInitalizer);
        $serviceManager->get('ControllerLoader')->addInitializer($activeUserInitalizer);
    }

    /**
     *
     * @return array
     */
    public function getServiceConfiguration()
    {
        return array(
            'invokables' => array(
                'sds.auth.defaultUser'                      => 'Sds\AuthModule\Model\DefaultUser',
                'zend.authentication.authenticationService' => 'Zend\Authentication\AuthenticationService',
            ),
            'factories' => array(
                'doctrine.odm.auth.adapter' => 'Sds\AuthModule\Service\DoctrineODMAuthAdapterFactory',
                'sds.auth.activeUser'       => 'Sds\AuthModule\Service\ActiveUserFactory',
                'sds.auth.authServiceBase'  => 'Sds\AuthModule\Service\AuthServiceBaseFactory',
                'sds.auth.authService'      => 'Sds\AuthModule\Service\AuthServiceFactory',
            )
        );
    }
}