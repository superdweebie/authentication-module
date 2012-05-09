SdsAuthModule
=============

A simple zend framework 2 authentication module. This module is targeted at AJAX authentication.

#Installation

    -Place the module in your vendor directory.
    -Edit application.config.php and add an entry for `SdsAuthModule`
    -Copy the `module.sdsauthmodule.global.config.php.dist` file to your `config\autoload` directory and edit it with your own Auth Adapter settings. It is preconfigured to use DoctrineMongoDBModule.

#Use

Configure the guest user in module.sdsauthmodule.global.config.php. This object will be the active_user when there is no authenticated identity.

The active_user alias is created in the DI config. It can be used to inject the active user into your objects.

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