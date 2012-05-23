<?php
return array(
    'sds_auth_config' => array(
        'auth_service' => 'Zend\Authentication\AuthenticationService',
        'guest_user' => 'guest_user',
        'adapter' => 'DoctrineModule\Authentication\Adapter\DoctrineObject',  
        'adapterUsernameMethod' => 'setIdentityValue',
        'adapterPasswordMethod' => 'setCredentialValue'        
    ),
    'router' => array(
        'routes' => array(
            'login' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/login',
                    'defaults' => array(
                        'controller' => 'auth',
                        'action' => 'login',
                    ),
                ),
            ),
            'logout' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/logout',
                    'defaults' => array(
                        'controller' => 'auth',
                        'action' => 'logout',
                    ),
                ),
            ),            
        ),
    ),    
    'controller' => array(
        'classes' => array(
            'auth' => 'SdsAuthModule\Controller\AuthController'
        ),              
    ),  
);
