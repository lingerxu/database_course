<!DOCTYPE html>
<html lang="en">
<head>
	<title>Threads</title>
	<!-- Bootstrap -->
	<script src="http://code.jquery.com/jquery-latest.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/bootstrap.js"></script>
	<script src="http://twitter.github.com/bootstrap/assets/js/bootstrap-popover.js"></script>  
	<script type="text/javascript" src="http://twitter.github.com/bootstrap/assets/js/bootstrap-dropdown.js"></script>
	<script type="text/javascript" src="http://twitter.github.com/bootstrap/assets/js/bootstrap-tooltip.js"></script>
	<script type="text/javascript" src="http://twitter.github.com/bootstrap/assets/js/bootstrap-modal.js"></script>
	<script type="text/javascript" src="http://twitter.github.com/bootstrap/assets/js/bootstrap-transition.js"></script>
	

	<script src="js/search.js"></script>
	<script src="js/common.js"></script>
	
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/bootstrap-responsive.css" rel="stylesheet">
	<link href="css/bootstrap-responsive.min.css" rel="stylesheet">
	<link href="css/bootstrap.min.css" rel="stylesheet">

	<link href="css/threads.css" rel="stylesheet">




</head>
<body>


	<div class="navbar navbar-inverse navbar-fixed-top">
		<div class="navbar-inner" style="padding: 0px 10px;">
			<a class="brand" href="index.php">Course Disscussion System</a>
			<ul class="nav">
				<li class="divider-vertical"></li>				
				<li><a id="new-thread-link" rel="tooltip" data-toggle="modal" href="#myModal" data-original-title="new thread" data-placement="bottom"><i class="icon-pencil icon-white"></i></a></li>
				<li class="divider-vertical"></li>				
				<li><a id="new-group-link" rel="tooltip"  data-original-title="create group" data-placement="bottom"><i class="icon-th icon-white"></i></a></li>
				<li class="divider-vertical"></li>				
				<li>
					<div class="btn btn-link" id="new-notifications-button" rel="tooltip"  data-original-title="notifications" data-placement="bottom">
						<i class="icon-bullhorn icon-white"></i>
					</div>
				</li>
					
					
				<!-- <li><a id="new-notifications-button" rel="tooltip"  data-original-title="notifications" data-placement="bottom"><i class="icon-bullhorn icon-white"></i></a></li> -->
				<li class="divider-vertical"></li>				
					
					
			</ul>



			<ul class="nav pull-right">
				<!-- <li class="divider-vertical"></li> -->
				<li class="divider-vertical"></li>				
				<li class="dropdown">
					<a  id="drop1" role="button" class="dropdown-toggle" data-toggle="dropdown" data-target="#" href="#">&nbsp;<p  id="loggedUser">Usernname</p>&nbsp;<i class="icon-user icon-white"></i></a>
					<ul class="dropdown-menu" role="menu" aria-labelledby="drop1">
						<li>
							<a href="#" tabindex="-1">Profile</a>
						</li>
						<li>
							<a href="#" class="logoutLink">Logout</a>
						</li>

					</ul>
				</li>
				<li class="divider-vertical"></li>				
			</ul>




			<form class="navbar-search">
				<div class="input-append">
					<input class="span3" id="searchText" type="text" placeholder="Search Threads">
					<a class="btn" href="#" rel="popover" id="threadSearch" data-placement="top" data-content="demo" data-orignal-title="popvoer"><i class="icon-search"></i></a>
					<div class="popover fade bottom in" id="example">
						<div class="arrow"></div>
						<div class="popover-inner">
							<h3 class="popover-title">Sample Popover</h3>
							<div class="popover-content">
								<p>Sample value</p>
							</div>
						</div>
					</div>
					<a  rel="tooltip" data-toggle="modal" href="#filtersModal" data-original-title="Thread Search Filters" data-placement="bottom" class="btn">Advance Search</i></a>
						
				</div>
			</form>
		</div>
			
		<div class="container-fluid" style="padding-left: 5px !important; padding-right: 5px !important;">
			<div class="row-fluid">
				<div class="span10" style="margin-left: 20px !important;">
					<strong>
						<div class="alert alert-error" id="errorAlert" style="display: none">
						</div>
						<div class="alert" id="infoAlert" style="display: none;">
						</div>
						<div class="alert alert-info" id="successAlert" style="display: none;">
						</div>
					</strong>
				
				</div>
				<div class="span2"></div>
			</div>
		</div>
			


	</div>



	<div class="container-fluid" id="content_container">
			
		<div class="row-fluid" id="row1">


			<!-- <div class="span2 well well-small"   id="sidebar">
			</div> -->

			<div class="span10" id="contentPane">
				<!--Body content-->
				<table class="table outer_table">
					<thead><caption><ul class="breadcrumb pull-left">
						<li><a href="categories.php" class="homeLink">Home</a> <span class="divider">/</span></li>
						<li class="catLink" id="CategoryName">Category <span class="divider">/</span></li>
						
								
					</ul></caption>
					<th>
						
						<div class="sortLinks">
							<ul class="sortList">
								<li class="dropdown">
									<a class="dropdown-toggle"
									data-toggle="dropdown"
									href="#">
									Sort by
									<b class="caret"></b>
								</a>
								<ul class="dropdown-menu">
							
									<li><a tabindex="-1" href="" sort_key="title" class="sort_attr" currOrder='ASC'>title</a></li>
									<li><a tabindex="-1" href="" sort_key="group" class="sort_attr" currOrder='ASC'>group</a></li>
									<li><a tabindex="-1" href="" sort_key="creator" class="sort_attr" currOrder='ASC'>creator</a></li>
									<li><a tabindex="-1" href="" sort_key="status" class="sort_attr" currOrder='ASC'>status</a></li>
									<li><a tabindex="-1" href="" sort_key="datecreated" class="sort_attr" currOrder='ASC'>date created</a></li>
									<li><a tabindex="-1" href="" sort_key="votes" class="sort_attr" currOrder='ASC'>number of votes</a></li>
									<li><a tabindex="-1" href="" sort_key="views" class="sort_attr" currOrder='ASC'>number of views</a></li>
									<li><a tabindex="-1" href="" sort_key="numPost" class="sort_attr" currOrder='ASC'>number of posts</a></li>
									
									
								</ul>
							</li>
						</ul>
					</div>
						
						
				</th>
			</thead>
			<tbody>
				<tr class="tableRow" id="ref">
					<td class="col_for_inner_table">
						<div class="inner_div">
							<table class="inner_table table">
								<tbody>				
										
									<tr class="thread_title_row">
										<td class="ratings_col1" rowspan="7">
											<div id="ddiv">
												<a href="" class="plus_button"><i class="icon-plus" id="star1"></i></a><br/>
												<span class="mybadge" id="votes_val">10</span><br/>
												<a href="" class="minus_button"><i class="icon-minus" id="star2"></i></a><br/>
												<br/>
											</div>
										</td>	
											
										<td class="thread_title_col" colspan="6">
											<div class="thread_title_div">
												<a href="" class="threadLink">
													Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam scelerisque mattis dui et blandit.
												</a></div>
											</td>
											<!-- <td><div class="btn btn-mini btn-link">close</div></td> -->
											<td class="delete_button_cell" ><a href="" class="deleteLink"><i class="icon-trash"></i></td>
											</tr>
										
											
											<tr class="thread_content_row">
												<td class="thread_content_col" colspan="7">
													<div class="thread_content_div">
														Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam scelerisque mattis dui et blandit. Etiam a orci et purus fringilla pulvinar posuere eget massa. Nam at velit ante. In hac habitasse platea dictumst. Phasellus in mauris erat, vitae scelerisque ligula. Suspendisse potenti. Cras mauris sem, cursus ut molestie mollis, tincidunt ut nibh. Quisque eleifend libero dui. Proin sagittis adipiscing diam sit amet elementum. Fusce pellentesque vulputate massa cursus cursus. Nulla facilisi. Nam rhoncus ligula ut nisl sodales in cursus elit viverra. Vestibulum volutpat, velit in hendrerit tempor, risus erat ultricies lectus, sed tincidunt dolor ligula sed quam. Morbi congue tempus nibh, eget imperdiet nulla placerat facilisis.
													</div>
												</td>
											
											
											</tr>
										
											<tr class="thread_info_row">
												<td class="status_col">
													<p class="status_lbl">Status:&nbsp;<a href="" class="status-link">Closed</a></p>
												</td>
												<td class="posts_col">
													<p class="posts_lbl">Posts:&nbsp; <span class="posts_val"></span></p>
												</td>
												<td class="views_col">
													<p class="views_val_lbl">Views:&nbsp;<span class="views_val"></span></p>
												</td>
												<td class="created_by_col">
													<p class="created_by_lbl">Created By:&nbsp; <span class="created_by_val"></span></p>
												</td>
												<td class="group_col">
													<p class="group_lbl">Group: &nbsp; <span class="group_val">-</span></p>
												</td>
												<td class="created_col">
													<p class="date_creted_lbl">Created:&nbsp; <span class="date_creted_val"></span></p>
												</td>
											</tr>
										

											<tr class="tagsRow">
												<td colspan="4" class="tagsCol"><div class="tagContainer"><span class="label label-info tag" id="reftag">Sample Tag</span></div></td>
											</tr>
										

										</tbody>
									</table>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			</div>


			<div class="span2" data-spy="affix"  id="rightPane">
				<div id="tch">Top Threads</div>
				<ul id="right_bar_nav_list">
					<li id="right_bar_ref_listItem" class="right_bar_ref_listItems"><a id="right_bar_ref_link" target-row="cat:x" class="right_bar_nav_link">Cat 1</a></li>
				</ul>
				
			</div>
		</div>
	</div>


	<!-- Modal view for creating new thread -->

	<div id="myModal" class="modal" style="display: none;">
		<div class="modal-header">
			<!-- <button class="close" data-dismiss="modal">×</button> -->
			<h6>New Thread</h6>
		</div>
		<div class="modal-body">
			<input class="span6" type="text"  placeholder="thread title" id="newThreadTitle" maxlength="200">
			<br/>
			<textarea rows="6" cols="200" class="span6" placeholder="thread description" id="newThreadDesc"></textarea>
			<br/>
			<div>
				<input class="span6" type="text" placeholder="tag1,tag2,tag3...." id="tagsList" maxlength="200">
				<select id="tagOption">
					<option id="refTagOption" tagId="-1">--Select Tag--</option>
				</select>
			</div>
			<br/>
			<select id="groupsOption">
				<option id="refOption" grpid='-1'>-- select group--</option>
			</select>
		</div>
		<div class="modal-footer">
			<a href="" class="btn" data-dismiss="modal" id="newThreadCloseButton">Close</a>
			<a href="" class="btn btn-primary" id="newThreadSaveButton">Create thread</a>
		</div>
	</div>
		
		
	<!-- Modal view for search filters -->
		
	<div id="filtersModal" class="modal" style="display: none; ">
		<div class="modal-header">
			<!-- <button class="close" data-dismiss="modal">×</button> -->
			<h6>Filters</h6>
		</div>
		<div class="modal-body">
			<form class="form-horizontal">
				  
				<div class="control-group">
					<label class="control-label" for="inputEmail">Search by keyword</label>
					<div class="controls">
						<input type="text" id="keyword_filter" placeholder="keyword">
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" for="inputEmail">Search by User</label>
					<div class="controls">
						<input type="text" id="user_filter" placeholder="user">
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="inputEmail">Search by Tag</label>
					<div class="controls">
						<input type="text" id="tag_filter" placeholder="tag">
					</div>
				</div>
			</form>
				
		</div>
		<div class="modal-footer">
			<a href="#" class="btn" data-dismiss="modal">Cancel</a>
			<a href="#" class="btn btn-primary">Search</a>
		</div>
	</div>
		
		
		
		
		
	<!-- Modal view for creating new group -->
		
	<div id="myGroupModalContainer" style="display: none;" >
		<div id="myGroupModal">
			<div class="grpReqAlert error">This is alerts</div>
			<div class="grpReqAlert success">This is alerts</div>
			<div id="mheader">
				New Group Request
			</div>
			<input type="text" placeholder="group name" id="newgroupTitle" maxlength="200">
				
			<div id="grpReqMembersLbl">Select group members</div>
			<div id="mbody">
				<table id="modalTable" width="100%">
					<!-- <th>Select group members</th> -->
					<tr id="modalRow" class="userRemoved reqMemberRow">
						<td class="uname">
							Sample name
						</td>
						<td class="bcol">
							<a href="" class="addRemLink"><i class="icon-plus"></i></a>
						</td>
					</tr>
				</table>
			</div>
			<div id="mfooter">
				<div class="btn btn-link" id="cancelGrpReq">cancel</div>
				<div class="btn btn-link" id="submitGrpReq">submit request</div>
			</div>
		</div>
	</div>
		
		
	<!-- Modal view for group request -->
	<div id="requestContainer">
		<div id="requestsModal">
			<div id="requestModalHeader">
				<div style="display: inline-block;">Group Requests</div>
			</div>
			<div class="alertPopUp" id="grpReqErrorMsg">Alert</div>
				
			<!-- <table>
				<thead class="reqHeaders">
					<th>Group Name</th>
					<th>Requester</th>
					<th>Members</th>
					<th class="rightAlignClass">Action</th>
				</thead>
			</table> -->
				
			<div id="requestModalBody">
				<table class="reqTable">
					<thead class="reqHeaders">
						<th>Group Name</th>
						<th>Requester</th>
						<th>Members</th>
						<th class="rightAlignClass">Action</th>
					</thead>
						
					<tbody class="reqTableBody">
						<tr class="reqRow" id="refReqRow">
							<td class="nameCol">Group Name</td>
							<td class="requesterCol">Requester Name</td>
							<td class="membersCol">
								<p id="refMemberName" class="memberNameClass">Name1</p>
							</td>
							<td class="controlsCol rightAlignClass"><!-- <div class="btn btn-link groupApproveButton">Approve</div> -->
								<a class="btn btn-link groupApproveButton" href="" ><i class="icon-ok-sign"></i></a>
								<a class="btn btn-link groupRejectButton" href="" ><i class="icon-remove-sign"></i></a>
							</td>
						</tr>
						<tbody>
												
						</table>
					</div>
					<div id="requestModalFooter" style="text-align: right;">
						<div class="btn btn-link" id="reqModalCancel">close</div>
					</div>
				</div>
			</div>
		
		



		</body>
		</html>