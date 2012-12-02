<?php


/* Controller for operations on threads page*/

session_start();

include "dbconnect.php";

// Get info about the category for which the threads are being displayed
function searchThreadTitle($term,$cat)
{
	$allThreads = array();

	$result = json_encode(false);
	$query = "SELECT * from Thread where categoryid=".$cat." and lower(title) contains lower('".$term."')";
	$queryResult = mysql_query($query);
	if($queryResult==true)
	{
		$row = mysql_fetch_assoc($queryResult);
		$result = json_encode($row);
		array_push($allThreads,$result);
	}


	//list threads page
}


function searchPostContents($term,$cat)
{
	$allThreads = array();

	$result = json_encode(false);
	$query = "SELECT t.* from post as p, thread as t where categoryid=".$cat." and t.threadid = p.threadid and lower(p.text) contains lower('".$term."') group by t.threadid";
	$queryResult = mysql_query($query);
	if($queryResult==true)
	{
		$row = mysql_fetch_assoc($queryResult);
		$result = json_encode($row);
	}
	//list threads that matched
}

function searchFirstPostContents($term,$cat)
{
	$allThreads = array();

	$result = json_encode(false);
	$query = "SELECT t.* from post as p, thread as t where categoryid=".$cat." and t.threadid = p.threadid and !p.linkedpostid and lower(p.text) contains lower('".$term."') group by t.threadid";
	$queryResult = mysql_query($query);
	if($queryResult==true)
	{
		$row = mysql_fetch_assoc($queryResult);
		$result = json_encode($row);
	}
	//list threads that matched
}

function searchAuthor($term)
{
	$allThreads = array();

	$result = json_encode(false);
	$query = "SELECT t.* from user as u, thread as t where lower(u.username)=lower('".$term."') and u.userid=t.owner";
	$queryResult = mysql_query($query);
	if($queryResult==true)
	{
		$row = mysql_fetch_assoc($queryResult);
		$result = json_encode($row);
	}
	//list threads that matched
}
function searchTag($term)
{
	$allThreads = array();

	$result = json_encode(false);
	$query = "SELECT t.* from tag as ta, tagtothread as ttt, thread as th where lower(ta.keyword)=lower('".$term."') and ta.tagid=ttt.tagid and ttt.threadid=th.threadid";
	$queryResult = mysql_query($query);
	if($queryResult==true)
	{
		$row = mysql_fetch_assoc($queryResult);
		$result = json_encode($thre);
	}
	//list threads that matched
}
function searchFunction{
$cat = $_POST['catId'];
$term = $_POST['term'];
$type = $_POST['type'];
$result = json_encode(false);
switch($type)
{
	
//	case 'threadTitle'	
	case '1':
	$term = $_POST['term'];
	$result = searchThreadTitle($term,$cat);
	break;
	
	
//	case 'postContent':
	case '2':
	$term = $_POST['term'];
	$result = searchPostContents($term,$cat);
	break;
	
//	case 'firstPostContent':
	case '3':
	$term = $_POST['term'];
	$result = searchFirstPostContents($term,$cat);
	break;
	
//	case 'threadAuthor':
	case '4':
	$term = $_POST['term'];
	$result = searchAuthor($term);
	break;

//	case 'tagMatch':
	case '5':
	$term = $_POST['term'];
	$result = searchTag($term);
	break;		
}
