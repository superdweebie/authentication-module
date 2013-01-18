<?php
return array(
    'modules' => array(
        'DoctrineModule',
        'DoctrineMongoODMModule',
        'Sds\Zf2ExtensionsModule',
        'Sds\AuthenticationModule'
    ),
    'module_listener_options' => array(
        'config_glob_paths'    => array(
            __DIR__ . '/test.module.config.php',
        ),
        'module_paths' => array(
            './vendor',
        ),
    ),
);