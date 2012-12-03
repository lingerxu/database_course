$("document").ready(
	function()
	{
		
		var allCategories;
		var allCategoriesForSideBar;
		
		 $("#ref").hide();
		 $("#right_bar_ref_listItem").hide();
		 $("#search_result_info").hide();
		//Get logged in userinfo
		
		$.ajax({
			type: "POST",
			url: "helpers.php",
			async: false,
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
				
				
				//depending on usertype show/hide create and delete category button
				var userType =parseInt(userInfo.userType);
				if(userType != 0)
				{
					$("#ref").find(".delLink").hide();
					$("#create-category-link").hide();
				}
				else
				{
					$("#ref").find(".delLink").show();
					$("#create-category-link").show();
				}
				
			}
			
		});
		
		
		$(".delLink").css('opacity',0);
		$(".delLink").removeAttr('href');
		
		$('.cellSkeleton').live('mouseover mouseout', function(event) {
			if (event.type == 'mouseover') 
			{
				$(this).find('.delLink').css('opacity',1);
				$(this).find('.delLink').attr('href',"");
				
			} 
			else 
			{
				$(this).find(".delLink").css('opacity',0);
				$(this).find(".delLink").removeAttr('href');

			}
		});
		
		

		
		// Delete category
		$(".delLink").live('click',function(event){
			event.preventDefault();
			console.log($(this).parent().siblings('td[categoryid]'));
			var catId = $(this).parent().siblings('td[categoryid]').attr('categoryid');
			console.log(catId);
			
			$.ajax({
				type: "POST",
				url: "categoriesRepository.php",
				async: false,
				data: {eventType: "deleteCategory", categoryId: catId},
			}).done(function(response){
				$("#ref").siblings().detach();
				var result = jQuery.parseJSON(response);
				var delRsesult = result.deleteResult;
				var categories = result.list;
				console.log(categories);
				
				if(delRsesult<1)
				{
					//delete failed
					$(".alert").hide();
					$("#errorAlert").html("<i class=' icon-ok'></i> &nbsp; Error in deletion");
					$("#errorAlert").fadeIn('fast');
					$("#errorAlert").fadeOut(4000);
					
				}
				else
				{
					if(categories==null || categories.length<1)
					{
						//all categories deleted
						$(".alert").hide();
						$("#infoAlert").html("<i class=' icon-ok'></i> &nbsp; All categories added");
						$("#infoAlert").fadeIn('fast');
						$("#infoAlert").fadeOut(4000);
						
					}
					else if(categories.length>0)
					{
						//some cateogries are there
						$(".alert").hide();
						$("#successAlert").html("<i class=' icon-ok'></i> &nbsp; Category deleted");
						$("#successAlert").fadeIn('fast');
						$("#successAlert").fadeOut(4000);
						
						
					}
				}
				
				if(categories!=null && categories.length>0)
				{
					$("#ref").siblings().detach();
					allCategories = categories;
					layoutRows(categories);
				}
			});
		});
		
		
		
		// //onload get all categories
		// $.ajax({
		// 	type: "POST",
		// 	url: "categoriesRepository.php",
		// 	async: false,
		// 	data: { eventType: "getAllCategories" },
		// }).done(function(data){
		// 	var categories = jQuery.parseJSON(data);
		// 	//categories.sort(cfunc );
		// 	
		// 	allCategories = categories;
		// 	layoutRows(categories);
		// 	
		// });
		
		onLoadGetAllCategories();
		
		$('.dropdown-toggle').dropdown(); 
		$('[rel=tooltip]').tooltip(); 
		$("#blob").popover({ html : true}); 

		

		$("#searchFilter").click(function(event){
			console.log("Opening search filter");
			$('#example').popover();
		});
		
		
		
		$("#create-category-link").live('click',function(event){
			$("#catName").val('');
		});
		
		// Create new category
		$("#newCatSave").click(function(){
			$("#newCatAlert").hide();
			
			var catName = $("#catName").val();
			var user = $("#loggedUser").attr('userid');

			
			if(catName!=null)
			{
				if(catName.length<1)
				{
					$("#newCatAlert").show();
					$("#newCatAlert").fadeIn('fast');
					$("#newCatAlert").fadeOut(3000);
					
				}
				else
				{
					$("#newCatAlert").hide();
					$("#cancelNewCat").click();
					
					$.ajax({
						type: "POST",
						url: "categoriesRepository.php",
						async: false,
						data: {eventType: 'createNewCategory',kName: String(catName), userid:user },
					}).done(function(response){
						// $("#ref").show();
						$("#ref").siblings().detach();
						$(".alert").hide();
						$("#successAlert").html("<i class=' icon-ok'></i> &nbsp; Category added");
						$("#successAlert").fadeIn('fast');
						$("#successAlert").fadeOut(4000);
						var categories = jQuery.parseJSON(response);
						console.log(categories);
						allCategories = categories;
						layoutRows(categories);
				
					});
					
					
				}
			}
			
		});
		
		
		
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
			$("#ref").siblings().detach();
			for(var index in categories)
			{
				var cat = categories[index];
				var cell = $("#ref").clone();
				var cc = cell[0];
				$(cc).removeAttr('id');
				$(cc).attr('id','cat:'+String(cat.categoryid));
				$(cc).find(".catName").children().html(cat.Category);
				$(cc).find(".catName").attr('categoryId',String(cat.categoryid));
				$(cc).find(".delLink").attr('href','');
				$(cc).find('.catThreadsCount').html(cat.num+(parseInt(cat.num>1)?" threads":" thread"));
				$(cc).find('.createdBySpan').html(cat.creator.username);
				$(cc).show();
				$(cc).insertAfter('#ref');
				
				
			}
			populateRightSideBar(categories.slice());
			
			
			
			
			 // $("#ref").hide();
			
			
		}
		
		
		function onLoadGetAllCategories()
		{
			$.ajax({
				type: "POST",
				url: "categoriesRepository.php",
				async: false,
				data: { eventType: "getAllCategories" },
			}).done(function(data){
				var categories = jQuery.parseJSON(data);
				//categories.sort(cfunc );
			
				allCategories = categories;
				layoutRows(categories);
			
			});
			
		}
		
		
		var sortByNumberOfThreadAsc = function compare(obj1,obj2)
		{
			val1 = parseInt(obj1.num);
			val2 = parseInt(obj2.num);
			if(val1<val2)
			return -1;
			if(val1>val2)
			return 1;
			return 0;
				
		}
		
		var sortByNumberOfThreadDesc = function compare(obj1,obj2)
		{
			val1 = parseInt(obj1.num);
			val2 = parseInt(obj2.num);
			if(val1>val2)
			return -1;
			if(val1<val2)
			return 1;
			return 0;
			
				
		}
		
		
		
		
		var sortByCreatorAsc = function compareCreator(obj1,obj2)
		{
			var username1 = obj1.creator.username.toLowerCase();
			var username2 = obj2.creator.username.toLowerCase();
			if(username1<username2)
				return -1;
			if(username1>username2)
				return 1;
			return 0;
			
			
		}
		
		
		var sortByCreatorDesc = function compareCreator(obj1,obj2)
		{
			var username1 = obj1.creator.username.toLowerCase();
			var username2 = obj2.creator.username.toLowerCase();
			if(username1>username2)
				return -1;
			if(username1<username2)
				return 1;
			return 0;
			
			
		}
		
		
		var sortByTitleAsc = function compareTitleAsc(obj1,obj2)
		{
			var title1 = obj1.Category.toLowerCase();
			var title2 = obj2.Category.toLowerCase();
			console.log('Working ASC');
			if(title1<title2)
			return -1;
			if(title1>title2)
			return 1;
			return 0;
			
			
		}
		var sortByTitleDesc = function compareTitleDesc(obj1,obj2)
		{
			var title1 = obj1.Category.toLowerCase();
			var title2 = obj2.Category.toLowerCase();
			console.log('Working ASC');
			if(title1>title2)
			return -1;
			if(title1<title2)
			return 1;
			return 0;
			
			
		}
		
		
		
		
		$(".sort_attr").live('click',function(event){
			event.preventDefault();
			
			var postData =new Object();
			postData.attribute = $(this).attr('sort_key');
			postData.order = ($(this).attr('currOrder')=='ASC')?'DESC':'ASC';
			$(this).attr('currOrder',postData.order);
			console.log(postData);
			
			
			if(postData.order=='DESC')
			{
				switch(postData.attribute)
				{
					case 'Category':
					allCategories.sort(sortByTitleDesc);
					break;
				
					case 'creator':
					allCategories.sort(sortByCreatorDesc);				
					break;
				
					case 'threads_count':
					allCategories.sort(sortByNumberOfThreadDesc);								
					break;
				}
				
				
			}
			else if(postData.order=='ASC')
			{
				switch(postData.attribute)
				{
					case 'Category':
					allCategories.sort(sortByTitleAsc);
					break;
				
					case 'creator':
					allCategories.sort(sortByCreatorAsc);				
					break;
				
					case 'threads_count':
					allCategories.sort(sortByNumberOfThreadAsc);								
					break;
				}
				
			}
			
			layoutRows(allCategories);
			
			
			
			
		});
		
		
		
		
		// Populating side bar with top categories
		
		
		
		function populateRightSideBar(kCategoriesList)
		{
			 layoutRightSideBar();
		}
		
		
		
		
		function layoutRightSideBar()
		{
			
			$.ajax({
				type: "POST",
				url: "categoriesRepository.php",
				async: true,
				data: { eventType: "getAllCategories" },
			}).done(function(data){
				var categories = jQuery.parseJSON(data);
				categories.sort(sortByNumberOfThreadAsc);								
				$("#right_bar_ref_listItem").siblings().detach();
				for(var i=0;i<categories.length;i++)
				{
					var cat = categories[i];
					console.log(cat);
					$cell = $("#right_bar_ref_listItem").clone();
					$($cell).show();
					$($cell).find(".right_bar_nav_link").html(cat.Category);
					$($cell).find(".right_bar_nav_link").attr('target-row','cat:'+cat.categoryid);
					$($cell).find(".right_bar_nav_link").attr('href','#cat:'+cat.categoryid);
					$($cell).find(".right_bar_nav_link").removeAttr('id');
					$cell.insertAfter("#right_bar_ref_listItem");
				
				}
				
				
			
			});
			
			
		}
		
		
		
		/* Search related fuctionalities*/
		
		
		$("#catSearch").live('click',function(event)
		{
			event.preventDefault();
			
			//check if keyword is valid
			var searchKey = $("#searchText").val();
			
			
			if(searchKey.length>0)
			{
				//setup post parameters
				var params = new Object();
				params.eventType = 'basicSearchForKey';
				params.key = searchKey;
				
				//do search
				$.ajax({
					type: "POST",
					url: "categoriesRepository.php",
					async: false,
					data: params,
				}).done(function(data){
					
					if(data)
					{
						var categories = jQuery.parseJSON(data);
						if(categories.length>0)
						{
							$("#search_result_info").show();
							allCategories = categories;
							layoutRows(categories);
						}
					}
			
				});
				
				
			}
			
		
		});
		
		
		/* Clear search Results*/
		$("#search_result_info").live('click',function(event){
			event.preventDefault();
			$("#search_result_info").hide();
			onLoadGetAllCategories();
		});
		
		
		
		/* Advanced category search*/
		$("#catAdvancedSearch").live('click',function(event){
			event.preventDefault();
			
			//get values in search filters
			
			var userkey = $("#user_filter").val();
			var keyword = $("#keyword_filter").val();
			
			if(userkey.length>0 || keyword.length>0)
			//either of the filter values are entered
			{
				
				
				var params = new Object();
				params.eventType = 'advanceSearchForAttributes';
				params.key = keyword;
				params.creator = userkey
				
				//do search
				$.ajax({
					type: "POST",
					url: "categoriesRepository.php",
					async: false,
					data: params,
				}).done(function(data){
					
					if(data)
					{
						var categories = jQuery.parseJSON(data);
						if(categories.length>0)
						{
							$("#search_result_info").show();
							allCategories = categories;
							layoutRows(categories);
						}
					}
				});
				
				$("#catAdvancedSearchCancelButton").click();
				
			}
		});
		
		
		

	}
);