<?php

/**
 * @param $DBType
 * @param $DBUser
 * @param $DBPass
 * @param $DBServer
 * @param $DBName
 * @param $dsn_options
 * @return database connection
 */
function get_db_conn($DBType,$DBUser,$DBPass,$DBServer,$DBName,$dsn_options) {
    $dsn = "$DBType://$DBUser:$DBPass@$DBServer/$DBName$dsn_options";
    $conn = NewADOConnection($dsn);
    return $conn;
}

?>