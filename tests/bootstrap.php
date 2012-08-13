<?php
$applicationRoot = __DIR__ . '/../../../../';

chdir($applicationRoot);

$loader = require_once('vendor/autoload.php');
$loader->add('Sds\\AuthModule\\Test', __DIR__);
$loader->add('Sds\\ModuleUnitTester', __DIR__ . '/../../../superdweebie/module-unit-tester/lib');

$config = include(__DIR__ . '/test.application.config.php');

\Sds\ModuleUnitTester\AbstractTest::setApplicationConfig($config);