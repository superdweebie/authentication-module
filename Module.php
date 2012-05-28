<?php
/**
 * @package    SdsAuthModule
 * @license    MIT
 */
namespace SdsAuthModule;

use Zend\EventManager\Event;

class Module
{
    public function getConfig(){
        return include __DIR__ . '/config/module.config.php';
    }
    
    public function onBootstrap(Event $e){
        $app = $e->getParam('application');
        $serviceManager = $app->getServiceManager();
        
        $view = $serviceManager->get('Zend\View\View');
        $jsonStrategy = $serviceManager->get('di')->get('Zend\View\Strategy\JsonStrategy');
        $view->events()->attach($jsonStrategy, 100);                  
    } 
    
    public function getServiceConfiguration()
    {
        return array(
            'invokables' => array(
                //TODO:: Remove these when sm mvc integration is complete
                'zendauthenticationauthenticationservice' => 'Zend\Authentication\AuthenticationService'
            ),
            'factories' => array(
                'activeUser'                 => 'SdsAuthModule\Service\ActiveUserFactory',
                'SdsAuthModule\AuthServiceBase' => 'SdsAuthModule\Service\AuthServiceBaseFactory',
                'SdsAuthModule\AuthService' => 'SdsAuthModule\Service\AuthServiceFactory',                
            )
        );
    }     
}