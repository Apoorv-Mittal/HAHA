<?php
function generatePage($body, $title="Events", $css="") {
    $errorLogs = "";
    if (function_exists("getErrors")) {
        $errors = getErrors();
        if (count($errors) > 0) {
            $errorLogs = "<script>console.log(\"".implode(", '\\n',", $errors)."\")</script>";
        }
    }
    $page = <<<EOPAGE
<!doctype html>
<html>
    <head> 
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>$title</title>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" >
        $css
    </head>
            
    <body>
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
   $body= <<<BODY
 <div class="card w-75">
      <div class="card-body">
        <h5 class="card-title">$name</h5>
        <p class="card-text">Start Time:$start &nbsp; End Time: $end &nbsp; Event ID: $id</p>
        <input type="submit" value="Yes" class="yes" class="btn btn-primary">&nbsp; <input type="submit" value="No" class="yes" class="btn btn-primary"> 
      </div>
 </div>
BODY;
   return $body;
}

