

	function validateEmail(str) 
	{
    	var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
	    if (filter.test(str)) {
	        return true;
	    }
	    else {
	        return false;
	    }
	}

$("document").ready(function(){

	 $("#usernameAlertView").hide();
	 $("#firstnameAlertView").hide();
	 $("#lastnameAlertView").hide();
	 $("#emailAlertView").hide();
	 $("#passwordAlertView").hide();
	 $("#repasswordAlertView").hide();
	 $("#repasswordAlertView2").hide();


	$("#addButton").click(function(event){
		console.log("add button clicked");
		var username = $("#username").val();
		var firstname = $("#firstname").val();
		var lastname = $("#lastname").val();
		var email = $("#email").val();
		var pass = $("#password").val();
		var repass = $("#repassword").val();
		
		//console.log("username :"+usename + username.length);
		//console.log("password :"+pass  + pass.length);
		
		
		var isUsernameValid = false;
		var isFirstnameValid = false;
		var isLastnameValid = false;
		var isEmailValid = false;
		var isPasswordValid = false;
		var isRePasswordValid = false;
		var isRePasswordValid2 = false;
		
		
		if(username.length<1)
		{
			$("#usernameAlertView").show();
		}
		  
		else
		{
			$("#usernameAlertView").hide();
			isUsernameValid = true;
		}
		 
		 if(firstname.length<1)
		{
			$("#firstnameAlertView").show();
		}  
		else
		{
			$("#firstnameAlertView").hide();
			isFirstnameValid = true;
		}
		
		if(lastname.length<1)
		{
			$("#lastnameAlertView").show();
		}  
		else
		{
			$("#lastnameAlertView").hide();
			isLastnameValid = true;
		}
		
		if(email.length<1)
		{
			$("#emailAlertView").show();
		}  
		else
		{
			$("#emailAlertView").hide();
			isEmailValid = true;
		}
		
		if (validateEmail(email)) 
		{
	        $("#emailAlertView").hide();
			isEmailValid = true;
        }
        else 
		{
            $("#emailAlertView").show();
			isEmailValid = false;
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
		
		if(repass!=pass )
		{
			$("#repasswordAlertView2").show();
			
		}  
		else 
		{
			$("#repasswordAlertView2").hide();
			isRePasswordValid2 = true;
			
		}
		
		if(repass.length<1)
		{
			$("#repasswordAlertView").show();
			$("#repasswordAlertView2").hide();
			
		}  
		else 
		{
			$("#repasswordAlertView").hide();
			isRePasswordValid = true;
			
		}
		
				
		if(!isUsernameValid || !isFirstnameValid || !isLastnameValid || !isEmailValid || !isPasswordValid || !isRePasswordValid || !isRePasswordValid2)
		{
			event.preventDefault();
			return false;
		}

		 
		
		
	});
	
	$("#forgotPasswordButton").click(function(){

		console.log("forgot password clicked");
	});
	

});