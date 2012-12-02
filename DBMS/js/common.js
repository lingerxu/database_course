//Logout
$(".logoutLink").live('click', function(event) {

	console.log("Done");
	$.ajax({
		type : "POST",
		url : "logout.php",
	}).done(function(data) {
		window.location = "index.php";
	});
});

$("#threadSearch").live('click', function(event) {

	window.location = "search.php?catId="+$("#CategoryName").attr("catId")
	+"&threadTitle="+$("#searchText").val();
	
});

$('#searchText').live('keyup',function(e){
	e.preventDefault();
	if(e.keyCode == 13)
	{
		window.location = "search.php?catId="+$("#CategoryName").attr("catId")
		+"&threadTitle="+$("#searchText").val();
	}
});