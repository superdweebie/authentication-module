<?php
/**
 * @package    Sds
 * @license    MIT
 */
namespace Sds\AuthenticationModule\Options;

use Sds\AuthenticationModule\RememberMeInterface;
use Sds\Common\Identity\IdentityInterface;
use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\Storage\StorageInterface;
use Zend\Stdlib\AbstractOptions;

/**
 *
 * @since   1.0
 * @version $Revision$
 * @author  Tim Roediger <superdweebie@gmail.com>
 */
class AuthenticationService extends AbstractOptions
{

    protected $enablePerRequest = false;

    protected $enablePerSession = false;

    protected $enableRememberMe = false;

    protected $enableGuestIdentity = false;

    protected $guestIdentity;

    protected $perRequestAdapter;

    protected $perSessionStorage;

    protected $perSessionAdapter;

    protected $rememberMeService;

    public function getEnablePerRequest() {
        return $this->enablePerRequest;
    }

    public function setEnablePerRequest($enablePerRequest) {
        $this->enablePerRequest = (Boolean) $enablePerRequest;
    }

    public function getEnablePerSession() {
        return $this->enablePerSession;
    }

    public function setEnablePerSession($enablePerSession) {
        $this->enablePerSession = (Boolean) $enablePerSession;
    }

    public function getEnableRememberMe() {
        return $this->enableRememberMe;
    }

    public function setEnableRememberMe($enableRememberMe) {
        $this->enableRememberMe = (Boolean) $enableRememberMe;
    }

    public function getEnableGuestIdentity() {
        return $this->enableGuestIdentity;
    }

    public function setEnableGuestIdentity($enableGuestIdentity) {
        $this->enableGuestIdentity = (Boolean) $enableGuestIdentity;
    }


    public function getGuestIdentity() {
        return $this->guestIdentity;
    }

    public function setGuestIdentity(IdentityInterface $guestIdentity) {
        $this->guestIdentity = $guestIdentity;
    }

    public function getPerRequestAdapter() {
        return $this->perRequestAdapter;
    }

    public function setPerRequestAdapter(AdapterInterface $perRequestAdapter) {
        $this->perRequestAdapter = $perRequestAdapter;
    }

    public function getPerSessionStorage() {
        return $this->perSessionStorage;
    }

    public function setPerSessionStorage(StorageInterface $perSessionStorage) {
        $this->perSessionStorage = $perSessionStorage;
    }

    public function getPerSessionAdapter() {
        return $this->perSessionAdapter;
    }

    public function setPerSessionAdapter(AdapterInterface $perSessionAdapter) {
        $this->perSessionAdapter = $perSessionAdapter;
    }

    public function getRememberMeService() {
        return $this->rememberMeService;
    }

    public function setRememberMeService(RememberMeInterface $rememberMeService) {
        $this->rememberMeService = $rememberMeService;
    }
}
