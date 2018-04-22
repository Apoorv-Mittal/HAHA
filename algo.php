<?php
	/*
	The formula:
		Calculates the potential interest in the event.
		Parameters:
			F -> the number of friends attending an event
			C -> 1 if the category is of interest of the current user.
			T -> true if the user can attend the event due to time constraints
		Returns:
			if T then 0.75*F + 2*C else 0
	*/
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

    function algoForX() {// X is every public event
    	return queryForDB("select start_time, end_time, date, event_id from events where type = 'PUBLIC'");
    }

    function algoForY() {// Y is events the user is participating in
    	return queryForDB("select p.event_id, ed.start_time, ed.end_time, ed.date, ed.type from participants p left join events e on p.event_id = e.event_id where p.email = '".$_SESSION["email"]."'");
    }

    function eventsOverlap($e1, $e2) {
    	// true if the $e1 and $e2 conflict based on time
    	$COMPARE_FORMAT = "%Y%m%d%H%M%S";
    	$startDate =$e1["start_date"];
    	$endDate =$e1["end_date"];
    	// converts the date to a comparable format in integers
    	// reads from largest to smallest, 0-padded (Year, Month, Day, Hour, Minute, Second)
    	$e1Dates = array(
    		(int) strftime($start_date, $COMPARE_FORMAT),
    		(int) strftime($end_date, $COMPARE_FORMAT)
    	);
    	$startDate =$e2["start_date"];
    	$endDate =$e2["end_date"];
    	$e2Dates = array(
    		(int) strftime($start_date, $COMPARE_FORMAT),
    		(int) strftime($end_date, $COMPARE_FORMAT)
    	);
    	// return true if the start date of e1 falls between e2's start and end dates,
    	// or if the end date of e1 falls between e2's start and end dates
    	return ($e1Dates[0] >= $e2Dates[0] && $e1Dates[0] <= $e2Dates[1]) ||
    		   ($e1Dates[1] >= $e2Dates[0] && $e1Dates[1] <= $e2Dates[1]);
    }

    function algForT() {// T is true when an event is something the user can attend.
    	// However, it is hard to compute T for one event, so this function returns
    	// all events for when T is true.

    	$DATETIME_FORMAT = "%Y-%m-%d %H:%M:%S";
    	$X = algoForX();
    	$XArray = array();
    	// since our alg is O(n^2), we make this efficient by making an array of x pre-parsed.
    	while ($x = $X->fetch_assoc()) {
    		$parsedX = array(
    			"event_id" => $x["event_id"],
	    		"start_date" => strptime($x["start_date"], $DATETIME_FORMAT),
	    		"end_date" => strptime($x["end_date"], $DATETIME_FORMAT)
	    	);
    		$XArray[] = $parsedX;
    	}
    	$Y = algoForY();
    	// loop through all events user is participating in
    	while($y = $Y->fetch_assoc()) {
    		$parsedY = array(
    			"event_id" => $y["event_id"],
	    		"start_date" => strptime($y["start_date"], $DATETIME_FORMAT),
	    		"end_date" => strptime($y["end_date"], $DATETIME_FORMAT)
    		);
    		$overlapped = false;
    		$tempX = array();
    		foreach ($XArray as $x) {// loop through all remaining events
    			// if the event doesn't overlap, it's something the user could attend
    			// it will then be assigned a visibility score based on potential interest.
    			if (!eventsOverlap($x, $parsedY)) {
    				$tempX[] = $x;
    			}
    		}
    		// replace all public events with all public events that are open for user.
    		$XArray = $tempX;
    	}
    	return $XArray;
    }

    function algoForC($name, $category) {
        $query ="select * from interests where categry=$category and email=$name";
        return queryForDB($query)->num_rows;
    }