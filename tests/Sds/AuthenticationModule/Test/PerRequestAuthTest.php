<?php

namespace Sds\AuthenticationModule\Test;

use Sds\Common\Crypt\Hash;
use Sds\ModuleUnitTester\AbstractTest;
use Sds\AuthenticationModule\AuthenticationService;
use Sds\AuthenticationModule\Test\TestAsset\Identity;
use Zend\Http\Header\GenericHeader;
use Zend\Http\Request;
use Zend\Http\Response;

class PerRequestAuthTest extends AbstractTest{

    protected $request;

    protected $response;

    protected $authenticationService;

    public function setUp(){

        parent::setUp();

        $this->request    = new Request();
        $this->response   = new Response();

        $config = $this->serviceManager->get('config');
        $config['sds']['authentication']['authenticationServiceOptions']['enablePerRequest'] = true;

        $this->serviceManager->setAllowOverride(true);
        $this->serviceManager->setService('request', $this->request);
        $this->serviceManager->setService('response', $this->response);
        $this->serviceManager->setService('Config', $config);
        $this->serviceManager->setAllowOverride(false);

        $identity = new Identity;
        $identity->setIdentityName('toby');
        $identity->setCredential(Hash::hashAndPrependSalt(Hash::getSalt(), 'password'));

        $this->documentManager = $this->serviceManager->get('doctrine.documentmanager.odm_default');

        $this->documentManager->persist($identity);
        $this->documentManager->flush();

        $this->authenticationService = $this->serviceManager->get('Zend\Authentication\AuthenticationService');
    }

    public function testSucceed(){

        $this->request->setUri('https://test.local');
        $this->request->getHeaders()->addHeader(GenericHeader::fromString('Authorization: Basic ' . base64_encode('toby:password')));

        $this->assertTrue($this->authenticationService->hasIdentity());

        $identity = $this->authenticationService->getIdentity();
        $this->assertEquals('toby', $identity->getIdentityName());
    }

    public function testCredentialFail(){

        $this->request->setUri('https://test.local');
        $this->request->getHeaders()->addHeader(GenericHeader::fromString('Authorization: Basic ' . base64_encode('toby:not password')));

        $this->assertFalse($this->authenticationService->hasIdentity());
    }

    public function testSchemeFail(){

        $this->request->setUri('http://test.local');
        $this->request->getHeaders()->addHeader(GenericHeader::fromString('Authorization: Basic ' . base64_encode('toby:password')));

        $this->assertFalse($this->authenticationService->hasIdentity());
    }
}

