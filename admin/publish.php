<?php
require '../includes/init.php';

if (!Auth::requireLogin()) {
    header('Location: ../login.php?error=sign');
}

$conn = require '../includes/db.php';
$post = Post::getPostByID($conn, $_POST['id']);
$published_at = $post->publish($conn);

?><?=$published_at?>
