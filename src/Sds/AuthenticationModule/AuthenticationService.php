<?php
/**
 * @package    Sds
 * @license    MIT
 */
namespace Sds\AuthenticationModule;

use Sds\AuthenticationModule\Options\AuthenticationService as AuthenticationServiceOptions;
use Sds\AuthenticationModule\Exception;
use Zend\Authentication\AuthenticationService as ZendAuthenticationService;
use Zend\Authentication\Storage\NonPersistent;

/**
 * Authentication service that adds login and logout methods.
 */
class AuthenticationService extends ZendAuthenticationService
{

    protected $options;

    public function getOptions() {
        return $this->options;
    }

    public function setOptions($options) {
        if (!$options instanceof AuthenticationServiceOptions) {
            $options = new AuthenticationServiceOptions($options);
        }
        $this->options = $options;
    }

    /**
     *
     * @param string $identityValue
     * @param string $credentialValue
     * @param boolean $rememberMe
     * @return \Zend\Authentication\Result
     */
    public function login($identityValue, $credentialValue, $rememberMe = false){

        if ( ! $this->options->getEnablePerSession()){
            throw new Exception\RuntimeException('Login attempted, but options->modes perSession not set');
        }

        //If login is called, then stateful auth is implied
        $this->adapter = $this->options->getPerSessionAdapter();
        $this->storage = $this->options->getPerSessionStorage();

        $this->adapter->setIdentityValue($identityValue);
        $this->adapter->setCredentialValue($credentialValue);
        $result = $this->authenticate();

        if ($result->isValid() && $this->options->getEnableRememberMe()){
            $this->options->getRememberMeService()->loginSuccess($result->getIdentity(), $rememberMe);
        }

        return $result;
    }

    /**
     *
     */
    public function logout(){

        if ( ! $this->options->getEnablePerSession()){
            throw new Exception\RuntimeException('Logout attempted, but options->modes perSession not set');
        }

        //If logout is called, then stateful auth is implied
        $this->adapter = $this->options->getPerSessionAdapter();
        $this->storage = $this->options->getPerSessionStorage();

        if ($this->hasIdentity()) {
            $this->clearIdentity();
        }
        if ($this->options->getEnableRememberMe()){
            $this->options->getRememberMeService()->logout();
        }
    }

    public function hasIdentity(){

        if (isset($this->storage) && ! $this->storage->isEmpty()){
            return true;
        }

        //Check per session storage first
        if ($this->options->getEnablePerSession()){
            $this->storage = $this->options->getPerSessionStorage();
            if (! $this->storage->isEmpty()){
                return true;
            }
        }

        //If there is no identity, attempt to load one using the remember me service (stateful across sessions)
        if ($this->options->getEnableRememberMe()){
            $identity = $this->options->getRememberMeService()->getIdentity();
            if ($identity){
                $this->storage->write($identity);
                return true;
            }
        }

        //If there is still no identity, attempt to auth using stateless service (and use non-persistent storage)
        if ($this->options->getEnablePerRequest()){
            $result = $this->options->getPerRequestAdapter()->authenticate();
            if ($result->isValid()){
                $identity = $result->getIdentity();
                $this->storage = new NonPersistent;
                $this->storage->write($identity);
                return true;
            }
        }

        return false;
    }

    public function getIdentity(){

        if ( ! isset($this->storage)){
            if ( ! $this->hasIdentity()){
                return null;
            }
        }

        return $this->storage->read();
    }

    /**
     *
     * @return null | mixed
     */
    public function getIdentityKey(){
        if (method_exists($this->options->getStatefulStorage(), 'readKeyOnly')){
            return $this->options->getStatefulStorage()->readKeyOnly();
        }
    }
}