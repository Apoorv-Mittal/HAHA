<?php
$host = "localhost";
$user = "admin";
$password = "terps";
$database = "phaha";


	function queryForDB($query)
    {
        /* Connecting to the database */
        global $host, $user, $password, $database;
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
    }

    function get_events($email)
    {
        $categories = "Select category From interests Where email = $email";
        $public_view = "Create view public_events as
                        Select event_id, start_time, end_time
                        From events e inner join event_dates ed
                        Where type = public and category = some($categories)";
        $private_view = "Create view private_events as
                        Select event_id, start_time, end_time 
                        From events inner join event_dates
                        Where type = private and owner_email = $email";
        $query = "Select *
                  From private_events pr, public_events pu
                  Where pr.type = weekly and pr.week_day = pu.week_day or
	              Pr.type = one_day and pr.date = pu.date";

    }

