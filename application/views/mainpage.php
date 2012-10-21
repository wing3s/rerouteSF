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
<div class='visible-phone'>


</div>
</body>
</html>
<?php
	foreach($allStopName as $stopName)
	{
		echo $stopName;
	}
?>
