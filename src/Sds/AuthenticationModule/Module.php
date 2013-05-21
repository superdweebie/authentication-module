<?php
/**
 * @package    Sds
 * @license    MIT
 */
namespace Sds\AuthenticationModule;

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
}