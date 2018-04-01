<?php
	function queryForDB($query)
    {
        $host = "localhost";
        $user = "admin";
        $password = "terps";
        $database = "phaha";
        /* Connecting to the database */
        $db_connection = new mysqli($host, $user, $password, $database);
        if ($db_connection->connect_error) {
            die($db_connection->connect_error);
        }

        /* Executing query */
        $result = $db_connection->query($query);
        if (!$result) {
            die("Insertion failed: " . $db_connection->error);
        }
        /* Closing connection */
        $db_connection->close();
        return $result;
    }



