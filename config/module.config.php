<?php
return array(
    'sds' => array(
        'auth' => array(

            //Authentication service to use
            'authService' => 'zend.authentication.authenticationService',

            //Name that can be used by the serviceManager to retrieve an object that will be returned when there is no user logged in.
            'defaultUser' => array(
                'username' => 'anonymous',
                'roles' => array(
                    \Sds\Common\AccessControl\Constant\Role::guest,
                )
            ),

            //The auth adapter to use. Defaults to the adapter supplied with the Doctrine integration modules
            'adapter' => 'doctrine.odm.auth.adapter',

            'user' => array(
                'class' => 'Sds\UserModule\Model\User',
                'identityProperty' => 'username', //Used by doctrine auth adapter
                'credentialProperty' => 'password', //Used by doctrine auth adapter
                'credentialCallable' => 'Sds\Common\Auth\Crypt::hashPassword' //Used by doctrine auth adapter
            ),

            //The method on the adapter to inject the identity/username value
            'adapterUsernameMethod' => 'setIdentityValue',

            //The method of the adapter to inject the credential/password value
            'adapterPasswordMethod' => 'setCredentialValue',

            'serializerCallable' => array(
                'sds.doctrineExtensions.serializer',
                'toArray'
            ),

            'enableAccessControl' => false,
        ),

        //Only used if sds accessControl is in use
        'accessControl' => array(
            'controllers' => array(
                'auth' => array(
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

    'router' => array(
        'routes' => array(
            'sds.auth' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/auth',
                    'defaults' => array(
                        'controller' => 'sds.auth',
                    ),
                ),
            ),
        ),
    ),

    'controllers' => array(
        'factories' => array(
            'sds.auth' => 'Sds\AuthModule\Service\AuthControllerFactory'
        ),
    ),

    'service_manager' => array(
        'invokables' => array(
            'zend.authentication.authenticationService' => 'Zend\Authentication\AuthenticationService',
        ),
        'factories' => array(
            'doctrine.odm.auth.adapter' => 'Sds\AuthModule\Service\DoctrineODMAuthAdapterFactory',
            'sds.auth.activeUser'       => 'Sds\AuthModule\Service\ActiveUserFactory',
            'sds.auth.defaultUser'      => 'Sds\AuthModule\Service\DefaultUserFactory',
            'sds.auth.authServiceBase'  => 'Sds\AuthModule\Service\AuthServiceBaseFactory',
            'sds.auth.authService'      => 'Sds\AuthModule\Service\AuthServiceFactory',
        )
    )
);
