<?php

function generatePage($body, $title="Events") {
    $page = <<<EOPAGE
<!doctype html>
<html>
     <head> 
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>$title</title>
    </head>
            
    <body>
    <div class="container-fluid">
            $body
    </div>
    </body>
</html>
EOPAGE;
    echo $page;
}
?>