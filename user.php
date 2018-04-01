<?php
require_once ("support.php");
    $body= <<<BODY
    <h1 class="text-center"><strong>User Page</strong></h1><br>
        <div class="container-fluid text-center">
        <form action="friends.php" method="post">
        <div class="text-center form-group"><input type="submit" class="form-control" value="Friends" name="friends"></div>
        <div class="text-center form-group">
        <input type="submit" class="form-control" value="Edit Interests" name="interests" formaction="interests.php" formmethod="post">
        </div>
        <div class="text-center form-group">
        <input type="submit" class="form-control" value="Create Event" name="event" formaction="new_event.php" formmethod="post">
        </div>
        </form>    
        </div>
BODY;

    echo generatePage($body, "User");

?>