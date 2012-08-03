define([
    'dojo/_base/declare',
    'dojo/_base/lang',
    'dojo/_base/Deferred',
    'sijit/Common/Status',
    'dojox/rpc/Service',
    'dojo/Stateful',
    'sijit/ServiceManager/SafeGetPropertyMixin',
    'dojox/rpc/JsonRPC'
],
function (
    declare,
    lang,
    Deferred,
    Status,
    RpcService,
    Stateful,
    SafeGetPropertyMixin
){
    return declare(
        'Sds.AuthModule.AuthController',
        [Stateful, SafeGetPropertyMixin],
        {
            authApiMap: undefined,

            authApi: undefined,

            activeUser: undefined,

            loggedIn: false,

            status: undefined,

            errorService: undefined,

            // loginForm: Sds.AuthModule.LoginFormInterface | sijit.ServiceManager.Ref
            //     A login form, or reference to a login form.
            //     This form is shown to prompt login
            loginForm: undefined,

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
                this._loginDeferred = new Deferred();

                Deferred.when(this._activateLoginForm(), lang.hitch(this, function(){
                    this._processFormData();
                }));

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
            _authApiGetter: function(){
                if ( ! this.authApi) {
                    this.authApi = new RpcService(this.authApiMap);
                }
                return this.authApi;
            },
            _activateLoginForm: function()
            {
                // summary:
                //		Prompt for login details
                // returns: Deferred
                //      Returned deferred will resolve when the login
                //      form is complete.

                // The actual form activation
                var formDeferred = new Deferred;

                Deferred.when(this.safeGetProperty('loginForm'), function(loginForm){
                    Deferred.when(loginForm.activate(), function(){
                        formDeferred.resolve();
                    });
                });

                return formDeferred;
            },
            _processFormData: function(){
                // summary:
                //		Check the form validity, and send to the server
                // returns: Deferred
                //      Returned deferred will resolve when the login
                //      form is complete.

                // Do nothing if form not valid.
                if (!this.loginForm.get('state') == ''){
                    return;
                }

                // Update status
                this.set('status', new Status('logging in', Status.icon.SPINNER));

                // Send data to server
                var formValue = this.loginForm.get('value');

                this.get('authApi').login(formValue['username'], formValue['password']).then(
                    lang.hitch(this, '_loginComplete'),
                    lang.hitch(this, '_loginError')
                );
                this.loginForm.reset();
            },
            _loginComplete: function(data)
            {
                // Update status
                this.set('status', new Status('login complete', Status.icon.SUCCESS, 5000));

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
            }
        }
    );
});