<?php
/**
 * @package    Sds
 * @license    MIT
 */
namespace Sds\AuthModule\Controller;

use Zend\Authentication\AuthenticationService;
use Sds\AuthModule\Exception;
use Sds\Common\Serializer\SerializerInterface;
use Sds\JsonController\AbstractJsonRpcController;

/**
 * Controller to handle login and logout actions via json rpc
 *
 * @since   1.0
 * @version $Revision$
 * @author  Tim Roediger <superdweebie@gmail.com>
 */
class AuthController extends AbstractJsonRpcController
{
    /**
     *
     * @var \Zend\Authentication\AuthenticationService
     */
    protected $authenticationService;

    /**
     *
     * @var \Sds\Common\Serializer\SerializerInterface
     */
    protected $serializer;

    /**
     *
     * @return \Zend\Authentication\AuthenticationService
     */
    public function getAuthenticationService() {
        return $this->authService;
    }

    /**
     * @param \Zend\Authentication\AuthenticationService $authenticationService
     */
    public function setAuthenticationService(AuthenticationService $authenticationService) {
        $this->authenticationService = $authenticationService;
    }

    /**
     *
     * @return \Sds\Common\Serializer\SerializerInterface
     */
    public function getSerializer() {
        return $this->serializer;
    }

    /**
     *
     * @param \Sds\Common\Serializer\SerializerInterface $serializer
     */
    public function setSerializer(SerializerInterface $serializer) {
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
     * Checks the provided username and password against the authService and
     * returns the active user
     *
     * @param string $username
     * @param string $password
     * @return object
     * @throws Exception\AlreadyLoggedInException
     * @throws Exception\LoginFailedException
     */
    public function login($username, $password)
    {
        if($this->authenticationService->hasIdentity()){
            $this->getResponse()->setStatusCode(500);
            throw new Exception\AlreadyLoggedInException('You are aready logged in');
        }
        $result = $this->authenticationService->login($username, $password);
        if (!$result->isValid()){
            $this->getResponse()->setStatusCode(500);
            throw new Exception\LoginFailedException(implode('. ', $result->getMessages()));
        }

        $identity = $result->getIdentity();

        if (isset($this->serializer)) {
            $identity = $this->serializer->toArray($identity);
        }

        return array(
            'user' => $identity
        );
    }

    /**
     * Clears the active user
     *
     * @return object
     */
    public function logout()
    {
        $this->authenticationService->logout();
        return array(
            'user' => null
        );
    }
}
