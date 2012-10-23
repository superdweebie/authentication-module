<?php
/**
 * @package    Sds
 * @license    MIT
 */
namespace Sds\AuthenticationModule\Options;

use Zend\Authentication\Adapter\AdapterInterface;
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

    public function setAuthenticationAdapter($authenticationAdapter) {
        $this->authenticationAdapter = $authenticationAdapter;
    }

    public function getAuthenticationStorage() {
        return $this->authenticationStorage;
    }

    public function setAuthenticationStorage($authenticationStorage) {
        $this->authenticationStorage = $authenticationStorage;
    }

    public function getRememberMeEnabled() {
        return $this->rememberMeEnabled;
    }

    public function setRememberMeEnabled($rememberMeEnabled) {
        $this->rememberMeEnabled = $rememberMeEnabled;
    }

    public function getRememberMeService() {
        return $this->rememberMeService;
    }

    public function setRememberMeService($rememberMeService) {
        $this->rememberMeService = $rememberMeService;
    }

}
