define
(
    [
        'dojo/_base/declare',
        'dojo/_base/lang',
        'dojo/_base/Deferred',
        'dojox/rpc/Service',
        'dojo/Stateful',
        'dojox/rpc/JsonRPC'
    ],
    function
    (
        declare,
        lang,
        Deferred,
        RpcService,
        Stateful
    )
    {
        return declare
        (
            'Sds.AuthModule.AuthController',
            [Stateful],
            {
                authApiMap: undefined,

                activeUser: undefined,

                loggedIn: false,

                status: undefined,

                errorService: undefined,

                loginForm: undefined,

                authApi: undefined,

                constructor: function()
                {
                    this.authApi = new RpcService(this.authApiMap);
                },
                handleAccessDenied: function()
                {
                    // summary:
                    //		Checks if there is an active user. If so, raise an error.
                    //      If not, then prompt for login.

                    if(this.get('activeUser'))
                    {
                        this.errorService.use(function(errorService){
                            errorService.handle({message: 'Access denied'});
                        });
                        return null;
                    } else {
                        return this.login();
                    }
                },
                login: function()
                {
                    // summary:
                    //		Prompt for login details, and process
                    // returns: Deferred
                    //      Returned deferred will resolve when the whole login
                    //      process is complete.

                    Deferred.when(this._activateLoginForm(), lang.hitch(this, function(){
                        this._processFormData();
                    }));
                    this._loginDeferred = new Deferred();
                    return this._loginDeferred;
                },
                logout: function()
                {
                    // summary:
                    //		Send logout message to the server
                    // returns: Deferred
                    //      Returned deferred will resolve when the whole login
                    //      process is complete.

                    // Update status
                    this._setStatus({message: 'logging out', icon: 'spinner'});

                    // Send message to server
                    this.authApi.logout().then(
                        lang.hitch(this, '_logoutComplete'),
                        lang.hitch(this, '_logoutError')
                    );
                    this._logoutDeferred = new Deferred();
                    return this._logoutDeferred;
                },
                _activateLoginForm: function()
                {
                    // summary:
                    //		Prompt for login details
                    // returns: Deferred
                    //      Returned deferred will resolve when the login
                    //      form is complete.

                    // Checks to see if the form is only a reference. If so, the reference is loaded.
                    if (this.loginForm.getObject){
                        var outterFormDeferred = new Deferred;
                        Deferred.when(this.loginForm.getObject(), lang.hitch(this, function(loginForm){
                            this.loginForm = loginForm;
                            Deferred.when(this._activateLoginForm(), function(){
                               outterFormDeferred.resolve();
                            });
                        }));
                        return outterFormDeferred;
                    }

                    // The actual form activation
                    var innnerFormDeferred = new Deferred;
                    Deferred.when(this.loginForm.activate(), lang.hitch(this, function(){
                        innnerFormDeferred.resolve();
                    }));

                    return innnerFormDeferred;
                },
                _processFormData: function(){
                    // summary:
                    //		Check the form validity, and send to the server
                    // returns: Deferred
                    //      Returned deferred will resolve when the login
                    //      form is complete.

                    // Do nothing if not valid.
                    if (!this.loginForm.isValid()){
                        return;
                    }

                    var formValues = this.loginForm.getValues();

                    // Update status
                    this._setStatus({message: 'logging in', icon: 'spinner'});

                    // Send data to server
                    this.authApi.login(formValues['username'], formValues['password']).then(
                        lang.hitch(this, '_loginComplete'),
                        lang.hitch(this, '_loginError')
                    );
                    this.loginDialog.reset();
                },
                _loginComplete: function(data)
                {
                    // Update status
                    this._setStatus({message: 'login complete', icon: 'success', timeout: 5000});

                    //Set the active user
                    this.set('activeUser', data.user);

                    this.set('loggedIn', true);
                    this._loginDeferred.resolve(true);
                },
                _loginError: function(error)
                {
                    this.errorService.use(function(errorService){
                        errorService.handle(error);
                    });
                    this._loginDeferred.resolve(false);
                },
                _logoutComplete: function(data)
                {
                    this._setStatus({message: 'logout complete', icon: 'success', timeout: 5000});
                    this.set('activeUser', data.user);
                    this.objectService.use(function(objectService){
                        objectService.flushCache();
                    });
                    if(data.url){
                        this.pageLoaderService.use(function(pageLoaderService){
                            pageLoaderService.loadPage({url: data.url});
                        });
                    }
                    this.refreshPage();
                    this._logoutDeferred.resolve(true);
                    this.set('loggedIn', false);
                },
                _logoutError: function(error)
                {
                    this.errorService.use(function(errorService){
                        errorService.handle(error);
                    });
                    this._logoutDeferred.resolve(false);
                },
                recoverPassword: function(){
                    this.showRecoverPasswordForm();
                    this._recoverPasswordDeferred = new Deferred();
                    return this._recoverPasswordDeferred;
                },
                showRecoverPasswordForm: function()
                {
                    if (this.recoverPasswordDialog.show == undefined){
                        this.recoverPasswordDialog.use(lang.hitch(this, function(recoverPasswordDialog){
                            this.recoverPasswordDialog = recoverPasswordDialog;
                            this.showRecoverPasswordForm();
                        }));
                        return;
                    }
                    Deferred.when(this.recoverPasswordDialog.show(), lang.hitch(this, function()
                    {
                        var formValues = this.recoverPasswordDialog.getFormValue();
                        this._setStatus({message: 'recovering password', icon: 'spinner'});
                        this.authApi.recoverPassword(formValues['username'], formValues['email']).then(
                            lang.hitch(this, 'recoverPasswordComplete'),
                            lang.hitch(this, 'recoverPasswordError')
                        );
                        this.recoverPasswordDialog.resetForm();
                    }));
                },
                recoverPasswordComplete: function(data)
                {
                    this._setStatus({message: 'recover password complete', icon: 'success', timeout: 5000});
                    this._recoverPasswordDeferred.resolve(true);
                },
                recoverPasswordError: function(error)
                {
                    this.errorService.use(function(errorService){
                        errorService.handle(error);
                    });
                    this._recoverPasswordDeferred.resolve(false);
                },
                register: function(){
                    this.showRegisterForm();
                    this._registerDeferred = new Deferred();
                    return this._registerDeferred;
                },
                showRegisterForm: function()
                {
                    if (this.registerDialog.show == undefined){
                        this.registerDialog.use(lang.hitch(this, function(registerDialog){
                            this.registerDialog = registerDialog;
                            this.showRegisterForm();
                        }));
                        return;
                    }
                    Deferred.when(this.registerDialog.show(), lang.hitch(this, function()
                    {
                        var formValues = this.registerDialog.getFormValue();
                        this._setStatus({message: 'registering new user', icon: 'spinner'});
                        this.authApi.register(formValues['username'], formValues).then(
                            lang.hitch(this, 'registerComplete'),
                            lang.hitch(this, 'registerError')
                        );
                        this.registerDialog.resetForm();
                    }));
                },
                registerComplete: function(data)
                {
                    this._setStatus({message: 'registration complete', icon: 'success', timeout: 5000});
                    this._registerDeferred.resolve(true);
                },
                registerError: function(error)
                {
                    this.errorService.use(function(errorService){
                        errorService.handle(error);
                    });
                    this._registerDeferred.resolve(false);
                },
                refreshPage: function(){
                    if(this.config.pageRefreshTarget){
                        this.pageLoaderService.use(lang.hitch(this, function(pageLoaderService){
                            pageLoaderService.refreshPage(this.config.pageRefreshTarget);
                        }));
                    }
                },
                _setStatus: function(status){
                    this.status.set('status', status);
                }
            }
        );
    }
);