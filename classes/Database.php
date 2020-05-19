<?php

class Database
{

    public function getConn()
    {
        $db_host = "localhost";
        $db_name = "customcms";
        $db_user = "customcms_root";
        $db_password = "DKA9U4HNqrpS0qAF";

        $dsn = 'mysql:host=' . $db_host . ';dbname=' . $db_name . ';charset=utf8';
        try {
            $db = new PDO($dsn, $db_user, $db_password);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit;
        }

        return $db;

    }
}
