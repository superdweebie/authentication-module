define(
    [],
    function(){
        return {
            serviceManager: {
                authController: {
                    moduleName: 'Sds/AuthModule/AuthController',
                    values: {
                        authApiMap: '../../../../../auth',
                        loginPostBootstrap: undefined,
                        pageRefreshTarget: undefined,
                        activeUser: undefined
                    },
                    refObjects: {
//                        errorService: 'errorController',
                        loginForm: 'loginForm'
                    }
                },
                loginForm: {
                    moduleName: 'Sds/AuthModule/LoginFormDialog',
                    refObjects: {
                        userController: 'userController'
                    }
                }
            }
        }
    }
);


