-First display the ones you've checked (header text: Yours)
- then display the ones you haven't checked
- create new category
- return to user.php

<?php

require_once 'support.php';
require_once 'db.php';

session_start();
$email= $_SESSION['email'];

$result = queryForDB("select * from interests where email = ".$email);
$num_rows = $result->num_rows;
$row = $result->fetch_array(MYSQLI_ASSOC);
$i=0;
$body ="<table>";
for ($i=0;$i<$num_rows;$i++){
    $body.= "<tr><td>".$row['category']."</td><td><input type=\"submit\" name=\"".$row['category']."\" formaction=\"interests.php\" formmethod=\"post\"></td></tr>";
}

$body.="</table>";


generatePage($body,"Your Categories");