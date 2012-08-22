Sds authModule
==============

[![Build Status](https://secure.travis-ci.org/superdweebie/authModule.png)](http://travis-ci.org/superdweebie/authModule)

A simple zend framework 2 authentication module. This module is enables AJAX authentication.

For a dojo based client that consumes this authenticaion service, see superdweebie/sijit.

Module is also configured to use Sds accessControl if desired.

#Release Information

I'm pleased to annouce that authModule has reached some degree of stability! This is therefore release 0.1.

#Installation

    -Add the module to your composer.json:

    "require": {
		"superdweebie/auth-module": "dev-master",
    }

    -Edit application.config.php and add an entry for `Sds\authModule`

#Use

Override values in `module.config.php` to match your system.

Get the active user with `$serviceManager->get('sds.auth.activeUser');`.

Retrieve the JsonRpc SMD with a GET request to `/auth`. Use the returned SMD to make login and
logout requests to the server.