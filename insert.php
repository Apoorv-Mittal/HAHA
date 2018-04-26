<?php
include("support.php");
include("db.php");

$id = $_REQUEST["id"];
$email = $_REQUEST["email"];
$query = "insert into participants values (".$id.",".$email.")" ;
echo queryForDB($query);
?>