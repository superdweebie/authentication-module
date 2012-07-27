define
(
    [
        'dojo/_base/declare',
        'dijit/_Widget',
        'dijit/_TemplatedMixin',
        'dijit/_WidgetsInTemplateMixin',
        'dojo/text!./Template/LoginDialog.html',
        'sds/Dialog',
        'dojox/layout/TableContainer',
        'dijit/form/ValidationTextBox'
    ],
    function
    (
        declare,
        _Widget,
        templatedMixin,
        widgetsInTemplateMixin,
        template
    )
    {
        return declare
        (
            'Sds.AuthModule.LoginDialog',
            [_Widget, templatedMixin, widgetsInTemplateMixin],
            {
                templateString: template,
                show: function(){
                    return this.loginDialogNode.show();
                },
                getFormValue: function(){
                    return this.loginDialogNode.getFormValue();
                },
                resetForm: function(){
                    return this.loginDialogNode.resetForm();
                },
                onRecoverPassword: function(){
                    this.loginDialogNode.setFormValue({recoverPassword: "1"});
                    this.loginDialogNode.hide();
                },
                onRegister: function(){
                    this.loginDialogNode.setFormValue({register: "1"});
                    this.loginDialogNode.hide();
                }
            }
        );
    }
);


