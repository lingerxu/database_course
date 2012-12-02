$("document").ready(function(){

	 $("#usernameAlertView").hide();
	 $("#passwordAlertView").hide();


	$("#loginButton").click(function(event){
		console.log("login button clicked");
		var email = $("#username").val();
		var pass = $("#password").val();
		console.log("username :"+email + email.length);
		console.log("password :"+pass  + pass.length);
		
		
		var isUsernameValid = false;
		var isPasswordValid = false;
		
		if(email.length<1)
		{
			$("#usernameAlertView").show();
		}  
		else
		{
			$("#usernameAlertView").hide();
			isUsernameValid = true;
		}
		 
		
		
		if(pass.length<1)
		{
			$("#passwordAlertView").show();
			
		}  
		else 
		{
			$("#passwordAlertView").hide();
			isPasswordValid = true;
			
		}
		
		
		if(!isPasswordValid || !isUsernameValid)
		{
			event.preventDefault();
			return false;
		}

		 
		
		
	});
	
	$("#forgotPasswordButton").click(function(){

		console.log("forgot password clicked");
	});
	

});