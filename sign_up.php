<!doctype html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>$title</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="./css/sign_up.css" />
    </head>
    <body>
    	<h1>Sign Up</h1>
<?php
		/*
		-email
		-pass
		-confirm pass
		-after send to user.php*/
			$fileName = basename(__FILE__);
			$emailValue = "";
			$body = "";
			$errors = [];
			if (isset($_POST["email"])) {
				if (false) {// email exists in database
					$errors[] = "<h2>That email is already in use</h2>";
				} else {
					$emailValue = $_POST["email"];
				}
			}
			$body .= <<<END
			    <form method="post" action="$fileName" class="container-fluid col-lg-4 col-md-6 col-sm-12">
			    	<label><span>Email</span><input type="email" name="email" required value="$emailValue" /></label>
			    	<label><span>Password</span><input type="password" name="password" required /></label>
			    	<label><span>Confirm Password</span><input type="password" name="confirmPassword" required /></label>
			    	<input type="submit" value="Register" />
			    </form>
END;
			if (isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["confirmPassword"])) {
				if ($_POST["password"] == $_POST["confirmPassword"]) {

				} else {
					$errors[] = "<h2>Your password confirmation failed.</h2>";
				}
			}
			if (count($errors) > 0) {
				echo "<div class='errors'>".implode("", $errors)."</div>";
			}
			echo $body;
?>
	</body>
</html>