<?php
return array(
    'sdsAuthConfig' => array(
        
        //Authentication service to use
        'authService' => 'Zend\Authentication\AuthenticationService',
        
        //Name that can be used by the serviceManager to retrieve an object that will be returned when there is no user logged in.
        'guestUser' => 'guestUser',
        
        //The auth adapter to use. Defaults to the adapter supplied with the Doctrine integration modules
        'adapter' => 'DoctrineModule\Authentication\Adapter\DoctrineObject',  
        
        //The method on the adapter to inject the identity/username value
        'adapterUsernameMethod' => 'setIdentityValue',
        
        //The method of the adapter to inject the credential/password value
        'adapterPasswordMethod' => 'setCredentialValue',
        
        //Object that can be called to retrieve extra json data to be returned with a successful login
        'returnDataObject' => null,
        
        //Method to be called on an object to retrieve extra json data to be returned with a successful login
        'returnDataMethod' => null
    ),
    
    //Set up routes
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
    
    //Used by SdsAccessControlModule. If you are not using SdsAccessControlModule,
    //this part of the config is ignored.
    'accessControl' => array(
        'controllers' => array(
            'auth' => array(
                'actions' => array(
                    'login' => array(
                        'roles' => array(
                            array(
                                'name' => 'guest'
                            ),
                        ), 
                     ),
                    'logout' => array(
                        'roles' => array(
                            array(
                                'name' => 'authenticated'
                            ),
                        ), 
                     ),                    
                ),
            ),
        ),
    ),    
);
