<?php
/**
 * Created by PhpStorm.
 * User: apoorvmittal
 * Date: 4/28/18
 * Time: 1:40 PM
 */
session_start();
session_destroy();
header('Location: index.php');
exit;
