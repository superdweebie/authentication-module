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
                'guest_user' => 'Application\Model\User',
                'auth_service' => 'SdsAuthModule\AuthService',
            ),

            'guest_user' => array(
                'parameters' => array(
                    'isGuest' => true
                )
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
        ),
    ),
);
