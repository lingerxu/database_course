<?php
$q=$_GET["q"];
session_start();
$userid = $_SESSION['userid'];
include "dbconnect.php";



// as Q, User as U where Q.creator=U.userid and U.userid='". $_SESSION['userid']."' ";   //WHERE id = '".$q."'";

if ($q == 'category')
{
	$sql="SELECT * FROM ".$q."";  
	$result = mysql_query($sql);

	if (!$result) 
	{
    	echo "Could not successfully run query ($sql) from DB: " . mysql_error();
    	exit;
	}

	else if (mysql_num_rows($result) == 0) 
	{
    	echo "No rows found, nothing to print so am exiting";
    	exit;
	}
	 
	echo "
	<table class='table cellSkeleton'>
		<thead >
			<th>category name</th>
			<th>created by</th>
		</thead>
	<tbody>
 		";
	while($row = mysql_fetch_array($result))
	{
	   $creator = $row['creator'];
	   $sql2="SELECT * FROM User where userid = '".$creator."'";
	   $result2 = mysql_query($sql2);
	   $row2 = mysql_fetch_array($result2);
	   if($creator == $_SESSION["userid"] && $row2['type']==0)
	   {
		   $mode="visible";
	   }
	   else $mode="hidden";
	   echo "
		     <tr class=\"rowSkeleton\">
		     <td class=\"skeletonCol catName\"> <a href=\"javascript:void(0)\" onclick=\"goToThread(". $row['categoryid'] .")\">" . $row['Category'] . "</a> </td>
 		     <td class=\"skeletonCol catCreated\"> " .$row2['firstname'] . " " .$row2['lastname'] . " </td> <td class=\"skeletonCol catDelButton\" colspan=\"1\"><a style=\"visibility:". $mode ."; \" id=\"$creator\" href=\"javascript:void(0)\" class=\"delLink\" onclick=\"ondel(". $row['categoryid'] .")\" ><i class=\"icon-trash\"></i></a></td>
		     </tr>
			";
  }
  
  echo "</tbody>
		</table>
		</td>
	  	</tr> 
	  	</tbody>
	  	</table>";
 }
 
 else if ($q == 'thread')
 {
	$sql="SELECT * FROM Thread as Q, User as U where Q.owner=U.userid and U.userid='". $_SESSION['userid']."'"; 
	 
 	$result = mysql_query($sql);

	if (!$result) 
	{
    echo "Could not successfully run query ($sql) from DB: " . mysql_error();
    exit;
	}

	else if (mysql_num_rows($result) == 0) 
	{
    echo "You are a lousy user. You have not created any Threads yet. So go create some.";
    exit;
	}
	 
	 echo "<table class=\"table\" border='1' id='thrdTable'>
	 <!--<tr>
	 <th>Title</th>
	 <th>Description</th>
	 <th>Votes</th>
	 <th>Views</th>
	 </tr>-->";
  	while($row = mysql_fetch_array($result))
   {
	   echo "<tr colspan=2>";
	   echo "<td colspan=2> <a href=\"javascript:void(0)\" onclick=\"goToPost(". $row['threadid'] ."," . $row['categoryid'] .")\">" . $row['title'] . "<a href=\"javascript:void(0)\" class=\"delLink\" onclick=\"onthreaddel(". $row['threadid'] .")\" ><i  class=\"icon-trash\"></i></a></td>";
	   echo "</tr>";
	   echo "<tr colspan=2>";
	   echo "<td colspan=2>" . $row['description'] . "</td>";
	   echo "</tr> <tr>";
	   echo "<td> Votes : " . $row['votes'] . "</td>";
	   echo "<td> Views: " . $row['views'] . "</td>";
	   echo "</tr>";
	   echo "</table>";
	   echo "<table class=\"table\" border='1' id='thrdTable'>";
   }
	echo "</table>";
 }
 
 else if ($q == 'post')
 {
	$sql="SELECT * FROM Post as P, User as U where P.createdby=U.userid and U.userid='". $_SESSION['userid']."'"; 
	 
 	$result = mysql_query($sql);

	if (!$result) 
	{
    echo "Could not successfully run query ($sql) from DB: " . mysql_error();
    exit;
	}

	else if (mysql_num_rows($result) == 0) 
	{
    echo "You are a lousy user. You have not created any Posts yet. So go create some.";
    exit;
	}
	
	echo "<table class=\"table\" border='1' id='thrdTable'>";
	
	while($row = mysql_fetch_array($result))
	{
		// cleaning up the post text
		$post_text=$row['text'];
		$pos = strpos($post_text, '[endPost]');
		while(!($pos == false))
		{	
			$post_text = strstr($post_text, '[endPost]');
			$post_text = substr($post_text, 9);
			$pos = strpos($post_text, '[endPost]');
		}
		
		$thread_id= $row['threadid'];
	   	$sql2="SELECT * FROM Thread where threadid = '".$thread_id."'";
	   	$result2 = mysql_query($sql2);
	   	$row2 = mysql_fetch_array($result2);
		echo "<tr>";
		echo "<td><a href=\"javascript:void(0)\" onclick=\"goToPost(". $row2['threadid'] ."," . $row2['categoryid'] .")\">" . $row2['title'] . "</a></td>";
   		echo "<td>" . $post_text . "</td>";
		echo "<td> Votes : " . $row['votes'] . "</td>";
		echo "<td class=\"skeletonCol catDelButton\" colspan=\"1\"><a href=\"javascript:void(0)\" class=\"delLink\" onclick=\"onpostdel(". $row['postid'] .")\" ><i class=\"icon-trash\"></i></a></td>";
		echo "</tr>";
		echo "</table>";
   		echo "<table class=\"table\" border='1' id='thrdTable'>";
   	}
	echo "</table>"; 
		
 }
  
else if ($q == 'roster')
{
	$sql="SELECT * FROM User where type != 3 and type != 4"; 
	 
	$result = mysql_query($sql);

	if (!$result) 
	{
		echo "Could not successfully run query ($sql) from DB: " . mysql_error();
		exit;
	}

	else if (mysql_num_rows($result) == 0) 
	{
    	echo "No rows found, nothing to print so am exiting";
    	exit;
	}
	
	echo "<table class=\"table\">
		<thead>
		<th class=\"skeletonCol catName\"> Name </th>
		<th class=\"skeletonCol catCreated\">Email ID</th>
		<th class=\"skeletonCol catCreated\">Role</th>
		</thead>
	 	<tbody>";

		while($row = mysql_fetch_array($result))
   		{
	   		$type = $row['type'];
			$logged_user_type=$_SESSION['userType'];
//	   		$sql2="SELECT * FROM User where userid = '".$creator."'";
//	   		$result2 = mysql_query($sql2);
//	   		$row2 = mysql_fetch_array($result2);
			if($logged_user_type == 0)
			{
			   if($type == "0")
			   {
				   $role="Instructor";
				   $mode="hidden";
			   }
			   else if($type == "1")
			   {
				   $role="Associate Instructor";
				   $mode="visible";
			   }
			   else if($type == "2")
			   {
				   $role="Student";
				   $mode="visible";
			   }
			}
			else if($logged_user_type == 1)
			{
			   if($type == "0")
			   {
				   $role="Instructor";
				   $mode="hidden";
			   }
			   else if($type == "1")
			   {
				   $role="Associate Instructor";
				   $mode="hidden";
			   }
			   else if($type == "2")
			   {
				   $role="Student";
				   $mode="visible";
			   }
			}
			else if($logged_user_type == 2)
			{
			   if($type == "0")
			   {
				   $role="Instructor";
				   $mode="hidden";
			   }
			   else if($type == "1")
			   {
				   $role="Associate Instructor";
				   $mode="hidden";
			   }
			   else if($type == "2")
			   {
				   $role="Student";
				   $mode="hidden";
			   }
			}
		   else $role="Blocked";
		   echo "
				 <tr class=\"rowSkeleton\">
				 <td class=\"skeletonCol catName\"> " . $row['firstname'] . " " . $row['lastname'] ."</a> </td>
				 <td class=\"skeletonCol catCreated\"> <a href=\"mailto:".$row['emailid'] ."\" > " .$row['emailid'] . "</a> </td> 				 <td class=\"skeletonCol catCreated\"> " .$role . " </td>
			 	 <td class=\"skeletonCol catDelButton\" colspan=\"1\"><a style=\"visibility:". $mode ."; \" href=\"javascript:void(0)\" class=\"delLink\" onclick=\"onuserdel(". $row['userid'] .")\" ><i class=\" icon-remove\"></i></a></td> 
				 </tr>";
	   }
	   echo "</tbody>
			 </table>";

}

else if ($q == 'group')
{
	if($_SESSION['userType'] == 0 || $_SESSION['userType'] == 1)
	{
		$sql="SELECT * FROM groups";
	}
	else $sql="SELECT * FROM groups as G, user_group as U where G.id=U.group_id and U.user_id = '".$_SESSION['userid']."'";
	 
	$result = mysql_query($sql);

	if (!$result) 
	{
		echo "Could not successfully run query ($sql) from DB: " . mysql_error();
		exit;
	}

	else if (mysql_num_rows($result) == 0) 
	{
    	echo "You are not part of any groups.";
    	exit;
	}
	if($_SESSION['userType']==0)
	   {
		   $mode="visible";
	   }
	   else $mode="hidden";
	   
	echo "<table class=\"table\">
		<thead>
		<th class=\"skeletonCol catName\"> Group Name </th>
		<th class=\"skeletonCol catCreated\">Created By</th>
		<th class=\"skeletonCol catCreated\"> </th>
		</thead>
	 	<tbody>";

		while($row = mysql_fetch_array($result))
		{
		   $creator = $row['creator'];
		   $sql2="SELECT * FROM User where userid = '".$creator."'";
		   $result2 = mysql_query($sql2);
		   $row2 = mysql_fetch_array($result2);
		   echo "<tr class=\"rowSkeleton\">
				 <td class=\"skeletonCol catName\"> " . $row['name'] . "</a> </td>
				 <td class=\"skeletonCol catCreated\"> " .$row2['firstname'] . " " . $row2['lastname'] . "</td> 							
				 <td class=\"skeletonCol catDelButton\" colspan=\"1\"><a style=\"visibility:". $mode ."; \" href=\"javascript:void(0)\" class=\"delLink\" onclick=\"ongrpdel(". $row['id'] .")\" ><i class=\"icon-remove\"></i></a></td> 
				 </tr>";
	   }
	   echo "</tbody>
			 </table>";
	
}
else if($q == 'password')
{
	echo "  <form action='change_pass.php' method='post'>
			<table>
			<tr>
			<td width='175px'>Enter current password:</td><td><input type='password' name='cur_pass'></td>
			</tr><tr>
			<td>Enter new password:</td> <td><input type='password' name='new_pass'></td>
			</tr><tr>
			<td>Re-type new password:</td> <td><input type='password' name='re_new_pass'></td>
			</tr>
			</table>
			<input type='hidden' name='userid' value='$userid'>
			<input type='submit' value='Submit'>
			</form>
			
		";	
}
 
else if ($q == 'blocked')
{
	$sql="SELECT * FROM User where type = 3 or type = 4"; 
	 
	$result = mysql_query($sql);

	if (!$result) 
	{
		echo "Could not successfully run query ($sql) from DB: " . mysql_error();
		exit;
	}

	else if (mysql_num_rows($result) == 0) 
	{
    	echo "No Blocked Users!";
    	exit;
	}
	
	if($_SESSION['userType']==0)
	   {
		   $mode="visible";
	   }
	   else $mode="hidden";
	   
	echo "<table class=\"table\">
		<thead>
		<th class=\"skeletonCol catName\"> Name </th>
		<th class=\"skeletonCol catCreated\">Email ID</th>
		<th class=\"skeletonCol catCreated\">Role</th>
		</thead>
	 	<tbody>";

		while($row = mysql_fetch_array($result))
   		{
	   		$type = $row['type'];
//	   		$sql2="SELECT * FROM User where userid = '".$creator."'";
//	   		$result2 = mysql_query($sql2);
//	   		$row2 = mysql_fetch_array($result2);
		   if($type == "3")
		   {
			   $role="Student";
		   }
		   else if($type == "4")
		   {
			   $role="Associate Instructor";
		   }
		   
		   echo "
				 <tr class=\"rowSkeleton\">
				 <td class=\"skeletonCol catName\"> " . $row['firstname'] . " " . $row['lastname'] ."</a> </td>
				 <td class=\"skeletonCol catCreated\"> <a href=\"mailto:".$row['emailid'] ."\" > " .$row['emailid'] . "</a> </td> 				 <td class=\"skeletonCol catCreated\"> " .$role . " </td>
			 	 <td class=\"skeletonCol catDelButton\" colspan=\"1\"><a style=\"visibility:". $mode ."; \" href=\"javascript:void(0)\" class=\"delLink\" onclick=\"onremblock(". $row['userid'] .")\" ><i class=\"icon-ok\"></i></a></td> 
				 </tr>";
	   }
	   echo "</tbody>
			 </table>";

} 
mysql_close($dbConnection);
?>