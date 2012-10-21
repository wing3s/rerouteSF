<script src="/reroutesf/bootstrap/js/bootstrap-tooltip.js "></script>
<script>
$(function() {

	var isVisible = false;
    var clickedAway = false;
	$(".busRoute").popover({
		placement:'right',
		trigger:'manual',
		title:'Bus Route',
		content:"<img src='http://maps.googleapis.com/maps/api/staticmap?center=San+Francisco&amp;size=300x640&amp;maptype=terrain&amp;sensor=false&amp;markers=color:green%7Clabel:S%7C37.791982,-122.408037&amp;markers=color:blue%7Clabel:%7C37.725571,-122.394272&amp;markers=color:green%7Clabel:E%7C37.783537,-122.415641&amp;path=color:0x0000ff%7Cweight:5%7C37.791982,-122.408037%7C37.725571,-122.394272%7C37.783537,-122.415641'>"
	}).click(function(e){
		$(this).popover('show');
		isVisible = true;
		e.preventDefault();
	});


    $(document).click(function(e){
        if(isVisible & clickedAway) {
            $(".busRoute").popover('hide');
            isVisible = clickedAway = false;
        } else {
            clickedAway = true;
        }
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
