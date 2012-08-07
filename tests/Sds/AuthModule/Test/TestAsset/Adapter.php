<?php
/**
 * @package    Sds
 * @license    MIT
 */
namespace Sds\AuthModule\Test\TestAsset;

use Sds\AuthModule\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\Result as AuthenticationResult;

class Adapter implements AdapterInterface
{
    protected $identityValue;

    protected $credentialValue;

    public function setIdentityValue($identityValue){
        $this->identityValue = $identityValue;
    }

    public function setCredentialValue($credentialValue){
        $this->credentialValue = $credentialValue;
    }

    public function authenticate(){

        if ($this->identityValue == 'toby' && $this->credentialValue == 'password'){

            $user = new User();
            $user->setUsername($this->identityValue);
            $user->setPassword($this->credentialValue);

            return new AuthenticationResult(
                AuthenticationResult::SUCCESS,
                $user,
                []
            );
        } else {
            return new AuthenticationResult(
                AuthenticationResult::FAILURE,
                null,
                []
            );
        }
    }
}