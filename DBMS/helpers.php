<?php

session_start();


include "dbconnect.php";

// Connect to database

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


function addNewUser($kusername,$kfirstname,$klastname,$kemailid,$kpassword,$ktype)
{
	
	$result = json_encode(false);
	$currDateTime = date('Y-m-d H:i:s');
	$query = "INSERT INTO User (username,firstname,lastname,emailid,password,datejoined,type) VALUES ('$kusername', '$kfirstname', '$klastname', '$kemailid', '$kpassword','$currDateTime', $ktype)";
	
	$queryResult = mysql_query($query);
	if($queryResult==true || $queryResult!=NULL)
	$queryResult = json_encode(true);
	
	return $queryResult;
	
}


function getLoggedInUserInfo()
{
	
	return (isset($_SESSION['userInfoMap']))?json_encode($_SESSION['userInfoMap']):json_encode(false);
}


function getAllUsersListForUser($userid)
{
	$result = json_encode(false);
//	$query ="SELECT userid, username FROM User where userid <> ".$userid;
	$query ="SELECT userid, username FROM User ";
	$qresult = mysql_query($query);
	$users = array();
	if($qresult)
	{
		while($row = mysql_fetch_assoc($qresult))
			array_push($users,$row);
		
		$result = json_encode($users);
	}
	

	return $result;
}



$req = $_POST["requestType"];
$response = json_encode(false);



switch($req)
{
	
	case "getUserInfoFromUserId":
	$uId = $_POST['userId'];
	$response = getUserInfoFromUserId($uId);
	break;
	
	
	/*+------------+-------------+------+-----+---------+----------------+
	| Field      | Type        | Null | Key | Default | Extra          |
	+------------+-------------+------+-----+---------+----------------+
	| userid     | int(11)     | NO   | PRI | NULL    | auto_increment |
	| username   | varchar(45) | NO   | UNI | NULL    |                |
	| firstname  | varchar(45) | YES  |     | NULL    |                |
	| lastname   | varchar(45) | YES  |     | NULL    |                |
	| emailid    | varchar(45) | NO   | UNI | NULL    |                |
	| password   | varchar(45) | NO   |     | NULL    |                |
	| datejoined | datetime    | YES  |     | NULL    |                |
	| lastlogin  | datetime    | YES  |     | NULL    |                |
	| type       | int(11)     | NO   |     | 1       |                |
	+------------+-------------+------+-----+---------+----------------+
	*/

	case "addNewUser";
	$username = $_POST['username'];
	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];
	$emailid = $_POST['emailid'];
	$password = $_POST['password'];
	$type = $_POST['type'];
	
	$response = addNewUser($username,$firstname,$lastname,$emailid,$password,$type);
	
	break;
	
	
	case 'getLoggedInUserInfo':
	$response = getLoggedInUserInfo();
	break;
		
		
	case 'getAllUsersListForUser':
	$userid = $_POST['userid'];
	$response = getAllUsersListForUser($userid);
	break;
	
}


echo $response;
	




?>