<!DOCTYPE html>
<html>
<head>
	<title>Posts</title>
	<!-- Bootstrap -->
	<script src="http://code.jquery.com/jquery-latest.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/bootstrap.js"></script>
	<script src="http://twitter.github.com/bootstrap/assets/js/bootstrap-popover.js"></script>  
	<script type="text/javascript" src="http://twitter.github.com/bootstrap/assets/js/bootstrap-dropdown.js"></script>
	<script type="text/javascript" src="http://twitter.github.com/bootstrap/assets/js/bootstrap-tooltip.js"></script>
	<script type="text/javascript" src="http://twitter.github.com/bootstrap/assets/js/bootstrap-modal.js"></script>
	<script type="text/javascript" src="http://twitter.github.com/bootstrap/assets/js/bootstrap-transition.js"></script>

	<script src="js/posts.js"></script>
	<script src="js/common.js"></script>

	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/bootstrap-responsive.css" rel="stylesheet">
	<link href="css/bootstrap-responsive.min.css" rel="stylesheet">
	<link href="css/bootstrap.min.css" rel="stylesheet">

	<link href="css/posts.css" rel="stylesheet">


	</head>
	<body>


		<div class="navbar navbar-inverse navbar-fixed-top">
			<div class="navbar-inner" style="padding: 0px 10px;">
				<a class="brand" href="index.php">Course Disscussion System</a>
				<ul class="nav">
					<li class="divider-vertical"></li>				
					<li><a  rel="tooltip" data-toggle="modal" href="#myModal" data-original-title="new post" data-placement="bottom"><i class="icon-pencil icon-white"></i></a></li>
					<li class="divider-vertical"></li>				
				</ul>



				<ul class="nav pull-right">
					<!-- <li class="divider-vertical"></li> -->
					<li class="divider-vertical"></li>				
					<li class="dropdown">
						<a  id="drop1" role="button" class="dropdown-toggle" data-toggle="dropdown" data-target="#" href="#">&nbsp;<span id="loggedUser">Usernname</span>&nbsp;<i class="icon-user icon-white"></i></a>
						<ul class="dropdown-menu" role="menu" aria-labelledby="drop1">
							<li>
								<a href="#" tabindex="-1">Profile</a>
							</li>
							<li>
								<a href="#" tabindex="-1" class="logoutLink">Logout</a>
							</li>

						</ul>
					</li>
					<li class="divider-vertical"></li>				
				</ul>




				<form class="navbar-search">
					<div class="input-append">
						<input class="span3" id="searchText" placeholder="Search Threads" type="text">
						<a class="btn" href="#" rel="popover" id="threadSearch" data-placement="top" data-content="demo" data-orignal-title="Search"><i class="icon-search"></i></a>
						<div class="popover fade bottom in" id="example">
							<div class="arrow"></div>
							<div class="popover-inner">
								<h3 class="popover-title">Sample Popover</h3>
								<div class="popover-content">
									<p>Sample value</p>
								</div>
							</div>
						</div>
						<a rel="tooltip" data-toggle="modal" href="#filtersModal" data-original-title="Thread Search Filters" data-placement="bottom" class="btn">Advance Search</a>
						
					</div>
				</form>
			</div>
		</div>


		<div class="container-fluid" id="content_container">
			<div class="row-fluid" id="row1"class="margin: 0px;">


				<div class="span9" id="contentPane">
					<!--Body content-->
					<table class="table outer_table">
						<thead><caption><ul class="breadcrumb pull-left">
							<li><a href="" class="homeLink">Home</a> <span class="divider">/</span></li>
							<li><a href="" id="CategoryName" class="catLink">Category</a> <span class="divider">/</span></li>
							<li class="threadLink" id="ThreadName">Thread <span class="divider">/</span></li>
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
							
									<li><a tabindex="-1" href="" sort_key="votes" class="sort_attr" currOrder='ASC'>number of votes</a></li>
									<li><a tabindex="-1" href="" sort_key="dateposted" class="sort_attr" currOrder='ASC'>Date created</a></li>
									
								</ul>
							</li>
						</ul>
					</div>
						
						
				</th>
						</thead>
						<tbody>
							<tr class="tableRow" id="ref">
								<td>
									<div class="inner_div">
									
									<table class="inner_table table">
									<tbody>
										<tr class="post_rating_row">
											<td class="ratings_col1" rowspan="6">
												<div id="ddiv">
												<a href="" class="plus_button"><i title="Vote Up" class="icon-plus" id="star1"></i></a><br/>
												<span class="mybadge" id="votes_val"> 10</span><br/>
												<a href="" class="minus_button"><i title="Vote Down" class="icon-minus" id="star2"></i></a><br/>
											</div>
											</td>	
											<td class="posted_by">
												<p>Posted By: <span class="posted_by_val"></span></p>
											</td>
											<td class="posted_date">
												<p>Date Posted: <span class="posted_date_val"></span></p>
											</td>
											<td/>
											<td class="button_cell"><a href="#" class="editLink"><i title="Edit" class="icon-edit"></i></a>  <a href="" class="delete_button_cell deleteLink"><i title="Delete" class="icon-remove"></i></a></td>
										</tr>
										
											
										<tr class="post_content_row">
											<td class="post_content_col" colspan="4">
												<div class="post_content_div">
														Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam scelerisque mattis dui et blandit. Etiam a orci et purus fringilla pulvinar posuere eget massa. Nam at velit ante. In hac habitasse platea dictumst. Phasellus in mauris erat, vitae scelerisque ligula. Suspendisse potenti. Cras mauris sem, cursus ut molestie mollis, tincidunt ut nibh. Quisque eleifend libero dui. Proin sagittis adipiscing diam sit amet elementum. Fusce pellentesque vulputate massa cursus cursus. Nulla facilisi. Nam rhoncus ligula ut nisl sodales in cursus elit viverra. Vestibulum volutpat, velit in hendrerit tempor, risus erat ultricies lectus, sed tincidunt dolor ligula sed quam. Morbi congue tempus nibh, eget imperdiet nulla placerat facilisis.
												</div>
											</td>
										</tr>
<!-- 										<tr class="reply-btn-row"> -->
<!-- 											<td class="reply-btn-col"><a href="" class="btn btn btn-mini replyLink" >Reply</a></td> -->
<!-- 										</tr> -->
										<tr class="tagsRow">
											<td colspan="3" class="tagsCol"><div class="tagContainer"><span class="label label-info tag" id="reftag">Sample Tag</span></div></td>
										</tr>
										<tr class="replyRow">
										<td><a href="" class="btn replyLink" >Reply</a></td>
										</tr>
										
									</tbody>
								</table>
							</div>
							</td>
							</tr>
						</tbody>
						</table>
						
						
						<div  class="new_post_div">
							
						</div>
				</div>


				<div class="span3" id="rightPane"></div>
			</div>
		</div>


		<!-- Modal view for creating new post -->

		<div id="myModal" class="modal" style="display: none; ">
			<div class="modal-header">
				<h6>New Post</h6>
			</div>
			<div class="modal-body">
				<textarea rows="5" class="span7" placeholder="Your message goes here" id="newPostDesc"></textarea>
				<br/>
				<div>
				<input class="span6" type="text" placeholder="tag1,tag2,tag3...." id="tagsList" maxlength="200">
				<select id="tagOption">
					<option id="refTagOption" tagId="-1">--Select Tag--</option>
				</select>
				</div>
				<br/>
				
			</div>
			<div class="modal-footer">
				<a href="" class="btn" data-dismiss="modal" id="newPostCloseButton">Close</a>
				<a href="" class="btn btn-primary" id="newPostSaveButton">Create Post</a>
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

		


	</body>
	</html>
