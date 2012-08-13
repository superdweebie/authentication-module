<?php
return array(
    'sds' => array(
        'auth' => array(
            'userClass' => 'Sds\AuthModule\Test\TestAsset\User',
            'adapter' => 'testAdapter',
            'serializer' => 'testSerializer',
        ),
    ),
    'service_manager' => array(
        'invokables' => array(
            'testAdapter' => 'Sds\AuthModule\Test\TestAsset\Adapter',
            'testSerializer' => 'Sds\AuthModule\Test\TestAsset\Serializer',
        ),
    ),
);