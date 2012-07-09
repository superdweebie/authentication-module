<?php

namespace SdsAuthModuleTest\Controller;

use SdsAuthModule\Controller\AuthController;
use SdsAuthModuleTest\BaseTest;
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

        $this->controller = new AuthController();
        $this->request    = new Request();
        $this->routeMatch = new RouteMatch(array('controller' => 'auth'));
        $this->event      = new MvcEvent();
        $this->event->setRouteMatch($this->routeMatch);
        $this->controller->setEvent($this->event);
    }

    protected function alterConfig(array $config) {
        return $config;
    }

    public function testLoginSuccess(){


        $this->request->setMethod(Request::METHOD_POST);
        $this->request->setContent('{"method": "login", "params": ["toby", "password"], "id": null}');
        $result = $this->controller->dispatch($this->request, $this->response);
        $returnArray = $result->getVariables();
    }
}

