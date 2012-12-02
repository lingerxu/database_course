$("document").ready(
	function()
	{
		
		 $("#refCategory").hide();
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
			
		});
    
    //onload get top posts
		$.ajax({
			type: "GET",
			url: "statsRepository.php",
			async: true,
			data: { eventType: "getTopPosts" },
		}).done(function(data){
      var posts = jQuery.parseJSON(data);
			console.log(posts);
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
				$(cc).find('.catThreadsCount').html(cat.num+(parseInt(cat.num>1)?" threads":" thread"));
				$(cc).find('.createdBySpan').html(cat.creator.username);
				$(cc).show();
				$(cc).insertAfter('#refCategory');
			}
		}
	}
);