<?php
chdir(__DIR__);

$previousDir = '.';
while (!file_exists('config/application.config.php')) {
    $dir = dirname(getcwd());
    if($previousDir === $dir) {
        throw new RuntimeException(
            'Unable to locate "config/application.config.php": ' .
            'is SdsAuthModule in a subdir of your application skeleton?'
        );
    }
    $previousDir = $dir;
    chdir($dir);
}

$loader = require_once('vendor/autoload.php');
$loader->add('Sds\\AuthModule\\Test', __DIR__);

if (is_readable(__DIR__ . '/TestConfiguration.php')) {
    require_once __DIR__ . '/TestConfiguration.php';
} else {
    require_once __DIR__ . '/TestConfiguration.php.dist';
}

\Sds\AuthModule\Test\BaseTest::setMvcConfig($configuration);
