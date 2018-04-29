<?php
function generatePage($body, $title="Events", $css="", $includeBootstrap=true) {
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
</html>
EOPAGE;

    echo $page;
}

function createEventCards($name, $start, $end, $id) {
    if ($start["minute"] == '0') {
        $start["minute"] = "00";
    } 
    if ($start["month"]%10 == $start["month"]) {
        $start["month"] = "0".$start["month"];
    }
    if ($start["day"]%10 == $start["day"]) {
        $start["day"] = "0".$start["day"];
    }
    if ($end["minute"] == '0') {
        $end["minute"] = "00";
    } 
    if ($end["month"]%10 == $start["month"]) {
        $end["month"] = "0".$start["month"];
    }
    if ($end["day"]%10 == $start["day"]) {
        $end["day"] = "0".$start["day"];
    }
   $body= <<<BODY
 <div class="card w-75" id=$id>
      <div class="card-body" >
        <h5 class="card-title">$name</h5>
        <p class="card-text">Start Time:{$start["month"]}/{$start["day"]}/{$start["year"]}, {$start["hour"]}:{$start["minute"]} &nbsp; End Time: {$end["month"]}/{$end["day"]}/{$end["year"]}, {$end["hour"]}:{$end["minute"]} &nbsp; Event ID: $id</p>
        <input type="submit" value="Yes" onclick = "addEventEntry($name, $id)" class="btn btn-primary">&nbsp;
         <input type="submit" value="No" onclick = "removeEntry($id)" class="btn btn-primary"> 
        <br> <strong id= $id> </strong>
      </div>
 </div>
BODY;
   return $body;
}

