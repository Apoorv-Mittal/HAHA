<?php
function generatePage($body, $title="Events", $css="", $includeBootstrap=true,$jsIncludes="") {
    $errorLogs = "";
    if (function_exists("getErrors")) {
        $errors = getErrors();
        if (count($errors) > 0) {
            $errorLogs = "<script>console.log(\"".implode(", '\\n',", $errors)."\")</script>";
        }
    }
    $bootstrap = $includeBootstrap ? '<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" >' : '';
    $page = <<<EOPAGE
<!doctype html>
<html>
    <head> 
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>$title</title>
        <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
        $bootstrap
        $css
        <style>
       html {
        height: 100%;
        }
        body {
        background-image: url("img/background.jpg");
        background-size: cover;
        background-repeat: no-repeat;
        background-color: #cccccc;
        }
        </style>
    </head>
            
    <body >
        <div class="container-fluid">
            $body
        </div>
        $errorLogs
    </body>
        $jsIncludes

</html>
EOPAGE;

    echo $page;
}


function createEventCards($name, $start, $end, $id, $email) {
    if ($start["minute"] == '0') {
        $start["minute"] = "00";
    } 
    if ($start["month"]%10 == $start["month"]) {
        $start["month"] = "0".$start["month"];
    }
    if ($start["hour"]%10 == $start["hour"]) {
        $start["hour"] = "0".$start["hour"];
    }
    if ($start["day"]%10 == $start["day"]) {
        $start["day"] = "0".$start["day"];
    }
    if ($end["minute"] == '0') {
        $end["minute"] = "00";
    } 
    if ($end["month"]%10 == $end["month"]) {
        $end["month"] = "0".$end["month"];
    }
    if ($end["hour"]%10 == $end["hour"]) {
        $end["hour"] = "0".$end["hour"];
    } 
    if ($end["day"]%10 == $end["day"]) {
        $end["day"] = "0".$end["day"];
    }
    $dummy = $start["minute"];

   $body= <<<BODY
 <div class="card w-75" id=$id>
      <div class="card-body" >
        <h5 class="card-title">$name</h5>
        <p class="card-text">Start Time: {$start["month"]}/{$start["day"]}/{$start["year"]}, {$start["hour"]}:{$start["minute"]} &nbsp; End Time: {$end["month"]}/{$end["day"]}/{$end["year"]}, {$end["hour"]}:{$end["minute"]} &nbsp; Event ID: $id</p>
        <input type="submit" value="Yes" onclick =  {addEventEntry($dummy,'$email',$id)}  class="btn btn-primary">&nbsp;
         <input type="submit" value="No" onclick = {removeEntry($dummy,$id)} class="btn btn-primary"> 

        <br> <strong id= $id> </strong>
      </div>
 </div>
BODY;
   return $body;
}

