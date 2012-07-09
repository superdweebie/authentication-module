SdsAuthModule
=============

A simple zend framework 2 authentication module. This module is enables AJAX authentication.

Module is also configured to use SdsAccessControl if desired.

#Installation

    -Add the module to your composer.json:

    "require": {
		"superdweebie/SdsAuthModule": "dev-master",
    }

    -Edit application.config.php and add an entry for `SdsAuthModule`

#Use

Override values in `module.config.php` to match your system.

Get the active user with `$serviceManager->get('activeUser');`.

Retrieve the JsonRpc SMD with a GET request to `/auth`. Use the returned SMD to make login and
logout requests to the server.