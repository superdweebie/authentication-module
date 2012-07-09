<?php
/**
 * @package    SdsAuthModule
 * @license    MIT
 */
namespace SdsAuthModule;

use SdsCommon\User\UserInterface;
use Zend\Authentication\AuthenticationService as ZfAuthService;
use Zend\Authentication\Adapter\AdapterInterface as Adapter;

/**
 *
 * @since   1.0
 * @version $Revision$
 * @author  Tim Roediger <superdweebie@gmail.com>
 */
class AuthService extends AuthServiceBase
{
    /**
     *
     * @var \Zend\Authentication\Adapter\AdapterInterface
     */
    protected $adapter;

    /**
     *
     * @var string
     */
    protected $adapterUsernameMethod;

    /**
     *
     * @var string
     */
    protected $adapterPasswordMethod;

    /**
     * @var object
     */
    protected $returnDataObject;

    /**
     * @var string
     */
    protected $returnDataMethod;

    /**
     *
     * @param \Zend\Authentication\AuthenticationService $authenticationService
     * @param \SdsCommon\User\UserInterface $defaultUser
     * @param \Zend\Authentication\Adapter\AdapterInterface $adapter
     * @param string $adapterUsernameMethod
     * @param string $adapterPasswordMethod
     */
    public function __construct(
        ZfAuthService $authenticationService,
        UserInterface $defaultUser,
        Adapter $adapter,
        $adapterUsernameMethod,
        $adapterPasswordMethod
    ){
        parent::__construct($authenticationService, $defaultUser);
        $this->setAdapter($adapter);
        $this->setAdapterUsernameMethod($adapterUsernameMethod);
        $this->setAdapterPasswordMethod($adapterPasswordMethod);
    }

    /**
     *
     * @param \Zend\Authentication\Adapter\AdapterInterface $adapter
     */
    public function setAdapter(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     *
     * @return \Zend\Authentication\Adapter\AdapterInterface
     */
    public function getAdapter() {
        return $this->adapter;
    }

    /**
     *
     * @return string
     */
    public function getAdapterUsernameMethod() {
        return $this->adapterUsernameMethod;
    }

    /**
     *
     * @param string $adapterUsernameMethod
     */
    public function setAdapterUsernameMethod($adapterUsernameMethod) {
        $this->adapterUsernameMethod = (string) $adapterUsernameMethod;
    }

    /**
     *
     * @return string
     */
    public function getAdapterPasswordMethod() {
        return $this->adapterPasswordMethod;
    }

    /**
     *
     * @param string $adapterPasswordMethod
     */
    public function setAdapterPasswordMethod($adapterPasswordMethod) {
        $this->adapterPasswordMethod = (string) $adapterPasswordMethod;
    }

    /**
     *
     * @return string
     */
    public function getReturnDataObject() {
        return $this->returnDataObject;
    }

    /**
     *
     * @return string
     */
    public function getReturnDataMethod() {
        return $this->returnDataMethod;
    }

    /**
     *
     * @param object $returnDataObject
     */
    public function setReturnDataObject($returnDataObject) {
        $this->returnDataObject = $returnDataObject;
    }

    /**
     *
     * @param string $returnDataMethod
     */
    public function setReturnDataMethod($returnDataMethod) {
        $this->returnDataMethod = $returnDataMethod;
    }

    /**
     *
     * @param string $username
     * @param string $password
     * @return object
     */
    public function login($username, $password)
    {
        $adapter = $this->adapter;
        $adapter->{$this->adapterUsernameMethod}($username);
        $adapter->{$this->adapterPasswordMethod}($password);
        $result  = $this->authenticationService->authenticate($this->adapter);
        return $result;
    }

    /**
     * 
     * @return null
     */
    public function logout()
    {
        if (!$this->authenticationService->hasIdentity()) {
            return null;
        }
        $this->authenticationService->clearIdentity();
    }
}

