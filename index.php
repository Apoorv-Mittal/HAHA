<head>
    <!-- Bootstrap -->
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
</head>

<style>
    body {
        background-image: url("img/background.jpg");
        background-size: cover;
    }
    .panel-footer {
        color: #A0A0A0;
    }
    .jaja-img {
        width: 120px;
        height: 80px;
        margin: 0 auto 10px;
        display: block;
    }
    .profile-img {
        width: 96px;
        height: 96px;
        margin: 0 auto 10px;
        display: block;
        border-radius: 50%;
    }
</style>

<body>

<?php
require_once 'support.php';
require_once 'db.php';

function alert(){
    echo '<script language="javascript">';
    echo 'alert("Wrong password and/or email")';
    echo '</script>';
}
session_start();
$body="";

if( isset($_POST['Login'])){
    $email= trim($_POST['Email']);
    $password= trim($_POST['Pass']);
    $result = queryForDB("select * from user where email = \"".$email."\"");

    if($result == null )
        alert();
    else {
        /* Number of rows found */
        $num_rows = $result->num_rows;
        if ($num_rows === 0) {
            alert();
        } else {
            $row = $result->fetch_array(MYSQLI_ASSOC);
            if (password_verify($password, $row['hash'])) {
                $_SESSION['email'] = $email;
                header('Location:user.php');
                exit();
            } else
                alert();
        }
    }
}
?>
<div class="container" style="margin-top:40px">
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong> Log in to continue</strong>
                </div>
                <div class="panel-body">
                    <form role="form" action="index.php" method="POST">
                        <div class="row">
                            <div class="center-block">
                                <img class="jaja-img" src="img/jaja.png" alt="">
                                <img class="profile-img" src="img/profile.png" alt="">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-10  col-md-offset-1 ">
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                        <input class="form-control" placeholder="Email" name="Email" type="text" autofocus>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                        <input class="form-control" placeholder="Password" name="Pass" type="password" value="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="submit" class="btn btn-lg btn-primary btn-block" name="Login" value="Log in">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="panel-footer ">
                    Don't have an account? <a href="sign_up.php" onClick=""> Sign Up Here </a>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
