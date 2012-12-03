<?php

// Inialize session
session_start();

// Include database connection settings
include('dbconnect.php');

//Retrieve the values from _POST

$username=$_POST["username"];
$firstname=$_POST["firstname"];
$lastname=$_POST["lastname"];
$email=$_POST["email"];
$password=$_POST["password"];
date_default_timezone_set('America/Indianapolis');
$currDateTime = date('Y-m-d H:i:s');

/*echo $username ." ";
echo $firstname ." ";
echo $lastname ." ";
echo $email ." ";
echo $password ." ";*/

$query = "INSERT INTO User (username, firstname, lastname, emailid, password, datejoined, type) VALUES ('".$username."','".$firstname."','".$lastname."','".$email."','".$password."','".$currDateTime."','2')";

$result = mysql_query($query);

if (!$result) 
				{
					echo "Could not successfully run query ($sql) from DB: " . mysql_error();
					exit;
				}
				else 
				{
					header( 'Location: index.php' ) ;
				}
/*// Retrieve username and password from database according to user's input
$login = mysql_query("SELECT * FROM User WHERE (username = '" . mysql_real_escape_string($_POST['username']) . "') and (password = '" . mysql_real_escape_string($_POST['password']) . "')");

if (mysql_num_rows($login) == 1) {
	// Set username session variable
	$row = mysql_fetch_assoc($login);
	$userid = $row["userid"];
	$_SESSION['username'] = $_POST['username'];
	$_SESSION['userid'] = $userid;
	$_SESSION['userType'] = $row['type'];
	if($_SESSION['userType']==0) {
		$_SESSION['isProfessor'] = true;
		$_SESSION['isAI'] = false;
		$_SESSION['isAdmin'] = true;
	}
	else if($_SESSION['userType']==1) {
		$_SESSION['isProfessor'] = false;
		$_SESSION['isAI'] = true;
		$_SESSION['isAdmin'] = true;
	} else {
		$_SESSION['isProfessor'] = false;
		$_SESSION['isAI'] = false;
		$_SESSION['isAdmin'] = false;
	}
	
	
	$userInfoMap = array();
	$userInfoMap['username'] = $_SESSION['username'];
	$userInfoMap['userid'] = $_SESSION['userid'];
	$userInfoMap['userType'] = $_SESSION['userType'];
	$userInfoMap['isProfessor'] = $_SESSION['isProfessor'];
	$userInfoMap['isAI'] = $_SESSION['isAI'];
	$userInfoMap['isAdmin'] = $_SESSION['isAdmin'];
	
	 $_SESSION['userInfoMap'] = $userInfoMap;
	 	
	

//Update lastlogin
	$currDateTime = date('Y-m-d H:i:s');
	$updateQuery = "UPDATE User SET lastlogin = '$currDateTime' WHERE userid = $userid ";
	$updateResult = mysql_query($updateQuery);
	if($updateQuery)
	{
		//update success
	}
	else
	{
		//update fiailed
	}

		
	
	//header('Location: categories.php');
}
else {
	// Jump to login page
	 //header('Location: index.php');

}
*/
?>