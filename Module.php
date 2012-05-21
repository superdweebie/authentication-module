<?php

namespace SdsAuthModule;

use Zend\ModuleManager\ModuleManager,
    Zend\ModuleManager\Feature\ConfigProviderInterface,
    Zend\ModuleManager\Feature\BootstrapListenerInterface,
    Zend\EventManager\Event;

class Module implements ConfigProviderInterface, BootstrapListenerInterface
{
    public function getConfig(){
        return include __DIR__ . '/config/module.config.php';
    }
    
    public function onBootstrap(Event $e){
        $app = $e->getParam('application');
        $locator = $app->getLocator();
        
        $view = $locator->get('Zend\View\View');
        $jsonStrategy = $locator->get('Zend\View\Strategy\JsonStrategy');
        $view->events()->attach($jsonStrategy, 100);                  
    }    
}