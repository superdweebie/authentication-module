<?php
/**
 * @package    Sds
 * @license    MIT
 */
namespace Sds\AuthenticationModule\Options;

use Zend\Stdlib\AbstractOptions;

/**
 *
 * @since   1.0
 * @version $Revision$
 * @author  Tim Roediger <superdweebie@gmail.com>
 */
class RememberMeService extends AbstractOptions
{

    protected $cookieName;

    protected $cookieExpire;

    protected $secureCookie;

    protected $identityProperty;

    protected $identityClass;

    protected $documentManager;

    public function getCookieName() {
        return $this->cookieName;
    }

    public function setCookieName($cookieName) {
        $this->cookieName = (string) $cookieName;
    }

    public function getCookieExpire() {
        return $this->cookieExpire;
    }

    public function setCookieExpire($cookieExpire) {
        $this->cookieExpire = (integer) $cookieExpire;
    }

    public function getSecureCookie() {
        return $this->secureCookie;
    }

    public function setSecureCookie($secureCookie) {
        $this->secureCookie = (boolean) $secureCookie;
    }

    public function getIdentityProperty() {
        return $this->identityProperty;
    }

    public function setIdentityProperty($identityProperty) {
        $this->identityProperty = (string) $identityProperty;
    }

    public function getIdentityClass() {
        return $this->identityClass;
    }

    public function setIdentityClass($identityClass) {
        $this->identityClass = $identityClass;
    }

    public function getDocumentManager() {
        return $this->documentManager;
    }

    public function setDocumentManager($documentManager) {
        $this->documentManager = $documentManager;
    }
}
