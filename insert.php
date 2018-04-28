<?php
include("support.php");
include("db.php");

$id = $_REQUEST["id"];
$email = $_REQUEST["email"];
$query = "insert into participants values (\"".$id."\",\"".$email."\")" ;
$result = queryForDB($query);
if ($result) {
    echo "You have been added to the attendees for this event";
}
//generatePage("");
?>