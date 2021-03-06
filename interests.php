<!---First display the ones you've checked (header text: Yours)-->
<!--- then display the ones you haven't checked-->
<!--- create new category-->
<!--- return to user.php-->

<?php

require_once 'support.php';
require_once 'db.php';

session_start();
$email= $_SESSION['email'];
$body=<<<END
<div style="padding: 4px;height:49px;background-color:lightblue; margin-left: -15px; margin-right: -15px">
        <form>
            <input type="submit" value="Go to Home Page" class="btn btn-info" formaction="user.php" formmethod="post"/>
            <input type="submit" value="Create New Event" class="btn btn-info" formaction="new_event.php" formmethod="post"/>
            <a href="logout.php" class="btn btn-warning" style='float: right'>Logout</a>                   
        </form>
    </div>
    <h1 class='text-center'>Your Interests</h1>
END;

if ( isset($_POST['createCat'])){
    $CatName = trim($_POST['createCat']);
    $result1 = queryForDB("select * from interests where email = \"".$email."\" and category = \"{$CatName}\";");
    if ($result1->num_rows ==0 ){
        $adding = queryForDB("insert into interests values (\"{$email}\",\"{$CatName}\") ;");
        $adding = queryForDB("insert into categories values (\"{$CatName}\") ;");
        $body .="<h3>You successfully added {$CatName} in your interests.</h3>";
    }
    else
        $body .= "<h3>{$CatName} is already one of you interests</h3>";

    unset($_POST['createCat']);
}

if ( isset($_POST['dropCat'])){
    $CatName = trim($_POST['DrCat']);
    $result1 = queryForDB(" delete from interests where email= \"{$email}\" and category = \"{$CatName}\" ;");

    if ($result1){
        $body .="<h3>You successfully dropped {$CatName} from your interests.</h3>";
    }
    else
        $body .= "<h3>{$CatName} interest not dropped</h3>";

    unset($_POST['dropCat']);
}



$result = queryForDB("select * from interests where email = \"".$email."\";");
if ( $result == null )
    $body.="error";
else {
    $num_rows = $result->num_rows;
    if ( $num_rows == 0 ){
        $body .= "<h1>You have no interests right now.</h1>";
        $body.=interests();
    }
    else {

        $body .="<table class='table'><thead><tr><th scope='col'>Your Categories</th></tr></thead><tbody>";
        while ($row = $result->fetch_array(MYSQLI_ASSOC)){
            $body.= "<tr><td>".$row['category']."</td><td>
                    <form action=\"{$_SERVER["PHP_SELF"]}\" method=\"post\" class=\"form-horizontal\">
                            <input type=\"submit\" name=\"dropCat\" class='btn btn-danger' id='dropCat' value='Drop This interest'>
                            <input type='text' type=\"text\" id=\"DrCat\" name=\"DrCat\" value='{$row['category']}' hidden>
                    </form>
                    </td></tr>";
        }
        $body.="</tbody></table>";
        $body.=interests();
    }
}

generatePage($body,"Your Categories");

function interests(){


    $cat = queryForDB("select * from categories;");
    if ( $cat == null )
        $body1="error";
    else {
        $num_rows = $cat->num_rows;
        if ( $num_rows == 0 )
            $body1 = "<h1>There are no categories</h1>";
        else {

            $body1 = "<table class='table'><thead><tr><th scope='col'>All categores</th></tr></thead><tbody>";
            while ($row = $cat->fetch_array(MYSQLI_ASSOC)) {
                $body1 .= "<tr><td>" . $row['category'] . "</td><td>
                        <form action=\"{$_SERVER["PHP_SELF"]}\" method=\"post\" class=\"form-horizontal\">
                            <input type=\"submit\" name=\"" . $row['category'] . "\" class='btn btn-primary' id='createCat'
                            formaction=\"interests.php\" formmethod=\"post\" value='Add it to yours'>
                            <input type='text' type=\"text\" id=\"createCat\" name=\"createCat\" value='{$row['category']}' hidden>
                        </form>
                        </td></tr>";
            }
            $body1 .="</tbody></table>";
        }

    }
    return $body1;
}