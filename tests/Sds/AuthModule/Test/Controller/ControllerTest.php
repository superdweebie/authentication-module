<?php

namespace Sds\AuthModule\Test\Controller;

use Sds\ModuleUnitTester\BaseTest;
use Sds\UserModule\Model\User;
use Zend\Http\Request;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;

class ControllerTest extends BaseTest{

    public $userId;
    public $controller;
    public $serviceMapArray;
    public $event;
    public $request;
    public $response;

    public function setUp(){

        parent::setUp();

        //create test user
        $user = new User();
        $user->setUsername('toby');
        $user->setPassword('password');

        $documentManager = $this->serviceManager->get('doctrine.documentmanager.odm_default');
        $documentManager->persist($user);
        $this->user = $user;
        $documentManager->flush();

        $this->request    = new Request();
        $this->routeMatch = new RouteMatch(array('controller' => 'sds.auth'));
        $this->event      = new MvcEvent();
        $this->event->setRouteMatch($this->routeMatch);

        $controllerLoader = $this->serviceManager->get('ControllerLoader');
        $this->controller = $controllerLoader->get('sds.auth');

        $this->controller->setEvent($this->event);
    }

    protected function alterConfig(array $config) {
        return $config;
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
        $this->assertEquals('Sds\AuthModule\Exception\LoginFailedException', $returnArray['error']['type']);
    }

    public function testLoginSuccess(){
        $this->request->setMethod(Request::METHOD_POST);
        $this->request->setContent('{"method": "login", "params": ["toby", "password"], "id": 1}');
        $result = $this->controller->dispatch($this->request, $this->response);
        $returnArray = $result->getVariables();

        $this->assertEquals(1, $returnArray['id']);
        $this->assertEquals('toby', $returnArray['result']['user']['username']);
    }

    public function testAlreadyLoggedIn(){
        $this->request->setMethod(Request::METHOD_POST);
        $this->request->setContent('{"method": "login", "params": ["toby", "password"], "id": 1}');
        $result = $this->controller->dispatch($this->request, $this->response);
        $returnArray = $result->getVariables();

        $this->assertEquals(1, $returnArray['id']);
        $this->assertEquals('Sds\AuthModule\Exception\AlreadyLoggedInException', $returnArray['error']['type']);
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
                    'url' => null,
                    'user' => null
                ),
                'error' => null
           ),
           $returnArray
        );
    }

    public function tearDown(){
        $documentManager = $this->serviceManager->get('doctrine.documentmanager.odm_default');
        $documentManager->remove($this->user);
        $documentManager->flush();
    }
}

