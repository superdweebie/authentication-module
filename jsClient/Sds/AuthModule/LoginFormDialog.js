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
                _onRecoverPassword: function(){
                    this.loginDialogNode.setFormValue({recoverPassword: "1"});
                    this.loginDialogNode.hide();
                },
                _onRegister: function(){
                    this.loginDialogNode.setFormValue({register: "1"});
                    this.loginDialogNode.hide();
                }
            }
        );
    }
);


