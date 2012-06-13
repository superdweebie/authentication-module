<?php
/**
 * @package    SdsAuthModule
 * @license    MIT
 */
namespace SdsAuthModule;

use Zend\EventManager\Event;
use SdsInitalizerModule\Service\Events as InitalizerEvents;
use Zend\ModuleManager\ModuleManager;
use SdsCommon\ActiveUser\ActiveUserAwareInterface;
use SdsCommon\User\UserInterface;
use Zend\View\Strategy\JsonStrategy;
use Zend\View\Renderer\JsonRenderer;

class Module
{
    public function init(ModuleManager $moduleManager){
        $sharedEvents = $moduleManager->events()->getSharedManager();
        $sharedEvents->attach(
            InitalizerEvents::IDENTIFIER, 
            InitalizerEvents::LOAD_CONTROLLER_LOADER_INITALIZERS, 
            array($this, 'loadInitalizers')
        );
        $sharedEvents->attach(
            InitalizerEvents::IDENTIFIER, 
            InitalizerEvents::LOAD_SERVICE_MANAGER_INITALIZERS, 
            array($this, 'loadInitalizers')
        );        
    }
    
    public function loadInitalizers(Event $e){
        $serviceLocator = $e->getTarget();        
        return array(
            'Auth\ActiveUserAwareInterface' =>
            function ($instance) use ($serviceLocator) {
                if ($instance instanceof ActiveUserAwareInterface){             
                    $instance->setActiveUser($serviceLocator->get('SdsAuthModule\ActiveUser'));
                }
            }             
        );
    }
    
    public function getConfig(){
        return include __DIR__ . '/../../config/module.config.php';
    }
    
    public function onBootstrap(Event $e){
        $app = $e->getParam('application');
        $serviceManager = $app->getServiceManager();
        
        $view = $serviceManager->get('Zend\View\View');
        $view->events()->attach(new JsonStrategy(new JsonRenderer), 100);                  
    } 
    
    public function getServiceConfiguration()
    {
        return array(
            'invokables' => array(
                'Zend\Authentication\AuthenticationService' => 'Zend\Authentication\AuthenticationService'
            ),
            'factories' => array(
                'SdsAuthModule\ActiveUser'      => 'SdsAuthModule\Service\ActiveUserFactory',
                'SdsAuthModule\AuthServiceBase' => 'SdsAuthModule\Service\AuthServiceBaseFactory',
                'SdsAuthModule\AuthService'     => 'SdsAuthModule\Service\AuthServiceFactory',
            )
        );
    }     
}