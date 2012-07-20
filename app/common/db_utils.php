<?php

/**
 * @param $dsn
 * @return the database connection
 */
function get_db_conn($dsn) {
    return NewADOConnection($dsn);
}

?>