<?php
require 'includes/init.php';

if (!Auth::isLoggedIn()) {

    header('Location: login.php?error=unauthorised');
}

//Declare form variables.

$formTitle = 'New Post';
$button = 'Add Post';
$state = 'Add';

$post = new Post();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['state'] === 'Add') {
    $conn = require 'includes/db.php';

    $post->title = $_POST['title'];
    $post->content = $_POST['content'];

    if ($post->create($conn)) {
        header("Location: post.php?id={$post->id}&key={$post->post_hash}");
    }
}

?>


<?php require 'includes/header.php'?>

<?php require 'includes/form.php'?>

<?php require 'includes/footer.php'?>