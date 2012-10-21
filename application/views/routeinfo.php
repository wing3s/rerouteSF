<script src="/reroutesf/bootstrap/js/bootstrap-tooltip.js "></script>
<script>
$(document).ready(function() {
	$(".busRoute").popover({
		placement:'right',
		trigger:'manual',
		title:'Bus Route',
		content:"aa"
	}).click(function(e){
		$(this).popover('show');
		isVisible = true;
		e.preventDefault();
	});
});
</script>

<ul class='nav nav-tabs nav-stacked'>
	<li style='width:600px'>
	<a>
	<div class='row'>
	<div class='span2'>Route Number</div>
	<div class='span2'>Estimate duration</div>
	<div class='span2'>Bus Load</div>
	</div>
	</a>
	</li>

<?php
	foreach($routes as $route)
	{
		$routeRow	= "
			<div class='row'>
			<div class='span2'>".$route['routeNum']."</div>
			<div class='span2'>".$route['duration']."</div>
			<div class='span2'>".$route['load']."</div>
			</div>
			";
		echo "<li style='width:600px'><a class='busRoute'> $routeRow </a></li>";
	}
?>
</ul>
