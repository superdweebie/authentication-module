<?php

namespace SdsAuthModuleTest;

use PHPUnit_Framework_TestCase;
use Zend\Mvc\Service\ServiceManagerConfiguration;
use Zend\ServiceManager\ServiceManager;

abstract class BaseTest extends PHPUnit_Framework_TestCase
{

    protected $serviceManager;

    protected static $mvcConfig;

    public function setup(){

        $mvcConfig = $this->getMvcConfig();

        // $configuration is loaded from TestConfiguration.php (or .dist)
        $serviceManager = new ServiceManager(new ServiceManagerConfiguration($mvcConfig['service_manager']));
        $serviceManager->setService('ApplicationConfiguration', $mvcConfig);
        $serviceManager->setAllowOverride(true);


        $this->serviceManager = $serviceManager;

        /** @var $moduleManager \Zend\ModuleManager\ModuleManager */
        $moduleManager = $serviceManager->get('ModuleManager');
        $moduleManager->loadModules();

        $serviceManager->setService('Configuration', $this->alterConfig($serviceManager->get('Configuration')));
    }

    /**
     * @var array $config
     * @return array
     */
    abstract protected function alterConfig(array $config);

    public static function setMvcConfig(array $mvcConfig)
    {
        self::$mvcConfig = $mvcConfig;
    }

    /**
     * @return ServiceManager
     */
    public function getMvcConfig()
    {
    	return self::$mvcConfig;
    }
}
