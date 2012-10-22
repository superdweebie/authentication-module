<?php
/**
 * @package    Sds
 * @license    MIT
 */
namespace Sds\AuthenticationModule;

/**
 *
 * @license MIT
 * @link    http://www.doctrine-project.org/
 * @since   0.1.0
 * @author  Tim Roediger <superdweebie@gmail.com>
 */
class Module
{

    /**
     *
     * @return array
     */
    public function getConfig(){
        return include __DIR__ . '/../../../config/module.config.php';
    }

//    public function onBootstrap(MvcEvent $e) {
//
//        $session = new \Zend\Session\Container('zfcuser');
//        $cookieLogin = $session->offsetGet("cookieLogin");
//        $cookie = $e->getRequest()->getCookie();
//
//        // do autologin only if not done before and cookie is present
//        if(isset($cookie['remember_me']) && $cookieLogin == false) {
//            $adapter = $e->getApplication()->getServiceManager()->get('ZfcUser\Authentication\Adapter\AdapterChain');
//            $adapter->prepareForAuthentication($e->getRequest());
//            $authService = $e->getApplication()->getServiceManager()->get('zfcuser_auth_service');
//
//            $auth = $authService->authenticate($adapter);
//        }
//
//    }
}