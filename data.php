<?php
require_once("scheduler/codebase/connector/scheduler_connector.php");
require_once ('scheduler/codebase/connector/db_mysqli.php');

$host = "localhost";
$user = "admin";
$password = "terps";
$database = "phaha";

session_start();
$email = $_SESSION['email'];

$res = new mysqli($host, $user, $password, $database);
/* check connection */
if ($res->connect_errno) {
    printf("Connect failed: %s\n", $res->connect_error);
    exit();
}

mysqli_select_db($res, "events");
$scheduler = new schedulerConnector($res, "MySQLi");

$query =
    "select events.event_id, events.start_date, events.end_date, events.type, events.owner_email, events.title, events.description, events.category
    from events, participants
    where events.owner_email='{$email}' or (events.event_id=participants.event_id and participants.email='{$email}')";

if ($scheduler->is_select_mode())
    //code for loading data
    $scheduler->render_sql($query,"event_id","start_date,end_date,title,type,owner_email,description,image");
?>