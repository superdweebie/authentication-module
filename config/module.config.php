<?php
return array(
    'sdsAuth' => array(

        //Authentication service to use
        'authService' => 'zend.authentication.authenticationService',

        //Name that can be used by the serviceManager to retrieve an object that will be returned when there is no user logged in.
        'defaultUser' => 'sdsAuth.defaultUser',

        //The auth adapter to use. Defaults to the adapter supplied with the Doctrine integration modules
        'adapter' => 'doctrine.auth.adapter',

        //The method on the adapter to inject the identity/username value
        'adapterUsernameMethod' => 'setIdentityValue',

        //The method of the adapter to inject the credential/password value
        'adapterPasswordMethod' => 'setCredentialValue',
    ),

    'router' => array(
        'routes' => array(
            'auth' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/auth',
                    'defaults' => array(
                        'controller' => 'auth',
                    ),
                ),
            ),
        ),
    ),

    'controller' => array(
        'factories' => array(
            'auth' => 'SdsAuthModule\Service\AuthControllerFactory'
        ),
    ),

    //Used by SdsAccessControlModule. If you are not using SdsAccessControlModule,
    //this part of the config is ignored.
    'sdsAccessControl' => array(
        'controllers' => array(
            'auth' => array(
                'actions' => array(
                    'serviceMap' => array(
                        'roles' => array(
                            'name' => \Sds\Common\AccessControl\Constant\Role::guest
                        ),
                    ),
                    'login' => array(
                        'roles' => array(
                            'name' => \Sds\Common\AccessControl\Constant\Role::guest
                        ),
                     ),
                    'logout' => array(
                        'roles' => array(
                            'name' => \Sds\Common\AccessControl\Constant\Role::user
                        ),
                    ),
                    'recoverPassword' => array(
                        'roles' => array(
                            'name' => \Sds\Common\AccessControl\Constant\Role::user
                        ),
                    ),
                    'register' => array(
                        'roles' => array(
                            'name' => \Sds\Common\AccessControl\Constant\Role::user
                        ),
                    ),
                ),
            ),
        ),
    ),
);
