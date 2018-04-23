<!---First display the ones you've checked (header text: Yours)-->
<!--- then display the ones you haven't checked-->
<!--- create new category-->
<!--- return to user.php-->

<?php

require_once 'support.php';
require_once 'db.php';

session_start();
$email= $_SESSION['email'];
$body="    <h1 class='text-center'>Your Interests</h1>";

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


$body .="<form action=\"user.php\" method=\"post\"><input type=\"submit\" name=\"back\" value=\"Go Back To User Page\" class=\"form-control col-2 btn btn-primary\"></form><br>";

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

            $body1 ="<table class='table'><thead><tr><th scope='col'>All categores</th></tr></thead><tbody>";
            while ($row = $cat->fetch_array(MYSQLI_ASSOC)){
                $body1.= "<tr><td>".$row['category']."</td><td>
                        <form action=\"{$_SERVER["PHP_SELF"]}\" method=\"post\" class=\"form-horizontal\">
                            <input type=\"submit\" name=\"".$row['category']."\" class='btn btn-primary' id='createCat'
                            formaction=\"interests.php\" formmethod=\"post\" value='Add it to yours'>
                            <input type='text' type=\"text\" id=\"createCat\" name=\"createCat\" value='{$row['category']}' hidden>
                        </form>
                        </td></tr>";
            }

            $body1.=<<<END
            </tbody></table>
            
            <form action="{$_SERVER["PHP_SELF"]}" method="post" class="form-horizontal">
            <div class="form-group">                   
                <label for="createCat" class="control-label col-sm-3 col-sm-9"><h4>Create Category</h4></label>
                    <input type="text" id="createCat" name="createCat" class="form-control">
            </div>
            <div class="form-group col-sm-3 col-sm-push-3">
                <input type="submit" name="createCatSub" value="Create" class="form-control  btn btn-primary">
            </div>
            
        </form>
END;


        }
    }
    return $body1;
}