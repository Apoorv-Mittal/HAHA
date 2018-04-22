<?php
require_once ("support.php");
session_start();
$body="";
$frnds="<div class=\"form-group col\">";


$result = queryForDB("SELECT TOP 5 email2 FROM Friends WHERE email1 == \" ".$_SESSION['email']." \"");
if($result == null )
    $body .= "<h1>You have no Friends</h1>";
else {
    /* Number of rows found */
    $num_rows = $result->num_rows;
    if ($num_rows === 0) {
        $frnds.=" You don't have any friends right Now :) <br>
        <input type=\"submit\" class=\"form-control btn btn-info\" value=\"Add Friends\" name=\"friends\">
                </div>";
    } else {
        $frnds.= "<table class=\"table\">";
        while ($recordArray = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $frnds .="<tr><td>".$recordArray['email2']."</td></tr>";
        }
        $frnds.= "</table>
                <input type=\"submit\" class=\"form - control btn btn - info\" value=\"Add more friends\" name=\"friends\">
                </div>";
    }
}


    $body .= <<<BODY
    <h1 class="text-center"><strong>User Page</strong></h1>
        
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

    generatePage($body, "User");

