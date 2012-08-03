define([
    'dojo/_base/declare',
    'dojo/_base/Deferred',
    'dijit/_Widget',
    'dijit/_TemplatedMixin',
    'dijit/_WidgetsInTemplateMixin',
    'sijit/ServiceManager/SafeGetPropertyMixin',
    'Sds/AuthModule/LoginFormInterface',
    'dojo/text!./Template/LoginFormDialog.html',
    'sijit/Common/Dialog',
    'sijit/Common/JsLink',
    'dojox/layout/TableContainer',
    'dijit/form/ValidationTextBox'
],
function(
    declare,
    Deferred,
    Widget,
    TemplatedMixin,
    WidgetsInTemplateMixin,
    SafeGetPropertyMixin,
    LoginFormInterface,
    template
){
    return declare(
        'Sds.AuthModule.LoginFormDialog',
        [
            Widget,
            TemplatedMixin,
            WidgetsInTemplateMixin,
            SafeGetPropertyMixin,
            LoginFormInterface
        ],
        {
            templateString: template,

            // userController: Sds.UserModule.UserControllerInterface | sijit.ServiceManager.Ref
            //     A userController or reference to one
            userController: undefined,

            activate: function(){
                return this.loginDialogNode.show();
            },
            reset: function(){
                return this.loginDialogNode.reset();
            },
            _getValueAttr: function(){
                return this.loginDialogNode.get('value');
            },
            _getStateAttr: function(){
                return this.loginDialogNode.get('state');
            },
            _onRecoverPassword: function(){
                this.set('state', 'recoverPassword');
                this.loginDialogNode.hide();
                Deferred.when(this.safeGetProperty('userController'), function(userController){
                    userController.recoverPassword();
                });
            },
            _onRegister: function(){
                this.set('state', 'register');
                this.loginDialogNode.hide();
                Deferred.when(this.safeGetProperty('userController'), function(userController){
                    userController.register();
                });
            }
        }
    );
});


