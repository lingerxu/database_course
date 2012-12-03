<!DOCTYPE html>
<html>
<head>
	<title>Statistics</title>
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

	<script src="js/stats.js"></script>
	<script src="js/common.js"></script>

	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/bootstrap-responsive.css" rel="stylesheet">
	<link href="css/bootstrap-responsive.min.css" rel="stylesheet">
	<link href="css/bootstrap.min.css" rel="stylesheet">
	


	<link href="css/stats.css" rel="stylesheet">
	</head>
	<body>


		<div class="navbar navbar-inverse navbar-fixed-top">
			<div class="navbar-inner" style="padding: 0px 10px;">
				<a class="brand" href="index.php">Course Disscussion System</a>

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
				</ul>

			</div>
		</div>


		<div class="container-fluid" id="content_container">
			<div class="row-fluid" id="row1"class="margin: 0px;">


				<div class="span2"   id="sidebar">
					<!-- Side bar div  -->
				</div>

				<div  class="span7" id="contentPane">
					<!--Body content-->
					<table class="table">
						<caption><ul class="breadcrumb pull-left">
							<li>Home <span class="divider">/</span></li>
              <li>Statistics</li>
						</ul></caption>

						<thead>
						</thead>
						<tbody>
              <tr>
                <th>Top Categories</th>
              </tr>
              <tr id="categoryLoadingIndicator">
                <td><img src="img/loading-indicator.gif"/></td>
              </tr>
							<tr class="tableRow" id="refCategory">
								<td>
									<table class="cellSkeleton">
										<!-- <thead><th/><th/><th/><th/></thead> -->
										<col width="200">
                    <col width="100">
                    <col width="100">
										<tbody>
											<tr class="catDesc">
												<td class="skeletonCol catName"><a href="" class="catLink">&lt;Category Name&gt;</a></td>
												<td class="skeletonCol catThreadsCount">50 threads</td>
												<td class="skeletonCol createdBy">created by:&nbsp;<span class="createdBySpan"></span></td>											
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
						</tbody>
            
            <tbody>
              <tr style="display: none;">
                <th>Top Posts</th>
              </tr>
							<tr class="tableRow" id="refPost">
								<td>
									<table class="cellSkeleton">
										<!-- <thead><th/><th/><th/><th/></thead> -->
										<col width="200">
                    <col width="100">
                    <col width="100">
										<tbody>
											<tr class="postDesc">
												<td class="skeletonCol postName"><a href="" class="postLink">&lt;Category Name&gt;</a></td>
												<td class="skeletonCol postVoteCount">50 votes</td>
												<td class="skeletonCol createdBy">created by:&nbsp;<span class="createdBySpan"></span></td>											
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
						</tbody>
            
            <tbody>
              <tr>
                <th>Top Threads by View</th>
              </tr>
              <tr id="threadViewLoadingIndicator">
                <td><img src="img/loading-indicator.gif"/></td>
              </tr>
							<tr class="tableRow" id="refThreadView">
								<td>
									<table class="cellSkeleton">
										<!-- <thead><th/><th/><th/><th/></thead> -->
										<col width="200">
                    <col width="100">
                    <col width="100">
										<tbody>
											<tr class="threadDesc">
												<td class="skeletonCol threadName"><a href="" class="threadLink">&lt;Thread Name&gt;</a></td>
												<td class="skeletonCol threadViewCount">50 views</td>
												<td class="skeletonCol createdBy">created by:&nbsp;<span class="createdBySpan"></span></td>											
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
						</tbody>
            
            <tbody>
              <tr>
                <th>Top Threads by Vote</th>
              </tr>
              <tr id="threadVoteLoadingIndicator">
                <td><img src="img/loading-indicator.gif"/></td>
              </tr>
							<tr class="tableRow" id="refThreadVote">
								<td>
									<table class="cellSkeleton">
										<col width="200">
                    <col width="100">
                    <col width="100">
										<tbody>
											<tr class="threadDesc">
												<td class="skeletonCol threadName"><a href="" class="threadLink">&lt;Thread Name&gt;</a></td>
												<td class="skeletonCol threadVoteCount">50 votes</td>
												<td class="skeletonCol createdBy">created by:&nbsp;<span class="createdBySpan"></span></td>											
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
						</tbody>
            
            <tbody>
              <tr>
                <th>Top Users by Posts</th>
              </tr>
              <tr id="userLoadingIndicator">
                <td><img src="img/loading-indicator.gif"/></td>
              </tr>
							<tr class="tableRow" id="refUser">
								<td>
									<table class="cellSkeleton">
										<col width="150">
                    <col width="150">
                    <col width="100">
										<tbody>
											<tr class="userDesc">
                        <td class="skeletonCol userLoginName">&lt;User Name&gt;</td>
												<td class="skeletonCol userName">&lt;User Name&gt;</td>
												<td class="skeletonCol userPostCount">50 posts</td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</body>
	</html>