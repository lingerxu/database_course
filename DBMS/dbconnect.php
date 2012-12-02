<?php 
$dbHost = "silo.cs.indiana.edu:3306"; 
$dbUserName = "b561f12_27"; 
$dbPass = "b561f12_27"; 
$dbName = "b561f12_27"; 

$dbConnection = mysql_connect ($dbHost, $dbUserName, $dbPass) or die ("Cannot connect to host $dbHost with user $dbUserName and the password provided."); 
mysql_select_db ($dbName) or die ("Database $dbName not found on host $dbHost");
?>