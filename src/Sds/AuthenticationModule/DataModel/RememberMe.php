<?php
/**
 * @package    Sds
 * @license    MIT
 */
namespace Sds\AuthenticationModule\DataModel;

use Sds\Common\Identity\CredentialInterface;
use Sds\Common\Identity\IdentityInterface;
use Sds\Common\Identity\RoleAwareIdentityInterface;
use Sds\DoctrineExtensions\Identity\DataModel\CredentialTrait;
use Sds\DoctrineExtensions\Identity\DataModel\IdentityTrait;
use Sds\DoctrineExtensions\Identity\DataModel\RoleAwareIdentityTrait;

//Annotation imports
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Sds\DoctrineExtensions\Annotation\Annotations as Sds;

/**
 *
 * @license MIT
 * @since   0.1.0
 * @author  Tim Roediger <superdweebie@gmail.com>
 *
 * @ODM\Document
 */
class RememberMe
{

    /**
     *
     * @ODM\Id(strategy="none")
     */
    protected $sessionId;

    /**
     *
     * @ODM\String
     */
    protected $token;

    /**
     *
     * @ODM\String
     */
    protected $identityId;

    public function getSessionId() {
        return $this->sessionId;
    }

    public function setSessionId($sessionId) {
        $this->sessionId = (string) $sessionId;
    }

    public function getToken() {
        return $this->token;
    }

    public function setToken($token) {
        $this->token = (string) $token;
    }

    public function getIdentityId() {
        return $this->identityId;
    }

    public function setIdentityId($identityId) {
        $this->identityId = (string) $identityId;
    }
}
