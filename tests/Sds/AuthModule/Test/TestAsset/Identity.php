<?php
/**
 * @package    Sds
 * @license    MIT
 */
namespace Sds\AuthModule\Test\TestAsset;

use Sds\Common\Identity\IdentityInterface;
use Sds\Common\Identity\CredentialInterface;

class Identity implements IdentityInterface, CredentialInterface
{
    protected $name;

    protected $credential;

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getCredential() {
        return $this->credential;
    }

    public function setCredential($credential) {
        $this->credential = $credential;
    }
}