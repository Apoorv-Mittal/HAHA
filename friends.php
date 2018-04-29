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

$friendsExisting ="";

if (isset($_POST["remove"])) {
	$fr = $_POST["toRemove"];
	$delete = queryForDb("DELETE FROM friends WHERE (email1=\"{$_SESSION['email']}\" AND email2=\"{$fr}\") OR (email2=\"{$_SESSION['email']}\" AND email1=\"{$fr}\")");
    $additional .= '<h3>Friend '.$fr.' has been removed</h3>';
}
else {
    $result = queryForDB("SELECT * FROM friends WHERE email1 = \"".$_SESSION['email']."\" or email2 = \"".$_SESSION['email']."\";");
    if($result == null ) {
        $friendsExisting .= "<h1>You have no Friends</h1>";
    }
    else {
        /* Number of rows found */
        $num_rows = $result->num_rows;
        if ($num_rows === 0) {
            $friendsExisting.=" You don't have any friends right Now :)";
        } else {
            $friendsExisting.= "<table class=\"table\"><thead><tr><th scope=\"col\">Your Friends</th><th></th></tr></thead><tbody>";
            while ($recordArray = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                if ($_SESSION['email'] == $recordArray['email1'] ){
                    $friendsExisting .="<tr><td>".$recordArray['email2']."</td><td><form action=\"{$_SERVER["PHP_SELF"]}\" method=\"post\" class=\"form-horizontal\">
                            <input type=\"submit\" name=\"remove\" class='btn btn-danger' id='remove' value='Unfriend this friend'>
                            <input type='text' type=\"text\" id=\"toRemove\" name=\"toRemove\" value='{$recordArray['email2']}' hidden>
                    </form></td></tr>";
                }
                else{
                    $friendsExisting .="<tr><td>".$recordArray['email1']."</td><td><form action=\"{$_SERVER["PHP_SELF"]}\" method=\"post\" class=\"form-horizontal\">
                            <input type=\"submit\" name=\"remove\" class='btn btn-danger' id='remove' value='Unfriend this friend'>
                            <input type='text' type=\"text\" id=\"toRemove\" name=\"toRemove\" value='{$recordArray['email1']}' hidden>
                    </form></td></tr>";
                }

            }
            $friendsExisting.= "</tbody>
                </table>";
        }
    }
}

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
        
        $friendsExisting
EOBODY;



generatePage($response);
