<?php
/**
 * @package    Sds
 * @license    MIT
 */
namespace Sds\AuthenticationModule\Test\TestAsset;

use Sds\Common\Identity\IdentityInterface;
use Sds\Common\Identity\CredentialInterface;

class Identity implements IdentityInterface, CredentialInterface
{
    protected $identityName;

    protected $credential;

    public function getIdentityName() {
        return $this->identityName;
    }

    public function setIdentityName($identityName) {
        $this->identityName = $identityName;
    }

    public function getCredential() {
        return $this->credential;
    }

    public function setCredential($credential) {
        $this->credential = $credential;
    }
}