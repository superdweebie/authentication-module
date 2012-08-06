define(
    [],
    function(){
        return {
            serviceManager: {
                authController: {
                    moduleName: 'Sds/AuthModule/AuthController',
                    values: {
                        authApiMap: '../../../../../auth'
                    },
                    refObjects: {
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


