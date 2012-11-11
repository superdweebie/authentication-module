<?php

namespace Sds\AuthenticationModule\Test\Controller;

use Sds\Common\Crypt\Hash;
use Sds\ModuleUnitTester\AbstractControllerTest;
use Sds\AuthenticationModule\Test\TestAsset\Identity;
use Zend\Http\Request;

class ControllerTest extends AbstractControllerTest{

    protected $serviceMapArray;

    public function setUp(){

        $this->controllerName = 'Sds\AuthenticationModule\Controller\AuthenticatedIdentityController';

        parent::setUp();

        $identity = new Identity;
        $identity->setIdentityName('toby');
        $identity->setCredential(Hash::hashAndPrependSalt(Hash::getSalt(), 'password'));

        $this->documentManager = $this->serviceManager->get('doctrine.documentmanager.odm_default');

        $this->documentManager->persist($identity);
        $this->documentManager->flush();
    }

    public function testLogout(){
        $this->logout();
    }

    public function testLoginFail(){
        $this->setExpectedException('Sds\AuthenticationModule\Exception\LoginFailedException');
        $this->request->setMethod(Request::METHOD_POST);
        $this->request->setContent('{"identityName": "toby", "credential": "wrong password"}');
        $this->controller->dispatch($this->request, $this->response);
    }

    public function testLoginSuccess(){

        $this->request->setMethod(Request::METHOD_POST);
        $this->request->setContent('{"identityName": "toby", "credential": "password"}');
        $result = $this->controller->dispatch($this->request, $this->response);
        $returnArray = $result->getVariables();

        $this->assertEquals('toby', $returnArray['name']);
    }

    public function testSecondLogout(){
        $this->logout();
    }

    protected function logout(){
        $this->routeMatch->setParam('id', -1);
        $this->request->setMethod(Request::METHOD_DELETE);
        $result = $this->controller->dispatch($this->request, $this->response);
        $returnArray = $result->getVariables();
        $this->assertEquals(0, count($returnArray));
    }
}

