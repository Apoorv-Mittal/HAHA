<?php
function generatePage($body, $title="Events") {
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
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" >
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

