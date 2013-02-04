<?php
/**
 * @package    Sds
 * @license    MIT
 */
namespace Sds\AuthenticationModule\Controller;

use Sds\AuthenticationModule\Exception;
use Sds\AuthenticationModule\Options\AuthenticatedIdentityController as Options;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\Mvc\MvcEvent;

/**
 * Controller to handle login and logout actions via json rest
 *
 * @since   1.0
 * @version $Revision$
 * @author  Tim Roediger <superdweebie@gmail.com>
 */
class AuthenticatedIdentityController extends AbstractRestfulController
{

    protected $model;

    protected $acceptCriteria = array(
        'Zend\View\Model\JsonModel' => array(
            'application/json',
        ),
        'Zend\View\Model\ViewModel' => array(
            '*/*',
        ),
    );

    protected $options;

    public function onDispatch(MvcEvent $e) {
        $this->model = $this->acceptableViewModelSelector($this->acceptCriteria);
        return parent::onDispatch($e);
    }

    public function getOptions() {
        return $this->options;
    }

    public function setOptions($options) {
        if (!$options instanceof Options) {
            $options = new Options($options);
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
            $identity = $authenticationService->getIdentity();

            //don't return the guest identity
            if ($identity !== $authenticationService->getOptions()->getGuestIdentity()){
                return $this->model->setVariables([$identity]);
            }
        }
        return $this->model->setVariables([]);
    }

    public function get($id){
        return $this->getList();
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

        return $this->model->setVariables($this->options->getSerializer()->toArray($result->getIdentity()));
    }

    /**
     * Clears the active identity
     * @param type $id
     */
    public function delete($id){
        $this->options->getAuthenticationService()->logout();
        return $this->model->setVariables([]);
    }

    public function update($id, $data) {
        return $this->model->setVariables([]);
    }
}
