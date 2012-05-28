SdsAuthModule
=============

A simple zend framework 2 authentication module. This module is targeted at AJAX authentication.

#Installation

    -Place the module in your vendor directory.
    -Edit application.config.php and add an entry for `SdsAuthModule`

#Use

Override values in `module.config.php` to match your system.

Get the active user with `$serviceManager->get('activeUser');`.

Two routes are configured:

    /login
    /logout

#Login

Login expects a POST with these two variables:

    Username
    Password

If authentication succeeds, it will return a JSON representation of the active user. If authentication fails, it will return a JSON error message.

#Logout

Logout expects an empty POST. It will return a JSON representation of the guest user.