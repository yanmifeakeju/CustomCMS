<?php

/**
 * Undocumented class
 */
class Post
{
    public $id;
    public $title;
    public $content;
    public $post_img;
    public $post_hash;
    public $created_at;
    public $published_at;

    protected $errors = [];

    public static function getAll($conn)
    {

        $sql = "SELECT *
            FROM posts
            ORDER BY
                created_at
            DESC";

        $results = $conn->query($sql);
        return $results->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getPage($conn, $limit, $offset, $only_published = false)
    {
        $condition = $only_published ? " WHERE published_at IS NOT NULL" : '';

        $sql = "SELECT
                    a.*, categories.name as category_name
                FROM
                    (
                    SELECT
                        *
                    FROM
                        posts
                    $condition
                    ORDER BY
                        created_at
                    LIMIT :limit OFFSET :offset
                ) AS a
                LEFT JOIN posts_categories ON a.id = posts_categories.post_id
                LEFT JOIN categories ON posts_categories.category_id = categories.id";

        $stmt = $conn->prepare($sql);

        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // var_dump($result);
        // exit;

        $posts = [];

        $previous_id = null;

        foreach ($result as $row) {
            $post_id = $row['id'];

            if ($post_id != $previous_id) {
                $row['category_names'] = [];
                $posts[$post_id] = $row;
            }

            $posts[$post_id]['category_names'][] = $row['category_name'];

            $previous_id = $post_id;
        }

        return $posts;
    }

    public static function getTotal($conn, $only_published = false)
    {
        $condition = $only_published ? " WHERE published_at IS NOT NULL" : '';

        $total = $conn->query("SELECT COUNT(*) FROM posts{$condition}")->fetchColumn();
        return $total;
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

    public function publish($conn)
    {
        $sql = "UPDATE
                    posts
                SET published_at = :published_at
                WHERE
                    id = :id";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);

        $published_at = date("Y-m-d H:i:s");
        $stmt->bindValue(':published_at', $published_at, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return $published_at;
        } else {
            return 'false';
        }

    }
    public function getCategories($conn)
    {

        $sql = "SELECT
                        categories.*
                FROM
                        categories
                JOIN
                        posts_categories
                ON
                        categories.id = posts_categories.category_id
                WHERE
                        post_id = :id";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getWithCategories($conn, $id, $only_published = false)
    {
        $sql = "SELECT
                        posts.*, categories.name as category_name
                FROM
                        posts
                LEFT JOIN
                        posts_categories
                ON
                        posts.id = posts_categories.post_id
                LEFT JOIN
                        categories
                ON
                        categories.id = posts_categories.category_id
                WHERE
                        posts.id = :id";

        if ($only_published) {
            $sql .= " AND posts.published_at IS NOT NULL";
        }

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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

    public function setCategories($conn, $ids)
    {
        if ($ids) {
            $sql = "INSERT
                    IGNORE
                    INTO
                        posts_categories (post_id, category_id)
                    VALUES ";

            $values = [];
            foreach ($ids as $id) {
                $values[] = "({$this->id}, ?)";
            }

            $sql .= implode(", ", $values);

            $stmt = $conn->prepare($sql);

            foreach ($ids as $i => $id) {

                $stmt->bindValue($i + 1, $id, PDO::PARAM_INT);

            }
            $stmt->execute();
        }

        $sql = "DELETE
                FROM
                    posts_categories
                WHERE
                    post_id = {$this->id}";

        if ($ids) {
            $placeholders = array_fill(0, count($ids), '?');

            $sql .= " AND
                        category_id
                    NOT IN
                    (" . implode(", ", $placeholders) . ")";
        }

        $stmt = $conn->prepare($sql);

        foreach ($ids as $i => $id) {

            $stmt->bindValue($i + 1, $id, PDO::PARAM_INT);

        }

        $stmt->execute();

        return;

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
    public function setImageFile($conn, $filename)
    {
        $sql = "UPDATE posts
                SET post_img = :post_img
                WHERE id = :id";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':post_img', $filename, $filename === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $stmt->bindValue(':id', $this->id);

        return $stmt->execute();
    }
}
