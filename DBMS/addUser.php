<?php

// Inialize session
session_start();

?>
<!DOCTYPE html>
<html>
  <head>
    <title>Sign Up</title>
    <!-- Bootstrap -->
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="js/bootstrap.min.js"></script>
	<script src="js/bootstrap.js"></script>
	<script src="js/addUser.js"></script>

    <link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/bootstrap-responsive.css" rel="stylesheet">
	<link href="css/bootstrap-responsive.min.css" rel="stylesheet">
	<link href="css/bootstrap.min.css" rel="stylesheet">
	
  </head>
  <body>
	<div class="navbar navbar-inverse">
		<div class="navbar-inner">
		    <div class="container">
		      <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		      </a>
		      <a class="brand" href="index.php">Course Discussion System</a>
		      <div class="nav-collapse">
				<!-- <ul class="nav">
				  <li class="active">
				    <a href="#">Home</a>
				  </li>
				  <li><a href="#">TEST</a></li>
				  <li><a href="#">TEST</a></li>
				</ul> -->
		      </div>
		    </div>
		  </div>
	</div>
	<div class="hero-unit">
	  <h1>B561</h1>
	  <p>Advanced Database System</p>
	<div class="container-fluid">
	  <div class="row-fluid">
	    <div class="span6 well">
			<form class="form-horizontal" method="POST" action="addUserValidation.php">
			  <legend><i class="icon-user" style="vertical-align: middle"></i>&nbsp;Add Details</legend>
			
			  <div class="control-group">
			    <label class="control-label" for="username">username</label>
			    <div class="controls">
			      <input type="text" id="username" name="username" placeholder="username">
			    </div>
			  </div>
			
                <!-- </div> -->
				<div class="alert alert-error" id="usernameAlertView">
				  <!-- <button type="button" class="close" data-dismiss="alert">×</button> -->
				  <strong>Warning!</strong> Please enter username
				</div>

				<div class="control-group">
			    <label class="control-label" for="firstname">first name</label>
			    <div class="controls">
			      <input type="text" id="firstname" name="firstname" placeholder="firstname">
			    </div>
			  </div>
			
                <!-- </div> -->
				<div class="alert alert-error" id="firstnameAlertView">
				  <!-- <button type="button" class="close" data-dismiss="alert">×</button> -->
				  <strong>Warning!</strong> Please enter firstname
				</div>
                               
                <div class="control-group">
			    <label class="control-label" for="firstname">last name</label>
			    <div class="controls">
			      <input type="text" id="lastname" name="lastname" placeholder="lastname">
			    </div>
			  </div>
			
                <!-- </div> -->
				<div class="alert alert-error" id="lastnameAlertView">
				  <!-- <button type="button" class="close" data-dismiss="alert">×</button> -->
				  <strong>Warning!</strong> Please enter lastname
				</div>
                
                <div class="control-group">
			    <label class="control-label" for="email">email-id</label>
			    <div class="controls">
			      <input type="text" id="email" name="email" placeholder="email-id">
			    </div>
			  </div>
			
                <!-- </div> -->
				<div class="alert alert-error" id="emailAlertView">
				  <!-- <button type="button" class="close" data-dismiss="alert">×</button> -->
				  <strong>Warning!</strong> Please enter valid email-id
				</div>
                
			  <div class="control-group">
    			<label class="control-label" for="password">password</label>
			    <div class="controls">
			      <input type="password" id="password" name="password" placeholder="password">
			    </div>
			  </div>
              
                <div class="alert alert-error" id="passwordAlertView">
				  <!-- <button type="button" class="close" data-dismiss="alert">×</button> -->
				  <strong>Warning!</strong> Please enter password
				</div>
                
                <div class="control-group">
    			<label class="control-label" for="repassword">re-type password</label>
			    <div class="controls">
			      <input type="password" id="repassword" name="repassword" placeholder="password">
			    </div>
			  </div>
              
                <div class="alert alert-error" id="repasswordAlertView">
				  <!-- <button type="button" class="close" data-dismiss="alert">×</button> -->
				  <strong>Warning!</strong> Please re-enter password
				</div>
                <div class="alert alert-error" id="repasswordAlertView2">
				  <!-- <button type="button" class="close" data-dismiss="alert">×</button> -->
				  <strong>Warning!</strong> Passwords do not match
				</div>
			
			  <div class="control-group">
			    <div class="controls">
			      
			      <button type="submit" class="btn" id="addButton">Sign up</button>
				  
			    </div>
			  </div>
			</form>
		</div>
	    <div class="span6 well">
	      <!--Body content-->
		<p><img src="img/DiscussionForum.jpg"/><p>
	    </div>
	  </div>
	</div>
	
	</div>
	
  </body>
</html>
