<!DOCTYPE html>
<html>
<head>
	<title>Categories</title>
	<!-- Bootstrap -->
	<script src="http://code.jquery.com/jquery-latest.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/bootstrap.js"></script>
	<script src="http://twitter.github.com/bootstrap/assets/js/bootstrap-popover.js"></script>  
	<script type="text/javascript" src="http://twitter.github.com/bootstrap/assets/js/bootstrap-dropdown.js"></script>
	<script type="text/javascript" src="http://twitter.github.com/bootstrap/assets/js/bootstrap-tooltip.js"></script>
	<script type="text/javascript" src="http://twitter.github.com/bootstrap/assets/js/bootstrap-modal.js"></script>
	<script type="text/javascript" src="http://twitter.github.com/bootstrap/assets/js/bootstrap-transition.js"></script>
	<script src="http://twitter.github.com/bootstrap/assets/js/bootstrap-popover.js"></script>  

	<script src="js/categories.js"></script>
	<script src="js/common.js"></script>

	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/bootstrap-responsive.css" rel="stylesheet">
	<link href="css/bootstrap-responsive.min.css" rel="stylesheet">
	<link href="css/bootstrap.min.css" rel="stylesheet">
	


	<link href="css/categories.css" rel="stylesheet">
	</head>
	<body>


		<div class="navbar navbar-inverse navbar-fixed-top">
			<div class="navbar-inner" style="padding: 0px 10px;">
				<a class="brand" href="index.php">Course Disscussion System</a>
				<ul class="nav">
					<li class="divider-vertical"></li>				
					<li><a id="create-category-link" rel="tooltip" data-toggle="modal" href="#myModal" data-original-title="create category" data-placement="bottom"><i class="icon-pencil icon-white"></i></a></li>
					<li class="divider-vertical"></li>				
				</ul>



				<ul class="nav pull-right">
					<!-- <li class="divider-vertical"></li> -->
					<li class="divider-vertical"></li>				
					<li class="dropdown">
						<a  id="drop1" role="button" class="dropdown-toggle" data-toggle="dropdown" data-target="#" href="#"><p id="loggedUser" style="display: inline;">Username</p>&nbsp;<i class="icon-user icon-white"></i></a>
						<ul class="dropdown-menu" role="menu" aria-labelledby="drop1">
							<li>
								<a href="profile.php" tabindex="-1">Profile</a>
							</li>
							<li>
								<a href="#" tabindex="-1" class="logoutLink">Logout</a>
							</li>

						</ul>
					</li>
					<li class="divider-vertical"></li>	
          <li><a href="/DBMS/stats.php">Statistics</a></li>
					<li class="divider-vertical"></li>
          <li><a href="/DBMS/categories.php">About</a></li>
					<li class="divider-vertical"></li>               
				</ul>




				<form class="navbar-search">
					<div class="input-append">
						<input class="span3" id="searchText" type="text" placeholder="Search Categories">
						<a class="btn" href="#" id="catSearch"><i class="icon-search"></i></a>
						<a  rel="tooltip" data-toggle="modal" href="#filtersModal" data-original-title="Thread Search Filters" data-placement="bottom" class="btn">Advance Search</i></a>
						<!-- <a href="#" id="blob" class="btn" rel="popover inner" data-placement="bottom" data-content="Works" data-original-title="Filters">Advance Search</a> -->
						
					</div>
				</form>
			</div>
			
			<div class="row-fluid" id="row1"class="margin: 0px;">
				<div class="span2 ">
				</div>
				<div  class="span7">
					<strong>
						<div class="alert alert-error" id="errorAlert" style="display: none">
						</div>
						<div class="alert" id="infoAlert" style="display: none;">
						</div>
						<div class="alert alert-info" id="successAlert" style="display: none;">
						</div>
					</strong>
				</div>
				<div class="span3">
				</div>
			</div>
			
		</div>


		<div class="container-fluid" id="content_container">
			<div class="row-fluid" id="row1"class="margin: 0px;">


				<div class="span2"   id="sidebar">
					<!-- Side bar div  -->
				</div>

				<div  class="span7" id="contentPane">
					<!--Body content-->
					<div id="search_result_info"><a href="" id="clearSearchResult">Clear Search Results</a></div>
					<table class="table">
						<caption><ul class="breadcrumb pull-left">
							<li>Home <span class="divider">/</span></li>
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
							
										<li><a tabindex="-1" href="" sort_key="Category" class="sort_attr" currOrder='ASC'>title</a></li>
										<li><a tabindex="-1" href="" sort_key="creator" class="sort_attr" currOrder='ASC'>creator</a></li>
										<li><a tabindex="-1" href="" sort_key="threads_count" class="sort_attr" currOrder='ASC'>thread count</a></li>
									
									</ul>
								</li>
							</ul>
						</div>
							
						</th>
						<thead>
						</thead>
						<tbody>
							<tr class="tableRow" id="ref">
								<td>
									<table class="cellSkeleton">
										<!-- <thead><th/><th/><th/><th/></thead> -->
										<col width="24.5%">
										<col width="24.5%">
										<col width="24.5%">
										<col width="24.5%">
										<col width="10%">
																																								
										<tbody>
											<tr class="catDesc">
												<td class="skeletonCol catName" colspan="4"><a href="" class="catLink">&lt;Category Name&gt;</a></td>
												<td class="skeletonCol catDelButton" colspan="1"><a href="javascript:void(0)" class="delLink"><i class="icon-trash"></i></a></td>
											</tr>
											<tr class="catInfo">
												<td class="skeletonCol catThreadsCount">50 threads</td>
												<td class="skeletonCol createdBy">created by:&nbsp;<span class="createdBySpan"></span></td>											
												<td/>
												<td/>
												<td/>
											</tr>

										</tbody>
									</table>
								</td>
							</tr>
						</tbody>
					</table>
				</div>


				<div class="span3 " id="rightPane">
					<div id="tch">Top Categories</div>
					<ul id="right_bar_nav_list">
						<li id="right_bar_ref_listItem" class="right_bar_ref_listItems"><a id="right_bar_ref_link" target-row="cat:x" class="right_bar_nav_link">Cat 1</a></li>
					</ul>
				</div>
			</div>
		</div>


		<!-- Modal view for creating new category -->

		<div id="myModal" class="modal" style="display: none; ">
			<div class="modal-header">
				<!-- <button class="close" data-dismiss="modal">×</button> -->
				<h3>Create new category</h3>
			</div>
			<div id='newCatAlert'>Please enter category Name</div>
			
			<div class="modal-body">
				<input type="text" placeholder="category name" class="span5"  maxlength="200" size="100" id="catName">
				<br/>
				<!-- <textarea rows="5" placeholder="description"></textarea> -->
			</div>
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal" id="cancelNewCat">Close</a>
				<a href="#" class="btn btn-primary" id="newCatSave">Save changes</a>
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

				<!-- <div class="control-group">
				    <label class="control-label" for="inputEmail">Search by Tag</label>
				    <div class="controls">
				      <input type="text" id="tag_filter" placeholder="tag">
				    </div>
				 </div> -->
				
				
				
				</form>
				
			</div>
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal" id="catAdvancedSearchCancelButton">Cancel</a>
				<a href="#" class="btn btn-primary" id="catAdvancedSearch">Search</a>
			</div>
		</div>



	</body>
	</html>
