<?php
return [
    'sds' => [
        'authentication' => [
            'authenticationServiceOptions' => [
                'enablePerRequest'    => true,
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
