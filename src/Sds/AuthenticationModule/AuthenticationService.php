<?php
/**
 * @package    Sds
 * @license    MIT
 */
namespace Sds\AuthenticationModule;

use Sds\AuthenticationModule\Options\AuthenticationService as AuthenticationServiceOptions;
use Zend\Authentication\AuthenticationService as ZendAuthenticationService;

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
        $this->adapter = $options->getAuthenticationAdapter();
        $this->storage = $options->getAuthenticationStorage();
    }

    /**
     *
     * @param string $identityValue
     * @param string $credentialValue
     * @param boolean $rememberMe
     * @return \Zend\Authentication\Result
     */
    public function login($identityValue, $credentialValue, $rememberMe = false){

        $this->adapter->setIdentityValue($identityValue);
        $this->adapter->setCredentialValue($credentialValue);
        $result = $this->authenticate();

        if ($result->isValid() && $this->options->getRememberMeEnabled()){
            $this->options->getRememberMeService()->loginSuccess($result->getIdentity(), $rememberMe);
        }

        return $result;
    }

    /**
     *
     */
    public function logout(){
        if ($this->hasIdentity()) {
            $this->clearIdentity();
        }
        if ($this->options->getRememberMeEnabled()){
            $this->options->getRememberMeService()->logout();
        }
    }

    public function hasIdentity(){
        $return = parent::hasIdentity();
        if (!$return && $this->options->getRememberMeEnabled()){
            $identity = $this->options->getRememberMeService()->getIdentity();
            if ($identity){
                $this->getStorage()->write($identity);
                return true;
            }
        }
        return $return;
    }

    public function getIdentity(){
        $return = parent::getIdentity();
        if (!$return && $this->options->getRememberMeEnabled()){
            $identity = $this->options->getRememberMeService()->getIdentity();
            if ($identity){
                $this->getStorage()->write($identity);
                return $identity;
            }
        }
        return $return;
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