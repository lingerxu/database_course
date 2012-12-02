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

function compare_count($a, $b) {
  $a_count = $a['num'];
  $b_count = $b['num'];
  if ($a_count == $b_count) {
    return 0;
  }
  return $a_count > $b_count ? 1 : -1;
}

function get_top_categories()
{

	$jsonString = json_encode("failure");
	$topCategoryIDsQuery  = "select * from stats_category where update_time = (select max(update_time) from stats_category);";
	$topCategoryIDsResult = mysql_query($topCategoryIDsQuery);
	if($topCategoryIDsResult==NULL) {
		die("Error fetching all Categories".mysql_error());
	} else {
    $topCategoryIDCountMap = array();
    while ($categoryIDRow = mysql_fetch_assoc($topCategoryIDsResult)) {
      $topCategoryIDCountMap[$categoryIDRow['category_id']] = $categoryIDRow['thread_count'];
    }
    
    $topCategoryQuery = "select * from category where categoryid in (".join(",", array_keys($topCategoryIDCountMap)).")";
		//Fetch all queries and encode in to json
    $topCategoryResult = mysql_query($topCategoryQuery);
    $topCategories = array();
		while ($categoryRow = mysql_fetch_assoc($topCategoryResult)) {
      $categoryID = $categoryRow['categoryid'];
			//get the creator name from creator id
			$userInfo = getUserInfoFromUserId($categoryRow['creator']);

			$categoryRow['num'] = $topCategoryIDCountMap[$categoryID];
			$categoryRow['creator'] = json_decode($userInfo);
			$topCategories[] = $categoryRow;
		}
    usort($topCategories, "compare_count");
		$jsonString = json_encode($topCategories);
		
	}
	return $jsonString;
}

function get_top_posts()
{
	$response = json_encode("failure");
	$top_post_ids_query  = "select * from stats_post_vote where update_time = (select max(update_time) from stats_post_vote);";
	$top_category_ids_result = mysql_query($top_post_ids_query);
	if($top_category_ids_result==NULL) {
		die("Error fetching top posts:".mysql_error());
	} else {
    $top_posts_id_count_map = array();
    while ($category_id_row = mysql_fetch_assoc($top_category_ids_result)) {
      $top_posts_id_count_map[$category_id_row['post_id']] = $category_id_row['vote_count'];
    }
    
    $top_post_query = "select postid, threadid, createdby from Post where postid in (".join(",", array_keys($top_posts_id_count_map)).")";
		//Fetch all queries and encode in to json
    $top_post_result = mysql_query($top_post_query);
    $top_posts = array();
		while ($post_row = mysql_fetch_assoc($top_post_result)) {
      $post_id = $post_row['postid'];
			//get the creator name from creator id
			$user_info = getUserInfoFromUserId($post_row['createdby']);

			$post_row['num'] = $top_posts_id_count_map[$post_id];
			$post_row['creator'] = json_decode($user_info);
			$top_posts[] = $post_row;
		}
    usort($top_posts, "compare_count");
		$response = json_encode($top_posts);
		
	}
	return $response;
}

function getUserInfo()
{
	return json_encode($_SESSION['username']);
}

$event = $_POST["eventType"];
if (!$event) {
  $event = $_GET["eventType"];
}

$result = null;
switch($event) {
	case "getTopCategories":
	  $result = get_top_categories();
	  break;

	case "getUserInfo":
		$result = getUserInfo();
	  break;
    
  case 'getTopPosts':
    $result = get_top_posts();
    break;
}

 echo $result;

?>