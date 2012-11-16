<?php

namespace Sds\AuthenticationModule\Test\Controller;

use Sds\Common\Crypt\Hash;
use Sds\ModuleUnitTester\AbstractControllerTest;
use Sds\AuthenticationModule\Test\TestAsset\Identity;
use Zend\Http\Request;

class ControllerTest extends AbstractControllerTest{

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

    public function testLogoutWithNoAuthenticatedIdentity(){
        $this->routeMatch->setParam('id', -1);
        $this->request->setMethod(Request::METHOD_DELETE);
        $result = $this->controller->dispatch($this->request, $this->response);
        $returnArray = $result->getVariables();
        $this->assertEquals(0, count($returnArray));
    }

    public function testLogoutWithAuthenticatedIdentity(){

        $this->controller->getOptions()->getAuthenticationService()->login('toby', 'password');

        $this->routeMatch->setParam('id', -1);
        $this->request->setMethod(Request::METHOD_DELETE);
        $result = $this->controller->dispatch($this->request, $this->response);
        $returnArray = $result->getVariables();
        $this->assertEquals(0, count($returnArray));
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

    public function testLoginSuccessWithAuthenticatedIdentity(){

        $this->controller->getOptions()->getAuthenticationService()->login('toby', 'password');

        $this->request->setMethod(Request::METHOD_POST);
        $this->request->setContent('{"identityName": "toby", "credential": "password"}');
        $result = $this->controller->dispatch($this->request, $this->response);
        $returnArray = $result->getVariables();

        $this->assertEquals('toby', $returnArray['name']);
    }

    public function testLoginFailWithAuthenticatedIdentity(){
        $this->setExpectedException('Sds\AuthenticationModule\Exception\LoginFailedException');

        $this->controller->getOptions()->getAuthenticationService()->login('toby', 'password');

        $this->request->setMethod(Request::METHOD_POST);
        $this->request->setContent('{"identityName": "toby", "credential": "wrong password"}');
        $this->controller->dispatch($this->request, $this->response);
    }

    public function testGetWithAuthenticatedIdentity(){

        $this->controller->getOptions()->getAuthenticationService()->login('toby', 'password');

        $this->request->setMethod(Request::METHOD_GET);
        $result = $this->controller->dispatch($this->request, $this->response);
        $returnArray = $result->getVariables();

        $this->assertEquals('toby', $returnArray[0]['name']);
    }

    public function testGetWithoutAuthenticatedIdentity(){

        $this->request->setMethod(Request::METHOD_GET);
        $result = $this->controller->dispatch($this->request, $this->response);
        $returnArray = $result->getVariables();

        $this->assertCount(0, $returnArray);
    }
}

