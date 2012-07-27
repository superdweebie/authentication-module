define(["doh", "require"], function(doh, require){
	if(doh.isBrowser){
		doh.register("Sds.AuthModule.Test.TestAuthController", require.toUrl("./TestAuthController.html"));
	}
});
