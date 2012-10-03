<?php
return array(
    'sds' => array(
        'auth' => array(
            'serializer' => 'testSerializer',
            'authenticationAdapter' => new \Sds\AuthModule\Test\TestAsset\AuthenticationAdapter,
            'authenticationStorage' => new \Zend\Authentication\Storage\NonPersistent
        ),
    ),
    'service_manager' => array(
        'invokables' => array(
            'testSerializer' => 'Sds\AuthModule\Test\TestAsset\Serializer',
        ),
    ),
);