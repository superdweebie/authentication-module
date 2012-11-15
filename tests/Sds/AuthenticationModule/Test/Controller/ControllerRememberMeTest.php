<?php

namespace Sds\AuthenticationModule\Test\Controller;

use Sds\Common\Crypt\Hash;
use Sds\ModuleUnitTester\AbstractControllerTest;
use Sds\AuthenticationModule\Test\TestAsset\Identity;
use Zend\Http\Header\SetCookie;
use Zend\Http\Response;
use Zend\Http\Request;

class ControllerRememberMeTest extends AbstractControllerTest{

    protected static $staticDcumentManager;

    protected static $dbIdentityCreated = false;

    public static function tearDownAfterClass(){
        //Cleanup db after all tests have run
        $collections = static::$staticDcumentManager->getConnection()->selectDatabase('authenticationModuleTest')->listCollections();
        foreach ($collections as $collection) {
            $collection->remove(array(), array('safe' => true));
        }
    }

    public function setUp(){

        $this->controllerName = 'Sds\AuthenticationModule\Controller\AuthenticatedIdentityController';

        parent::setUp();

        $this->documentManager = $this->serviceManager->get('doctrine.documentmanager.odm_default');
        static::$staticDcumentManager = $this->documentManager;

        if ( ! static::$dbIdentityCreated){
            //Create an indentiy in the db to query against

            $identity = new Identity;
            $identity->setIdentityName('toby');
            $identity->setCredential(Hash::hashAndPrependSalt(Hash::getSalt(), 'password'));

            $this->documentManager->persist($identity);
            $this->documentManager->flush();

            static::$dbIdentityCreated = true;
        }

        $this->rememberMeObject = $this->documentManager->getRepository('Sds\AuthenticationModule\DataModel\RememberMe')->findOneBy([]);

        $this->serviceManager->setAllowOverride(true);
        $this->serviceManager->setService('request', $this->request);
        $this->serviceManager->setService('response', $this->response);
        $this->serviceManager->setAllowOverride(false);

        $this->controller->getOptions()->getAuthenticationService()->getOptions()->setRememberMeEnabled(true);
    }

    public function testLoginSuccessWithRememberMe(){

        //Do the inital login
        $this->request->setMethod(Request::METHOD_POST);
        $this->request->setContent('{"identityName": "toby", "credential": "password", "rememberMe": ["on"]}');

        $result = $this->controller->dispatch($this->request, $this->response);
        $returnArray = $result->getVariables();

        $this->assertEquals('toby', $returnArray['name']);
        $this->assertEquals(1, count($this->response->getHeaders()));

        $cookie = $this->response->getHeaders()->get('SetCookie')[0];
        $this->assertEquals('rememberMe', $cookie->getName());

        list($series, $token, $identityName) = explode("\n", $cookie->getValue());
        $this->assertNotNull($series);
        $this->assertNotNull($token);
        $this->assertEquals('toby', $identityName);
    }

    public function testGetIdentityWithRememberMe(){

        $this->request->setMethod(Request::METHOD_GET);

        $series = $this->rememberMeObject->getSeries();
        $token = $this->rememberMeObject->getToken();

        $requestCookie = new SetCookie();
        $requestCookie->setName('rememberMe');
        $requestCookie->setValue("$series\n$token\ntoby");
        $requestCookie->setExpires(time() + 3600);
        $this->request->getHeaders()->addHeader($requestCookie);

        $result = $this->controller->dispatch($this->request, $this->response);
        $returnArray = $result->getVariables();

        $this->assertEquals('toby', $returnArray[0]['name']);
        $this->assertEquals(1, count($this->response->getHeaders()));

        $responseCookie = $this->response->getHeaders()->get('SetCookie')[0];
        $this->assertEquals('rememberMe', $responseCookie->getName());

        list($newSeries, $newToken, $newIdentityName) = explode("\n", $responseCookie->getValue());
        $this->assertEquals($series, $newSeries);
        $this->assertNotEquals($token, $newToken);
        $this->assertEquals('toby', $newIdentityName);
    }

    public function testReloginWithRememberMeToken(){

        $series = $this->rememberMeObject->getSeries();
        $token = $this->rememberMeObject->getToken();

        $requestCookie = new SetCookie();
        $requestCookie->setName('rememberMe');
        $requestCookie->setValue("$series\n$token\ntoby");
        $requestCookie->setExpires(time() + 3600);
        $this->request->getHeaders()->addHeader($requestCookie);

        $this->request->setMethod(Request::METHOD_POST);
        $this->request->setContent('{"identityName": "toby", "credential": "password", "rememberMe": ["on"]}');
        $result = $this->controller->dispatch($this->request, $this->response);
        $returnArray = $result->getVariables();

        $this->assertEquals('toby', $returnArray['name']);
        $this->assertEquals(1, count($this->response->getHeaders()));

        $cookie = $this->response->getHeaders()->get('SetCookie')[0];
        $this->assertEquals('rememberMe', $cookie->getName());

        list($newSeries, $newToken, $newIdentityName) = explode("\n", $cookie->getValue());
        $this->assertNotEquals($series, $newSeries);
        $this->assertNotEquals($token, $newToken);
        $this->assertEquals('toby', $newIdentityName);
    }

    public function testGetIdentityWithNoRememberMeToken(){

        $this->request->setMethod(Request::METHOD_GET);

        $result = $this->controller->dispatch($this->request, $this->response);
        $returnArray = $result->getVariables();

        $this->assertCount(0, $returnArray);
        $this->assertEquals(1, count($this->response->getHeaders()));

        $responseCookie = $this->response->getHeaders()->get('SetCookie')[0];
        $this->assertEquals('rememberMe', $responseCookie->getName());
        $this->assertEquals('', $responseCookie->getValue());
    }

    public function testLoginSuccessWithRememberMe2(){

        //Do the inital login
        $this->request->setMethod(Request::METHOD_POST);
        $this->request->setContent('{"identityName": "toby", "credential": "password", "rememberMe": ["on"]}');

        $result = $this->controller->dispatch($this->request, $this->response);
        $returnArray = $result->getVariables();

        $this->assertEquals('toby', $returnArray['name']);
        $this->assertEquals(1, count($this->response->getHeaders()));

        $cookie = $this->response->getHeaders()->get('SetCookie')[0];
        $this->assertEquals('rememberMe', $cookie->getName());

        list($series, $token, $identityName) = explode("\n", $cookie->getValue());
        $this->assertNotNull($series);
        $this->assertNotNull($token);
        $this->assertEquals('toby', $identityName);
    }

    public function testSessionTheftWithRememberMe(){

        $this->request->setMethod(Request::METHOD_GET);

        $series = $this->rememberMeObject->getSeries();
        $token = 'wrong token';

        $requestCookie = new SetCookie();
        $requestCookie->setName('rememberMe');
        $requestCookie->setValue("$series\n$token\ntoby");
        $requestCookie->setExpires(time() + 3600);
        $this->request->getHeaders()->addHeader($requestCookie);

        $result = $this->controller->dispatch($this->request, $this->response);
        $returnArray = $result->getVariables();

        $this->assertCount(0, $returnArray);
        $this->assertEquals(1, count($this->response->getHeaders()));

        $responseCookie = $this->response->getHeaders()->get('SetCookie')[0];
        $this->assertEquals('rememberMe', $responseCookie->getName());
        $this->assertEquals('', $responseCookie->getValue());
    }
}

