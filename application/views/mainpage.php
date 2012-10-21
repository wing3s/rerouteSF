<!DOCTYPE html>
<html lan="en">
<head>
	<script type="text/javascript" src="https://ajax.microsoft.com/ajax/jquery/jquery-1.8.0.min.js"></script>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
	 <!--load bootstrap-->
	 <link rel="stylesheet" href="/reroutesf/bootstrap/css/bootstrap.min.css" type="text/css"/>
	<script type="text/javascript" src="/reroutesf/bootstrap/js/bootstrap.min.js"></script>
	<!-- for device size-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="/reroutesf/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
</head>

<body>
<div class='row'>
	<ul class='nav nav-pills'>
		<li class='dropdown'>
			<a class='dropdown-toggle' id='startDrop' role='button' data-toggle='dropdown' href="#">Origin<b class='caret'></b>
			</a>
			<ul class='dropdown-menu' role='menu' aria-labelledby='startDrop'>
				<?php
					foreach($allStopName as $stopName)
					{
						echo "<li><a tabindex='-1' href='#'>$stopName</a></li>";
					}
				?>
			</ul>
		</li>
	</ul>
</div>
<div class='row'>
	<ul class='nav nav-pills'>
		<li class='dropdown'>
			<a class='dropdown-toggle' id='endDrop' role='button' data-toggle='dropdown' href="#">Destination<b class='caret'></b>
			</a>
			<ul class='dropdown-menu' role='menu' aria-labelledby='endDrop'>
				<?php
					foreach($allStopName as $stopName)
					{
						echo "<li><a tabindex='-1' href='#'>$stopName</a></li>";
					}
				?>
			</ul>
		</li>
	</ul>
</div>
</body>
</html>