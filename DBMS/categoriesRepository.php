<?php

session_start();

include "dbconnect.php";


/*Remove this replace this with cURL as this func is there in helpers.php*/ 
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


function getAllCategories()
{

	$allCat = array();
	$jsonString = json_encode("failure");
	$allCategoriesQuery  = "SELECT * FROM category";
	$numOfThreads = 0;
	$result = mysql_query($allCategoriesQuery);
	if($result==NULL)
	{
		die("Error fetching all Categories".mysql_error());
	}
	else
	{
		//Fetch all queries and encode in to jsos
		while($row = mysql_fetch_assoc($result))
		{
			
			//get number of threads in this category
			$cid= $row['categoryid'];
			$numberOfThreadsQuery  = "SELECT COUNT(*) AS num FROM Thread WHERE categoryid = $cid ";
			$numOfThreadsResult = mysql_query($numberOfThreadsQuery);

			if(mysql_num_rows($numOfThreadsResult)==1)
			{
				$n = mysql_fetch_assoc($numOfThreadsResult);
				$numOfThreads = $n['num'];
			}
			
			
			//get the creator name from creator id
			$userInfo = getUserInfoFromUserId($row['creator']);
			
			$row['num'] = $numOfThreads;
			$row['creator'] = json_decode($userInfo);
			array_push($allCat,$row);
		}	
		$jsonString = json_encode($allCat);
		
	
	}
	return $jsonString;
	
	
}

function createNewCategory($catName,$ownerId)
{
	$result = json_encode(false);
	$query = "INSERT INTO category (Category, creator) VALUES ('".$catName."',".$ownerId.")";
	$result = mysql_query($query);
	if($result==true)
		$result = getAllCategories();
	
	 return $result;

}

function deleteCategory($kCategoryId)
{
	 $result = array();
	 $query = "DELETE FROM category WHERE categoryid = ".$kCategoryId;
	 $queryRessult = mysql_query($query);
	 
	 $result['deleteResult']=mysql_affected_rows();
	 $result['list'] = json_decode(getAllCategories());
	
	 return json_encode($result);
}


function getUserInfo()
{
	return json_encode($_SESSION['username']);
}


function basicSearchForKey($key)
{

	$allCat = array();
	$jsonString = json_encode("failure");
	$allCategoriesQuery  = "Select * from `category` where `Category` LIKE '%$key%'"; 
	$numOfThreads = 0;
	$result = mysql_query($allCategoriesQuery);
	if($result==NULL)
	{
		die("Error fetching all Categories".mysql_error());
	}
	else
	{
		//Fetch all queries and encode in to jsos
		while($row = mysql_fetch_assoc($result))
		{
			
			//get number of threads in this category
			$cid= $row['categoryid'];
			$numberOfThreadsQuery  = "SELECT COUNT(*) AS num FROM Thread WHERE categoryid = $cid ";
			$numOfThreadsResult = mysql_query($numberOfThreadsQuery);

			if(mysql_num_rows($numOfThreadsResult)==1)
			{
				$n = mysql_fetch_assoc($numOfThreadsResult);
				$numOfThreads = $n['num'];
			}
			
			
			//get the creator name from creator id
			$userInfo = getUserInfoFromUserId($row['creator']);
			
			$row['num'] = $numOfThreads;
			$row['creator'] = json_decode($userInfo);
			array_push($allCat,$row);
		}	
		$jsonString = json_encode($allCat);
		
	
	}
	return $jsonString;
	
	
}

function advanceSearchForAttributes($key,$creator)
{
	
	$allCat = array();
	$jsonString = json_encode("failure");
	$allCategoriesQuery;
	$allCategoriesQuery = "Select * from `category` WHERE `creator` IN (SELECT userid FROM User WHERE username LIKE '%$creator%') UNION Select * from category where Category LIKE '%$key%'";
	$numOfThreads = 0;
	$result = mysql_query($allCategoriesQuery);

	if($result==NULL)
	{
		die("Error fetching all Categories".mysql_error());
	}
	else
	{
		//Fetch all queries and encode in to jsos
		while($row = mysql_fetch_assoc($result))
		{
			
			//get number of threads in this category
			$cid= $row['categoryid'];
			$numberOfThreadsQuery  = "SELECT COUNT(*) AS num FROM Thread WHERE categoryid = $cid ";
			$numOfThreadsResult = mysql_query($numberOfThreadsQuery);

			if(mysql_num_rows($numOfThreadsResult)==1)
			{
				$n = mysql_fetch_assoc($numOfThreadsResult);
				$numOfThreads = $n['num'];
			}
			
			
			//get the creator name from creator id
			$userInfo = getUserInfoFromUserId($row['creator']);
			
			$row['num'] = $numOfThreads;
			$row['creator'] = json_decode($userInfo);
			array_push($allCat,$row);
		}	
		$jsonString = json_encode($allCat);
		
	
	}
	return $jsonString;
	
	
}


$event = $_POST["eventType"];

$result;
switch($event)
{
	case "getAllCategories":
	$result = getAllCategories();
	break;
	
	case "createNewCategory":
	{
		 $catName = $_POST['kName'];
		 $userid = $_POST['userid'];
		 $result = createNewCategory($catName,$userid);
	}
	break;
	
	case "deleteCategory":
	{
		$catId = $_POST['categoryId'];
		$result = deleteCategory($catId);
	}
	break;
	
	case "getUserInfo":
	{
		$result = getUserInfo();
	}
	break;
	
	case 'basicSearchForKey':
	{
		$key = $_POST['key'];
		$result = basicSearchForKey($key);
	}
	break;
	
	
	case 'advanceSearchForAttributes':
	{
			$key = (isset($_POST['key']))?$_POST['key']:'';
			$creator = (isset($_POST['creator']))?$_POST['creator']:'';
			$result = advanceSearchForAttributes($key,$creator);
	}
	break;
 }

 echo $result;

?>