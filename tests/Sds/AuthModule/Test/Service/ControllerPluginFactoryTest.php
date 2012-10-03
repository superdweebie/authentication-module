<?php

namespace Sds\AuthModule\Test\Service;

use Sds\AuthModule\Service\ControllerPluginFactory;
use Sds\ModuleUnitTester\AbstractTest;
use Zend\Mvc\Controller\PluginManager;

class ControllerPluginFactoryTest extends AbstractTest
{
    public function testWillInstantiateFromFQCN()
    {

        $factory = new ControllerPluginFactory;

        $pluginManager = new PluginManager();
        $pluginManager->setServiceLocator($this->serviceManager);

        $plugin = $factory->createService($pluginManager);
        $this->assertInstanceOf('Zend\Mvc\Controller\Plugin\Identity', $plugin);
    }
}
