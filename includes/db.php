<?php

/**
 * Get database connection
 *
 * @return object Connection to a MySQL server
 */
function getDB()
{
    $db_host = "localhost";
    $db_name = "customcms";
    $db_user = "customcms_root";
    $db_password = "DKA9U4HNqrpS0qAF";

    $conn = mysqli_connect($db_host, $db_user, $db_password, $db_name);

    if (mysqli_connect_error()) {
        echo mysqli_connect_error();
        exit;
    }
    return $conn;
}
