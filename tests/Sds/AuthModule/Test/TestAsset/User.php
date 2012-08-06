<?php
/**
 * @package    Sds
 * @license    MIT
 */
namespace Sds\AuthModule\Test\TestAsset;

use Sds\Common\User\UserInterface;
use Sds\Common\User\AuthInterface;

class User implements UserInterface, AuthInterface
{
    protected $username;

    protected $password;

    protected $isGuest;

    public function getUsername() {
        return $this->username;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function getIsGuest() {
        return $this->isGuest;
    }

    public function setIsGuest($isGuest) {
        $this->isGuest = $isGuest;
    }
}