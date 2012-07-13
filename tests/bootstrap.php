<?php
chdir(__DIR__);

$previousDir = '.';
while (!file_exists('config/application.config.php')) {
    $dir = dirname(getcwd());
    if($previousDir === $dir) {
        throw new \RuntimeException(
            'Unable to locate "config/application.config.php": ' .
            'is your module in a subdir of your application skeleton?'
        );
    }
    $previousDir = $dir;
    chdir($dir);
}

$loader = require_once('vendor/autoload.php');
$loader->add('Sds\\AuthModule\\Test', __DIR__);
$loader->add('Sds\\ModuleUnitTester', __DIR__ . '/../../../superdweebie/module-unit-tester/lib');

\Sds\ModuleUnitTester\DependencyChecker::CheckTestDependencies(__DIR__ . '/composer.json');
\Sds\ModuleUnitTester\BaseTest::setServiceConfigPaths(array(
    __DIR__ . '/TestConfiguration.php',
    __DIR__ . '/TestConfiguration.php.dist'
));