<?php
require '../includes/init.php';

if (!Auth::isLoggedIn()) {
    header('Location: ../login.php?error=sign');
}

//Make database connection
$conn = require '../includes/db.php';

//Check the id is set in the GET method
if (isset($_GET['id'])) {
    $post = Post::getPostByID($conn, $_GET['id']);

    //Check if post is valid.
    if (!$post) {
        $post = null;
    }
}

//Declare form variables
$formTitle = 'Edit Post';
$button = 'Update Post';

$postCategories = array_column($post->getCategories($conn), 'id');

$categories = Category::getAll($conn);

//Check if request to update post has been made
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $post->title = $_POST['title'];
    $post->content = $_POST['content'];

    $category_ids = $_POST['categories'] ?? [];

    if ($post->update($conn)) {
        $post->setCategories($conn, $category_ids);
        header("Location: post.php?id={$post->id}");

    }

}

?>


<?php require '../includes/header.php'?>
<?php require '../includes/nav.php';?>
<?php if (!$post): ?>
    <div class="container postsContainer">
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title"><?="No record of post with id: " . htmlspecialchars($_GET['id'])?></h5>
            </div>
        </div>
    </div>
<?php else: ?>

    <?php require 'includes/form.php'?>

<?php endif;?>

<?php require '../includes/footer.php'?>