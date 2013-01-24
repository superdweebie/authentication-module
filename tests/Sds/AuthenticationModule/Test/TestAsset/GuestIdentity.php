<?php
/**
 * @package    Sds
 * @license    MIT
 */
namespace Sds\AuthenticationModule\Test\TestAsset;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Sds\Common\Identity\IdentityInterface;

/**
 * @ODM\Document
 */
class GuestIdentity implements IdentityInterface
{

    /**
     *
     * @ODM\String
     */
    protected $identityName = 'guest';

    public function getIdentityName() {
        return $this->identityName;
    }

    public function setIdentityName($identityName) {
        $this->identityName = $identityName;
    }

}