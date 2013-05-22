<?php
return [
    'sds' => [
        'authentication' => [
            'authentication_service_options' => [
                'enable_per_request'    => true,
            ]
        ]
    ],

    'router' => [
        'routes' => [
            'test' => [
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => [
                    'route' => '/test',
                    'defaults' => [
                        'controller' => 'testcontroller',
                        'action' => 'index'
                    ],
                ],
            ],
        ]
    ],

    'controllers' => [
        'invokables' => [
            'testcontroller' => 'Sds\AuthenticationModule\Test\TestAsset\TestController'
        ]
    ]
];
