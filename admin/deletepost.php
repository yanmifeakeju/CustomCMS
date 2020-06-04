<?php
require '../includes/init.php';

if (!Auth::isLoggedIn()) {
    header('Location: ../login.php?error=unauthorised');
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $conn = require '../includes/db.php';
    $post = Post::getPostByID($conn, $_GET['id'], 'id, post_hash');

}
if ($post) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if ($post->deletePost($conn)) {
            header("Location: index.php");
        }
    }
}

?>

<?php require '../includes/header.php';?>
<?php require '../includes/nav.php';?>
<div class="mx-auto text-center card text-white bg-warning mb-3" style="max-width: 18rem;">


    <?php if ($post): ?>
        <div class="card-header">Are you sure?</div>
        <div class="card-body">
            <form class="" action="" method="post">
                <a class="btn btn-secondary mr-1" href="post.php?id=<?=$post->id?>">Cancel</a>
                <button class="btn btn-secondary">Delete</button>
            </form>
        </div>
    <?php else: ?>
        <div class="card-header">No record found</div>
        <div class="card-body">
            <h5 class="card-title">This post does not exist</h5>
            <p class="card-text"></p>
        </div>
    <?php endif;?>

</div>
<?php require '../includes/footer.php';?>