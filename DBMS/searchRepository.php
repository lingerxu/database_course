<?php


/* Controller for operations on threads page*/

session_start();

include "dbconnect.php";

// Get info about the category for which the threads are being displayed
function searchThreadTitle($CatId,$term)
{
	$result = json_encode(false);
	// Setting userid by default to -1. Not sure when to use 2nd query
	//$kUserId = -1;
	//if($kUserId==-1)
	if(is_numeric($CatId))
		$query = "SELECT * from Thread where categoryid=".$CatId." and title like ('%".$term."%')";
	else 
		$query = "SELECT * from Thread where title like ('%".$term."%')";
	//else
		//$query = "Select * from Thread WHERE (groupid IS NULL OR groupid IN (SELECT group_id FROM user_group WHERE user_id = ".$kUserId.")) AND categoryid = ".$CatId." and lower(title) contains lower('".$term."')";
	$queryResult = mysql_query($query);
	$allThreads = array();
	if($queryResult!=NULL)
	{
		while($row = mysql_fetch_assoc($queryResult))
		{
			//get tags for this thread
			$threadId = $row['threadid'];
			//select keyword from Tag where tagid IN (Select tagid from tagtothread where threadid=61);
			$tagSearchQuery = "select keyword from Tag where tagid IN (Select tagid from tagtothread where threadid = $threadId)";
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
			
			
			
			//get creater info
			$owner = $row['owner'];
			$ownerSearchQuery = "Select * from User where userid = $owner";
			$ownerSearchQueryResult = mysql_query($ownerSearchQuery);
			if(mysql_num_rows($ownerSearchQueryResult)==1)
			{
				$user = mysql_fetch_assoc($ownerSearchQueryResult);
				$row['owner'] = $user;
			}
			
			//get group name
			$groupId = $row['groupid'];
			if($groupId != NULL)
			{
				$groupQuery = "SELECT name from groups WHERE id = $groupId";
				$groupQueryResult = mysql_query($groupQuery);
				if(mysql_num_rows($groupQueryResult)==1)
				{
					$grp = mysql_fetch_assoc($groupQueryResult);
					$row['groupName']= $grp['name'];
				}	
				
			}

			array_push($allThreads,$row);
		}
		$result = json_encode($allThreads);
	}
	return $result;
}


function searchPostContents($CatId,$kUserId,$term)
{
	$result = json_encode(false);
	$query ;
	if($kUserId==-1)
		$query = "SELECT t.* from post as p, thread as t where t.categoryid=".$CatId." and t.threadid = p.threadid and lower(p.text) contains lower('".$term."') group by t.threadid";
	else
		$query = "Select t.* from post as p, thread as t WHERE (t.groupid IS NULL OR .tgroupid IN (SELECT t.group_id FROM user_group WHERE user_id = ".$kUserId.")) AND t.categoryid = ".$CatId." and lower(p.text) contains lower('".$term."') group by t.threadid";
	$queryResult = mysql_query($query);
	$allThreads = array();
	if($queryResult!=NULL)
	{
		while($row = mysql_fetch_assoc($queryResult))
		{
			//get tags for this thread
			$threadId = $row['threadid'];
			//select keyword from Tag where tagid IN (Select tagid from tagtothread where threadid=61);
			$tagSearchQuery = "select keyword from Tag where tagid IN (Select tagid from tagtothread where threadid = $threadId)";
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
			
			
			
			//get creater info
			$owner = $row['owner'];
			$ownerSearchQuery = "Select * from User where userid = $owner";
			$ownerSearchQueryResult = mysql_query($ownerSearchQuery);
			if(mysql_num_rows($ownerSearchQueryResult)==1)
			{
				$user = mysql_fetch_assoc($ownerSearchQueryResult);
				$row['owner'] = $user;
			}
			
			//get group name
			$groupId = $row['groupid'];
			if($groupId != NULL)
			{
				$groupQuery = "SELECT name from groups WHERE id = $groupId";
				$groupQueryResult = mysql_query($groupQuery);
				if(mysql_num_rows($groupQueryResult)==1)
				{
					$grp = mysql_fetch_assoc($groupQueryResult);
					$row['groupName']= $grp['name'];
				}	
				
			}

			array_push($allThreads,$row);
		}
		$result = json_encode($allThreads);
	}
	return $result;
}

function searchFirstPostContents($CatId,$kUserId,$term)
{
	$result = json_encode(false);
	$query ;
	if($kUserId==-1)
		$query = "SELECT * from Thread WHERE categoryid = ".$kCatId." and owner=".$kUserId;
	else
		$query = "Select * from Thread WHERE (groupid IS NULL OR groupid IN (SELECT group_id FROM user_group WHERE user_id = ".$kUserId.")) AND categoryid = ".$kCatId." and owner=".$kUserId;
	$allThreads = array();
	if($queryResult!=NULL)
	{
		while($row = mysql_fetch_assoc($queryResult))
		{
			//get tags for this thread
			$threadId = $row['threadid'];
			//select keyword from Tag where tagid IN (Select tagid from tagtothread where threadid=61);
			$tagSearchQuery = "select keyword from Tag where tagid IN (Select tagid from tagtothread where threadid = $threadId)";
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
			
			
			
			//get creater info
			$owner = $row['owner'];
			$ownerSearchQuery = "Select * from User where userid = $owner";
			$ownerSearchQueryResult = mysql_query($ownerSearchQuery);
			if(mysql_num_rows($ownerSearchQueryResult)==1)
			{
				$user = mysql_fetch_assoc($ownerSearchQueryResult);
				$row['owner'] = $user;
			}
			
			//get group name
			$groupId = $row['groupid'];
			if($groupId != NULL)
			{
				$groupQuery = "SELECT name from groups WHERE id = $groupId";
				$groupQueryResult = mysql_query($groupQuery);
				if(mysql_num_rows($groupQueryResult)==1)
				{
					$grp = mysql_fetch_assoc($groupQueryResult);
					$row['groupName']= $grp['name'];
				}	
				
			}

			array_push($allThreads,$row);
		}
		$result = json_encode($allThreads);
	}
	return $result;
}

function searchAuthor($CatId,$kUserId,$term)
{
	$result = json_encode(false);
	$query ;
	if($kUserId==-1)
		$query = "SELECT * from Thread where categoryid=".$CatId." and lower(title) contains lower('".$term."')";
	else
		$query = "Select * from Thread WHERE (groupid IS NULL OR groupid IN (SELECT group_id FROM user_group WHERE user_id = ".$kUserId.")) AND categoryid = ".$CatId." and lower(title) contains lower('".$term."')";
	$queryResult = mysql_query($query);
	$allThreads = array();
	if($queryResult!=NULL)
	{
		while($row = mysql_fetch_assoc($queryResult))
		{
			//get tags for this thread
			$threadId = $row['threadid'];
			//select keyword from Tag where tagid IN (Select tagid from tagtothread where threadid=61);
			$tagSearchQuery = "select keyword from Tag where tagid IN (Select tagid from tagtothread where threadid = $threadId)";
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
			
			
			
			//get creater info
			$owner = $row['owner'];
			$ownerSearchQuery = "Select * from User where userid = $owner";
			$ownerSearchQueryResult = mysql_query($ownerSearchQuery);
			if(mysql_num_rows($ownerSearchQueryResult)==1)
			{
				$user = mysql_fetch_assoc($ownerSearchQueryResult);
				$row['owner'] = $user;
			}
			
			//get group name
			$groupId = $row['groupid'];
			if($groupId != NULL)
			{
				$groupQuery = "SELECT name from groups WHERE id = $groupId";
				$groupQueryResult = mysql_query($groupQuery);
				if(mysql_num_rows($groupQueryResult)==1)
				{
					$grp = mysql_fetch_assoc($groupQueryResult);
					$row['groupName']= $grp['name'];
				}	
				
			}

			array_push($allThreads,$row);
		}
		$result = json_encode($allThreads);
	}
	return $result;
}
function searchTag($CatId,$kUserId,$term)
{
	$result = json_encode(false);
	$query ;
	if($kUserId==-1)
		$query = "SELECT  t.* from tag as ta, tagtothread as ttt, thread as th where t.categoryid=".$CatId." and lower(ta.keyword)=lower('".$term."') and ta.tagid=ttt.tagid and ttt.threadid=th.threadid";
	else
		$query = "Select * from Thread WHERE (groupid IS NULL OR groupid IN (SELECT group_id FROM user_group WHERE user_id = ".$kUserId.")) AND t.categoryid = ".$CatId." and lower(ta.keyword)=lower('".$term."') and ta.tagid=ttt.tagid and ttt.threadid=th.threadid";
	$queryResult = mysql_query($query);
	$allThreads = array();
	if($queryResult!=NULL)
	{
		while($row = mysql_fetch_assoc($queryResult))
		{
			//get tags for this thread
			$threadId = $row['threadid'];
			//select keyword from Tag where tagid IN (Select tagid from tagtothread where threadid=61);
			$tagSearchQuery = "select keyword from Tag where tagid IN (Select tagid from tagtothread where threadid = $threadId)";
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
			
			
			
			//get creater info
			$owner = $row['owner'];
			$ownerSearchQuery = "Select * from User where userid = $owner";
			$ownerSearchQueryResult = mysql_query($ownerSearchQuery);
			if(mysql_num_rows($ownerSearchQueryResult)==1)
			{
				$user = mysql_fetch_assoc($ownerSearchQueryResult);
				$row['owner'] = $user;
			}
			
			//get group name
			$groupId = $row['groupid'];
			if($groupId != NULL)
			{
				$groupQuery = "SELECT name from groups WHERE id = $groupId";
				$groupQueryResult = mysql_query($groupQuery);
				if(mysql_num_rows($groupQueryResult)==1)
				{
					$grp = mysql_fetch_assoc($groupQueryResult);
					$row['groupName']= $grp['name'];
				}	
				
			}

			array_push($allThreads,$row);
		}
		$result = json_encode($allThreads);
	}
	return $result;
}

//$CatId = $_POST['catId'];
//$term = $_POST['term'];
$requestType = $_POST['requestType'];
//$kUserId= $_SESSION['userid'];
$result = json_encode(false);
switch($requestType)
{
	
	case 'threadTitle':
//	case '1':
	$searchText = urldecode($_POST['searchText']);
	$catId = $_POST['catId'];
	$result = searchThreadTitle($catId,$searchText);
	break;
	
	
//	case 'postContent':
	case '2':
	$term = $_POST['term'];
	$result = searchPostContents($CatId,$kUserId,$term);
	break;
	
//	case 'firstPostContent':
	case '3':
	$term = $_POST['term'];
	$result = searchFirstPostContents($CatId,$kUserId,$term);
	break;
	
//	case 'threadAuthor':
	case '4':
	$term = $_POST['term'];
	$result = searchAuthor($CatId,$kUserId,$term);
	break;

//	case 'tagMatch':
	case '5':
	$term = $_POST['term'];
	$result = searchTag($CatId,$kUserId,$term);
	break;		
}


echo $result;

?>