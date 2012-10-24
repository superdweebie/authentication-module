<?php
return array(
    'sds' => array(
        'authentication' => array(
            'authenticationServiceOptions' => [
                'rememberMeEnabled' => false,
            ],
            'authenticationControllerOptions' => [
                'serializer' => 'testSerializer',
            ],
        )
    ),
    'doctrine' => array(
        'authentication' => array(
            'odm_default' => array(
                'identityClass' => 'Sds\AuthenticationModule\Test\TestAsset\Identity',
                'storage' => new \Zend\Authentication\Storage\NonPersistent
            )
        ),
        'driver' => array(
            'odm_default' => array(
                'drivers' => array(
                    'Sds\AuthenticationModule\Test\TestAsset' => 'Sds\AuthenticationModule\Test\TestAsset'
                ),
            ),
            'Sds\AuthenticationModule\Test\TestAsset' => array(
                'class' => 'Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver',
                'paths' => array(
                    'vendor/superdweebie/authentication-module/tests/Sds/AuthenticationModule/Test/TestAsset'
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'invokables' => array(
            'testSerializer' => 'Sds\AuthenticationModule\Test\TestAsset\Serializer',
        ),
    ),
);
