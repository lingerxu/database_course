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

function get_top_categories($time = null)
{

	$jsonString = json_encode("failure");
  if ($time) {
    $topCategoryIDsQuery  = "select * from stats_category where update_time = (select max(update_time) from stats_category where update_time < STR_TO_DATE('".$time."', '%Y-%m-%d %H:%i:%s'))";
  } else {
    $topCategoryIDsQuery  = "select * from stats_category where update_time = (select max(update_time) from stats_category);";
  }
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

function get_top_posts($time = null)
{
	$response = json_encode("failure");
  if ($time) {
    $top_post_ids_query  = "select * from stats_post_vote where update_time = (select max(update_time) from stats_post_vote where update_time < STR_TO_DATE('".$time."', '%Y-%m-%d %H:%i:%s'))";
  } else {
	  $top_post_ids_query  = "select * from stats_post_vote where update_time = (select max(update_time) from stats_post_vote);";
  }
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

function get_top_threads_by_vote($time = null)
{
	$response = json_encode("failure");
  if ($time) {
    $top_thread_ids_query  = "select * from stats_thread_vote where update_time = (select max(update_time) from stats_thread_vote where update_time < STR_TO_DATE('".$time."', '%Y-%m-%d %H:%i:%s'))";
  } else {
	  $top_thread_ids_query  = "select * from stats_thread_vote where update_time = (select max(update_time) from stats_thread_vote);";
  }
    $top_thread_ids_result = mysql_query($top_thread_ids_query);
	if($top_thread_ids_result==NULL) {
		die("Error fetching top posts:".mysql_error());
	} else {
    $top_threads_id_count_map = array();
    while ($thread_id_row = mysql_fetch_assoc($top_thread_ids_result)) {
      $top_threads_id_count_map[$thread_id_row['thread_id']] = $thread_id_row['vote_count'];
    }
    
    $top_thread_query = "select * from Thread where threadid in (".join(",", array_keys($top_threads_id_count_map)).")";
		//Fetch all queries and encode in to json
    $top_thread_result = mysql_query($top_thread_query);
    $top_threads = array();
		while ($thread_row = mysql_fetch_assoc($top_thread_result)) {
      $thread_id = $thread_row['threadid'];
			//get the creator name from creator id
			$user_info = getUserInfoFromUserId($thread_row['owner']);

			$thread_row['num'] = $top_threads_id_count_map[$thread_id];
			$thread_row['creator'] = json_decode($user_info);
			$top_threads[] = $thread_row;
		}
    usort($top_threads, "compare_count");
		$response = json_encode($top_threads);
		
	}
	return $response;
}

function get_top_threads_by_view($time = null)
{
	$response = json_encode("failure");
  if ($time) {
    $top_thread_ids_query  = "select * from stats_thread_view where update_time = (select max(update_time) from stats_thread_view where update_time < STR_TO_DATE('".$time."', '%Y-%m-%d %H:%i:%s'))";
  } else {
	  $top_thread_ids_query  = "select * from stats_thread_view where update_time = (select max(update_time) from stats_thread_view);";
  }
	$top_thread_ids_result = mysql_query($top_thread_ids_query);
	if($top_thread_ids_result==NULL) {
		die("Error fetching top posts:".mysql_error());
	} else {
    $top_threads_id_count_map = array();
    while ($thread_id_row = mysql_fetch_assoc($top_thread_ids_result)) {
      $top_threads_id_count_map[$thread_id_row['thread_id']] = $thread_id_row['view_count'];
    }
    
    $top_thread_query = "select * from Thread where threadid in (".join(",", array_keys($top_threads_id_count_map)).")";
		//Fetch all queries and encode in to json
    $top_thread_result = mysql_query($top_thread_query);
    $top_threads = array();
		while ($thread_row = mysql_fetch_assoc($top_thread_result)) {
      $thread_id = $thread_row['threadid'];
			//get the creator name from creator id
			$user_info = getUserInfoFromUserId($thread_row['owner']);

			$thread_row['num'] = $top_threads_id_count_map[$thread_id];
			$thread_row['creator'] = json_decode($user_info);
			$top_threads[] = $thread_row;
		}
    usort($top_threads, "compare_count");
		$response = json_encode($top_threads);
		
	}
	return $response;
}

function get_top_users($time = null)
{
	$response = json_encode("failure");
  if ($time) {
    $top_user_ids_query  = "select * from stats_user_post where update_time = (select max(update_time) from stats_user_post where update_time < STR_TO_DATE('".$time."', '%Y-%m-%d %H:%i:%s'))";
  } else {
	  $top_user_ids_query  = "select * from stats_user_post where update_time = (select max(update_time) from stats_user_post);";
  }
	$top_user_ids_result = mysql_query($top_user_ids_query);
	if($top_user_ids_result==NULL) {
		die("Error fetching top posts:".mysql_error());
	} else {
    $top_users_id_count_map = array();
    while ($user_id_row = mysql_fetch_assoc($top_user_ids_result)) {
      $top_users_id_count_map[$user_id_row['user_id']] = $user_id_row['post_count'];
    }
    
    $top_user_query = "select * from User where userid in (".join(",", array_keys($top_users_id_count_map)).")";
		//Fetch all queries and encode in to json
    $top_user_result = mysql_query($top_user_query);
    $top_users = array();
		while ($user_row = mysql_fetch_assoc($top_user_result)) {
      $user_id = $user_row['userid'];
			$user_row['num'] = $top_users_id_count_map[$user_id];
			$top_users[] = $user_row;
		}
    usort($top_users, "compare_count");
		$response = json_encode($top_users);
	}
	return $response;
}

function get_top_users_by_vote($time = null)
{
	$response = json_encode("failure");
  if ($time) {
    $top_user_ids_query  = "select * from stats_user_votes where update_time = (select max(update_time) from stats_user_votes where update_time < STR_TO_DATE('".$time."', '%Y-%m-%d %H:%i:%s'))";
  } else {
	  $top_user_ids_query  = "select * from stats_user_votes where update_time = (select max(update_time) from stats_user_votes);";
  }
	$top_user_ids_result = mysql_query($top_user_ids_query);
	if($top_user_ids_result==NULL) {
		die("Error fetching top posts:".mysql_error());
	} else {
    $top_users_id_count_map = array();
    while ($user_id_row = mysql_fetch_assoc($top_user_ids_result)) {
      $top_users_id_count_map[$user_id_row['user_id']] = $user_id_row['vote_count'];
    }
    
    $top_user_query = "select * from User where userid in (".join(",", array_keys($top_users_id_count_map)).")";
		//Fetch all queries and encode in to json
    $top_user_result = mysql_query($top_user_query);
    $top_users = array();
		while ($user_row = mysql_fetch_assoc($top_user_result)) {
      $user_id = $user_row['userid'];
			$user_row['num'] = $top_users_id_count_map[$user_id];
			$top_users[] = $user_row;
		}
    usort($top_users, "compare_count");
		$response = json_encode($top_users);
	}
	return $response;
}

function update_now() {
  $response = "FAILURE";
  $update_now_query = "CALL stats_update();";
  $result = mysql_query($update_now_query);
  if ($result) {
    $response = "SUCCESS";
  }
  return $response;
}

function getUserInfo()
{
	return json_encode($_SESSION['username']);
}

$event = null;
$time = null;
if (isset($_POST["eventType"])) {
  $event = $_POST["eventType"];
} else if (isset($_GET["eventType"])) {
  $event = $_GET["eventType"];
}

if (isset($_POST["time"])) {
  $time = $_POST["time"];
} else if (isset($_GET["time"])) {
  $time = $_GET["time"];
}

$result = null;
switch($event) {
	case "getTopCategories":
	  $result = get_top_categories($time);
	  break;

	case "getUserInfo":
		$result = getUserInfo();
	  break;
    
  case 'getTopPosts':
    $result = get_top_posts($time);
    break;
    
  case 'getTopThreadsByVote':
    $result = get_top_threads_by_vote($time);
    break;
    
  case 'getTopThreadsByView':
    $result = get_top_threads_by_view($time);
    break;
    
  case 'getTopUsers':
    $result = get_top_users($time);
    break;
    
  case 'getTopUsersByVote':
    $result = get_top_users_by_vote($time);
    break;
    
  case 'updateNow':
    $result = update_now();
    break;
}

include "dbclose.php";
echo $result;

?>