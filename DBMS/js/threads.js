$("document").ready(
	function()
	{
		
	 $("#right_bar_ref_listItem").hide();
						$("#NewThreadErrorMsg").hide();

		var allThreads;
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
				//force logout
				$(".logoutLink").click();
			}
			else
			{
				//set username
				$("#loggedUser").html(userInfo.username);
				$("#loggedUser").attr('userType',userInfo.userType);
				$("#loggedUser").attr('userid',userInfo.userid);
				$("#loggedUser").attr('username',userInfo.username);
				
				
				//depending on usertype show/hide create and delete thread button
				var userType =parseInt(userInfo.userType);
				if(userType != 0 && userType!= 1)
				{
					$(".deleteLink").hide();
					$("#new-thread-link").show();
				}
				else
				{
					$(".deleteLink").show();
					$("#new-thread-link").show();
				}
				
				//show notifications to admins only
				if(userType==0)
				{
					$("#new-notifications-button").show();
				}
				else
				{
					$("#new-notifications-button").hide();
				}
				
				
			}
			
		});
		
		
		
		$(".deleteLink").removeAttr('href');
		$(".deleteLink").css('opacity',0);
		
		
		
		$('.inner_table').live('mouseover mouseout', function(event) {
			if (event.type == 'mouseover') 
			{
				$(this).find(".deleteLink").attr('href',"");
				$(this).find(".deleteLink").css('opacity',1);
				
			} 
			else 
			{
				$(".deleteLink").removeAttr('href');
				$(".deleteLink").css('opacity',0);

			}
		});
		
		
		
		
		$('.status-link').live('mouseover mouseout', function(event) {
			
			var orignalText = $(this).html();
			if (event.type == 'mouseover') 
			{
				$(this).css('font-weight','bold');
				if(orignalText == 'open')
				{
						$(this).html('close thread');
				}
				else if(orignalText == 'closed')
				{
						$(this).html('open thread');					
				}
				
			} 
			else 
			{
				$(this).css('font-weight','normal');
				if(orignalText == 'close thread')
				{
						$(this).html('open');
				}
				else if(orignalText == 'open thread')
				{
						$(this).html('closed');					
				}

			}
		});
		
		//set thread as open or closed
		$('.status-link').live('click', function(event) {
			event.preventDefault();
			var threadId = $(this).parentsUntil('.tableRow').parent().attr('threadid');
			var catId = $("#CategoryName").attr('catId');
			var postData = new Object();
			postData.threadId = threadId;
			postData.requestType = 'setThreadStatus';
			if($(this).html()=='close thread')
			{
				//close the thread
				postData.status='closed';
				console.log('closing '+threadId);
			}
			else if($(this).html()=='open thread')
			{
				//open thread
				postData.status='open';
				console.log('opening '+threadId);
			}
			
			$.ajax({
				type: "POST",
				url: "threadsRepository.php",
				async: false,
				data: postData,
				context: this,
			}).done(function(response){
				var res = jQuery.parseJSON(response);
				if(res.updateResult == true)
				{
					$(this).html(res.status);
					
					//make changes in the array
					for(var i=0; i<allThreads.length;i++)
					{
						if(allThreads[i].threadid == threadId)
							allThreads[i].status = res.status;
					}
					
				}
				else
				{
					
				}
			});
		
			
			
			
			
			
		});


		$('.dropdown-toggle').dropdown(); 
		$('[rel   = tooltip]').tooltip(); 

		$(".delete_button_cell").click(function(){
			//			$(this).parent(".tableRow").hide();			
			$(this).parentsUntil(".tableRow").hide();			
		});




		$("#searchFilter").click(function(event){
			console.log("Opening search filter");
			$('#example').popover();
		});
		
		
		/*------------Get groups for current user-------------*/
		getGroupsForCurrentUser();
		
		getTagsForThreads();
		
		
		/*---------------------------------------get url components---------------------------*/
		var params = location.search;
		console.log(params);
		var components = String(params).split("=");
		var param_name = components[0].slice(1);
		var param_val = components[1];
		console.log(param_val+" <> "+param_name);
		
		
		/*---------------------------------------get Parent category info---------------------------*/
		$.post("threadsRepository.php",{requestType: 'getParentCategoryInfo', catId: String(param_val)},
		function(response){
			var json = jQuery.parseJSON(response);
			console.log(json);
			$("#CategoryName").html(String(json.Category));
			$("#CategoryName").attr("catId",String(json.categoryid));
		});
		
		
		/*---------------------------------------Get all threads in category---------------------------*/
		$.ajax({
			type: "POST",
			url: "threadsRepository.php",
			async: false,
			data: {requestType: 'getThreadsForCategory',catId: String(param_val)},
		}).done(function(response){
		
			var list = jQuery.parseJSON(response);
			console.log(list);
			 allThreads = list;
			layoutRows(list);
			
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
		
		
		// --- clear pop up contents before showing popup
		$("#new-thread-link").live('click',function(){
			
			newThreadTitle
			newThreadDesc
			tagOption
			refOption
			tagsList
			$("#newThreadTitle").val('');
			$("#newThreadDesc").val('');
			$("#newThreadDesc").val('');
			$('#tagsList').val('');
			$("#tagOption").val('0');
			$("#refOption").val('0');
			$("#groupsOption").val('0');
		});
		
		/*---------------------------------------Create new thread---------------------------*/
		
		$("#newThreadSaveButton").click(function(event){
			event.preventDefault();
			
			var title = $("#newThreadTitle").val();
			var desc = $("#newThreadDesc").val();
			var catId = $("#CategoryName").attr('catId');
			var tagsList = $('#tagsList').val();
			var allTags =tagsList.split(','); 
			var jsonTags = JSON.stringify(allTags);
			var grpName = $('#groupsOption option:selected').val(); 
			var grpId = parseInt($('#groupsOption option:selected').attr('grpid'));
			var grpcreator = $('#groupsOption option:selected').attr('creator');
			console.log(jsonTags);
			console.log("Creating new thread title "+ title + " desc: "+ desc + "for cat "+catId);
			
			var isvalid = false;
			
			
			isvalid = (title.length > 0)?true:false;
			isvalid = ((desc.length>0)?true:false)&isvalid;
			
			
			if(!isvalid)
			{
				
				$(".alert").hide();
				$("#NewThreadErrorMsg").html("Enter title and description for new Thread");
				$("#NewThreadErrorMsg").fadeIn('fast');
				$("#NewThreadErrorMsg").fadeOut(3000);
				
			}
			else
			{
				
				var postData = new Object();
				postData.requestType = 'createNewThreadForCategory';
				postData.tags = jsonTags;
				postData.catId = String(catId);
				postData.title = String(title);
				postData.desc = String(desc);
				if(grpId!=-1)
				{
					postData.groupid = grpId;
				}
			
				$.ajax({
					type: "POST",
					url: "threadsRepository.php",
					async: false,
					// data: {requestType: 'createNewThreadForCategory',tags: jsonTags, catId: String(catId), title: String(title), desc: String(desc)},
					data: postData,				
				}).done(function(response)
				{
			
					/* remove all old threads*/
					$("#ref").siblings().detach();
					var list = jQuery.parseJSON(response);
					console.log(list);
					/* show alert on top of the page*/
					if(list.length && list.length>0)
					{
						$(".alert").hide();
						$("#successAlert").html("<i class=' icon-ok'></i> Thread inserted");
						$("#successAlert").fadeIn('fast');
						$("#successAlert").fadeOut(5000);
					
					}
	   			 allThreads = list;
				
					layoutRows(list);
					$("#newThreadCloseButton").click();
				});
				
				
			}
			
			
		});
		
		
		
		/*---------------------------------------Delete thread---------------------------*/
		$(".deleteLink").live('click',function(event){
			event.preventDefault();
			
			//get the thread id and category id of the thread
			var threadId = $(this).parentsUntil('.tableRow').parent().attr('threadid');
			var catId = $("#CategoryName").attr('catId');
			
			
			$.ajax({
				type: "POST",
				url: "threadsRepository.php",
				async: false,
				data: {requestType: 'deleteThreadInCategory',catId: String(catId) ,threadId: String(threadId)},
			}).done(function(response){
				
				
				var result = jQuery.parseJSON(response);
				var deleteResult = result.deleteResult;
				var list = result.threads;
				//error in deletion
				//list size
				if(deleteResult < 1)
				{
					//deletion failed
					$(".alert").hide();
					$("#errorAlert").html("<i class=' icon-warning-sign'></i> Error in deletion");
					$("#errorAlert").fadeIn('fast');
					$("#errorAlert").fadeOut(3000);
					
				}
				else if(deleteResult > 0)
				{
					//delete success 
					if(list.length > 0)
					{
						//all threads not deleted
						$(".alert").hide();
						$("#successAlert").html("<i class=' icon-ok'></i> Thread deleted");
						$("#successAlert").fadeIn('fast');
						$("#successAlert").fadeOut(5000);
						
					}
					else
					{
						//all threads deleted
						$(".alert").hide();
						$("#infoAlert").html("<i class=' icon-warning-sign'></i> All threads deleted");
						$("#infoAlert").fadeIn('fast');
						$("#infoAlert").fadeOut(5000);
						$("#ref").siblings().detach();
						
					}
					
					
				}
				
				if(list.length>0)
				{
					$("#ref").siblings().detach();
					console.log(list);
					 allThreads = list;
					 layoutRows(list);
				}
			});
		});
		
		
		////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		//submit request to create new group
		$("#new-group-link").live('click',function(event){
			$("#myGroupModalContainer").hide();
			$("#myGroupModalContainer").show();
			$("#myGroupModalContainer").css('position','relative');
			$("#myGroupModalContainer").offset({ top: window.pageYOffset, left: 0 });
			$("#myGroupModalContainer").height($("body").height());
			$("#myGroupModalContainer").css('z-index',9999999999999999999999);
			$("#myGroupModalContainer").css('opacity','1.0');
			$("#myGroupModalContainer").css('background-color','black');
			$("#myGroupModalContainer").css('margin-left','auto');
			$("#myGroupModalContainer").css('margin-right','auto');
			$("#myGroupModalContainer").css('display','block');
			$("#myGroupModalContainer").css('text-align','center');
			
			$("body").css("overflow","hidden");
			
			
			var kuserid = $("#loggedUser").attr('userid');
			$.ajax({
				type: "POST",
				url: "helpers.php",
				async: false,
				data: {requestType: 'getAllUsersListForUser',userid: String(kuserid)},
			}).done(function(response){
			
				var respone = jQuery.parseJSON(response);
				if(respone!=false)
				{
					var users = respone;
					console.log(users);
					$("#modalRow").hide();
					$("#modalRow").siblings().detach();
					for(var i=0; i<users.length; i++)
					{
						$row  = $("#modalRow").clone();
						$($row).removeAttr('id');
						$($row).attr('userid',users[i].userid);
						$($row).find('.uname').html(users[i].username);
						$($row).insertAfter("#modalRow");
						$($row).addClass('aabbdd');
						$($row).show();
						console.log($row);
					}
					
				}
			
			});
			//get all usernames
			
		});
		
		
		//dismiss modal for new group request
		$("#cancelGrpReq").click(function(event){
			$("#myGroupModalContainer").hide();
			$("body").css("overflow","auto");
			

		});
		
		
		//submit new group request
		$("#submitGrpReq").click(function(event){
			var $seletedRow = $(this).parentsUntil('table').find('.userSelected');
			var kuserid = $("#loggedUser").attr('userid');
			var grpName = $("#newgroupTitle").val();


			//check if group name is enterd
			if(typeof grpName === undefined || grpName.length <1)
			{
				//alert user and close the pop up
				//show alert
				
				$("div.grpReqAlert").hide();
				$("div.grpReqAlert.error").html("<i class=' icon-warning-sign'></i> please enter group name");
				$("div.grpReqAlert.error").fadeIn('fast');
				$("div.grpReqAlert.error").fadeOut(3000);
				return false;
			}
			//check if some users are selected
			if(typeof $seletedRow === undefined || $seletedRow.length < 1)
			{
				//no members are select close the pop up 
				//show alert
				$("div.grpReqAlert").hide();
				$("div.grpReqAlert.error").html("<i class=' icon-warning-sign'></i> please select members for group");
				$("div.grpReqAlert.error").fadeIn('fast');
				$("div.grpReqAlert.error").fadeOut(3000);
				
				
				return false;
			}


			var myarray = [];
			var myJSON = "";
			$.each($seletedRow,function(index,val){
				var item = {"userid": $(val).attr('userid')};
				myarray.push(item);
				
			});
			myJSON = JSON.stringify({memberslist: myarray});
			console.log(myJSON);
			
			
			//submit request 
			
			$.ajax({
				type: "POST",
				url: "GroupsController.php",
				async: false,
				data: {requestType: 'newGroupRequest',groupName: grpName, requesterId: String(kuserid), groupMembers: myJSON},
			}).done(function(response)
			{
				/*{
				    "duplicateGroup": false,
				    "duplicateRequest": true,
				    "insert": false
				}*/
				if(response)
				{
					var result = jQuery.parseJSON(response);
					if(result.duplicateGroup==true)
					{
						$("div.grpReqAlert").hide();
						$("div.grpReqAlert.error").html("<i class=' icon-warning-sign'></i> Please select different group name,group name already exists");
						$("div.grpReqAlert.error").fadeIn('fast');
						$("div.grpReqAlert.error").fadeOut(3000);
						
						
					}
					else if( result.duplicateRequest == true)
					{
						$("div.grpReqAlert").hide();
						$("div.grpReqAlert.error").html("<i class=' icon-warning-sign'></i> Please select different group name,group name already exists");
						$("div.grpReqAlert.error").fadeIn('fast');
						$("div.grpReqAlert.error").fadeOut(3000);
						
					}
					else if(result.insert == false)
					{
						$("div.grpReqAlert").hide();
						$("div.grpReqAlert.error").html("<i class=' icon-warning-sign'></i> Something went wrong, please try again");
						$("div.grpReqAlert.error").fadeIn('fast');
						$("div.grpReqAlert.error").fadeOut(3000);
						
						
					}
					else if(result.insert == true)
					{
						$("div.grpReqAlert").hide();
						$("div.grpReqAlert.error").html("New group request submitted");
						$("div.grpReqAlert.error").fadeIn('fast');
						$("div.grpReqAlert.error").fadeOut(3000);
						
						
					}
				}
				else
				{
					$("#cancelGrpReq").click();
					
				}
				
				
			});
			
			//directly create group if user is admin
			
			
			
		});
		
		//toggle removal and addition of members in a group while creating new request
		$(".addRemLink").live('click',function(event){
			event.preventDefault();
			$(this).parent().parent().attr('userid');
			$(this).children().toggleClass('icon-plus icon-minus');
			$(this).parent().parent().toggleClass('userRemoved userSelected');
			
			// $(this).parent().parent().toggleClass
		});
		
		
		
		
		
		
		//get pending requests for groups and show it in modal
		$("#new-notifications-button").click(function(event){
			$.ajax({
				type: "POST",
				url: "GroupsController.php",
				async: false,
				data: {requestType: 'getGroupResquests'},
			}).done(function(response)
			{
				var data = jQuery.parseJSON(response);
				if(data!=false && data.length>0)
				{
					$("#grpReqErrorMsg").html("");
					$("#grpReqErrorMsg").hide();
					$("#requestContainer").find("#requestModalBody").show();
					
					$("#requestContainer").find("#refReqRow").hide();
					$("#requestContainer").find("#refReqRow").siblings().detach();
					$refRow = $("#requestContainer").find("#refReqRow");
				
					for(var index=0; index<data.length; index++)
					{
						console.log(data[index]);
						var grpName = data[index].name;
						var requester = data[index].requester.username;
					
						$newRow = $($refRow).clone();
						$($newRow).show();
						$($newRow).removeAttr('id');
						$($newRow).attr('grpname',grpName);
						$($newRow).attr('creatorid',data[index].requester.userid);
						$($newRow).find(".nameCol").html(grpName);
						$($newRow).find(".requesterCol").html(requester);


						var members = data[index].members;
						$membersCol = $($newRow).find(".membersCol");
						$memberRefRow = $($membersCol).find("p");
						$($membersCol).find("p").detach();
						for(var j=0 ; j<members.length ; j++)
						{
							var member = members[j];
							console.log(member.username);
							$newMemRow = $($memberRefRow).clone();
							$($newMemRow).removeAttr('id');
							$($newMemRow).html(member.username);
							$($membersCol).append($newMemRow);
						}
					
					
						$($newRow).insertAfter($refRow);
					}
				
				}
				else
				{
				
					$("#requestContainer").find("#refReqRow").hide();
					$("#requestContainer").find("#requestModalBody").hide();
					$("#grpReqErrorMsg").hide().show();
					
					$("#grpReqErrorMsg").html("No pending requests");
					
				}
				
			});
			
			
			$("#requestContainer").show();
			$("#requestContainer").css('top',window.pageYOffset);
			$("body").css("overflow","hidden");
		});
		
		
		//dismiss modal to see pending group request
		$("#reqModalCancel").click(function(event){
			$("#requestContainer").hide();
			$("body").css("overflow","auto");
			
		});
		
		//approve group request
		$(".groupApproveButton").live('click',function(event){
			event.preventDefault();
			$row = $(this).parentsUntil('tr').parent();
			var grpname = $(this).parentsUntil('tr').parent().attr('grpname');
			var creatorid = $(this).parentsUntil('tr').parent().attr('creatorid');
			console.log(grpname+".........."+creatorid);
			
			//approve the request
			$.ajax({
				type: "POST",
				url: "GroupsController.php",
				async: false,
				data: {requestType: 'approveGroupRequest',groupName: String(grpname),creatorid :String(creatorid)},
			}).done(function(response)
			{
				$($row).detach();
				
				var siblings = $($row).siblings();
				if(siblings.length==0)
				{
					// $("#requestContainer").find("#requestModalBody").hide();
					// $("#grpReqErrorMsg").hide().show();
					// $("#grpReqErrorMsg").html("No pending requests");
					
					
				}
				
				
				//after request is approved refresh the groups lists
				getGroupsForCurrentUser();
			});
					
		});
		
		//reject group request
		$(".groupRejectButton").live('click',function(event){
			event.preventDefault();
			$row = $(this).parentsUntil('tr').parent();
			var grpname = $(this).parentsUntil('tr').parent().attr('grpname');
			var creatorid = $(this).parentsUntil('tr').parent().attr('creatorid');
			console.log(grpname+".........."+creatorid);
			
			//approve the request
			$.ajax({
				type: "POST",
				url: "GroupsController.php",
				async: false,
				data: {requestType: 'rejectGroupRequest',groupName: String(grpname),creatorid :String(creatorid)},
			}).done(function(response)
			{
				var result = jQuery.parseJSON(response);
				if(result.deleteResult == true)
					$($row).detach();
				else
				{
					//show error message
				}
				var siblings = $($row).siblings();
				if(siblings.length==0)
				{
					// $("#requestContainer").find("#requestModalBody").hide();
					// $("#grpReqErrorMsg").hide().show();
					// $("#grpReqErrorMsg").html("No pending requests");
					
					
				}
				
				//after request is approved refresh the groups lists
				getGroupsForCurrentUser();
			});
					
		});
		
		
		
		
		
		
		
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
		/* increment vote for thread*/
		$(".plus_button").live('click',function(event){
			//increment vote
			$(this).removeAttr('href');
			event.preventDefault();
			var threadId = $(this).parentsUntil('.tableRow').parent().attr('threadid');
			console.log("Incrementing vote for .."+threadId);
			var prev_count = parseInt($(this).siblings(".mybadge").html());
			$(this).siblings(".mybadge").html(String(prev_count+1));
			//update database
			$.post('threadsRepository.php',{requestType: 'incrementVoteForThread',threadId: threadId},function(response){
				console.log("Done");
				var status = jQuery.parseJSON(response);
				console.log(status);
				if(status == true)
				{
					console.log(threadId);
					for(var i=0; i<allThreads.length; i++)
					{
						var currThread = allThreads[i];
						if(currThread.threadid == threadId)
						{
							currThread.votes = String(parseInt(currThread.votes)+1);
							allThreads[i]=currThread;
						}	
					}
					layoutRightSideBar();
				}
				
				
			});

			
			$(this).attr('href','');
			return false;

		});
		
		
		/* decrement vote for thread*/
		$(".minus_button").live('click',function(event){
			//increment vote
			event.preventDefault();
			var threadId = $(this).parentsUntil('.tableRow').parent().attr('threadid');
			console.log("Incrementing vote for .."+threadId);
			var prev_count = parseInt($(this).siblings(".mybadge").html());
			$(this).siblings(".mybadge").html(String(prev_count-1));
			//store in the database 
			$.post('threadsRepository.php',{requestType: 'decrementVoteForThread',threadId: threadId},function(response){
				console.log("Done");
				var status = jQuery.parseJSON(response);
				console.log(status);
				if(status == true)
				{
					
					console.log(threadId);
					for(var i=0; i<allThreads.length; i++)
					{
						var currThread = allThreads[i];
						if(currThread.threadid == threadId)
						{
							currThread.votes = String(parseInt(currThread.votes)+1);
							allThreads[i]=currThread;
						}	
					}
				layoutRightSideBar();	
				}
				
			});
			
			
			
			return false;
			//deactivate the button
		});
		
		//When user clicks on a particular thread
		$('.threadLink').live('click',function(event){
			event.preventDefault();
			//get the thread id, for the link which is clicked
			var threadid  = $(this).parent().attr('threadId');
			console.log("Clicked thread : "+threadid);
			
			//increase view count for this thred
			
			$.ajax({
				type: "POST",
				url: "threadsRepository.php",
				async: false,
				data: {requestType: 'incrementViewCountForThread',threadId: threadid},				
			}).done(function(response){
								console.log(response);
			});
			
			window.location = 'posts.php?threadId='+threadid+'&catId='+param_val;
		});
		
		$('.homeLink').live('click',function(event){
			event.preventDefault();
			//get the thread id, for the link which is clicked
			console.log("Clicked home : ");
			window.location = 'categories.php';
		});	
		
		
		function layoutRows(list)
		{
			$("#ref").siblings().detach();
			
			for(var i=0; i<list.length; i++)
			{
				var thread = list[i];
				var cell = $("#ref").clone();
				var createdDate = new Date(thread.datecreated);
				var formattedDate = createdDate.getMonth()+1+"/"+createdDate.getDate()+"/"+createdDate.getFullYear()+"    "+createdDate.toLocaleTimeString();
				
				$(cell).removeAttr('id');
				$(cell).attr('id','thread:'+String(thread.threadid));
				$(cell).attr('threadid',String(thread.threadid));
				$(cell).find('.created_by_val').html(thread.owner.username);
				$(cell).find('.date_creted_val').html(formattedDate);
				$(cell).find(".mybadge").html(thread.votes);
				$(cell).find('.thread_title_div').children().html(thread.title);
				$(cell).find(".thread_title_div").attr('threadId',String(thread.threadid));
				$(cell).find('.thread_content_div').html(thread.description);
				$(cell).find('.views_val').html(thread.views);
				$(cell).find('.posts_val').html(thread.numPost);				
				$(cell).find('.group_val').html((thread.groupid)?thread.groupName:"no group");
				$(cell).find('.status-link').html(thread.status);
				$(cell).show();
				if(thread.tags.length>0)
				{
					for(var j=0 ; j<thread.tags.length; j++)
					{
						var tag  =thread.tags[j];
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
			}
			$("#reftag").hide();
		 layoutRightSideBar();
			
		}
		
		
		
		
		function getGroupsForCurrentUser()
		{
			//get all groups for current user
			$.ajax({
				type: "POST",
				url: "GroupsController.php",
				async: false,
				data: {requestType: 'getGroupsForUser',userId:String($("#loggedUser").attr('userid'))},
			}).done(function(response)
			{
				if(response)
				{
					var data = jQuery.parseJSON(response);
					if(data!=false)
					{
						$("#groupsOption").show();
						$refOption = $("#groupsOption").find("#refOption");
						$($refOption).siblings().detach();
						for(var index=0; index < data.length; index++)
						{
							var grp = data[index];
							$newOpt = $($refOption).clone();
							$($newOpt).removeAttr('id');
							$($newOpt).html(grp.name);
							$($newOpt).attr('grpid',grp.id);
							$($newOpt).attr('creator',grp.creator);
							$($newOpt).insertAfter($refOption);
						}
						console.log(data);
							
					}
					else
					{
						//hide the select option
						$("#groupsOption").hide();
					}
				}
					
			});
					
		}
		
		
		function getTagsForThreads()
		{
			$.ajax({
				type: "POST",
				url: "threadsRepository.php",
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
		
		
		
		
		
		/* functions for sorting threads on various attributes*/
		
		// sort by title
		var sortByTitleAsc = function compare(obj1,obj2)
		{
			var title1 = obj1.title.toLowerCase();
			var title2 = obj2.title.toLowerCase();
			
			if(title1<title2)
			return -1;
			if(title1>title2)
			return 1;
			return 0
		}
		
		var sortByTitleDesc = function compare(obj1,obj2)
		{
			var title1 = obj1.title.toLowerCase();
			var title2 = obj2.title.toLowerCase();
			
			if(title1>title2)
			return -1;
			if(title1<title2)
			return 1;
			return 0
		}
		
		
		// sort by creator
		var sortByCreatorAsc = function compare(obj1,obj2)
		{
			var val1 = obj1.owner.username.toLowerCase();
			var val2 = obj2.owner.username.toLowerCase();
			
			if(val1<val2)
			return -1;
			if(val1>val2)
			return 1;
			return 0
		}
		
		
		var sortByCreatorDesc = function compare(obj1,obj2)
		{
			var val1 = obj1.owner.username.toLowerCase();
			var val2 = obj2.owner.username.toLowerCase();
			
			if(val1>val2)
			return -1;
			if(val1<val2)
			return 1;
			return 0
		}
		
		
		
		// sort by views
		var sortByViewsAsc = function compare(obj1,obj2)
		{
			var val1 = parseInt(obj1.views);
			var val2 = parseInt(obj2.views);
			
			if(val1<val2)
			return -1;
			if(val1>val2)
			return 1;
			return 0
		}
		var sortByViewsDesc = function compare(obj1,obj2)
		{
			var val1 = parseInt(obj1.views);
			var val2 = parseInt(obj2.views);
			
			if(val1>val2)
			return -1;
			if(val1<val2)
			return 1;
			return 0
		}
		
		
		// Sort by votes
		var sortByVotesAsc = function compare(obj1,obj2)
		{
			var val1 = parseInt(obj1.votes);
			var val2 = parseInt(obj2.votes);
			
			if(val1<val2)
			return -1;
			if(val1>val2)
			return 1;
			return 0
		}
		var sortByVotesDesc = function compare(obj1,obj2)
		{
			var val1 = parseInt(obj1.votes);
			var val2 = parseInt(obj2.votes);
			
			if(val1>val2)
			return -1;
			if(val1<val2)
			return 1;
			return 0
		}
		
		
		// sort by posts
		
		var sortByPostsAsc = function compare(obj1,obj2)
		{
			var val1 = parseInt(obj1.numPost);
			var val2 = parseInt(obj2.numPost);
			
			if(val1<val2)
			return -1;
			if(val1>val2)
			return 1;
			return 0
		}
		var soryByPostsDesc = function compare(obj1,obj2)
		{
			var val1 = parseInt(obj1.numPost);
			var val2 = parseInt(obj2.numPost);
			
			if(val1>val2)
			return -1;
			if(val1<val2)
			return 1;
			return 0
		}
		
		
		//sort by status
		var sortByStatusAsc = function compare(obj1,obj2)
		{
			var val1 = obj1.status.toLowerCase();
			var val2 = obj2.status.toLowerCase();
			
			if(val1<val2)
			return -1;
			if(val1>val2)
			return 1;
			return 0
		}
		
		var sortByStatusDesc = function compare(obj1,obj2)
		{
			var val1 = obj1.status.toLowerCase();
			var val2 = obj2.status.toLowerCase();
			
			if(val1>val2)
			return -1;
			if(val1<val2)
			return 1;
			return 0
		}
		
		
		//sort by group
		
		var sortByGroupNameAsc = function compare(obj1,obj2)
		{
			var val1 = obj1.groupName.toLowerCase();
			var val2 = obj2.groupName.toLowerCase();
			
			if(val1<val2)
			return -1;
			if(val1>val2)
			return 1;
			return 0
		}
		
		var sortByGroupNameDesc = function compare(obj1,obj2)
		{
			var val1 = obj1.groupName.toLowerCase();
			var val2 = obj2.groupName.toLowerCase();
			
			if(val1>val2)
			return -1;
			if(val1<val2)
			return 1;
			return 0
		}
		
		
		//sort by date created
		var sortByDateCreatedAsc = function compare(obj1,obj2)
		{
			var val1 = new Date(obj1.datecreated);
			var val2 = new Date(obj2.datecreated);
			return val1-val2;
		}
		
		var sortByDateCreatedDesc = function compare(obj1,obj2)
		{
			var val1 = new Date(obj1.datecreated);
			var val2 = new Date(obj2.datecreated);
			return val2-val1;
		}
		
		
		
		
		/*Sorting threads*/
		$(".sort_attr").live('click',function(event){
			event.preventDefault();
			
			var postData =new Object();
			postData.attribute = $(this).attr('sort_key');
			postData.order = ($(this).attr('currOrder')=='ASC')?'DESC':'ASC';
			$(this).attr('currOrder',postData.order);
			
			
				
			if(postData.order == 'ASC')
			{
				switch(postData.attribute)
				{
					case 'title':
					allThreads.sort(sortByTitleAsc);
					break;
					
					case 'creator':
					allThreads.sort(sortByCreatorAsc);
					break;
					
					
					case 'views':
					allThreads.sort(sortByViewsAsc);
					break;
					
					
					case 'votes':
					allThreads.sort(sortByVotesAsc);					
					break;
					
					
					case 'numPost':
					allThreads.sort(sortByPostsAsc);										
					break;
					
					
					case 'status':
					allThreads.sort(sortByStatusAsc);															
					break;
					
					
					case 'group':
					allThreads.sort(sortByGroupNameAsc);															
					break;
					
					
					case 'datecreated':
					allThreads.sort(sortByDateCreatedAsc);															
					break;
				}
				
			}
			else if(postData.order = 'DESC')
			{
				
				switch(postData.attribute)
				{
					case 'title':
					allThreads.sort(sortByTitleDesc);
					break;
					
					case 'creator':
					allThreads.sort(sortByCreatorDesc);
					break;
					
					case 'views':
					allThreads.sort(sortByViewsDesc);
					break;
					
					case 'votes':
					allThreads.sort(sortByVotesDesc);					
					break;
					
					
					case 'numPost':
					allThreads.sort(soryByPostsDesc);										
					break;
					
					case 'status':
					allThreads.sort(sortByStatusDesc);															
					break;
					
					
					case 'group':
					allThreads.sort(sortByGroupNameDesc);															
					break;
					
					
					case 'datecreated':
					allThreads.sort(sortByDateCreatedDesc);															
					break;
					
					
					
				}
				
				
			}
			
			layoutRows(allThreads);
			
		});
		
		
		
		
		
		function populateRightSideBar(kCategoriesList)
		{
			 layoutRightSideBar();
		}
		
		
		
		
		function layoutRightSideBar()
		{
			
			$.ajax({
				type: "POST",
				url: "threadsRepository.php",
				async: true,
				data: {requestType: 'getThreadsForCategory',catId: String(param_val)},
			}).done(function(response){
		
				var list = jQuery.parseJSON(response);
				list.sort(sortByVotesAsc);
				$("#right_bar_ref_listItem").siblings().detach();
				for(var i=0;i<list.length;i++)
				{
					var thread = list[i];
					$cell = $("#right_bar_ref_listItem").clone();
					$($cell).show();
					$($cell).find(".right_bar_nav_link").html(thread.title);
					$($cell).find(".right_bar_nav_link").attr('target-row','thread:'+thread.threadid);
					$($cell).find(".right_bar_nav_link").attr('href','#thread:'+thread.threadid);
					$($cell).find(".right_bar_nav_link").removeAttr('id');
					$cell.insertAfter("#right_bar_ref_listItem");
				
				}
				
				
			
			});
			
		}
		
			


	}
);
