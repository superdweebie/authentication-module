<?php
/**
 * @package    Sds
 * @license    MIT
 */
namespace Sds\AuthenticationModule\Options;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\AbstractOptions;

/**
 *
 * @since   1.0
 * @version $Revision$
 * @author  Tim Roediger <superdweebie@gmail.com>
 */
class AuthenticatedIdentityController extends AbstractOptions
{

    protected $serviceLocator;

    /**
     *
     * @var string | \Zend\Authentication\AuthenticationService
     */
    protected $authenticationService;

    /**
     *
     * @var string | \Sds\Common\Serializer\SerializerInterface
     */
    protected $serializer;

    protected $dataIdentityKey;

    protected $dataCredentialKey;

    protected $dataRememberMeKey;

    public function getServiceLocator() {
        return $this->serviceLocator;
    }

    public function setServiceLocator(ServiceLocatorInterface $serviceLocator) {
        $this->serviceLocator = $serviceLocator;
    }

    /**
     *
     * @return \Zend\Authentication\AuthenticationService
     */
    public function getAuthenticationService() {
        if (is_string($this->authenticationService)){
            $this->authenticationService = $this->serviceLocator->get($this->authenticationService);
        }
        return $this->authenticationService;
    }

    /**
     * @param string | \Zend\Authentication\AuthenticationService $authenticationService
     */
    public function setAuthenticationService($authenticationService) {
        $this->authenticationService = $authenticationService;
    }

    /**
     *
     * @return \Sds\Common\Serializer\SerializerInterface
     */
    public function getSerializer() {
        if (is_string($this->serializer)){
            $this->serializer = $this->serviceLocator->get($this->serializer);
        }
        return $this->serializer;
    }

    /**
     *
     * @param string | \Sds\Common\Serializer\SerializerInterface $serializer
     */
    public function setSerializer($serializer) {
        $this->serializer = $serializer;
    }

    public function getDataIdentityKey() {
        return $this->dataIdentityKey;
    }

    public function setDataIdentityKey($dataIdentityKey) {
        $this->dataIdentityKey = $dataIdentityKey;
    }

    public function getDataCredentialKey() {
        return $this->dataCredentialKey;
    }

    public function setDataCredentialKey($dataCredentialKey) {
        $this->dataCredentialKey = $dataCredentialKey;
    }

    public function getDataRememberMeKey() {
        return $this->dataRememberMeKey;
    }

    public function setDataRememberMeKey($dataRememberMeKey) {
        $this->dataRememberMeKey = $dataRememberMeKey;
    }
}
