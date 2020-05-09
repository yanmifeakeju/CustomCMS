<?php
$formTitle = 'New Post';
$title = '';
$content = '';
$button = 'Add Post';
$state = 'Add';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['state'] === 'Add') {
    if ($_POST['title'] !== '' && $_POST['content'] !== '') {
        require 'includes/db.php';
        $title = mysqli_escape_string($conn, $_POST['title']);
        $content = mysqli_escape_string($conn, $_POST['content']);
        $sql = "INSERT
                INTO posts
                        SET title = ?,
                            content = ?";

        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt !== false) {

            mysqli_stmt_bind_param($stmt, 'ss', $title, $content);
            mysqli_stmt_execute($stmt);
            $id = mysqli_insert_id($conn);
            $title = $content = '';
            header("Location: post.php?id={$id}");
        } else {

            echo mysqli_stmt_error($stmt);
            echo ' eror';
            exit;
        }
    } else {
        echo 'bull';
    }

}

?>


<?php require 'includes/header.php'?>

<?php require 'includes/form.php'?>

<?php require 'includes/footer.php'?>