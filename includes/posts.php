<?php

/**
 * Retrieve post form DB using the ID
 *
 *
 * @param object $conn Connection to the database
 * @param integer $id the article ID
 * @param string $columns Optional list of columns for the select, defaults to *
 * @return mixed  An associative array containing the post with the ID, or null if not found
 */
function getPost($conn, $id, $columns = '*')
{
    $sql = "SELECT $columns
            FROM posts
                WHERE id = :id";

    $stmt = $conn->prepare($sql);

    $stmt->bindValue(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

/**
 * Validate post properties
 *
 * @param string $title Title, required
 * @param string $content Content, required.
 *
 * @return array an Array of validation error messages
 */
function validatePost($title, $content)
{
    $errors = [];

    if ($title == '') {
        $errors[] = 'Title is required';
    }

    if ($content == '') {
        $errors[] = 'Content is required';
    }

    return $errors;
}
