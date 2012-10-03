<?php

namespace Sds\AuthModule\Test\Service;

use Sds\AuthModule\Service\ViewHelperFactory;
use Sds\ModuleUnitTester\AbstractTest;
use Zend\View\HelperPluginManager;

class ViewHelperFactoryTest extends AbstractTest
{
    public function testWillInstantiateFromFQCN()
    {

        $factory = new ViewHelperFactory;

        $helperManager = new HelperPluginManager();
        $helperManager->setServiceLocator($this->serviceManager);

        $helper = $factory->createService($helperManager);
        $this->assertInstanceOf('Zend\View\Helper\Identity', $helper);
    }
}
