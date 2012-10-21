<!DOCTYPE html>
<html lan="en">
<head>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>

	 <!--load bootstrap-->
	 <link rel="stylesheet" href="/reroutesf/bootstrap/css/bootstrap.css" type="text/css"/>
	 <link rel="stylesheet" href="/reroutesf/bootstrap/css/bootstrap-responsive.css" type="text/css"/>
	<script type="text/javascript" src="/reroutesf/bootstrap/js/bootstrap.min.js"></script>
	<!-- for device size-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="/reroutesf/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
<script src="/reroutesf/bootstrap/js/bootstrap-tooltip.js"></script>
<script src="/reroutesf/bootstrap/js/bootstrap-popover.js"></script>
</head>

<style type='text/css'>
body {
	text-align: center;
}
.allContent {
	position: absolute;
	width: 600px;
}
</style>

<script type='text/javascript'>
function showRoutes(url){
	console.log(url);
	$.ajax({
			type:'POST',
			url: url,
			success: function(response){
				$("#routeinfo").html(response);
			}
		});
}
$(document).ready(function(){
	var pathname = window.location.pathname;
	var queryRoute	= "/showRoutes/";
	var startStop	= "";
	var endStop		= "";
	$(".startStop").click(function(){
		startStop	= $(this).html();
		queryURL	= pathname + queryRoute + startStop + "/" + endStop;
		if(!(endStop==''))
		{
			showRoutes(queryURL);
		}
	});
	$(".endStop").click(function(){
		endStop		= $(this).html();
		console.log(startStop,endStop);
		console.log(pathname);
		queryURL	= pathname + queryRoute + startStop + "/" + endStop;
		if(!(startStop==''))
		{
			showRoutes(queryURL);
		}
	});
});

</script>
<title>Reroute SF</title>

<body>
<div class='allContent'>
<div class='row'>
<div class='span3'>
	<ul class='nav nav-pills'>
		<li class='dropdown'>
			<a class='dropdown-toggle' id='startDrop' role='button' data-toggle='dropdown' href="#">Origin<b class='caret'></b>
			</a>
			<ul class='dropdown-menu' role='menu' aria-labelledby='startDrop'>
				<?php
					foreach($allStopName as $stopName)
					{
						echo "<li><a class='startStop' tabindex='-1' href='#'>$stopName</a></li>";
					}
				?>
			</ul>
		</li>
	</ul>
</div>
<div class='span3'>
	<ul class='nav nav-pills'>
		<li class='dropdown'>
			<a class='dropdown-toggle' id='endDrop' role='button' data-toggle='dropdown' href="#">Destination<b class='caret'></b>
			</a>
			<ul class='dropdown-menu' role='menu' aria-labelledby='endDrop'>
				<?php
					foreach($allStopName as $stopName)
					{
						echo "<li><a class='endStop' tabindex='-1' href='#'>$stopName</a></li>";
					}
				?>
			</ul>
		</li>
	</ul>
</div>


<div id='routeinfo'>
</div>
</div>
</body>
</html>
