<?php
/**
 * @package    Sds
 * @license    MIT
 */
namespace Sds\AuthenticationModule;

use Zend\Authentication\AuthenticationService as ZendAuthenticationService;

/**
 * Authentication service that adds login and logout methods.
 */
class AuthenticationService extends ZendAuthenticationService
{

    /**
     *
     * @param string $identityValue
     * @param string $credentialValue
     * @return \Zend\Authentication\Result
     */
    public function login($identityValue, $credentialValue){

        $this->adapter->setIdentityValue($identityValue);
        $this->adapter->setCredentialValue($credentialValue);
        return $this->authenticate();
    }

    /**
     *
     */
    public function logout(){
        if ($this->hasIdentity()) {
            $this->clearIdentity();
        }
    }

    /**
     *
     * @return null | mixed
     */
    public function getIdentityKey(){
        if (method_exists($this->storage, 'readKeyOnly')){
            return $this->storage->readKeyOnly();
        }
    }

}