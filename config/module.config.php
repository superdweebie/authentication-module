<?php
return array(
    'sds' => array(
        'authentication' => array(
            'authenticationServiceOptions' => [
                'enablePerRequest'    => false,
                'enablePerSession'    => false,
                'enableRememberMe'    => false,
                'perRequestAdapter' => 'Sds\AuthenticationModule\HttpAdapter',
                'perSessionAdapter' => 'doctrine.authenticationadapter.default',
                'perSessionStorage' => 'doctrine.authenticationstorage.default',
                'rememberMeService' => 'Sds\AuthenticationModule\RememberMeService',
            ],

            'authenticatedIdentityControllerOptions' => [
                'serializer' => 'doctrineExtensions.serializer',
                'authenticationService' => 'Zend\Authentication\AuthenticationService'
            ],

            'rememberMeServiceOptions' => [
                'cookieName' => 'rememberMe',
                'cookieExpire' => 60 * 60 * 24 * 14, //14 days
                'secureCookie' => false,
                'identityProperty' => 'identityName',
                'identityClass' => 'Sds\IdentityModule\DataModel\Identity',
                'documentManager' => 'doctrine.odm.documentmanager.default'
            ],
        ),
        'exception' => [
            'exceptionMap' => [
                'Sds\AuthenticationModule\Exception\LoginFailedException' => [
                    'describedBy' => 'login-failed',
                    'title' => 'Login failed',
                    'statusCode' => 401,
                ],
                'Sds\DoctrineExtensionsModule\Exception\DocumentNotFoundException' => [
                    'describedBy' => 'document-not-found',
                    'title' => 'Document not found',
                    'statusCode' => 404
                ],
            ],
        ],
    ),

    'doctrine' => array(
        'authentication' => array(
            'default' => array(
                'identityProperty' => 'identityName',
                'credentialProperty' => 'credential',
                'identityClass' => 'Sds\IdentityModule\DataModel\Identity',
                'credentialCallable' => 'Sds\Common\Crypt\Hash::hashCredential'
            )
        ),
        'driver' => array(
            'default' => array(
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

    'controllers' => array(
        'factories' => array(
            'authenticatedIdentity' => 'Sds\AuthenticationModule\Service\AuthenticatedIdentityControllerFactory'
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
