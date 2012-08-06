<?php
/**
 * @package    SdsAuthModule
 * @license    MIT
 */
namespace Sds\AuthModule;

use Sds\Common\User\UserInterface;
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
     * @param \Zend\Authentication\AuthenticationService $authenticationService
     * @param \SdsCommon\User\UserInterface $defaultUser
     * @param \Zend\Authentication\Adapter\AdapterInterface $adapter
     * @param string $adapterUsernameMethod
     * @param string $adapterPasswordMethod
     */
    public function __construct(
        ZfAuthService $authenticationService,
        UserInterface $defaultUser,
        Adapter $adapter
    ){
        parent::__construct($authenticationService, $defaultUser);
        $this->setAdapter($adapter);
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
     * @param string $username
     * @param string $password
     * @return object
     */
    public function login($username, $password)
    {
        $this->adapter->setIdentity($username);
        $this->adapter->setCredential($password);
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

