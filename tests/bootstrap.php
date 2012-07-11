<?php
$loader = require_once('vendor/autoload.php');
$loader->add('Sds\\AuthModule\\Test', __DIR__);
$loader->add('Sds\\ModuleUnitTester', __DIR__ . '/../../../superdweeibe/module-base-test/lib');

\Sds\ModuleUnitTester\Util::checkStructure();
\Sds\ModuleUnitTester\BaseTest::setServiceConfigPaths(array(
    __DIR__ . '/TestConfiguration.php',
    __DIR__ . '/TestConfiguration.php.dist'
));