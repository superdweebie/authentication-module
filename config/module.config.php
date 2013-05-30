<?php
return array(
    'sds' => array(
        'authentication' => array(
            'authentication_service_options' => [
                'enable_per_request'    => false,
                'enable_per_session'    => false,
                'enable_remember_me'    => false,
                'per_request_adapter' => 'Sds\AuthenticationModule\HttpAdapter',
                'per_session_adapter' => 'doctrine.authentication.adapter.default',
                'per_session_storage' => 'doctrine.authentication.storage.default',
                'remember_me_service' => 'Sds\AuthenticationModule\RememberMeService',
            ],

            'authenticated_identity_controller_options' => [
                'serializer' => 'doctrineextensions.default.serializer',
                'authentication_service' => 'Zend\Authentication\AuthenticationService',
                'data_identity_key' => 'identityName',
                'data_credential_key' => 'credential',
                'data_rememberme_key' => 'rememberMe'
            ],

            'remember_me_service_options' => [
                'cookie_name' => 'rememberMe',
                'cookie_expire' => 60 * 60 * 24 * 14, //14 days
                'secure_cookie' => false,
                'identity_property' => 'identityName',
                'identity_class' => 'Sds\IdentityModule\DataModel\Identity',
                'document_manager' => 'doctrine.odm.documentmanager.default'
            ],
        ),
        'exception' => [
            'exception_map' => [
                'Sds\AuthenticationModule\Exception\LoginFailedException' => [
                    'described_by' => 'login-failed',
                    'title' => 'Login failed',
                    'status_code' => 401,
                ],
                'Sds\DoctrineExtensionsModule\Exception\DocumentNotFoundException' => [
                    'described_by' => 'document-not-found',
                    'title' => 'Document not found',
                    'status_code' => 404
                ],
            ],
        ],
        'doctrineExtensions' => [
            'manifest' => [
                'default' => [
                    'document_manager' => 'doctrine.odm.documentmanager.default',
                    'extension_configs' => [
                        'extension.rest' => true,
                        'extension.serializer' => true,
                    ],
                ]
            ]
        ]
    ),

    'doctrine' => array(
        'authentication' => array(
            'adapter' => array(
                'default' => array(
                    'identity_class' => 'Sds\IdentityModule\DataModel\Identity',
                    'credential_callable' => 'Sds\Common\Crypt\Hash::hashCredential',
                    'identity_property' => 'identityName',
                    'credential_property' => 'credential'
                )
            ),
            'storage' => array(
                'default' => array(
                    'identity_class' => 'Sds\IdentityModule\DataModel\Identity',
                )
            ),
        ),

        'driver' => array(
            'default' => array(
                'drivers' => array(
                    'Sds\AuthenticationModule\DataModel' => 'doctrine.driver.authentication'
                ),
            ),
            'authentication' => array(
                'class' => 'Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver',
                'paths' => array(
                    __DIR__ . '/../src/Sds/AuthenticationModule/DataModel'
                ),
            ),
        ),
    ),

    'controllers' => array(
        'factories' => array(
            'rest.default.authenticatedidentity' => 'Sds\AuthenticationModule\Service\AuthenticatedIdentityControllerFactory'
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
