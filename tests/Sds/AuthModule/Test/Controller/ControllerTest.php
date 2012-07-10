<?php

namespace Sds\AuthModule\Test\Controller;

use Sds\AuthModule\Test\BaseTest;
use Zend\Http\Request;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
use Zend\Json\Json;

class ControllerTest extends BaseTest{

    public $controller;
    public $serviceMapArray;
    public $event;
    public $request;
    public $response;

    public function setUp(){

        parent::setUp();

        $this->request    = new Request();
        $this->routeMatch = new RouteMatch(array('controller' => 'auth'));
        $this->event      = new MvcEvent();
        $this->event->setRouteMatch($this->routeMatch);

        $controllerLoader = $this->serviceManager->get('ControllerLoader');
        $this->controller = $controllerLoader->get('auth');

        $this->controller->setEvent($this->event);
    }

    protected function alterConfig(array $config) {
        return $config;
    }

    public function testLogout(){
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

    public function testLoginFail(){
        $this->request->setMethod(Request::METHOD_POST);
        $this->request->setContent('{"method": "login", "params": ["toby", "wrong password"], "id": 1}');
        $result = $this->controller->dispatch($this->request, $this->response);
        $returnArray = $result->getVariables();
        $this->assertEquals(
            array(
                'id' => 1,
                'result' => array(),
                'error' => null
           ),
           $returnArray
        );
    }

    public function testLoginSuccess(){
        $this->request->setMethod(Request::METHOD_POST);
        $this->request->setContent('{"method": "login", "params": ["toby", "password"], "id": 1}');
        $result = $this->controller->dispatch($this->request, $this->response);
        $returnArray = $result->getVariables();
        $this->assertEquals(
            array(
                'id' => 1,
                'result' => array(),
                'error' => null
           ),
           $returnArray
        );
    }
}

