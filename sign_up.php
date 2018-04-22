<?php
		/*
		-email
		-pass
		-confirm pass
		-after send to user.php*/
    require_once 'support.php';
    require_once 'db.php';

			session_start();
			$fileName = basename(__FILE__);
			$emailValue = "";
			$body = "<h1 class='text-center'>Sign Up</h1>";
			$errors = [];
			if (isset($_POST["email"])) {
				$emailValue = $_POST["email"];
			}
			$body .= <<<END
			    <form method="post" action="$fileName" class="container-fluid col-lg-4 col-md-6 col-sm-12">
			    	<label><span>Email</span><input type="email" name="email" required value="$emailValue" /></label>
			    	<label><span>Password</span><input type="password" name="password" required /></label>
			    	<label><span>Confirm Password</span><input type="password" name="confirmPassword" required /></label>
			    	<input type="submit" class="btn btn-primary" value="Register" />
			    </form>
END;
			if (isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["confirmPassword"])) {
				if ($_POST["password"] == $_POST["confirmPassword"]) {
					$sql = "insert into user (email, hash) values ('".$_POST["email"]."', '".password_hash($_POST["password"], PASSWORD_BCRYPT)."')";
					$result = queryForDB($sql);
					if ($result == null ) {
						$errors[] = "<h2>That email is already in use</h2>";
					} else {
						$_SESSION["email"] = $_POST["email"];
					}
				} else {
					$errors[] = "<h2>Your password confirmation failed.</h2>";
				}
			}
			if (count($errors) > 0) {
				echo "<div class='errors'>".implode("", $errors)."</div>";
			}

			if (isset($_SESSION["email"])) {
				header("Location: ./user.php");
			}
generatePage($body,"Sign Up", "<link rel=\"stylesheet\" href=\"./css/sign_up.css\" />");
