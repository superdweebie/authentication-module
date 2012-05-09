<?php
return array(
    'di' => array(
        'definition' => array(
            'class' => array(
                'SdsAuthModule\ActiveUserFactory' => array(
                    'instantiator' => array('SdsAuthModule\ActiveUserFactory', 'get'),
                    'methods' => array(
                        'get' => array(
                            'authService' => array('type' => 'SdsAuthModule\AuthService', 'required' => true)
                        ),
                    ),
                ),            
            ),
        ),         
        
        'instance' => array(
            'alias' => array(            
                'active_user' => 'SdsAuthModule\ActiveUserFactory',
                'auth_service' => 'SdsAuthModule\AuthService',
            ),
            
            'auth_service' => array(
                'parameters' => array(                
                    'authenticationService' => 'Zend\Authentication\AuthenticationService',
                    'adapter' => 'Zend\Authentication\Adapter\Digest',                    
                    'guestUser' => 'guest_user'
                )
            ),
            
            'active_user' => array(
                'parameters' => array(
                    'authService' => 'auth_service'
                )
            ), 
            
            'SdsAuthModule\Controller\AuthController' => array(
                'parameters' => array(
                    'authService' => 'auth_service',                        
                    'activeUser' => 'active_user',                     
                )
            ),  
            
            // Setup for router and routes
            'Zend\Mvc\Router\RouteStack' => array(
                'parameters' => array(
                    'routes' => array(                    
                        'login' => array(
                            'type'    => 'Literal',
                            'options' => array(
                                'route' => '/login',
                                'defaults' => array(
                                    'controller' => 'SdsAuthModule\Controller\AuthController',
                                    'action'     => 'login',
                                ),
                            ),
                        ),
                        'logout' => array(
                            'type'    => 'Literal',
                            'options' => array(
                                'route' => '/logout',
                                'defaults' => array(
                                    'controller' => 'SdsAuthModule\Controller\AuthController',
                                    'action'     => 'logout',
                                ),
                            ),
                        ),                       
                    ),
                ),
            ),            
        ),
    ),
);
