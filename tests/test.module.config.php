<?php
return array(
    'sds' => array(
        'authentication' => array(
            'serializer' => 'testSerializer',
            'authenticationAdapter' => new \Sds\AuthenticationModule\Test\TestAsset\AuthenticationAdapter,
            'authenticationStorage' => new \Zend\Authentication\Storage\NonPersistent
        ),
    ),
    'service_manager' => array(
        'invokables' => array(
            'testSerializer' => 'Sds\AuthenticationModule\Test\TestAsset\Serializer',
        ),
    ),
);