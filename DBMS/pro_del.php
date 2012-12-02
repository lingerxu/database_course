<?php
session_start();
include "dbconnect.php";

function deleteGroup($groupId)
{
	 $result = array();
	 $query = "DELETE FROM groups WHERE id = ".$groupId;
	 $queryRessult = mysql_query($query);
	 
	 $result['deleteResult']=mysql_affected_rows();
	  return json_encode(true);
	 //return json_encode($result);
}
function deleteThread($threadId)
{
	 $result = array();
	 $query = "DELETE FROM Thread WHERE threadid = ".$threadId;
	 $queryRessult = mysql_query($query);
	 $result['deleteResult']=mysql_affected_rows();
	  return json_encode(true);
	 //return json_encode($result);
}
function deletePost($postId)
{
	 $result = array();
	 $query = "DELETE FROM Post WHERE postid = ".$postId;
	 $queryRessult = mysql_query($query);
	 $result['deleteResult']=mysql_affected_rows();
	  return json_encode(true);
	 //return json_encode($result);
}
function deleteUser($userId)
{
	$sql2="SELECT * FROM User where userid=".$userId;
 	$result2 = mysql_query($sql2);
	$row = mysql_fetch_array($result2);
	$type = $row['type'];
	
	$result = array();
	
	if($type == 2)	 
	 $query = "UPDATE User SET type='3' WHERE userid=".$userId;
	else if($type == 1) $query = "UPDATE User SET type='4' WHERE userid=".$userId;
	 $queryRessult = mysql_query($query);
	 $result['deleteResult']=mysql_affected_rows();
	  return json_encode(true);
	 //return json_encode($result);
}

function deleteBlock($userId)
{
	$sql2="SELECT * FROM User where userid=".$userId;
 	$result2 = mysql_query($sql2);
	$row = mysql_fetch_array($result2);
	$type = $row['type'];
	
	$result = array();
	
	if($type == 3)	 
	 $query = "UPDATE User SET type='2' WHERE userid=".$userId;
	else if($type == 4) $query = "UPDATE User SET type='1' WHERE userid=".$userId;
	 $queryRessult = mysql_query($query);
	 $result['deleteResult']=mysql_affected_rows();
	  return json_encode(true);
	 //return json_encode($result);
}


$event = $_POST["eventType"];

$result;
switch($event)
{
	case "deleteGroup":
	{
		$grpId = $_POST['groupId'];
		$result = deleteGroup($grpId);
	}
	break;
	case "deleteThread":
	{
		$t_Id = $_POST['threadId'];
		$result = deleteThread($t_Id);
	}
	break;
	case "deletePost":
	{
		$p_Id = $_POST['postId'];
		$result = deletePost($p_Id);
	}
	break;
	case "deleteUser":
	{
		$u_Id = $_POST['userId'];
		$result = deleteUser($u_Id);
	}
	break;
	case "deleteBlock":
	{
		$b_Id = $_POST['userId'];
		$result = deleteBlock($b_Id);
	}
	break;
	
 }
 
  echo $result;
?>