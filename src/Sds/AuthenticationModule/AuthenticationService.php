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

    protected $requestHeaders;

    protected $responseHeaders;

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

    public function getRequestHeaders() {
        return $this->requestHeaders;
    }

    public function setRequestHeaders($requestHeaders) {
        $this->requestHeaders = $requestHeaders;
    }

    public function getResponseHeaders() {
        return $this->responseHeaders;
    }

    public function setResponseHeaders($responseHeaders) {
        $this->responseHeaders = $responseHeaders;
    }

    public function getRememberMeService(){
        $rememberMeService = $this->options->getRememberMeService();
        $rememberMeService->setRequestHeaders($this->getRequestHeaders());
        $rememberMeService->setResponseHeaders($this->getResponseHeaders());
        return $rememberMeService;
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
            $this->getRememberMeService()->loginSuccess($result->getIdentity(), $rememberMe);
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
            $this->getRememberMeService()->logout();
        }
    }

    public function hasIdentity(){
        $return = parent::hasIdentity();
        if (!$return && $this->options->getRememberMeEnabled()){
            $identity = $this->getRememberMeService()->getIdentity();
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
            $identity = $this->getRememberMeService()->getIdentity();
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