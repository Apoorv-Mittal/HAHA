<?php
	include "./support.php";
	session_start();
	$body = <<<END
		<h1>Personal Calendar</h1>
		<a class="btn btn-primary" href="./new_private_event.php">Add New Private Event</a>
		<div id="calendar"></div>
END;
	if (isset($_SESSION["email"])) {
		include "./db.php";
		$events = queryForDB("select * from participants p left join event_date e on p.event_id = e.event_id where p.email = '".$_SESSION["email"]."'");
		$body .= "You have ".$events->num_rows." events.";
	} else {
		header("Location: ./index.php");
	}
	generatePage($body, "Personal Calendar");
?>