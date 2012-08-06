<?php
/**
 * @package    Sds
 * @license    MIT
 */
namespace Sds\AuthModule\Test\TestAsset;

use Zend\Authentication\Adapter\AdapterInterface;

class Adapter implements AdapterInterface
{
    public function authenticate(){
        return true;
    }
}