<?php
/**
 * @package    SdsAuthModule
 * @license    MIT
 */
namespace SdsAuthModule;

use Zend\EventManager\Event;
use SdsCommon\ActiveUser\ActiveUserAwareInterface;

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
        return include __DIR__ . '/../../config/module.config.php';
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
                    $instance->setActiveUser($serviceManager->get('sdsAuthModule.activeUser'));
                }
            }
        ;

        $serviceManager->addInitalizer($activeUserInitalizer);
    }

    /**
     *
     * @return array
     */
    public function getServiceConfiguration()
    {
        return array(
            'invokables' => array(
                'doctrine.auth.adapter' => 'DoctrineModule\Authentication\Adapter\DoctrineObjectRepository',
                'sdsAuthModule.defaultUser' => 'SdsAuthModule\Model\DefaultUser',
                'zend.authentication.authenticationService' => 'Zend\Authentication\AuthenticationService',
            ),
            'factories' => array(
                'sdsAuthModule.activeUser'      => 'SdsAuthModule\Service\ActiveUserFactory',
                'sdsAuthModule.authServiceBase' => 'SdsAuthModule\Service\AuthServiceBaseFactory',
                'sdsAuthModule.authService'     => 'SdsAuthModule\Service\AuthServiceFactory',
            )
        );
    }
}