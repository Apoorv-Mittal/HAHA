<?php
    $errors = array();
	function queryForDB($query)
    {
        global $errors;
        $host = "localhost";
        $user = "id4717175_admin";
        $password = "terps";
        $database = "id4717175_phaha";
        /* Connecting to the database */
        $db_connection = new mysqli($host, $user, $password, $database);

        if ($db_connection->connect_error) {
            echo $db_connection->connect_error;
            //die($db_connection->connect_error);
        }

        /* Executing query */
        $result = $db_connection->query($query);
        if (!$result) {
            $errors[] = $db_connection->error;
            $result = null;
        }
        /* Closing connection */
        $db_connection->close();
        return $result;
    }

    function getErrors() {
        global $errors;
        return $errors;
    }



