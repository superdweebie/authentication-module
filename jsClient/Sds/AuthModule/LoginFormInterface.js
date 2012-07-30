define
(
    [
        'dojo/_base/declare'
    ],
    function
    (
        declare
    )
    {
        // module:
        //		Sds/AuthModule/LoginFormInterface
        // summary:
        //		The module defines the interface for login forms.

        return declare
        (
            'Sds.AuthModule.LoginFormInterface',
            null,
            {
                activate: function(){
                    // summary:
                    //		Makes the login form visible/active
                    // returns: Deferred
                    //		A Deferred that resolves
                    //		when the form is complete.
                },
                isValid: function(){
                    // summary:
                    //		Checks if the form values are valid
                    // returns: boolean
                },
                getValues: function(){
                    // summary:
                    //		Gets the form value object
                    // returns: object
                    //		An object with all the form values. Form values must include
                    //      username and password, eg:
                    //      {
                    //          username: 'superdweebie',
                    //          password: 'password'
                    //      }
                },
                reset: function(){
                    // summary:
                    //		Resets/clears the form
                }
            }
        );
    }
);


