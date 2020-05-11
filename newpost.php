<?php
require 'includes/auth.php';

session_start();
if (!isLoggedIn()) {

    header('Location: login.php?error=unauthorised');
}
require 'includes/posts.php';

$formTitle = 'New Post';
$title = '';
$content = '';
$button = 'Add Post';
$state = 'Add';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['state'] === 'Add') {

    $title = $_POST['title'];
    $content = $_POST['content'];

    $errors = validatePost($title, $content);
    if (empty($errors)) {
        require 'includes/db.php';
        $conn = getDB();
        $sql = "INSERT
                INTO posts
                        SET title = ?,
                            content = ?";

        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt !== false) {

            mysqli_stmt_bind_param($stmt, 'ss', $title, $content);
            mysqli_stmt_execute($stmt);
            $id = mysqli_insert_id($conn);

            //Create unique post hash
            $salt = bin2hex(random_bytes($id));
            $post_hash = hash('sha256', $id);
            $sql = "UPDATE posts
                    SET post_hash = '$post_hash'
                        WHERE id = $id";
            $query = mysqli_query($conn, $sql);

            if ($query) {
                $title = $content = '';
                header("Location: post.php?id={$id}");
            } else {
                echo mysqli_error($conn);
            }

        } else {
            echo mysqli_stmt_error($stmt);
            echo ' erorr';
            exit;
        }
    }

}

?>


<?php require 'includes/header.php'?>

<?php require 'includes/form.php'?>

<?php require 'includes/footer.php'?>