<?php
$applicationRoot = __DIR__ . '/../../../../';

chdir($applicationRoot);

$loader = require_once('vendor/autoload.php');
$loader->add('Sds\\AuthModule\\Test', __DIR__);
$loader->add('Sds\\ModuleUnitTester', __DIR__ . '/../../../superdweebie/module-unit-tester/lib');

\Sds\ModuleUnitTester\AbstractTest::setServiceConfigPaths(array(
    'config/test.application.config.php',
    'config/application.config.php',
    __DIR__ . '/test.application.config.php.dist'
));