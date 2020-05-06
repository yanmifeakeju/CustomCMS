<?php
require 'includes/db.php';
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
} else {
    $id = 0;
}
$sql = "SELECT id, title, content
        FROM posts
        WHERE id = $id";

$query = mysqli_query($conn, $sql);

if ($query === false) {
    echo mysqli_error($conn);
} else {
    $post = mysqli_fetch_assoc($query);
}
$formTitle = 'Edit Post';
$postID = $post['id'];
$title = $post['title'];
$content = $post['content'];
$button = 'Update Post';

if (isset($_POST['update'])) {

    $content = $_POST['content'];
    $title = $_POST['title'];

    $sql = "UPDATE posts
          SET
                title = '$title',
                content = '$content'
          WHERE
                id = $postID";
    $query = mysqli_query($conn, $sql);

    if ($query === false) {
        echo mysqli_error($conn);
    } else {
        $title = '';
        $content = '';
        header("Location: post.php?id={$postID}");
    }
}

?>


<?php require 'includes/header.php'?>

<?php require 'includes/form.php'?>

<?php require 'includes/footer.php'?>