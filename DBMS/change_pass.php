<?php

session_start();
include "dbconnect.php";

$old = $_POST['cur_pass'];
$new = $_POST['new_pass'];
$re_new = $_POST['re_new_pass'];
$user_id = $_POST['userid'];

$sql="SELECT * FROM User where userid='". $user_id ."'"; 
	 
 	$result = mysql_query($sql);

	if (!$result) 
	{
    echo "Could not successfully run query ($sql) from DB: " . mysql_error();
    exit;
	}

	else if (mysql_num_rows($result) == 0) 
	{
    echo "You should not be in this page. Strict action will be taken against you";
    exit;
	}
	
	$row = mysql_fetch_array($result);
	if(strcmp($row['password'], $old) == 0)
	{
		if(!(strcmp($new, "") == 0))
		{
			if(strcmp($new, $re_new) == 0)
			{
				$sql="UPDATE User SET password = '". $new ."' WHERE userid='". $user_id ."'";
				$result = mysql_query($sql);
				if (!$result) 
				{
					echo "Could not successfully run query ($sql) from DB: " . mysql_error();
					exit;
				}
				else 
				{
					if(isset($_COOKIE['success']))
						setcookie("success", "", time()-3600);
					$str="Password updated successfully";
					header( 'Location: profile.php?a=Password Updated Successfully' ) ;
				}
			} 
			else
			{
				if(isset($_COOKIE['success']))
						setcookie("success", "", time()-3600);
					$str="Password updated successfully";
					header( 'Location: profile.php?a=The new passwords dosen\'t match' ) ;
			}
		}
			else
		{
			if(isset($_COOKIE['success']))
					setcookie("success", "", time()-3600);
			$str="Password updated successfully";
			header( 'Location: profile.php?a=Your new password cannot be blank' ) ;
		}
	}
	else
	{
		if(isset($_COOKIE['success']))
				setcookie("success", "", time()-3600);
		 header( 'Location: profile.php?a=Your current password did not match' ) ;
	}

//echo $user_id;

?>