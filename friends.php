<?php
#-search email
#- add (if not friended)
#- remove (if friended)
#- return to user.php
include("support.php");
include("db.php");

$response = "";

if (isset($_POST["addFriend"])) {
	$result = queryForDb("SELECT * FROM user WHERE email='{$_POST['addEmail']}'");
	if (!$result) {
		$response .= <<<EOBODY
		<h1>Add friend</h1><strong>The given user does not exist</strong><form action="{$_SERVER["PHP_SELF"]}" method="post" class="form-horizontal">

        <div class="form-group">                   
            <label for="addEmail" class="control-label col-sm-3">Friend's email</label>
            <div class="col-sm-9">
                <input type="text" id="addEmail" name="addEmail" class="form-control"></input>
  	        </div>
        </div>
        <div class="form-group">
            <div class="col-sm-3 col-sm-push-3">
                <input type="submit" name="addFriend" value="Add" class="form-control">
            </div>
        </div>

EOBODY;
	} else {
		$result = queryForDb("INSERT INTO friends values('{$_SESSION['email']}', '{$_POST['addEmail']}')");
		$response .= <<<EOBODY
		<h1>Add friend</h1><strong>The given user does not exist</strong><form action="{$_SERVER["PHP_SELF"]}" method="post" class="form-horizontal">

        <div class="form-group">             
            <label for="addEmail" class="control-label col-sm-3">Friend's email</label>
            <div class="col-sm-9">
                <input type="text" id="addEmail" name="addEmail" class="form-control"></input>
  	        </div>
        </div>
        <div class="form-group">
            <div class="col-sm-3 col-sm-push-3">
                <input type="submit" name="addFriend" value="Add" class="form-control">
            </div>
        </div>

EOBODY;
	}
} else {
	$response .= <<<EOBODY
		<h1>Add friend</h1><form action="{$_SERVER["PHP_SELF"]}" method="post" class="form-horizontal">

        <div class="form-group">                   
            <label for="addEmail" class="control-label col-sm-3">Friend's email</label>
            <div class="col-sm-9">
                <input type="text" id="addEmail" name="addEmail" class="form-control"></input>
  	        </div>
        </div>
        <div class="form-group">
            <div class="col-sm-3 col-sm-push-3">
                <input type="submit" name="addFriend" value="Add" class="form-control">
            </div>
        </div>
EOBODY;
}

generatePage($response);
?>