<?php
require_once("scheduler/codebase/connector/scheduler_connector.php");
require_once ('scheduler/codebase/connector/db_mysqli.php');

$host = "localhost";
$user = "admin";
$password = "terps";
$database = "phaha";

$res = new mysqli($host, $user, $password, $database);
/* check connection */
if ($res->connect_errno) {
    printf("Connect failed: %s\n", $res->connect_error);
    exit();
}

mysqli_select_db($res, "events");
$scheduler = new schedulerConnector($res, "MySQLi");
$scheduler->render_table("events","event_id","start_date,end_date,title");
?>