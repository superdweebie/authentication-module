<?php
/**
 * @package    Sds
 * @license    MIT
 */
namespace Sds\AuthenticationModule\Test\TestAsset;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Sds\Common\Identity\IdentityInterface;
use Sds\Common\Identity\CredentialInterface;

/**
 * @ODM\Document
 */
class Identity implements IdentityInterface, CredentialInterface
{
    /**
     *
     * @ODM\Id(strategy="UUID")
     */
    protected $id;
    /**
     *
     * @ODM\String
     */
    protected $identityName;

    /**
     *
     * @ODM\String
     */
    protected $credential;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

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