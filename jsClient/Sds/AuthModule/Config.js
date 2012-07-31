define(
    [],
    function(){
        return {
            serviceManager: {
                authController: {
                    moduleName: 'Sds/AuthModule/AuthController',
                    values: {
                        authApiMap: '../../../../auth',
                        loginPostBootstrap: undefined,
                        pageRefreshTarget: undefined,
                        activeUser: undefined
                    },
                    refObjects: {
//                        status: 'status',
//                        errorService: 'errorController',
                        loginForm: 'Sds/AuthModule/LoginFormDialog'
                    }
                }
            }
        }
    }
);


