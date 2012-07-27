define(
    [],
    function(){
        return {
            serviceManager: {
                authController: {
                    moduleName: 'Sds/AuthModule/AuthController',
                    variable: {
                        authApiMap: undefined,
                        loginPostBootstrap: undefined,
                        pageRefreshTarget: undefined,
                        activeUser: undefined
                    },
                    asyncObject: {
//                        status: 'status',
//                        errorService: 'errorController',
//                        recoverPasswordDialog: 'Sds/UserModule/RecoverPasswordDialog',
//                        registerDialog: 'Sds/UserModule/RegisterDialog',
                        loginDialog: 'Sds/AuthModule/LoginDialog'
                    }
                }
            }
        }
    }
);


