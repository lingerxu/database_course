<!DOCTYPE html>
<html>
<head>
	<?php
	session_start();
	if(isset($_GET['a']) && (!(isset($_COOKIE['success'])))) 
	{ 
		setcookie('success');
		$a = $_GET['a'];
		
	}
	$logged_user_type=$_SESSION['userType'];
			if($logged_user_type == "0")
			   {
				   $mode="visible";
			   }
			   else if($logged_user_type == "1")
			   {
				  $mode="none";
			   }
			   else if($logged_user_type == "2")
			   {
				   $mode="none";
			   }
//	include 'header.php';
	?>
	<title>Profile Page</title>
	<script src="http://code.jquery.com/jquery-latest.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/bootstrap.js"></script>
	<script src="http://twitter.github.com/bootstrap/assets/js/bootstrap-popover.js"></script>  
	<script type="text/javascript" src="http://twitter.github.com/bootstrap/assets/js/bootstrap-dropdown.js"></script>
	<script type="text/javascript" src="http://twitter.github.com/bootstrap/assets/js/bootstrap-tooltip.js"></script>
	<script type="text/javascript" src="http://twitter.github.com/bootstrap/assets/js/bootstrap-modal.js"></script>
	<script type="text/javascript" src="http://twitter.github.com/bootstrap/assets/js/bootstrap-transition.js"></script>
	<script src="http://twitter.github.com/bootstrap/assets/js/bootstrap-popover.js"></script>  

	<!--<script src="js/categories.js"></script>-->
	<script src="js/common.js"></script>

	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/bootstrap-responsive.css" rel="stylesheet">
	<link href="css/bootstrap-responsive.min.css" rel="stylesheet">
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<!-- <link href="css/categories.css" rel="stylesheet"> -->
	<link href="css/profile.css" rel="stylesheet">


	<script>
		global_str="0";

		function list(str)
		{
			global_str=str;
	 
			if (str=="")
			{
				document.getElementById("contentPane").innerHTML="";
				return;
			} 
			if (window.XMLHttpRequest)
			{// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp=new XMLHttpRequest();
			}
			else
			{// code for IE6, IE5
				xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange=function()
			{
				if (xmlhttp.readyState==4 && xmlhttp.status==200)
				{
					document.getElementById("contentPane").innerHTML=xmlhttp.responseText;
				}
			}
			xmlhttp.open("POST","profileRepository.php?q="+str,true);
			xmlhttp.send();
 
		}
 
		function ondel(id)
		{
 	
			var catId = id;
			console.log(catId);
			
			$.ajax({
				type: "POST",
				url: "categoriesRepository.php",
				async: false,
				data: {eventType: "deleteCategory", categoryId: catId},
			}).done(function(response){});
			
			list(global_str);
		}
		
		function ongrpdel(id)
		{
 			//alert (id);
			var groupId = id;
			console.log(groupId);
			
			$.ajax({
				type: "POST",
				url: "pro_del.php",
				async: false,
				data: {eventType: "deleteGroup", groupId: groupId},
			}).done(function(response){
				});
			
			list(global_str);
		}
		
		function onpostdel(id)
		{
 			//alert (id);
			var postId = id;
			console.log(postId);
			
			$.ajax({
				type: "POST",
				url: "pro_del.php",
				async: false,
				data: {eventType: "deletePost", postId: postId},
			}).done(function(response){
				});
			
			list(global_str);
		}
		
		function onuserdel(id)
		{
 			//alert (id);
			var userId = id;
			console.log(userId);
			
			$.ajax({
				type: "POST",
				url: "pro_del.php",
				async: false,
				data: {eventType: "deleteUser", userId: userId},
			}).done(function(response){
				});
			
			list(global_str);
		}
		
		function onremblock(id)
		{
 			//alert (id);
			var userId = id;
			console.log(userId);
			
			$.ajax({
				type: "POST",
				url: "pro_del.php",
				async: false,
				data: {eventType: "deleteBlock", userId: userId},
			}).done(function(response){
				});
			
			list(global_str);
		}		
		
		function onthreaddel(id)
		{
 			//alert (id);
			var threadId = id;
			console.log(threadId);
			
			$.ajax({
				type: "POST",
				url: "pro_del.php",
				async: false,
				data: {eventType: "deleteThread", threadId: threadId},
			}).done(function(response){
				});
			
			list(global_str);
		}
 
   
		function goToThread(id)
		{
			//var a = "<?php echo $_SESSION['userid']; ?>";
			//alert (a);
	   
			//alert("i am here");
			window.location = 'threads.php?catId='+id;
		}
   
   		function goToPost(Tid,Cid)
		{
			//var a = "<?php echo $_SESSION['userid']; ?>";
			//alert (a);
	   
			//alert("i am here");
			window.location = 'posts.php?threadId='+Tid+'&catId='+Cid;
		}
	</script>
	
</head>
    

<body> 
	
	<div class="navbar navbar-inverse navbar-fixed-top">
		<div class="navbar-inner" style="padding: 0px 10px;">
			<a class="brand" href="index.php">Course Discussion System</a>
			<ul class="nav">
				<li class="divider-vertical"></li>				
				<li><a id="create-category-link" rel="tooltip" data-toggle="modal" href="#myModal" data-original-title="create category" data-placement="bottom"><i class="icon-pencil icon-white"></i></a></li>
				<li class="divider-vertical"></li>				
			</ul>



			<ul class="nav pull-right">
				<!-- <li class="divider-vertical"></li> -->
				<li class="divider-vertical"></li>				
				<li class="dropdown">
					<a  id="drop1" role="button" class="dropdown-toggle" data-toggle="dropdown" data-target="#" href="#"><p id="loggedUser" style="display: inline;">Username</p>&nbsp;<i class="icon-user icon-white"></i></a>
					<ul class="dropdown-menu" role="menu" aria-labelledby="drop1">
						<li>
							<a href="#" tabindex="-1">Profile</a>
						</li>
						<li>
							<a href="#" tabindex="-1" class="logoutLink">Logout</a>
						</li>

					</ul>
				</li>
				<li class="divider-vertical"></li>				
			</ul>




			<form class="navbar-search">
				<div class="input-append">
					<input class="span3" id="appendedInputButtons" type="text">
					<a class="btn" href="#"><i class="icon-search"></i></a>
					<a  rel="tooltip" data-toggle="modal" href="#filtersModal" data-original-title="create category" data-placement="bottom" class="btn">Advance Search</i></a>
					<!-- <a href="#" id="blob" class="btn" rel="popover inner" data-placement="bottom" data-content="Works" data-original-title="Filters">Advance Search</a> -->
						
				</div>
			</form>
		</div>
			
		<div class="row-fluid" id="row1"class="margin: 0px;">
			<div class="span2 ">
			</div>
			<div  class="span7">
				<strong>
					<div class="alert alert-error" id="errorAlert" style="display: none">
					</div>
					<div class="alert" id="infoAlert" style="display: none;">
					</div>
					<div class="alert alert-info" id="successAlert" style="display: none;">
					</div>
				</strong>
			</div>
			<div class="span3">
			</div>
		</div>
			
	</div>
	
	
	
	
	<div class="container-fluid" id="content_container">
	
	<div class="row-fluid" class="margin: 0px;">
		<div class="span2 well" id="sidebar">			
			<ul class="nav nav-list bs-docs-sidenav">
				<li id="category" onclick="list(this.id)"><a href="#"><i class="icon-chevron-right"></i> Categories</a></li>
				<li id="thread" onclick="list(this.id)"><a href="#"><i class="icon-chevron-right"></i> Threads</a></li>
				<li id="post" onclick="list(this.id)"><a href="#"><i class="icon-chevron-right"></i> Posts</a></li>
				<li id="roster" onclick="list(this.id)"><a href="#"><i class="icon-chevron-right"></i> Roster</a></li>
				<li id="group" onclick="list(this.id)"><a href="#"><i class="icon-chevron-right"></i> Group</a></li>
                <li style="display: <?php echo $mode; ?>" id="blocked" onclick="list(this.id)"><a href="#"><i class="icon-chevron-right"></i> Blocked &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Students</a></li>
                <li id="password" onclick="list(this.id)"><a href="#"><i class="icon-chevron-right"></i> Change &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Password</a></li>
			</ul>
		</div>
		<div  class="span10 well" id="contentPane">
            <?php 
			
			if(isset($a))
			{
				if(!(strcmp($a,"")==0))
				{ 
					echo $a;
					$a=""; 
				}
			}
			else echo "Welcome! to your profile page";
			?>
		</div>
	</div>    
</div>

</body>
</html>