<!---Login -> text popup  -> send to user.php-->
<!---Sign up -> sign-up.php-->
<!---->
<!---Logo HAHA EVENT-->
<?php

require_once 'support.php';
require_once 'db.php';
session_start();

if( isset($_POST['Login'])){
    $email= trim($_POST['Email']);

    $password= trim($_POST['Pass']);
    $result = queryForDB("select * from User where email = \"".$email."\"");

    /* Number of rows found */
    $num_rows = $result->num_rows;
    if ($num_rows === 0) {
        echo "Empty Table<br>";
    } else {
        $_SESSION['email']= $email;
        $row = $result->fetch_array(MYSQLI_ASSOC);
        if (password_verify($password, $row['password'])){
            header('Location:user.php');
            exit();
        }
        else
            $body .= "<h1>No entry exists in database for the specified email and password</h1>";

    }
}


    $body = <<<END
    <h1>HAHA EVENTS</h1>
            <form action="index.php" method="post">
                <strong>Email: </strong> <input type="text" name="Email">
                <strong>Password: </strong> <input type="text" name="Pass">
                <input type="submit" class="btn btn-primary" name="Login" value="Log In">
                <br>
                <input type="submit" class="btn btn-primary" formaction="sign-up.php" formmethod="post" value="Sign Up">
            </form>
END;


generatePage($body,"HAHA Events");