<?php

// Inialize session
session_start();

// Check, if user is already login, then jump to secured page
if (isset($_SESSION['username'])) {
header('Location: categories.php');

}

?>
<!DOCTYPE html>
<html>
  <head>
    <title>Login</title>
    <!-- Bootstrap -->
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="js/bootstrap.min.js"></script>
	<script src="js/bootstrap.js"></script>
	<script src="js/loginPage.js"></script>

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
              <ul class="nav pull-right">
				<li><a class="" href="addUser.php">Sign Up</a></li>
			</ul>
		    </div>
		  </div>
	</div>
	<div class="hero-unit">
	  <h1>B561</h1>
	  <p>Advanced Database System</p>
	<div class="container-fluid">
	  <div class="row-fluid">
	    <div class="span6 well">
			<form class="form-horizontal" method="POST" action="loginvalidation.php">
			  <legend><i class="icon-user" style="vertical-align: middle"></i>&nbsp;Log In</legend>
			
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
    			<label class="control-label" for="password">Password</label>
			    <div class="controls">
			      <input type="password" id="password" name="password" placeholder="password">
			    </div>
			  </div>
              
                <div class="alert alert-error" id="passwordAlertView">
				  <!-- <button type="button" class="close" data-dismiss="alert">×</button> -->
				  <strong>Warning!</strong> Please enter password
				</div>
			
			  <div class="control-group">
			    <div class="controls">
			      <!--<label class="checkbox">
			     <input type="checkbox"> Remember me
			      </label>-->
			      <button type="submit" class="btn" id="loginButton">Sign in</button>
				 <!-- <button class="btn btn-link btn-mini" id="forgotPasswordButton">Forgot password?</button>-->
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
