Sds authModule
==============

[![Build Status](https://secure.travis-ci.org/superdweebie/authModule.png)](http://travis-ci.org/superdweebie/authModule)

A thin zend framework 2 module that wraps an AuthenticationService for simple AJAX based authentication.

By default is set up to work with the DoctrineMongoORMModule authentication adapter.

For a dojo based client that consumes this authenticaion service, see superdweebie/sijit.

Module is also configured to use Sds accessControl if desired.

#Release Information

I'm pleased to annouce that authModule has had a significant update. Architecture has been much improved.
This is therefore release 0.2.

#Installation

    -Add the module to your composer.json:

    "require": {
		"superdweebie/auth-module": "dev-master",
    }

    -Edit application.config.php and add an entry for `Sds\authModule`

#Use

Override values in `module.config.php` to match your system.

To get the active user in a view or controller, just use

    $activeUser = $this->identity();

Retrieve the JsonRpc SMD with a GET request to `/auth`. Use the returned SMD to make login and
logout requests to the server.