<?php
include("support.php");
include("db.php");
$response = "";

if (isset($_POST["return"])) {	
	header("Location: user.php");
	exit();
}

if (isset($_POST["submitNewEvent"])) {

#	queryForDb("INSERT INTO table (
#    data
#) VALUES ( '{$_POST['type']}', '{$_SESSION['email']}'
#    '" . mysqli_real_escape_string (file_get_contents ({$_POST['image']}), $db) . "'
#);");
	queryForDb("INSERT INTO events VALUES ('{$_POST['type']}', {$_SESSION['email']}, {$_POST['title']}, {$_POST['description']})");
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
		<h1>Create New Event</h1><form action="{$_SERVER["PHP_SELF"]}" method="post" class="form-horizontal">
			<div class="form-group">                   
                <label for="title" class="control-label col-sm-3">Title</label>
                <div class="col-sm-9">
                    <input type="text" id="title" name="title" class="form-control input-md" autofocus required>
                </div>
            </div>
		    <div class="form-group">                   
                <label for="type" class="control-label col-sm-3">Type</label>
                <div class="col-sm-9">
                    <input type="radio" name="type" class="radio-inline" required>Public
                    <input type="radio" name="type" class="radio-inline">Private
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
                    <input type="file" name="file" class="form-control input-md">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-3 col-sm-push-3">
                    <input type="submit" name="submitNewEvent" value="Create" class="form-control">
                </div>
            </div>
        </form>
EOBODY;

generatePage($response);
}
?>