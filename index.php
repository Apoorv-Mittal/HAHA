<!---Login -> text popup  -> send to user.php-->
<!---Sign up -> sign-up.php-->
<!---->
<!---Logo HAHA EVENT-->
<?php

require_once 'support.php';

if( isset($_POST['Login'])){


    header('Location:user.php');
}


$body=<<<END
            <form action="index.php" method="post">
                <strong>Email: </strong> <input type="text" name="Email">
                <strong>Password: </strong> <input type="text" name="Pass">
                <input type="submit" name="Login" value="Log In">
                <br>
                <input type="submit" formaction="sign-up.php" formmethod="post" value="Sign Up">
            </form>
END;

generatePage($body,"HAHA Events");