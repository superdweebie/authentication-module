<?php
/**
 * @package    Sds
 * @license    MIT
 */
namespace Sds\AuthenticationModule\Controller;

use Sds\AuthenticationModule\Exception;
use Sds\JsonController\AbstractJsonRpcController;

/**
 * Controller to handle login and logout actions via json rpc
 *
 * @since   1.0
 * @version $Revision$
 * @author  Tim Roediger <superdweebie@gmail.com>
 */
class AuthenticationController extends AbstractJsonRpcController
{
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

    /**
     * {@inheritdoc}
     *
     * @return array
     */
    public function registerRpcMethods(){
        return array(
            'login',
            'logout'
        );
    }

    /**
     * Checks the provided identityName(nomally username) and credential(normally password) against the AuthenticationService and
     * returns the active identity
     *
     * @param string $identityName
     * @param string $credential
     * @return object
     * @throws Exception\AlreadyLoggedInException
     * @throws Exception\LoginFailedException
     */
    public function login($identityName, $credential)
    {
        $authenticationService = $this->getAuthenticationService();

        if($authenticationService->hasIdentity()){
            $this->getResponse()->setStatusCode(500);
            throw new Exception\AlreadyLoggedInException('You are aready logged in');
        }
        $result = $authenticationService->login($identityName, $credential);
        if (!$result->isValid()){
            $this->getResponse()->setStatusCode(500);
            throw new Exception\LoginFailedException(implode('. ', $result->getMessages()));
        }

        $identity = $result->getIdentity();

        if (isset($this->serializer)) {
            $identity = $this->getSerializer()->toArray($identity);
        }

        return array(
            'identity' => $identity
        );
    }

    /**
     * Clears the active identity
     *
     * @return object
     */
    public function logout()
    {
        $this->getAuthenticationService()->logout();
        return array(
            'identity' => null
        );
    }
}
