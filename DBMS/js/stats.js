$("document").ready(
	function()
	{
		
		 $("#refCategory").hide();
     $("#refPost").hide();
     $("#refThreadView").hide();
     $("#refThreadVote").hide();
     $("#refUser").hide();
		 $("#right_bar_ref_listItem").hide();
		//Get logged in userinfo
		
		$.ajax({
			type: "POST",
			url: "helpers.php",
			async: true,
			data: {requestType:'getLoggedInUserInfo'},
		}).done(function(response){
		
			var userInfo = jQuery.parseJSON(response);
			console.log(userInfo);
			if(userInfo==false)
			{
				$(".logoutLink").click();
			}
			else
			{
				//set username
				$("#loggedUser").html(userInfo.username);
				$("#loggedUser").attr('userType',userInfo.userType);
				$("#loggedUser").attr('userid',userInfo.userid);
				$("#loggedUser").attr('username',userInfo.username);
			}
		});
    
		//onload get top categories
		$.ajax({
			type: "GET",
			url: "statsRepository.php",
			async: true,
			data: { eventType: "getTopCategories" },
		}).done(function(data){
			var categories = jQuery.parseJSON(data);
			//categories.sort(cfunc );
			layoutRows(categories);
			$("#categoryLoadingIndicator").hide();
		});
    
    //onload get top posts
		$.ajax({
			type: "GET",
			url: "statsRepository.php",
			async: true,
			data: { eventType: "getTopPosts" },
		}).done(function(data){
      var posts = jQuery.parseJSON(data);
			//console.log(posts);
		});
    
    //onload get top threads by vote
		$.ajax({
			type: "GET",
			url: "statsRepository.php",
			async: true,
			data: { eventType: "getTopThreadsByView" },
		}).done(function(data){
      var threads = jQuery.parseJSON(data);
			console.log(threads);
      layoutThreadViewRows(threads);
      $("#threadViewLoadingIndicator").hide();
		});
    
    //onload get top threads by vote
		$.ajax({
			type: "GET",
			url: "statsRepository.php",
			async: true,
			data: { eventType: "getTopThreadsByVote" },
		}).done(function(data){
      var threads = jQuery.parseJSON(data);
			console.log(threads);
      layoutThreadVoteRows(threads);
      $("#threadVoteLoadingIndicator").hide();
		});
    
    //onload get top users
		$.ajax({
			type: "GET",
			url: "statsRepository.php",
			async: true,
			data: { eventType: "getTopUsers" },
		}).done(function(data){
      var users = jQuery.parseJSON(data);
      console.log('Top Users:');
			console.log(users);
      layoutUserRows(users);
      $("#userLoadingIndicator").hide();
		});
		
		$('.dropdown-toggle').dropdown(); 
		$('[rel=tooltip]').tooltip(); 
		$("#blob").popover({ html : true}); 

		//When user clicks on a category
		$('.catLink').live('click',function(event){
			event.preventDefault();
			//get the category id, for the link which is click
			var catid  = $(this).parent().attr('categoryId');
			console.log("Clicked category : "+catid);
			window.location = 'threads.php?catId='+catid;
		});
		
    //When user clicks on a thread
		$('.threadLink').live('click',function(event){
			event.preventDefault();
			//get the category id, for the link which is click
			var catid  = $(this).parent().attr('categoryId');
      var threadid = $(this).parent().attr('threadId');
			window.location = 'posts.php?threadId='+threadid+'&catId='+catid;
		});
    
		function layoutRows(categories)	
		{
			console.log(categories);
			for(var index in categories)
			{
				var cat = categories[index];
				var cell = $("#refCategory").clone();
				var cc = cell[0];
				$(cc).removeAttr('id');
				$(cc).attr('id','cat:'+String(cat.categoryid));
				$(cc).find(".catName").children().html(cat.Category);
				$(cc).find(".catName").attr('categoryId',String(cat.categoryid));
				$(cc).find('.catThreadsCount').html(cat.num+(parseInt(cat.num)>1?" threads":" thread"));
				$(cc).find('.createdBySpan').html(cat.creator.username);
				$(cc).show();
				$(cc).insertAfter('#refCategory');
			}
		}
    
    function layoutThreadViewRows(threads) {
			console.log(threads);
			for(var index in threads)
			{
				var thread = threads[index];
				var cell = $("#refThreadView").clone();
				var cc = cell[0];
				$(cc).removeAttr('id');
				$(cc).attr('id','thread:'+String(thread.threadid));
				$(cc).find(".threadName").children().html(thread.title);
        $(cc).find(".threadName").attr('categoryId',String(thread.categoryid));
				$(cc).find(".threadName").attr('threadId',String(thread.threadid));
				$(cc).find('.threadVoteCount').html(thread.num+(parseInt(thread.num)>1?" views":" view"));
				$(cc).find('.createdBySpan').html(thread.creator.username);
				$(cc).show();
				$(cc).insertAfter('#refThreadView');
			}
		}
    
    function layoutThreadVoteRows(threads) {
			console.log(threads);
			for(var index in threads)
			{
				var thread = threads[index];
				var cell = $("#refThreadVote").clone();
				var cc = cell[0];
				$(cc).removeAttr('id');
				$(cc).attr('id','thread:'+String(thread.threadid));
				$(cc).find(".threadName").children().html(thread.title);
        $(cc).find(".threadName").attr('categoryId',String(thread.categoryid));
				$(cc).find(".threadName").attr('threadId',String(thread.threadid));
				$(cc).find('.threadVoteCount').html(thread.num+(parseInt(thread.num)>1?" votes":" vote"));
				$(cc).find('.createdBySpan').html(thread.creator.username);
				$(cc).show();
				$(cc).insertAfter('#refThreadVote');
			}
		}
    
    function layoutUserRows(users) {
			console.log(users);
			for(var index in users)
			{
				var user = users[index];
				var cell = $("#refUser").clone();
				var cc = cell[0];
        $(cc).find(".userLoginName").html(user.username);
				$(cc).find(".userName").html(user.firstname + ' ' + user.lastname);
				$(cc).find('.userPostCount').html(user.num+(parseInt(user.num)>1?" posts":" post"));
				$(cc).show();
				$(cc).insertAfter('#refUser');
			}
		}
	}
);