<?php

    include("support.php");
    include("db.php");
    session_start();

    function weightalgo($key, $val) {
    	$interested = false;
    	$eventstruct = queryForDb("SELECT category FROM Events WHERE event_id=\"{$key}\"");
    	$event = $eventstruct->fetch_assoc();
    	$eventcat = $event["category"];

    	$interestsstruct = queryForDb("SELECT category FROM Interests WHERE email=\"{$_SESSION['email']}\"");
    	while($interest = $interestsstruct->fetch_assoc()) {
    		if ($eventcat = $interest["category"]) {
    			$interested = true;
    			break;
    		}
    	}

    	if($interested) {
    		return $val*0.75 + 2;
    	} else {
    		return $val*0.75;
    	}
    }
    function alfoForF(){
		$participants = queryForDb("SELECT * FROM Participants");
		$friends = queryForDb("SELECT * FROM Friends");
		$tally = [];

		while ($part = $participants->fetch_assoc()) {
			while($friend = $friends->fetch_assoc()) {
				if ($part["email"] == $_SESSION["email"]) {
					$tally[$part["event_id"]] = -100000;
					break;
				} elseif(($part["email"] == $friend["email1"] && $_SESSION["email"] == $friend["email2"]) || ($part["email"] == $friend["email2"] && $_SESSION["email"] == $friend["email1"])) {
					if(array_key_exists($part["event_id"], $tally)) {
						$tally[$part["event_id"]];
					} else {
						$tally[$part["event_id"]] = 1;
					}
				} 
			}
		}

		asort($tally);
		$tally = array_map("weightalgo", array_keys($tally), array_values($tally));

		return array_slice(array_keys($tally), 0, 2);
    }

    function alfoForC(){


    }

    function algoForX() {// X is every event
    	return queryForDB("select start_time, end_time, date, type, event_id from event_date");
    }

    function algoForY() {// Y is events the user is participating in
    	return queryForDB("select p.event_id, ed.start_time, ed.end_time, ed.date, ed.type from participants p left join event_date e on p.event_id = e.event_id where p.email = '".$_SESSION["email"]."'");
    }

    function eventsOverlap($e1, $e2) {
    	// Part 1: do the dates overlap?
    	// if they're the same day of year, then the date will overlap.
    	$sameDay = $e1["date"]["tm_yday"] === $e2["date"]["tm_yday"];

    	// if one of the events recurs and they fall on the same weekday, the date will overlap.
    	if (!$sameDay && ($e1["recurring"] || $e2["recurring"])) {
    		$sameDay = $e1["date"]["tm_wday"] === $e2["date"]["tm_wday"];
    	}

    	if (!$sameDay) {
    		return false;
    	}

    	// Part 2: do the times overlap?
    	$e1Times = array($e1["start_time"]["tm_min"] + $e1["start_time"]["tm_hour"]*60, $e1["end_time"]["tm_min"] + $e1["end_time"]["tm_hour"]*60);
    	$e2Times = array($e2["start_time"]["tm_min"] + $e2["start_time"]["tm_hour"]*60, $e2["end_time"]["tm_min"] + $e2["end_time"]["tm_hour"]*60);
    	// 0 => start time, 1 => end time
    	return ($e1Times[0] >= $e2Times[0] && $e1Times[0] <= $e2Times[1]) ||
    		   ($e1Times[1] >= $e2Times[0] && $e1Times[1] <= $e2Times[1]);
    }

    function weighInterest() {
    	// Returns events we should weigh interest in. Exclude events where the time overlaps or that the user is already participating.
    	$TIME_FORMAT = "%H:%M:%S";
    	$DATE_FORMAT = "%Y:%m:%d";
		/*

		TIME FORMAT:
		HH:MM:SS
		24-hour time
		0-padded

		DATE FORMAT:
		YYYY-MM-DD
		0-padded

		*/
    	$X = algoForX();
    	$XArray = array();
    	while ($x = $X->fetch_assoc()) {
    		$parsedX = array(
    			"event_id" => $x["event_id"],
	    		"start_time" => strptime($x["start_time"], $TIME_FORMAT),
	    		"end_time" => strptime($x["end_time"], $TIME_FORMAT),
	    		"date" => strptime($x["date"], $DATE_FORMAT),
	    		"recurring" => $x["type"] === "WEEKLY"
	    	);
    		$XArray[] = $parsedX;
    	}
    	$Y = algoForY();
    	while($y = $Y->fetch_assoc()) {
    		$parsedY = array(
    			"event_id" => $y["event_id"],
	    		"start_time" => strptime($y["start_time"], $TIME_FORMAT),
	    		"end_time" => strptime($y["end_time"], $TIME_FORMAT),
	    		"date" => strptime($y["date"], $DATE_FORMAT),
	    		"recurring" => $y["type"] === "WEEKLY"
    		);
    		$overlapped = false;
    		$tempX = array();
    		foreach ($XArray as $x) {
    			if (!eventsOverlap($x, $parsedY)) {
    				$tempX[] = $x;
    			}
    		}
    		$XArray = $tempX;
    	}
    	return $XArray;
    }