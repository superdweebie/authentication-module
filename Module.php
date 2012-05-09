<?php

namespace SdsAuthModule;

use Zend\Module\Manager,
    Zend\EventManager\StaticEventManager,
    Zend\Module\Consumer\AutoloaderProvider;

class Module implements AutoloaderProvider
{
    public function init(Manager $moduleManager)
    {
        $events = $moduleManager->events();
        $sharedEvents = $events->getSharedCollections();
        $sharedEvents->attach('bootstrap', 'bootstrap', array($this, 'initializeView'), 100);
    }
    
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
    
    public function initializeView($e)
    {
        $app = $e->getParam('application');
        $locator = $app->getLocator();
        
        $view = $locator->get('Zend\View\View');
        $jsonStrategy = $locator->get('Zend\View\Strategy\JsonStrategy');
        $view->events()->attach($jsonStrategy, 100);                  
    }    
}