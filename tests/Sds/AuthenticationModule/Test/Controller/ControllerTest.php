<?php

namespace Sds\AuthenticationModule\Test\Controller;

use Sds\ModuleUnitTester\AbstractControllerTest;
use Sds\AuthenticationModule\Test\TestAsset\Identity;
use Zend\Http\Request;

class ControllerTest extends AbstractControllerTest{

    protected $serviceMapArray;

    public function setUp(){

        $this->controllerName = 'sds.authentication';

        parent::setUp();

        $identity = new Identity;
        $identity->setName('toby');
        $identity->setCredential('password');

        $this->serviceManager->get('Zend\Authentication\AuthenticationService')->getAdapter()->setIdentity($identity);
    }

    public function testLogout(){
        $this->logout();
    }

    public function testLoginFail(){
        $this->request->setMethod(Request::METHOD_POST);
        $this->request->setContent('{"method": "login", "params": ["toby", "wrong password"], "id": 1}');
        $result = $this->controller->dispatch($this->request, $this->response);
        $returnArray = $result->getVariables();

        $this->assertEquals(1, $returnArray['id']);
        $this->assertEquals('Sds\AuthenticationModule\Exception\LoginFailedException', $returnArray['error']['type']);
    }

    public function testLoginSuccessAndAlreadyLoggedIn(){
        $this->request->setMethod(Request::METHOD_POST);
        $this->request->setContent('{"method": "login", "params": ["toby", "password"], "id": 1}');
        $result = $this->controller->dispatch($this->request, $this->response);
        $returnArray = $result->getVariables();

        $this->assertEquals(1, $returnArray['id']);
        $this->assertEquals('toby', $returnArray['result']['user']['name']);

        $this->request->setMethod(Request::METHOD_POST);
        $this->request->setContent('{"method": "login", "params": ["toby", "password"], "id": 1}');
        $result = $this->controller->dispatch($this->request, $this->response);
        $returnArray = $result->getVariables();

        $this->assertEquals(1, $returnArray['id']);
        $this->assertEquals('Sds\AuthenticationModule\Exception\AlreadyLoggedInException', $returnArray['error']['type']);
    }

    public function testSecondLogout(){
        $this->logout();
    }

    protected function logout(){
        $this->request->setMethod(Request::METHOD_POST);
        $this->request->setContent('{"method": "logout", "id": 1}');
        $result = $this->controller->dispatch($this->request, $this->response);
        $returnArray = $result->getVariables();
        $this->assertEquals(
            array(
                'id' => 1,
                'result' => array(
                    'user' => null
                ),
                'error' => null
           ),
           $returnArray
        );
    }
}

