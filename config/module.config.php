<?php
return array(
    'sds' => array(
        'authentication' => array(
            'authenticationServiceOptions' => [
                'modes' => [], //['perRequest', 'perSession', 'rememberMe', 'guestIdentity'],
                'perRequestAdapter' => 'Sds\AuthenticationModule\HttpAdapter',
                'perSessionAdapter' => 'doctrine.authenticationadapter.odm_default',
                'perSessionStorage' => 'doctrine.authenticationstorage.odm_default',
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
//            'Sds\Zf2Extensions\RestRoute' => array(
//                'options' => array(
//                    'endpointToControllerMap' => [
//                        'authenticatedIdentity' => 'Sds\AuthenticationModule\Controller\AuthenticatedIdentityController'
//                    ],
//                ),
//            ),
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
            'Sds\AuthenticationModule\HttpAdapter' => 'Sds\AuthenticationModule\Service\HttpAdapterServiceFactory',
            'Sds\AuthenticationModule\RememberMeService' => 'Sds\AuthenticationModule\Service\RememberMeServiceFactory'
        )
    )
);
