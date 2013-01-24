<?php

namespace Sds\AuthenticationModule\Test;

use Sds\ModuleUnitTester\AbstractTest;
use Sds\AuthenticationModule\AuthenticationService;
use Zend\Http\Request;
use Zend\Http\Response;

class GuestIdentityAuthTest extends AbstractTest{

    protected $request;

    protected $response;

    protected $authenticationService;

    public function setUp(){

        parent::setUp();

        $this->request    = new Request();
        $this->response   = new Response();

        $this->serviceManager->setAllowOverride(true);
        $this->serviceManager->setService('request', $this->request);
        $this->serviceManager->setService('response', $this->response);
        $this->serviceManager->setAllowOverride(false);

        $this->authenticationService = $this->serviceManager->get('Zend\Authentication\AuthenticationService');
        $this->authenticationService->getOptions()->setModes([
            AuthenticationService::GUESTIDENTITY
        ]);
    }

    public function testSucceed(){

        $this->assertTrue($this->authenticationService->hasIdentity());

        $identity = $this->authenticationService->getIdentity();
        $this->assertEquals('guest', $identity->getIdentityName());
    }
}

