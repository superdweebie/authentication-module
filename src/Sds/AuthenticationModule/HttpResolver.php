<?php
/**
 * @package    Sds
 * @license    MIT
 */
namespace Sds\AuthenticationModule;

use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\Adapter\Http\ResolverInterface;

/**
 * Authentication service that adds login and logout methods.
 */
class HttpResolver implements ResolverInterface
{

    protected $adapter;

    public function __construct(AdapterInterface $adapter) {
        $this->adapter = $adapter;
    }

    public function resolve($username, $realm, $password = null){

        $this->adapter->setIdentityValue($username);
        $this->adapter->setCredentialValue($password);

        return $this->adapter->authenticate();
    }
}