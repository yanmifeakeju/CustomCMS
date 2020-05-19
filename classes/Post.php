<?php

/**
 * Undocumented class
 */
class Post
{
    public $id;
    public $title;
    public $content;
    public $post_hash;
    public $created_at;
    public $published_at;

    protected $errors = [];

    public static function getAll($conn)
    {
        $db = new Database();
        $conn = $db->getConn();

        $sql = "SELECT *
            FROM posts";

        $results = $conn->query($sql);
        return $results->fetchAll(PDO::FETCH_ASSOC);

    }

    /**
     * Retrieve post form DB using the ID
     *
     *
     * @param object $conn Connection to the database
     * @param integer $id the article ID
     * @param string $columns Optional list of columns for the select, defaults to *
     * @return mixed  An associative array containing the post with the ID, or null if not found
     */
    public static function getPostByID($conn, $id, $columns = '*')
    {
        $sql = "SELECT $columns
            FROM posts
                WHERE id = :id";

        $stmt = $conn->prepare($sql);

        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Post');

        if ($stmt->execute()) {

            return $stmt->fetch();
        }
    }

    public function create($conn)
    {

        $sql = "INSERT
                INTO
                    posts
                SET
                    title = :title,
                    content = :content";

        $stmt = $conn->prepare($sql);

        $stmt->bindValue(':content', $this->content, PDO::PARAM_STR);
        $stmt->bindValue(':title', $this->title, PDO::PARAM_STR);

        if ($this->validatePost()) {
            if ($stmt->execute()) {
                try {
                    $id = $conn->lastInsertID();
                    $post_hash = hash('sha256', $id);
                    $sql = "UPDATE
                                posts
                            SET
                                post_hash = :post_hash
                            WHERE
                                id = :id";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindValue(':post_hash', $post_hash, PDO::PARAM_STR);
                    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
                    $stmt->execute();
                    $this->id = $id;
                    $this->post_hash = $post_hash;
                    return true;
                } catch (PDOException $e) {
                    echo 'error';
                    exit;
                }

            }
        }

    }
    public function update($conn)
    {
        $sql = "UPDATE
                    posts
                SET
                    title = :title,
                    content = :content
                WHERE
                    id = :id";

        $stmt = $conn->prepare($sql);

        $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
        $stmt->bindValue(':content', $this->content, PDO::PARAM_STR);
        $stmt->bindValue(':title', $this->title, PDO::PARAM_STR);

        if ($this->validatePost()) {
            return $stmt->execute();
        } else {
            return false;
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
    protected function validatePost()
    {

        if ($this->title == '') {
            $this->errors[] = 'Title is required';
        }

        if ($this->content == '') {
            $this->errors[] = 'Content is required';
        }

        return empty($this->errors);
    }

    protected function delete($conn)
    {
        $sql = "DELETE
                FROM
                    posts
                WHERE
                    id = :id";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function deletePost($conn)
    {
        if ($this->delete($conn)) {
            return true;
        }
    }

}
