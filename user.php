<?php
require_once ("support.php");
require_once ("db.php");
session_start();
$body="";
$frnds="<div class=\"form-group col\">";


$result = queryForDB("SELECT * FROM friends WHERE email1 = \"".$_SESSION['email']."\" or email2 = \"".$_SESSION['email']."\" LIMIT 5;");
if($result == null ) {
    $frnds .= "<h1>You have no Friends</h1>
        <input type=\"submit\" class=\"form-control btn btn-info\" value=\"Add Friends\" name=\"friends\">
                </div>";

}
else {
    /* Number of rows found */
    $num_rows = $result->num_rows;
    if ($num_rows === 0) {
        $frnds.=" You don't have any friends right Now :) <br>
        <input type=\"submit\" class=\"form-control btn btn-info\" value=\"Add Friends\" name=\"friends\">
                </div>";
    } else {
        $frnds.= "<table class=\"table\"><thead><tr><th scope=\"col\">Your Friends</th></tr></thead><tbody>";
        while ($recordArray = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            if ($_SESSION['email'] == $recordArray['email1'] )
                $frnds .="<tr><td>".$recordArray['email2']."</td></tr>";
            else
                $frnds .="<tr><td>".$recordArray['email1']."</td></tr>";
        }
        $frnds.= "</tbody>
                </table>
                <input type=\"submit\" class=\"form-control btn btn-info\" value=\"Add more friends\" name=\"friends\">
                </div>";
    }
}
    $eventsArray = algForT();

    $body .= <<<BODY
        <h1 class="text-center">User Page</h1>
        
            <form class="row justify-content-md-center" action="friends.php" method="post">
                $frnds
                
                <div class="col">
                    <div class="form-group ">
                        <input type="submit" class="form-control btn btn-info" value="Edit Interests" name="interests" formaction="interests.php" formmethod="post">
                    </div>
                    
                    <div class="form-group ">
                        <input type="submit" class="form-control btn btn-info" value="Create Event" name="event" formaction="new_event.php" formmethod="post">
                    </div>
                </div>
                </form>  
BODY;
    foreach ($eventsArray as $value) {
    $body.= createEventCards($value["title"],$value["start_time"], $value["end_time"], $value["event_id"]);
}

    generatePage($body, "User");

