<?php


/* Controller for operations on threads page*/

session_start();

include "dbconnect.php";

// Get info about the category for which the threads are being displayed

function getParentThreadInfo($kThreadId)
{
	$result = json_encode(false);
	$query = "SELECT * from Thread where threadid = ".$kThreadId;
	$queryResult = mysql_query($query);
	if($queryResult==true)
	{
		$row = mysql_fetch_assoc($queryResult);
		$result = json_encode($row);
	}
	return $result;
}

function getPostsForThread($kThreadId)
{
	$result = json_encode(false);
	$query = "SELECT * from Post where threadid = ".$kThreadId;
	$queryResult = mysql_query($query);
	$allPosts = array();
	if($queryResult!=NULL)
	{
		while($row = mysql_fetch_assoc($queryResult)){
			$postId = $row['postid'];
					
			//select keyword from Tag where tagid IN (Select tagid from tagtothread where threadid=61);
			$tagSearchQuery = "select keyword from Tag where tagid IN (Select tagid from tagtopost where postid = $postId)";
			$tagSearchQueryResult  = mysql_query($tagSearchQuery);
			$alltags = array();
			if(mysql_num_rows($tagSearchQueryResult))
			{
				//got some tags
					
				while($tagRow = mysql_fetch_assoc($tagSearchQueryResult))
				{
					//for each tag
					$tag = $tagRow['keyword'];
					//echo $tag;
					array_push($alltags,$tag);
				}
			}
			$row['tags'] = $alltags;
				
			array_push($allPosts,$row);
				
		}
			
			
		$result = json_encode($allPosts);
	}
	return $result;

}

function createReplyPost($replyText, $postId, $threadId) {
	$result = json_encode(false);
	$currDateTime = date('Y-m-d H:i:s');
	$createdby = $_SESSION['userid'];
	$query  = "INSERT INTO Post (text,dateposted,votes,linkedpostid,threadid,createdby) VALUES ('".$replyText."', '".$currDateTime."',
			0,".$postId.", ".$threadId.", ".$createdby." )";
	$result = mysql_query($query);
	if($result==true) {
		$result = json_encode($result);
	}
	return $result;
}

function createNewPost($kthreadId,$kDesc,$kTags)
{
	$result = json_encode(false);
	$currDateTime = date('Y-m-d H:i:s');
	$createdby = $_SESSION['userid'];
	$query  = "INSERT INTO Post (text,dateposted,votes,linkedpostid,threadid,createdby) VALUES ('".$kDesc."', '".$currDateTime."',
			0,null, ".$kthreadId.", ".$createdby." )";
	$result = mysql_query($query);
	//set make entries in tags for the new post
	if(!empty($kTags) && $result==true)
	{
		$kTags = json_decode($kTags);
	
		$postId = mysql_insert_id();
	
		foreach($kTags as $tag)
		{
			if(empty($tag))
				continue;
			/* Tag
			 +---------+-------------+------+-----+---------+----------------+
			| Field   | Type        | Null | Key | Default | Extra          |
			+---------+-------------+------+-----+---------+----------------+
			| tagid   | int(11)     | NO   | PRI | NULL    | auto_increment |
			| keyword | varchar(45) | YES  |     | NULL    |                |
			+---------+-------------+------+-----+---------+----------------+
			*/
	
			//check if tag already exist or else create new tag
			$tagId =false;
			$tagQuery = "SELECT * FROM Tag WHERE keyword LIKE '$tag'";
			$tagQueryResult = mysql_query($tagQuery);
			if(!mysql_num_rows($tagQueryResult))
			{
	
				//tag is not present insert it
				$insertTageQuery = "INSERT INTO Tag (keyword) VALUES ('$tag')";
				$tagInsertResult = mysql_query($insertTageQuery);
				if($tagInsertResult)
				{
					$tagId = mysql_insert_id();
				}
	
			}
			else
			{
				//tag already exist fetch the tagid
				$row = mysql_fetch_assoc($tagQueryResult);
				$tagId = $row['tagid'];
	
			}
				
	
	
			/* tagtopost
			 +----------+---------+------+-----+---------+-------+
			| Field    | Type    | Null | Key | Default | Extra |
			+----------+---------+------+-----+---------+-------+
			| threadid | int(11) | NO   | PRI | NULL    |       |
			| tagid    | int(11) | NO   | PRI | NULL    |       |
			+----------+---------+------+-----+---------+-------+
			*/
				
				
			//make entry in tagtopost
				
			if($tagId)
			{
				$insertTagToPostQuery = "INSERT INTO tagtopost (postid,tagid) VALUES ($postId,$tagId)";
				if(mysql_query($insertTagToPostQuery))
				{
					//insert complete
				}
			}
		}
	}
	
	
	
	
	if($result==true) {
		$result = json_encode($result);
	}
	return $result;
}


function deletePostInThread($postId)
{
	$result= json_encode(false);
	if($_SESSION['isAdmin']==true) {
		$query = "DELETE FROM Post WHERE postid = ".$postId;
	} else {
		$query = "DELETE FROM Post WHERE postid = ".$postId." AND createdby = ".$_SESSION['userid'];
	}
	$queryResult = mysql_query($query);
	if($queryResult>0) {
		$result = json_encode(true);
	}
	return $result;
}

function editPost($postId, $postText)
{
	$result = json_encode(false);
	$currDateTime = date('Y-m-d H:i:s');
	$query = "UPDATE Post SET text = '".$postText."',dateposted = '".$currDateTime."'  WHERE postid = ".$postId;
	$queryResult = mysql_query($query);
	if($queryResult !=NULL || $queryResult == true)
		$result = json_encode(true);

	return $result;
}

function incrementVoteForPosts($postId)
{
	$result = json_encode(false);
	$query = "UPDATE Post SET votes = votes +1  WHERE postid = ".$postId;
	$queryResult = mysql_query($query);
	if($queryResult !=NULL || $queryResult == true)
		$result = json_encode(true);

	return $result;
}


function decrementVoteForPosts($postId)
{
	$result = json_encode(false);
	$query = "UPDATE Post SET votes = votes - 1  WHERE postid = ".$postId;
	$queryResult = mysql_query($query);
	if($queryResult !=NULL || $queryResult == true)
		$result = json_encode(true);

	return $result;
}

function getAllTags()
{
	$result = json_encode('false');

	$query = "Select * from Tag";
	$queryResult  = mysql_query($query);
	$allTags = array();
	if(mysql_num_rows($queryResult)>0)
	{
		while($row = mysql_fetch_assoc($queryResult))
		{
			array_push($allTags,$row);
		}
		$result = json_encode($allTags);
	}


	return $result;

}
function sortByAttributeAndOrder($col,$order,$kthreadId)
{

	$result = json_encode(false);
	$query ;
	$query = "SELECT * from Post WHERE threadid = $kthreadId ORDER BY $col $order";
	$queryResult = mysql_query($query);
	$allPosts = array();
	if($queryResult!=NULL)
	{
		while($row = mysql_fetch_assoc($queryResult))
		{
			//get tags for this post
			$postId = $row['postid'];
			//select keyword from Tag where tagid IN (Select tagid from tagtothread where threadid=61);
			$tagSearchQuery = "select keyword from Tag where tagid IN (Select tagid from tagtopost where postid = $postId)";
			$tagSearchQueryResult  = mysql_query($tagSearchQuery);
			$alltags = array();
			if(mysql_num_rows($tagSearchQueryResult))
			{
				//got some tags

				while($tagRow = mysql_fetch_assoc($tagSearchQueryResult))
				{
					//for each tag
					$tag = $tagRow['keyword'];
					//echo $tag;
					array_push($alltags,$tag);
				}
			}
			$row['tags'] = $alltags;
				


			array_push($allPosts,$row);
		}
		$result = json_encode($allPosts);
	}
	return $result;


}


$reqType = $_POST['requestType'];
$result = json_encode(false);
switch($reqType)
{

	case "getParentThreadInfo":
		$threadId = $_POST['threadId'];
		$result  = getParentThreadInfo($threadId);
		break;

	case "createReplyPost":
		$replyText = $_POST['replyText'];
		$postId = $_POST['postId'];
		$threadId = $_POST['threadId'];
		$result = createReplyPost($replyText, $postId, $threadId);
		break;

	case 'createNewPost':
		$postText = $_POST['desc'];
		$threadId = $_POST['threadId'];
		$tags = $_POST['tags'];
		$result = createNewPost($threadId,$postText,$tags);
		break;
		
	case "editPost":
		$postId = $_POST['postId'];
		$postText = $_POST['postText'];
		$result  = editPost($postId, $postText);
		break;

	case 'getPostsForThread':
		$threadId = $_POST['threadId'];
		$result = getPostsForThread($threadId);
		break;

	case 'deletePostInThread':
		$postId = $_POST['postId'];
		$result = deletePostInThread($postId);
		break;
	
	case 'incrementVoteForPosts':
		$postId = $_POST['postId'];
		$result = incrementVoteForPosts($postId);
		break;
		
		
	case 'decrementVoteForPosts':
		$postId = $_POST['postId'];
		$result = decrementVoteForPosts($postId);
		break;
	
	case 'getAllTags':
		$result = getAllTags();
		break;
	
	case 'sortByAttributeAndOrder':
		$col = $_POST['attribute'];
		$order = $_POST['order'];
		$threadid = $_POST['threadId'];
		//$userid = (isset($_POST['userId']))?$_POST['userId']:-1;
		$result = sortByAttributeAndOrder($col,$order,$threadid);
		break;
		
		
	

}


echo $result;


?>
