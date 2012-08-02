define
(
    [
        'dojo/_base/declare',
        'dijit/_Widget',
        'dijit/_TemplatedMixin',
        'dijit/_WidgetsInTemplateMixin',
        'Sds/AuthModule/LoginFormInterface',
        'dojo/text!./Template/LoginFormDialog.html',
        'sijit/Common/Dialog',
        'sijit/Common/JsLink',
        'dojox/layout/TableContainer',
        'dijit/form/ValidationTextBox'
    ],
    function
    (
        declare,
        _Widget,
        templatedMixin,
        widgetsInTemplateMixin,
        LoginFormInterface,
        template
    )
    {
        return declare
        (
            'Sds.AuthModule.LoginFormDialog',
            [_Widget, templatedMixin, widgetsInTemplateMixin, LoginFormInterface],
            {
                templateString: template,

                // userController: Sds.UserModule.UserControllerInterface | sijit.ServiceManager.Ref
                //     A userController or reference to one
                userController: undefined,

                _isValild: false,

                activate: function(){
                    return this.loginDialogNode.show();
                },
                isValid: function(){
                    return this._isValid;
                },
                getValues: function(){
                    return this.loginDialogNode.getFormValue();
                },
                reset: function(){
                    return this.loginDialogNode.resetForm();
                },
                getUserController: function(){
                    // Checks to see if the userController is only a reference. If so, the reference is loaded.
                    var userControllerDeferred = new Deferred;
                    if (this.userController.getObject){
                        Deferred.when(this.userController.getObject(), lang.hitch(this, function(userController){
                            userControllerDeferred.resolve(userController);
                        }));
                    } else {
                        userControllerDeferred.resolve(this.userController);
                    }
                    return userControllerDeferred;
                },
                _onRecoverPassword: function(){
                    this.loginDialogNode.setFormValue({recoverPassword: "1"});
                    this.loginDialogNode.hide();
                    Deferred.when(this.getUserController(), function(userController){
                        userController.recoverPassword();
                    });
                },
                _onRegister: function(){
                    this.loginDialogNode.setFormValue({register: "1"});
                    this.loginDialogNode.hide();
                    Deferred.when(this.getUserController(), function(userController){
                        userController.register();
                    });
                }
            }
        );
    }
);


