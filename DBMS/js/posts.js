$("document").ready(
	function()
	{
		$("#NewPostErrorMsg").hide();
		$("#search_result_info").hide();
		
		//Get logged in userinfo
		$.ajax({
			type: "POST",
			url: "helpers.php",
			async: false,
			data: {requestType: 'getLoggedInUserInfo'},
		}).done(function(response){

			
			var userInfo = jQuery.parseJSON(response);
			console.log(userInfo);
			if(userInfo)
			{
				//set username
				$("#loggedUser").html(userInfo.username);
				$("#loggedUser").attr('userType',userInfo.userType);
				$("#loggedUser").attr('userid',userInfo.userid);
				$("#loggedUser").attr('username',userInfo.username);
				
				
			}
			
		});
		
		$(".deleteLink").removeAttr('href');
		$(".deleteLink").css('opacity',0);
		$(".editLink").removeAttr('href');
		$(".editLink").css('opacity',0);
		
		$('.inner_table').live('mouseover mouseout', function(event) {
			if (event.type == 'mouseover') 
			{
				$(this).find(".deleteLink").attr('href',"");
				$(this).find(".deleteLink").css('opacity',1);
				$(this).find(".editLink").attr('href',"");
				$(this).find(".editLink").css('opacity',1);
			} 
			else 
			{
				$(".deleteLink").removeAttr('href');
				$(".deleteLink").css('opacity',0);
				$(".editLink").removeAttr('href');
				$(".editLink").css('opacity',0);
			}
		});
		

		$('.dropdown-toggle').dropdown(); 
		$('[rel = tooltip]').tooltip(); 

		$(".star_link").click(function(){
			$(this).children().toggleClass('icon-star icon-star-empty');
		});

/*		$(".delete_button_cell").click(function(){
			$(this).parentsUntil(".tableRow").hide();			
		});*/

		$("#searchFilter").click(function(event){
			console.log("Opening search filter");
			$('#example').popover();
		});
		
		
		
		//get url components
		function getURLParamValue(paramName){
			   if(paramName=(new RegExp('[?&]'+encodeURIComponent(paramName)+'=([^&]*)')).exec(location.search))
			      return decodeURIComponent(paramName[1]);
			}
		var threadId = getURLParamValue("threadId");
		var catId = getURLParamValue("catId");
		console.log("Thread id = "+threadId+" Cat Id = "+catId);
		
		$.ajax({
			type: "POST",
			url: "threadsRepository.php",
			async: false,
			data: { requestType: "getParentCategoryInfo", catId: String(catId) },
		}).done(function(response){
				var json = jQuery.parseJSON(response);
				console.log(json);
				$("#CategoryName").html(String(json.Category));
				$("#CategoryName").attr("catId",String(json.categoryid));
		});
		
		$.ajax({
			type: "POST",
			url: "postsRepository.php",
			async: false,
			data: { requestType: "getParentThreadInfo", threadId: String(threadId) },
		}).done(function(response){
				var json = jQuery.parseJSON(response);
				console.log("thread is "+json);
				$("#ThreadName").html(String(json.title));
				$("#ThreadName").attr("threadId",String(json.threadid));
				// Disabling the create post button if thread is closed
				if(json.status=='closed') {
					$("#createNewPost").attr('href',"#");
					$("#createNewPost").css('cursor',"not-allowed");
				}
		 });
		
		
		//get posts for thread
		$.ajax({
			type: "POST",
			url: "postsRepository.php",
			async: false,
			data: { requestType: "getPostsForThread", threadId: String(threadId) },
		}).done(function(response){
			var list = jQuery.parseJSON(response);
			layoutRows(list);			
		});

		function convertPostToTable(text,counter) {
			// Based on counter providing a different color for the reply post text.
			if(counter%2===0)
				text = text.replace('[Post]', '<table class="well table"><tbody><tr><td><span class="replyTitle">');
			else
				text = text.replace('[Post]', '<table class="alert alert-info table"><tbody><tr><td><span class="replyTitle">');
			text = text.replace('[lineBreak]', '</span><br>');
			text = text.replace('[endPost]', '</td></tr></tbody></table>');
			if(text.indexOf('[Post]')>-1)
				text = convertPostToTable(text, counter+1);
			return text;
		}
		
		//When user clicks on a reply to a post
		$('.replyLink').live('click',function(event){
			event.preventDefault();
			$(this).parent().attr('colspan',4);
			$(this).parent().html("<div class=\"replyToPost well\">" +
					"<textarea class=\"span10\" rows=\"3\" placeholder=\"Your Reply\" id=\"replyPostContent\" data-spy=\"scroll\"></textarea>" +
					"<br>" +
					"<a href=\"\" id=\"replyPostSaveButton\" class=\"btn pull-right\"><i class=\"icon-ok\"></i></a>" +
					"<a href=\"\" id=\"replyPostCancelButton\" class=\"btn pull-right\"><i class=\"icon-remove\"></i></a>" +
					"</div>");
		});
		
		$('#replyPostSaveButton').live('click',function(event){
			event.preventDefault();
			// Read the parent post and add it to the reply to store it in the DB.
			// This is done to improve performance and to avoid recursive DB calls.
			var $parentPostRow = $(this).closest('.inner_table');
			parentPostText = $parentPostRow.find('.post_content_div').val();
			parentPostByUser = $parentPostRow.find('.posted_by_val').html();
			parentPostDate = $parentPostRow.find('.posted_date_val').html();
			parentPost = '[Post]'+parentPostByUser+' on '+parentPostDate+' wrote :[lineBreak]'+parentPostText+'[endPost]';
			
			var replyPostContent=$(this).parent().find("#replyPostContent").val();
			console.log("ERROR in Reply"+replyPostContent.length);
			var isvalid = false;
			isvalid = ((replyPostContent.length>0)?true:false);
						
			if(!isvalid)
			{
				console.log("ERROR in Reply");
				
				$("#errorAlert").html("<i class=' icon-warning-sign'></i> Please enter some text");
				$("#errorAlert").fadeIn('fast');
				$("#errorAlert").fadeOut(3000);
				return;
			}
			else
			{
			
			reply = parentPost + $(this).parent().find("#replyPostContent").val();
			//get the post id for the post to which you are replying
			var parentPostId  = $(this).closest('.tableRow').attr('postId');
			$.ajax({
				type: "POST",
				url: "postsRepository.php",
				async: false,
				data: { requestType: "createReplyPost", replyText: String(reply),
					postId: String(parentPostId), threadId:String(threadId) },
			}).done(function(data){
					var response = jQuery.parseJSON(data);
					if(response!=true) {
						alert("There was an error posting the reply!\nPlease check the console logs for more details");
					}
					console.log(response);
					window.location = 'posts.php?threadId='+threadId+'&catId='+catId;
				});
			}
		});
		
		
		$('#replyPostCancelButton').live('click',function(event){
			event.preventDefault();
			$(this).parent().parent().html("<a href=\"\" class=\"btn replyLink\" >Reply</a>");
		});
		
		//Create new post
		
		$("#newPostSaveButton").click(function(event){
			// get category id
			// get post description
			event.preventDefault();
			var desc = $("#newPostDesc").val();
			var threadId = $("#ThreadName").attr('threadId');
			var tagsList = $('#tagsList').val();
			var allTags =tagsList.split(','); 
			var jsonTags = JSON.stringify(allTags);
			//create new post and get updated list of posts
			console.log("Creating new post : "+ desc + "for thread "+threadId);
			
			var isvalid = false;
				
			isvalid = ((desc.length>0)?true:false);
						
			if(!isvalid)
			{
				console.log("ERROrin post");
				//$(".alert").hide();
				$("#NewPostErrorMsg").html("Please enter some text");
				$("#NewPostErrorMsg").fadeIn('fast');
				$("#NewPostErrorMsg").fadeOut(3000);
				return;
			}
			else
			{
			
			var postData = new Object();
			postData.requestType = 'createNewPost';
			postData.tags = jsonTags;
			postData.threadId = String(threadId);
			postData.desc = String(desc);
			$.ajax({
				type: "POST",
				url: "postsRepository.php",
				async: false,
//				data: { requestType: "createNewPost", postText: String(desc), threadId:String(threadId) },
				data: postData,

			}).done(function(data){
				var response = jQuery.parseJSON(data);
				if(response!=true) {
					alert("There was an error creating a new post!\nPlease check the console logs for more details");
				}
				console.log(response);
				$("#newPostCloseButton").click();
				window.location = 'posts.php?threadId='+threadId+'&catId='+catId;
			});
			
			}
			});
		
		
		
		//delete posts
		$(".deleteLink").live('click',function(event){
			event.preventDefault();
			
			//get the post id
			var postId  = $(this).closest('.tableRow').attr('postId');
			$.ajax({
				type: "POST",
				url: "postsRepository.php",
				async: false,
				data: { requestType: "deletePostInThread", postId: String(postId)},
			}).done(function(data){
					var response = jQuery.parseJSON(data);
					console.log(response);
					if(response!=true) {
						alert("Permission denied to delete the post");
					}
					window.location = 'posts.php?threadId='+threadId+'&catId='+catId;
				});
			
		});
		
		$(".editLink").live('click',function(event){
			event.preventDefault();
			
			var index; 
			//When user clicks on a edit of a post
			$postContent = $(this).closest('.inner_table').find('.post_content_div');
			if($postContent.val().indexOf('[endPost]')>-1) {
				index = $postContent.val().lastIndexOf('[endPost]')+9;
			} else {
				index = 0;
			}
			$postContent.html("<div class=\"replyToPost well\">" +
					"<textarea class=\"span10\" rows=\"3\" placeholder=\"Edit Post\" id=\"editPostContent\" data-spy=\"scroll\">"+
					$postContent.val().slice(index)+"</textarea>"+
					"<br>" +
					"<a href=\"\" id=\"editSaveButton\" class=\"btn pull-right\"><i class=\"icon-ok\"></i></a>" +
					"<a href=\"\" id=\"editCancelButton\" class=\"btn pull-right\"><i class=\"icon-remove\"></i></a>" +
					"</div");
			$postContent.attr('prevReplyText',$postContent.val().slice(0,index));
			$(this).closest('.inner_table').find('.replyRow').html("");
			
		});
		
		$('#editCancelButton').live('click',function(event){
			event.preventDefault();
			$(this).closest('.inner_table').find('.replyRow').html("<td><a href=\"\" class=\"btn replyLink\" >Reply</a></td>");
			$postContent = $(this).closest('.inner_table').find('.post_content_div');
			var postContent = $postContent.val();
			if(postContent.indexOf('[Post]') > -1) {
				postContent = convertPostToTable(postContent,1);
			}
			$postContent.html(postContent);
		});
		
		$('#editSaveButton').live('click',function(event){
			event.preventDefault();
			var $parentPostRow = $(this).closest('.inner_table');
			existingReplyText = $parentPostRow.find('.post_content_div').attr('prevReplyText');
			postText = existingReplyText + $(this).parent().find("#editPostContent").val();
			//get the post id for the post which you are editing
			var editPostContent= $(this).parent().find("#editPostContent").val();
			var isvalid = false;
			isvalid = ((editPostContent.length>0)?true:false);
						
			if(!isvalid)
			{
				console.log("ERROR in Edit");
				
				$("#errorAlert").html("<i class=' icon-warning-sign'></i> Please enter some text");
				$("#errorAlert").fadeIn('fast');
				$("#errorAlert").fadeOut(3000);
				return;
			}
			else
			{
			
			var postId  = $(this).closest('.tableRow').attr('postId');
			$.ajax({
				type: "POST",
				url: "postsRepository.php",
				async: false,
				data: { requestType: "editPost", postText: String(postText),
					postId: String(postId) },
			}).done(function(data){
					var response = jQuery.parseJSON(data);
					if(response!=true) {
						alert("There was an error editing the Post!\nPlease check the console logs for more details");
					}
					console.log(response);
					window.location = 'posts.php?threadId='+threadId+'&catId='+catId;
				});
			}
		});

		$('.catLink').live('click',function(event){
			event.preventDefault();
			//get the cat id, for the link which is clicked
			var catId  = $(this).attr('catId');
			console.log("Clicked thread : "+catId);
			window.location = 'threads.php?catId='+catId;
		});
		
		$('.homeLink').live('click',function(event){
			event.preventDefault();
			//get the thread id, for the link which is clicked
			console.log("Clicked home : ");
			window.location = 'categories.php';
		});
		
 
		/* increment vote for posts*/
		$(".plus_button").live('click',function(event){
			//increment vote
			$(this).removeAttr('href');
			event.preventDefault();
			var postId  = $(this).closest('.tableRow').attr('postId');
			
			//var postId  = $(this).parentsUntil('.tableRow').parent().attr('postId');
			console.log("Incrementing vote for .."+postId);
			var prev_count = parseInt($(this).siblings(".mybadge").html());
			$(this).siblings(".mybadge").html(String(prev_count+1));
			//update database
		
			$.post('postsRepository.php',{requestType: 'incrementVoteForPosts',postId: postId},function(response){
				console.log("Done");
				var status = jQuery.parseJSON(response);
				console.log(status);
				if(status == true)
				{
				}
				
			});

			
			$(this).attr('href','');
			return false;

		});
		
		
		/* decrement vote for posts*/
		$(".minus_button").live('click',function(event){
			//increment vote
			event.preventDefault();
			var postId  = $(this).closest('.tableRow').attr('postId');
			//var threadId = $(this).parentsUntil('.tableRow').parent().attr('threadid');
			console.log("Decrementing vote for .."+postId);
			var prev_count = parseInt($(this).siblings(".mybadge").html());
			$(this).siblings(".mybadge").html(String(prev_count-1));
			//store in the database 

			$.post('postsRepository.php',{requestType: 'decrementVoteForPosts',postId: postId},function(response){
				console.log("Done");
				var status = jQuery.parseJSON(response);
				console.log(status);
				if(status == true)
				{
				}
				
			});
			
			
			
			return false;
			//deactivate the button
		});

		$("#tagOption").change(function(){
			 var tagName = $('#tagOption option:selected').val();
			 console.log(tagName);
			 var tagsList = $('#tagsList').val();
			 if(tagsList== null || tagsList=='')
				 $("#tagsList").val(tagName);
			else
				$("#tagsList").val(tagsList+','+tagName);
			// var grpId = parseInt($('#groupsOption option:selected').attr('grpid'));
			// var grpcreator = $('#groupsOption option:selected').attr('creator');
			
		});
		function getTagsForPosts()
		{
			$.ajax({
				type: "POST",
				url: "postsRepository.php",
				async: false,
				data: {requestType: 'getAllTags'},
			}).done(function(response)
			{
				if(response)
				{
					var data = jQuery.parseJSON(response);
					if(data!=false)
					{
						$("#tagOption").show();
						$refOption = $("#tagOption").find("#refTagOption");
						$($refOption).siblings().detach();
						for(var index=0; index < data.length; index++)
						{
							var tag = data[index];
							$newOpt = $($refOption).clone();
							$($newOpt).removeAttr('id');
							$($newOpt).html(tag.keyword);
							$($newOpt).attr('tagid',tag.tagid);
							$($newOpt).insertAfter($refOption);
						}
						console.log(data);
							
					}
					else
					{
						//hide the select option
						 $("#tagOption").hide();
					}
				}
					
			});
			
		}
		getTagsForPosts();
		
		/*Sorting posts*/
		$(".sort_attr").live('click',function(event){
			event.preventDefault();
			
			var postData =new Object();
			postData.attribute = $(this).attr('sort_key');
			postData.order = ($(this).attr('currOrder')=='ASC')?'DESC':'ASC';
			$(this).attr('currOrder',postData.order);
			console.log(postData.order);
			console.log(postData.attribute);
			postData.threadId = String(threadId);
			postData.requestType = 'sortByAttributeAndOrder';			
			$.ajax({
				type: "POST",
				url: "postsRepository.php",
				async: false,
				data: postData,
			}).done(function(response){		
				var list = jQuery.parseJSON(response);
				$("#ref").siblings().detach();
				layoutRows(list);
			});
			
			
		});
		
		// Search for posts
		
		$("#postSearch").live('click', function(event) {

			event.preventDefault();
			performSearch();			
			
		});

		$('#postSearchText').live('keyup',function(e){
			e.preventDefault();
			if(e.keyCode == 13)
			{
				e.preventDefault();
				performSearch();
			}
		});
		
		$("#advancedSearch").live('click', function(event) {

			event.preventDefault();
			performSearch();
			
		});
		
		
		function performSearch() {
			var searchRequest =new Object();
			searchRequest.text = $("#postSearchText").val();
			searchRequest.threadId = String(threadId);
			searchRequest.catId = String(catId);
			if($("#keyword_filter").val()!="") {
				searchRequest.text = $("#keyword_filter").val();
			}
			searchRequest.user = $("#user_filter").val();
			searchRequest.tag = $("#tag_filter").val();
			$.ajax({
				type: "POST",
				url: "searchRepository.php",
				async: false,
				data: {searchRequest : searchRequest, requestType : 'searchPosts'}
			}).done(function(response){		
				var list = jQuery.parseJSON(response);
				$("#search_result_info").show();
				$('#keyword_filter').val('');
				$('#user_filter').val('');
				$('#tag_filter').val('');
				$("#postSearchText").val('');
				$("#ref").siblings().detach();				
				layoutRows(list);				
			});
			
		}
		
		$("#search_result_info").live('click',function(event){
			event.preventDefault();
			$("#search_result_info").hide();
			$("#postSearchText").val('');
			$.ajax({
				type: "POST",
				url: "postsRepository.php",
				async: false,
				data: { requestType: "getPostsForThread", threadId: String(threadId) },
			}).done(function(response){
				var list = jQuery.parseJSON(response);
				$("#ref").siblings().detach();
				layoutRows(list);			
			});
		});
		
		function layoutRows(list) {
			jQuery.each(list, function() {
				var cell = $("#ref").clone();
				$(cell).removeAttr('id');
				$(cell).show();
				$(cell).attr('postId',String(this.postid));
				var x=$(cell).find(".mybadge").html(this.votes);
				console.log("mybadge:::"+x);
				$(cell).find('.posted_date_val').html(this.dateposted);
				if(this.createdby != $("#loggedUser").attr('userid')) {
					$.post('helpers.php',{requestType: 'getUserInfoFromUserId',userId: String(this.createdby)},
					function(response){
						var user = jQuery.parseJSON(response);
						console.log(user);
						$(cell).find('.posted_by_val').html(user.username);
					});
				} else {
					$(cell).find('.posted_by_val').html($("#loggedUser").attr('username'));
				}
				$(cell).find('.post_content_div').attr("value",this.text);
				if(this.text.indexOf('[Post]') > -1) {
					this.text = convertPostToTable(this.text,1);
				}
				$(cell).find('.post_content_div').html(this.text);console.log(this.tags.length);
				if(this.tags.length>0)
				{
					console.log("Hello");
					for(var j=0 ; j<this.tags.length; j++)
					{
						var tag  =this.tags[j];
						v = $(cell).find("#reftag").clone();
						$(cell).find("#reftag").hide();
						$(v).removeAttr('id');
						$(v).show();
						$(v).html(tag);
						$(cell).find('.tagContainer').append(v);
					}
				}
				else
				{
					$(cell).find('.tagsRow').hide();
				}
				$(cell).insertAfter("#ref");
				
			});
			$("#reftag").hide();
			$("#ref").hide();			
		}
});
