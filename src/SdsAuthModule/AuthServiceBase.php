<?php
/**
 * @package    SdsAuthModule
 * @license    MIT
 */
namespace SdsAuthModule;

use SdsCommon\User\UserInterface;
use Zend\Authentication\AuthenticationService as ZfAuthService;

/**
 *
 * @since   1.0
 * @version $Revision$
 * @author  Tim Roediger <superdweebie@gmail.com>
 */
class AuthServiceBase
{
    /**
     *
     * @var \Zend\Authentication\AuthenticationService
     */
    protected $authenticationService;

    /**
     *
     * @var \SdsCommon\User\UserInterface
     */
    protected $defaultUser;

    /**
     *
     * @param \Zend\Authentication\AuthenticationService $authenticationService
     * @param \SdsCommon\User\UserInterface $defaultUser
     */
    public function __construct(ZfAuthService $authenticationService, UserInterface $defaultUser){
        $this->setAuthenticationService($authenticationService);
        $this->setDefaultUser($defaultUser);
    }

    /**
     *
     * @param \Zend\Authentication\AuthenticationService $authenticationService
     */
    public function setAuthenticationService(ZfAuthService $authenticationService){
        $this->authenticationService = $authenticationService;
    }

    /**
     *
     * @param \SdsCommon\User\UserInterface $defaultUser
     */
    public function setDefaultUser(UserInterface $defaultUser) {
        $this->defaultUser = $defaultUser;
    }

    /**
     *
     * @return \SdsCommon\User\UserInterface
     */
    public function getDefaultUser() {
        return $this->defaultUser;
    }

    /**
     *
     * @return boolean
     */
    public function hasIdentity()
    {
        return $this->authenticationService->hasIdentity();
    }

    /**
     * 
     * @return object
     */
    public function getIdentity()
    {
        if(!($identity = $this->authenticationService->getIdentity()))
        {
            return $this->defaultUser;
        } else {
            return $identity;
        }
    }
}
