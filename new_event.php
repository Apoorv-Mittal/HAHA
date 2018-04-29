<?php
include("support.php");
include("db.php");
$response = "";
session_start();

$DATETIME_FORMAT = "Y-m-d H:i:s";
/*

TIME FORMAT:
HH:MM
24-hour time
0-padded

DATE FORMAT:
YYYY-MM-DD
0-padded

*/
$valid = true;
if (!isset($_SESSION["email"])) {
    header("Location: index.php");
    exit();
}
if (isset($_POST["return"])) {	
	header("Location: user.php");
	exit();
}
if (isset($_FILES["file"]) && ($_FILES["file"]["error"] > 0 || array_search($_FILES["file"]["type"], array("image/gif", "image/png", "image/jpeg")) === FALSE)) {
    $response .= "<h3 class='alert alert-warning' style='background: pink; color: red; border-color: red'>Your image is not valid. Try another one.</h3>";
    $valid = false;
}
if (isset($_POST["submitNewEvent"]) && $valid) {

#	queryForDb("INSERT INTO table (
#    data
#) VALUES ( '{$_POST['type']}', '{$_SESSION['email']}'
#    '" . mysqli_real_escape_string (file_get_contents ({$_POST['image']}), $db) . "'
#);");

    $file_contents = addslashes(file_get_contents($_FILES["file"]["tmp_name"]));
    $start_date = date($DATETIME_FORMAT, strtotime($_POST["start_date"]));
    $description = addslashes($_POST['description']);
    $title = addslashes($_POST["title"]);
    $end_date = date($DATETIME_FORMAT, strtotime($_POST["end_date"]));
    $query = "INSERT INTO events (start_date, end_date, type, owner_email, title, description, image) VALUES ('{$start_date}', '{$end_date}', '{$_POST['type']}', '{$_SESSION['email']}', '{$title}', '{$description}', '{$file_contents}')";
    echo $query;
	$result = queryForDb($query);
	$response .= <<<EOBODY
		<h1>Event has been added</h1><form action="{$_SERVER["PHP_SELF"]}" method="post" class="form-horizontal">

        <div class="form-group">
            <div class="col-sm-3 col-sm-push-3">
                <input type="submit" name="return" value="Done" class="form-control">
            </div>
        </div>

EOBODY;
} else {
	$response .= <<<EOBODY
	<div style="padding: 4px;height:49px;background-color:lightblue; margin-left: -15px; margin-right: -15px">
        <form>
            <input type="submit" value="Go to Home Page" class="btn btn-info" formaction="user.php" formmethod="post"/>
            <input type="submit" value="Edit Interests" class="btn btn-info" formaction="interests.php" formmethod="post"/>
            <a href="logout.php" class="btn btn-warning" style='float: right'>Logout</a>        
        </form>
    </div>
		<h1>Create New Event</h1>
		

		<form action="{$_SERVER["PHP_SELF"]}" method="post" class="form-horizontal" enctype="multipart/form-data">
			<div class="form-group">                   
                <label for="title" class="control-label col-sm-3">Title</label>
                <div class="col-sm-9">
                    <input type="text" id="title" name="title" class="form-control input-md" autofocus required>
                </div>
            </div>
		    <div class="form-group">                   
                <label for="type" class="control-label col-sm-3">Type</label>
                <div class="col-sm-9">
                    <input type="radio" name="type" value="public" class="radio-inline" checked>Public
                    <input type="radio" name="type" value="private" class="radio-inline">Private
                </div>
            </div>
            <div class="form-group">                   
                <label for="description" class="control-label col-sm-3">Description</label>
                <div class="col-sm-9">
                    <textarea name="description" rows="5" class="form-control"></textarea>
                </div>
            </div>
            <div class="form-group">                   
                <label for="picture" class="control-label col-sm-3">Event Picture</label>
                <div class="col-sm-9">
                    <input type="file" name="file" class="btn btn-file btn-primary input-md" required>
                </div>
            </div>
            <div class='col-sm-5'>
                <label class="control-label">Start Time</label>
                <div class="form-group">
                    <div class='input-group date' id='start-date'>
                        <input type='text' name="start_date" class="form-control" required />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
            </div>
            <div class='col-sm-5 col-sm-push-1'>
                <label class="control-label">End Time</label>
                <div class="form-group">
                    <div class='input-group date' id='end-date'>
                        <input type='text' name="end_date" class="form-control" required />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <input type="submit" name="submitNewEvent" value="Create" class="btn btn-primary col-sm-12">
            </div>
        </form>
EOBODY;
}
$headExtras = <<<HEADEXTRAS
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<link href="bootstrap_extras/bootstrap-datetimepicker.min.css" rel="stylesheet" >
<script type="text/javascript" src="https://momentjs.com/downloads/moment.min.js" crossorigin="anonynmous"></script>
<script src="http://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script type="text/javascript" src="bootstrap_extras/bootstrap-datetimepicker.js"></script>
<script type="text/javascript">
    $(function () {
        $('#start-date').datetimepicker();
        $('#end-date').datetimepicker();
        const form = document.getElementById("form");
        form.addEventListener("submit", (e) =>{
            const inputs = document.getElementsByTagName("input");
            const {
                title,
                description,
                file,
                start_date,
                end_date,
            } = ["title",  "description", "file", "start_date", "end_date"].reduce((obj, x) => {
                obj[x] = document.getElementsByName(x)[0];
                return obj;
            }, {});
            if (title.value.length === 0 || description.value.length === 0 || !moment(start_date.value).isValid() || !moment(end_date.value).isValid() || moment(start_date.value).isAfter(moment(end_date.value))) {
                e.preventDefault();
            }
        });
    });
</script>
<style>
    form, h1 {
        width: 70%;
        margin-left: auto;
        margin-right: auto;
    }
</style>
HEADEXTRAS;
generatePage($response, "Events", $headExtras, false);
?>