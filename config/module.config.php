<?php
return array(
    'sds' => array(
        'authentication' => array(
            'authenticationServiceOptions' => [
                'authenticationAdapter' => 'doctrine.authenticationadapter.odm_default',
                'authenticationStorage' => 'doctrine.authenticationstorage.odm_default',
                'rememberMeEnabled' => true,
                'rememberMeService' => 'Sds\AuthenticationModule\RememberMeService',
            ],

            'authenticatedIdentityControllerOptions' => [
                'serializer' => 'Sds\DoctrineExtensions\Serializer',
                'authenticationService' => 'Zend\Authentication\AuthenticationService'
            ],

            'rememberMeServiceOptions' => [
                'cookieName' => 'rememberMe',
                'cookieExpire' => 60 * 60 * 24 * 14, //14 days
                'secureCookie' => false,
                'identityProperty' => 'identityName',
                'identityClass' => 'Sds\IdentityModule\DataModel\Identity',
                'documentManager' => 'doctrine.documentmanager.odm_default'
            ],

            'enableAccessControl' => false,
        ),

        //Only used if sds accessControl is in use
        'accessControl' => array(
            'controllers' => array(
                'authentication' => array(
                    'jsonRpc' => true,
                    'methods' => array(
                        'serviceMap' => array(
                            'roles' => array(
                                \Sds\Common\AccessControl\Constant\Role::guest
                            ),
                        ),
                        'login' => array(
                            'roles' => array(
                                \Sds\Common\AccessControl\Constant\Role::guest
                            ),
                        ),
                        'logout' => array(
                            'roles' => array(
                                \Sds\Common\AccessControl\Constant\Role::user
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),

    'doctrine' => array(
        'authentication' => array(
            'odm_default' => array(
                'identityProperty' => 'identityName',
                'credentialProperty' => 'credential',
                'identityClass' => 'Sds\IdentityModule\DataModel\Identity',
                'credentialCallable' => 'Sds\Common\Crypt\Hash::hashCredential'
            )
        ),
        'driver' => array(
            'odm_default' => array(
                'drivers' => array(
                    'Sds\AuthenticationModule\DataModel' => 'Sds\AuthenticationModule\DataModel'
                ),
            ),
            'Sds\AuthenticationModule\DataModel' => array(
                'class' => 'Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver',
                'paths' => array(
                    'vendor/superdweebie/authentication-module/src/Sds/AuthenticationModule/DataModel'
                ),
            ),
        ),
    ),

    'router' => array(
        'routes' => array(
            'Sds\AuthenticationModule\AuthenticatedIdentity' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route'    => '/authenticatedIdentity[/:id]',
                    'defaults' => array(
                        'controller' => 'Sds\AuthenticationModule\Controller\AuthenticatedIdentityController',
                    ),
                    'constraints' => [
                        'id' => '[a-zA-Z0-9_-]*'
                    ]
                ),
            ),
        ),
    ),

    'controllers' => array(
        'factories' => array(
            'Sds\AuthenticationModule\Controller\AuthenticatedIdentityController' => function($serviceLocator){
                return new Sds\AuthenticationModule\Controller\AuthenticatedIdentityController(
                    $serviceLocator
                        ->getServiceLocator()
                        ->get('Config')['sds']['authentication']['authenticatedIdentityControllerOptions']
                );
            }
        ),
    ),

    'view_manager' => array(
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),

    'service_manager' => array(
        'factories' => array(
            'Zend\Authentication\AuthenticationService' => 'Sds\AuthenticationModule\Service\AuthenticationServiceFactory',
            'Sds\AuthenticationModule\RememberMeService' => 'Sds\AuthenticationModule\Service\RememberMeServiceFactory'
        )
    )
);
