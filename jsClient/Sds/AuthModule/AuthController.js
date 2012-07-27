define
(
    [
        'dojo/_base/declare',
        'dojo/_base/lang',
        'dojo/_base/Deferred',
        'dojox/rpc/Service',
        'dojox/rpc/JsonRPC',
        'dojo/Stateful',
        'sijit/common/SubscribeMixin'
    ],
    function
    (
        declare,
        lang,
        Deferred,
        RpcService,
        JsonRpc,
        Stateful,
        SubscribeMixin
    )
    {
        return declare
        (
            'Sds.AuthModule.AuthController',
            [Stateful, SubscribeMixin],
            {
                authApiMap: undefined,

                authApi: undefined,

                loginPostBootstrap: false,

                pageRefreshTarget: undefined,

                activeUser: undefined,

                loggedIn: false,
                status: undefined,
                objectService: undefined,
                pageLoaderService: undefined,
                errorService: undefined,
                loginDialog: undefined,
                recoverPasswordDialog: undefined,
                registerDialog: undefined,
                constructor: function()
                {
                    this.subscribe('postBootstrap', 'postBootstrap');
                },
                postBootstrap: function(){
                    this.authApi = new RpcService(this.authApiMap);
                    if(this.loginPostBootstrap){
                        this.login();
                    }
                },
                handleAccessDenied: function()
                {
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
                    this.showLoginForm();
                    this._loginDeferred = new Deferred();
                    return this._loginDeferred;
                },
                showLoginForm: function()
                {
                    if (this.loginDialog.show == undefined){
                        this.loginDialog.getObject(lang.hitch(this, function(loginDialog){
                            this.loginDialog = loginDialog;
                            this.showLoginForm();
                        }));
                        return;
                    }

                    Deferred.when(this.loginDialog.show(), lang.hitch(this, function()
                    {
                        var formValues = this.loginDialog.getFormValue();
                        if(formValues['recoverPassword'] && formValues['recoverPassword'] != "0"){
                            this.recoverPassword();
                            return;
                        }
                        if(formValues['register'] && formValues['register'] != "0"){
                            this.register();
                            return;
                        }

                        this._setStatus({message: 'logging in', icon: 'spinner'});
                        this.authApi.login(formValues['username'], formValues['password']).then(
                            lang.hitch(this, 'loginComplete'),
                            lang.hitch(this, 'loginError')
                        );
                        this.loginDialog.resetForm();
                    }));
                },
                loginComplete: function(data)
                {
                    this._setStatus({message: 'login complete', icon: 'success', timeout: 5000});
                    this.set('activeUser', data.user);
                    if(data.data){
                        this.objectService.use(function(objectService){
                            objectService.preloadCache({data: data.data});
                        });
                    }
                    this.refreshPage();
                    this._loginDeferred.resolve(true);
                    this.set('loggedIn', true);
                },
                loginError: function(error)
                {
                    this.errorService.use(function(errorService){
                        errorService.handle(error);
                    });
                    this._loginDeferred.resolve(false);
                },
                logout: function()
                {
                    this._setStatus({message: 'logging out', icon: 'spinner'});
                    this.authApi.logout().then(
                        lang.hitch(this, 'logoutComplete'),
                        lang.hitch(this, 'logoutError')
                    );
                    this._logoutDeferred = new Deferred();
                    return this._logoutDeferred;
                },
                logoutComplete: function(data)
                {
                    this._setStatus({message: 'logout complete', icon: 'success', timeout: 5000});
                    this.set('activeUser', data.user);
                    this.objectService.use(function(objectService){
                        objectService.flushCache();
                    });
                    if(data.url){
                        this.pageLoaderService.use(function(pageLoaderService){
                            pageLoaderService..loadPage({url: data.url});
                        });
                    }
                    this.refreshPage();
                    this._logoutDeferred.resolve(true);
                    this.set('loggedIn', false);
                },
                logoutError: function(error)
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