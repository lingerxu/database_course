<?php

session_start();
include "dbconnect.php";


function getUserInfoFromUserId($userid)
{
	$result = json_encode(false);
	
	$query = "SELECT * FROM User WHERE userid = ".$userid;
	
	$queryResult = mysql_query($query);
	
	if($queryResult != NULL || $queryResult == true )
	{
		//as only one user will be returned
		$result = json_encode(mysql_fetch_assoc($queryResult));
	}
	
	return $result;
}


function newGroupRequest($kName, $kRequester, $kMembers)
{
	 
	 $result = array();
	 $result['duplicateGroup']=false;
	 $result['duplicateRequest']=false;
	 $result['insert']=false;
	 
	 //check if group with same name already exists
	 $groupCheckQuery = "SELECT *  FROM groups where name =  '$kName'";
	 $groupCheckQueryResult = mysql_query($groupCheckQuery);
	 if(mysql_num_rows($groupCheckQueryResult)>0)
	 {
		 $result['duplicateGroup']=true;
		 return json_encode($result);
	 }
	 
	 //check if there is already a req with same name
	 $groupReqCheckQuery = "SELECT *  FROM group_request where group_name =  '$kName'";
	 $groupReqCheckQueryResult = mysql_query($groupReqCheckQuery);
	 if(mysql_num_rows($groupReqCheckQueryResult)>0)
	 {
		 $result['duplicateRequest']=true;
		 return json_encode($result);
	 }
	 $members = json_decode($kMembers,true);
	 // print_r($members['memberslist']);
	 foreach($members['memberslist'] as $mem)
	 {
		 $memberId =  $mem['userid'];
		 $query = "INSERT INTO group_request (group_name,requester,member) VALUES ('$kName',$kRequester,$memberId)";
		 $query_result = mysql_query($query);
		 if(mysql_affected_rows()>0)
		 {
			 $result['insert']=true;
			 
		 }
		 else
		 {
		 	 $result['insert']=false;
			 return json_encode($result);
			 
		 }
	 }
	 
	 return json_encode($result);
}

function getGroupResquests()
{
	$result = json_encode(false);
	$query_groupNames = "Select DISTINCT group_name, requester from group_request";
	$groupNamesResult = mysql_query($query_groupNames);
	$allGroups = array();
	if($groupNamesResult)
	{
		
		$groupInfo = array();
		while($group = mysql_fetch_assoc($groupNamesResult))
		{
			
			//function get members for this group
			$groupInfo['name'] = $group['group_name'];
			
			/* Select * from  `group_request` where `group_name` */
			//get requester of this group
			$requesterId = $group['requester'];
			$requesterInfo = json_decode(getUserInfoFromUserId($requesterId));
			$groupInfo['requester'] = $requesterInfo;
			
			//get the group members
			$members = array();
			$membersQuery = "SELECT member from group_request where group_name = '".$group['group_name']."'";
			$memberQueryResutl = mysql_query($membersQuery);
			while($memberInfo = mysql_fetch_assoc($memberQueryResutl))
			{
				 $memberId =  $memberInfo['member'];
				 $member = json_decode(getUserInfoFromUserId($memberId)); 
				 array_push($members,$member);
				
			}
				
			$groupInfo['members'] = $members;
			
			array_push($allGroups,$groupInfo);
			
			
			
		}
		
		
		
		
		
	}
	
	
	 return json_encode($allGroups);
	
}


function approveGroupRequest($grpName,$creatorId)
{
	$result = json_encode(false);
	
	//get requests
	$groupInfoQuery = "SELECT * from group_request where group_name = '$grpName'";
	$groupInfoQueryResult = mysql_query($groupInfoQuery);
	
	//create group
	$createGroupQuery = "INSERT INTO groups(name,creator) VALUES ('$grpName',$creatorId)";
	$createGroupQueryResult = mysql_query($createGroupQuery);
	$groupId;
	if($createGroupQueryResult)
	{
		$groupId = mysql_insert_id();
		
	}
	else
	{
		//group creation failed return false	
		return json_encode(false);
	}

	
	
	//get all group request add make entry in user_group

	if($groupInfoQueryResult)
	{
		while($row = mysql_fetch_assoc($groupInfoQueryResult))
		{
				
			$memberId = $row['member'];
			$query = "INSERT INTO user_group(group_id,user_id) VALUES ($groupId,$memberId)";
			$insertResult = mysql_query($query);
			if($insertResult && mysql_affected_rows()>0)
			{
				// delete entries from group_request
				$deleteQuery = "DELETE FROM group_request WHERE group_name = '$grpName'";
				if(mysql_query($deleteQuery))
				{
					$result = json_encode(true);
				}
			}
		}
	}
	return $result;
}


function getGroupsForUser($kUserId)
{
	
	
	/*TODO
	
	fetch all rows if the user is of type 0
	
	
	*/
	$result = json_encode(false);
	$query = "SELECT * FROM groups WHERE id IN (SELECT group_id FROM user_group WHERE  user_id = $kUserId )";
	//echo  $query;
	$queryResult = mysql_query($query);
	$groups = array();
	if($queryResult)
	{
		while($row = mysql_fetch_assoc($queryResult))
		{
			array_push($groups,$row);
		}
		
		$result = json_encode($groups);
	}
	else
	{
	}
	
	
	return $result;
	
}


function rejectGroupRequest($kGrpName)
{
	$result = array();
	$result['deleteResult']=false;
	
	$deleteQuery = "DELETE FROM group_request WHERE group_name = '$kGrpName'";

	$queryResult = mysql_query($deleteQuery);
	if(mysql_affected_rows()>0)
	{
		//delete success
		$result['deleteResult'] = true;
	}
	
	//get grouprequests after deletion
	$result['groupRequets'] = json_decode(getGroupResquests());

	return json_encode($result);
}


$req = $_POST['requestType'];
$result = json_encode(false);


switch($req)
{
	case "newGroupRequest":
	$name = $_POST['groupName'];
	$requester = $_POST['requesterId'];
	$members = $_POST['groupMembers'];
	$result = newGroupRequest($name,$requester,$members);
	break;
	
	
	case "getGroupResquests":
	$result = getGroupResquests();
	break;
	
	
	case "approveGroupRequest":
	$grpName = $_POST['groupName'];
	$creatorId = $_POST['creatorid'];
	$result = approveGroupRequest($grpName,$creatorId);
	break;
	
	
	case "rejectGroupRequest":
	$grpName = $_POST['groupName'];
	$result = rejectGroupRequest($grpName);
	break;
	
	
	case "getGroupsForUser":
	$userId = $_POST['userId'];
	$result = getGroupsForUser($userId);
	break;
	
}




echo $result;


?>