<?php
#-search email
#- add (if not friended)
#- remove (if friended)
#- return to user.php
include("support.php");
include("db.php");

$response = "";
$additional="";
session_start();

if (isset($_POST["addFriend"])) {
    $fr = trim($_POST["addEmail"]);
	$result = queryForDb("SELECT * FROM user WHERE email=\"".$fr."\";");
	if ($result->num_rows == 0) {
		$additional .= "<h3>The given user does not exist</h3>";
	}
	else {
	    $exists = queryForDb("SELECT * FROM friends WHERE (email1=\"".$fr."\" AND email2=\"{$_SESSION['email']}\") OR 
	    (email2=\"".$fr."\" AND email1=\"{$_SESSION['email']}\");");


	    if ($exists->num_rows != 0){
            $additional = "<h3>You are already friends with {$fr}.</h3>";
        }
        else if ($fr == $_SESSION['email']){
            $additional = "<h3>You are already friends with yourself.</h3>";
        }
        else {
            $result = queryForDb("INSERT INTO friends values (\"{$_SESSION['email']}\", \"{$fr}\");");
            $additional = "<strong>You added {$fr}.</strong>";
        }
	}
} 

if (isset($_POST["remove"])) {
	$fr = explode(" ", $_POST["remove"])[1];
	$delete = queryForDb("DELETE FROM friends WHERE (email1=\"{$_SESSION['email']}\" AND email2=\"{$fr}\") OR (email1=\"{$_SESSION['email']}\" AND email2=\"{$fr}\")");
	$response .= ' 
			<h3>Friend '.$fr.' has been removed</h3>
			<form action="user.php" method="post" class="form-horizontal">
		        <div class="form-group col-sm-3 col-sm-push-3">
	                <input type="submit" name="back" value="Go Back To User Page" class="form-control  btn btn-primary">
	            </div>
            </form>';
} else {
	$response .= <<<EOBODY
	    <div style="padding: 4px;height:49px;background-color:lightblue; margin-left: -15px; margin-right: -15px">
            <form>
                <input type="submit" value="Go to Home Page" class="btn btn-info" formaction="user.php" formmethod="post"/>
                <input type="submit" value="Create New Event" class="btn btn-info" formaction="new_event.php" formmethod="post"/>
                <input type="submit" value="Edit Interests" class="btn btn-info" formaction="interests.php" formmethod="post"/>
                <a href="logout.php" class="btn btn-warning" style='float: right'>Logout</a>        
            </form>
        </div>
		<h1 class="text-center">Add friend</h1>
		
		$additional
		
		<form action="{$_SERVER["PHP_SELF"]}" method="post" class="form-horizontal">
            <div class="form-group">                   
                <label for="addEmail" class="control-label col-sm-3 col-sm-9">Friend's email</label>
                    <input type="email" id="addEmail" name="addEmail" class="form-control">
            </div>
            <div class="form-group col-sm-3 col-sm-push-3">
                <input type="submit" name="addFriend" value="Add" class="form-control  btn btn-primary">
            </div>
        </form>
EOBODY;
}


generatePage($response);
