<?php

namespace Sds\AuthModule\Test\Controller;

use Sds\AuthModule\Test\TestAsset\User;
use Sds\ModuleUnitTester\AbstractControllerTest;
use Zend\Http\Request;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;

class ControllerTest extends AbstractControllerTest{

    protected $serviceMapArray;

    public function setUp(){

        $this->controllerName = 'sds.auth';

        parent::setUp();

        //create test user
        $user = new User();
        $user->setUsername('toby');
        $user->setPassword('password');

        $this->request    = new Request();
        $this->routeMatch = new RouteMatch(array('controller' => 'sds.auth'));
        $this->event      = new MvcEvent();
        $this->event->setRouteMatch($this->routeMatch);

        $controllerLoader = $this->serviceManager->get('ControllerLoader');
        $this->controller = $controllerLoader->get('sds.auth');

        $this->controller->setEvent($this->event);
    }

    protected function alterConfig(array $config) {

        $config['sds']['auth']['userClass'] = 'Sds\AuthModule\Test\TestAsset\User';
        $config['sds']['auth']['adapter'] = 'Sds\AuthModule\Test\TestAsset\Adapter';
        $config['sds']['auth']['serializer'] = 'Sds\AuthModule\Test\TestAsset\Serializer';

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

