<?php

function generatePage($body, $title="Example") {
    $page = <<<EOPAGE
<!doctype html>
<!doctype html>
<html>
    <head> 
        <meta charset="utf-8" />
        <title>$title</title>
<<<<<<< HEAD
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">	
=======
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" >
>>>>>>> a994e0e4ec650e7389b99328123b5a19493fd5be
    </head>
            
    <body>
        <div class="container-fluid">
            $body
        </div>
    </body>
</html>
EOPAGE;

    return $page;
}

function connectToDB($host, $user, $password, $database) {
    $db = mysqli_connect($host, $user, $password, $database);
    if (mysqli_connect_errno()) {
        echo "Connect failed.\n".mysqli_connect_error();
        exit();
    }
    return $db;
}

?>