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
				  $mode="visible";
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
		
		function onmake_AI(id)
		{
 			//alert (id);
			var userId = id;
			console.log(userId);
			
			$.ajax({
				type: "POST",
				url: "pro_del.php",
				async: false,
				data: {eventType: "makeAI", userId: userId},
			}).done(function(response){
				});
			
			list(global_str);
		}
		
		function ondel_AI(id)
		{
 			//alert (id);
			var userId = id;
			console.log(userId);
			
			$.ajax({
				type: "POST",
				url: "pro_del.php",
				async: false,
				data: {eventType: "delAI", userId: userId},
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

			<ul class="nav pull-right">
				<li><a class="logoutLink" href="#">Logout</a></li>
			</ul>

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
                <li id="Statistics"><a href="stats.php"><i class="icon-chevron-right"></i> Statistics</a></li>
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