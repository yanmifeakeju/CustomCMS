<?php
require '../includes/init.php';

if (!Auth::isLoggedIn()) {

    header('Location: login.php?error=unauthorised');
}

//Declare form variables.

$formTitle = 'New Post';
$button = 'Add Post';
$state = 'Add';

$post = new Post();
$conn = require '../includes/db.php';

$postCategories = array_column($post->getCategories($conn), 'id');

$categories = Category::getAll($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['state'] === 'Add') {

    $post->title = $_POST['title'];
    $post->content = $_POST['content'];
    $postCategories = $_POST['categories'] ?? [];

    if ($post->create($conn)) {
        $post->setCategories($conn, $postCategories);
        header("Location: post.php?id={$post->id}&key={$post->post_hash}");
    }
}

?>


<?php require '../includes/header.php'?>
<?php require '../includes/nav.php';?>

<?php require 'includes/form.php'?>

<?php require '../includes/footer.php'?>