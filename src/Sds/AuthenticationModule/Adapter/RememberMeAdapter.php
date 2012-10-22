<?php
/**
 * @package    Sds
 * @license    MIT
 */
namespace Sds\Adapter\AuthenticationModule;

use Zend\Authentication\Adapter\AdapterInterface;


class RememberMeAdapter implements AdapterInterface
{

    protected $innerAdapter;

    /**
     * Set the value to be used as the identity
     *
     * @param  mixed $identityValue
     * @return ObjectRepository
     */
    public function setIdentityValue($identityValue)
    {
        $this->innerAdapter->setIdentityValue($identityValue);
        return $this;
    }

    /**
     * @return string
     */
    public function getIdentityValue()
    {
        return $this->innerAdapter->getIdentityValue();
    }

    /**
     * Set the credential value to be used.
     *
     * @param  mixed $credentialValue
     * @return ObjectRepository
     */
    public function setCredentialValue($credentialValue)
    {
        $this->innerAdapter->setCredentialValue($credentialValue);
        return $this;
    }

    /**
     * @return string
     */
    public function getCredentialValue()
    {
        return $this->innerAdapter->getCredentialValue();
    }

    public function authenticate(){

        $result = $this->innerAdapter->authenticate();
        if ($result->isValid()){
            //TODO
        }
        return $result;
    }
}