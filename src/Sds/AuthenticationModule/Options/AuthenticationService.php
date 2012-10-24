<?php
/**
 * @package    Sds
 * @license    MIT
 */
namespace Sds\AuthenticationModule\Options;

use Sds\AuthenticationModule\RememberMeInterface;
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

    protected $authenticationAdapter;

    protected $authenticationStorage;

    protected $rememberMeEnabled;

    protected $rememberMeService;

    public function getAuthenticationAdapter() {
        return $this->authenticationAdapter;
    }

    public function setAuthenticationAdapter(AdapterInterface $authenticationAdapter) {
        $this->authenticationAdapter = $authenticationAdapter;
    }

    public function getAuthenticationStorage() {
        return $this->authenticationStorage;
    }

    public function setAuthenticationStorage(StorageInterface $authenticationStorage) {
        $this->authenticationStorage = $authenticationStorage;
    }

    public function getRememberMeEnabled() {
        return $this->rememberMeEnabled;
    }

    public function setRememberMeEnabled($rememberMeEnabled) {
        $this->rememberMeEnabled = (boolean) $rememberMeEnabled;
    }

    public function getRememberMeService() {
        return $this->rememberMeService;
    }

    public function setRememberMeService(RememberMeInterface $rememberMeService) {
        $this->rememberMeService = $rememberMeService;
    }
}
