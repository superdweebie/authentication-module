<?php
/**
 * @package    Sds
 * @license    MIT
 */
namespace Sds\AuthenticationModule\Controller;

use Sds\AuthenticationModule\Exception;
use Sds\AuthenticationModule\Options\AuthenticationController as AuthenticationControllerOptions;
use Sds\JsonController\AbstractJsonRpcController;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Controller to handle login and logout actions via json rpc
 *
 * @since   1.0
 * @version $Revision$
 * @author  Tim Roediger <superdweebie@gmail.com>
 */
class AuthenticationController extends AbstractJsonRpcController
{

    protected $options;

    public function getOptions() {
        return $this->options;
    }

    public function setOptions($options) {
        if (!$options instanceof AuthenticationControllerOptions) {
            $options = new AuthenticationControllerOptions($options);
        }
        isset($this->serviceLocator) ? $options->setServiceLocator($this->serviceLocator) : null;
        $this->options = $options;
    }

    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        parent::setServiceLocator($serviceLocator);
        $this->getOptions()->setServiceLocator($serviceLocator);
    }

    /**
     * {@inheritdoc}
     *
     * @return array
     */
    public function registerRpcMethods(){
        return array(
            'getIdentity',
            'login',
            'logout'
        );
    }

    public function __construct($options = null) {
        $this->setOptions($options);
    }

    /**
     *
     * @return object
     */
    public function getIdentity(){

        $authenticationService = $this->options->getAuthenticationService();

        $result = [];
        $result['hasIdentity'] = $authenticationService->hasIdentity();
        if ($result['hasIdentity']){
            $result['identity'] = $this->options->getSerializer()->toArray($authenticationService->getIdentity());
        } else {
            $result['identity'] = false;
        }

        return $result;
    }

    /**
     * Checks the provided identityName(nomally username) and credential(normally password) against the AuthenticationService and
     * returns the active identity
     *
     * @param string $identityName
     * @param string $credential
     * @param boolean $rememberMe
     * @return object
     * @throws Exception\AlreadyLoggedInException
     * @throws Exception\LoginFailedException
     */
    public function login($identityName, $credential, $rememberMe = false)
    {
        $authenticationService = $this->options->getAuthenticationService();

        if($authenticationService->hasIdentity()){
            $authenticationService->logout();
        }

        $result = $authenticationService->login($identityName, $credential, $rememberMe);
        if (!$result->isValid()){
            $this->getResponse()->setStatusCode(500);
            throw new Exception\LoginFailedException(implode('. ', $result->getMessages()));
        }

        return array(
            'identity' => $this->options->getSerializer()->toArray($result->getIdentity())
        );
    }

    /**
     * Clears the active identity
     *
     * @return object
     */
    public function logout()
    {
        $this->options->getAuthenticationService()->logout();
        return array(
            'identity' => false
        );
    }
}
