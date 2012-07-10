<?php

namespace Sds\AuthModule\Test;

use PHPUnit_Framework_TestCase;
use Zend\ModuleManager\ModuleEvent;
use Zend\Mvc\Service\ServiceManagerConfiguration;
use Zend\ServiceManager\ServiceManager;

abstract class BaseTest extends PHPUnit_Framework_TestCase
{

    protected $serviceManager;

    protected static $serviceConfig;

    public function setup(){

        $serviceConfig = $this->getServiceConfig();

        // $configuration is loaded from TestConfiguration.php (or .dist)
        $serviceManager = new ServiceManager(new ServiceManagerConfiguration($serviceConfig['service_manager']));
        $serviceManager->setService('ApplicationConfiguration', $serviceConfig);
        $serviceManager->setAllowOverride(true);


        $this->serviceManager = $serviceManager;

        /** @var $moduleManager \Zend\ModuleManager\ModuleManager */
        $moduleManager = $serviceManager->get('ModuleManager');
        $eventManager = $moduleManager->getEventManager();
        $eventManager->attach(ModuleEvent::EVENT_LOAD_MODULES_POST, array($this, 'onLoadModulesPost'));

        $moduleManager->loadModules();

        $serviceManager->get('Application')->bootstrap();
    }

    public function onLoadModulesPost(ModuleEvent $event){
        $serviceLocator = $event->getParam('ServiceManager');
        $config = $serviceLocator->get('Configuration');
        $serviceLocator->setService('Configuration', $this->alterConfig($config));
    }

    /**
     * @var array $config
     * @return array
     */
    abstract protected function alterConfig(array $config);

    public static function setServiceConfig(array $serviceConfig)
    {
        self::$serviceConfig = $serviceConfig;
    }

    /**
     * @return ServiceManager
     */
    public function getServiceConfig()
    {
    	return self::$serviceConfig;
    }
}
