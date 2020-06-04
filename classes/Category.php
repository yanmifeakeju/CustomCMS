<?php

class Category
{
    public static function getAll($conn)
    {

        $sql = "SELECT *
            FROM categories
            ORDER BY
                name";

        $results = $conn->query($sql);
        return $results->fetchAll(PDO::FETCH_ASSOC);

    }

}
