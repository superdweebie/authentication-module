<?php
/**
 * @package    SdsAuthModule
 * @license    MIT
 */
namespace SdsAuthModule\Controller;

use SdsAuthModule\Events;
use SdsAuthModule\AuthService;
use SdsCommon\ActiveUser\ActiveUserAwareInterface;
use SdsCommon\ActiveUser\ActiveUserAwareTrait;
use SdsJsonRpc\Controller\AbstractJsonRpcController;

/**
 * Controller to handle login and logout actions via json rpc
 *
 * @since   1.0
 * @version $Revision$
 * @author  Tim Roediger <superdweebie@gmail.com>
 */
class AuthController extends AbstractJsonRpcController implements ActiveUserAwareInterface
{

    use ActiveUserAwareTrait;

    /**
     *
     * @var \SdsAuthModule\AuthService
     */
    protected $authService;

    /**
     *
     * @return \SdsAuthModule\AuthService
     */
    public function getAuthService() {
        return $this->authService;
    }

    /**
     *
     * @param \SdsAuthModule\AuthService $authService
     */
    public function setAuthService(AuthService $authService) {
        $this->authService = $authService;
    }

    /**
     * {@inheritdoc}
     *
     * @return array
     */
    public function registerRpcMethods(){
        return array(
            'login',
            'logout',
            'recoverPassword',
            'register'
        );
    }

    /**
     * Checks the provided username and password against the authService and
     * returns the active user
     *
     * @param string $username
     * @param string $password
     * @return object
     */
    public function login($username, $password)
    {
        if($this->activeUser != $this->authService->getDefaultUser()){
            $this->getResponse()->setStatusCode(500);
            return array('message' => 'You are aready logged in');
        }
        $result = $this->authService->login($username, $password);
        if (!$result->isValid()){
            $this->getResponse()->setStatusCode(500);
            return array('message' => implode('. ', $result->getMessages()));
        }

        $activeUser = $result->getIdentity();

        $this->events->addIdentifiers(array(Events::identifier));
        $collection = $this->events->trigger(Events::login, $activeUser);

        $data = array();
        foreach($collection as $response){
            $data = array_merge($data, $response);
        }

        return array(
            'user' => $activeUser->jsonSerialize(),
            'data' => json_encode($data)
        );
    }

    /**
     * Clears the active user
     *
     * @return object
     */
    public function logout()
    {
        $this->authService->logout();

        $this->events->addIdentifiers(array(Events::identifier));
        $this->events->trigger(Events::logout);

        return array(
            'user' => '',
            'url' => '',
        );
    }

    /**
     *
     * @param string $username
     * @param string $email
     * @return object
     */
    public function recoverPassword($username = null, $email = null){

        $this->events->addIdentifiers(array(Events::identifier));
        $collection = $this->events->trigger(Events::recoverPassword, array(
            'username' => $username,
            'email' => $email
        ));


    }

    /**
     *
     * @param string $username
     * @param array $details
     * @return object
     */
    public function register($username, array $details){

        $this->events->addIdentifiers(array(Events::identifier));
        $collection = $this->events->trigger(Events::register, array(
            'username' => $username,
            'details' => $details
        ));

    }
}
