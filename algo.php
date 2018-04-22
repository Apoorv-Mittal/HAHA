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
		return array_slice(array_keys($tally), 0, 2);
    }

    function alfoForC(){


    }