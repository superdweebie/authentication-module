<?php

namespace Sds\AuthenticationModule\Test;

use Sds\ModuleUnitTester\AbstractTest;
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

        $config = $this->serviceManager->get('config');
        $config['sds']['authentication']['authenticationServiceOptions']['enableGuestIdentity'] = true;

        $this->serviceManager->setAllowOverride(true);
        $this->serviceManager->setService('request', $this->request);
        $this->serviceManager->setService('response', $this->response);
        $this->serviceManager->setService('Config', $config);
        $this->serviceManager->setAllowOverride(false);

        $this->authenticationService = $this->serviceManager->get('Zend\Authentication\AuthenticationService');
    }

    public function testSucceed(){

        $this->assertTrue($this->authenticationService->hasIdentity());

        $identity = $this->authenticationService->getIdentity();
        $this->assertEquals('guest', $identity->getIdentityName());
    }
}

