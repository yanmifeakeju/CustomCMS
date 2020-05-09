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
                WHERE id = ?";

    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt !== false) {
        mysqli_stmt_bind_param($stmt, 'i', $id);

        if (mysqli_stmt_execute($stmt)) {
            $post = mysqli_stmt_get_result($stmt);
            return mysqli_fetch_array($post, MYSQLI_ASSOC);
        }
    } else {
        return null;
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
