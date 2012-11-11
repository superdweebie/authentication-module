<?php
/**
 * @package    Sds
 * @license    MIT
 */
namespace Sds\AuthenticationModule\Controller;

use Sds\AuthenticationModule\Exception;
use Sds\AuthenticationModule\Options\AuthenticatedIdentityController as AuthenticatedIdentityControllerOptions;
use Sds\JsonController\AbstractJsonRestfulController;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Controller to handle login and logout actions via json rest
 *
 * @since   1.0
 * @version $Revision$
 * @author  Tim Roediger <superdweebie@gmail.com>
 */
class AuthenticatedIdentityController extends AbstractJsonRestfulController
{

    protected $options;

    public function getOptions() {
        return $this->options;
    }

    public function setOptions($options) {
        if (!$options instanceof AuthenticatedIdentityControllerOptions) {
            $options = new AuthenticatedIdentityControllerOptions($options);
        }
        isset($this->serviceLocator) ? $options->setServiceLocator($this->serviceLocator) : null;
        $this->options = $options;
    }

    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        parent::setServiceLocator($serviceLocator);
        $this->getOptions()->setServiceLocator($serviceLocator);
    }

    public function __construct($options = null) {
        $this->setOptions($options);
    }

    public function getList(){
        $authenticationService = $this->options->getAuthenticationService();

        if ($authenticationService->hasIdentity()){
            return [$this->options->getSerializer()->toArray($authenticationService->getIdentity())];
        }
        return null;
    }

    public function get($id){
        $authenticationService = $this->options->getAuthenticationService();

        if ($authenticationService->hasIdentity()){
            return $this->options->getSerializer()->toArray($authenticationService->getIdentity());
        }
        return null;
    }

    /**
     * Checks the provided identityName(nomally username) and credential(normally password) against the AuthenticationService and
     * returns the active identity
     *
     * @param type $data
     * @return type
     * @throws Exception\LoginFailedException
     */
    public function create($data){

        $authenticationService = $this->options->getAuthenticationService();

        if($authenticationService->hasIdentity()){
            $authenticationService->logout();
        }

        $result = $authenticationService->login($data['identityName'], $data['credential'], isset($data['rememberMe']) ? $data['rememberMe']: false);
        if (!$result->isValid()){
            $this->getResponse()->setStatusCode(500);
            throw new Exception\LoginFailedException(implode('. ', $result->getMessages()));
        }

        return $this->options->getSerializer()->toArray($result->getIdentity());
    }

    /**
     * Clears the active identity
     * @param type $id
     */
    public function delete($id){
        $this->options->getAuthenticationService()->logout();
    }

    public function update($id, $data) {
    }
}
