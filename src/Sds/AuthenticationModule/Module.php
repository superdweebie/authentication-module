<?php
/**
 * @package    Sds
 * @license    MIT
 */
namespace Sds\AuthenticationModule;

use Sds\Zf2ExtensionsModule\JsonExceptionStrategy;
use Zend\Mvc\MvcEvent;

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

    /**
     *
     * @param \Zend\EventManager\Event $event
     */
    public function onBootstrap(MvcEvent $event)
    {

        $application = $event->getTarget();
        $serviceManager = $application->getServiceManager();
        $config = $serviceManager->get('Config');

        // Config json enabled exceptionStrategy
        $exceptionStrategy = new JsonExceptionStrategy();

        $displayExceptions = false;

        if (isset($config['view_manager']['display_exceptions'])) {
            $displayExceptions = $config['view_manager']['display_exceptions'];
        }

        $exceptionStrategy->setDisplayExceptions($displayExceptions);
        $exceptionStrategy->attach($application->getEventManager());
    }
}