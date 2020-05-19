<?php
require 'classes/Database.php';
require 'classes/Post.php';
require 'includes/auth.php';

session_start();
if (!isLoggedIn()) {
    header('Location: login.php?error=unauthorised');
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $db = new Database();
    $conn = $db->getConn();
    $post = Post::getPostByID($conn, $_GET['id'], 'id, post_hash');

}
if ($post) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' & $post->post_hash === $_GET['key']) {
        if ($post->deletePost($conn)) {
            header("Location: index.php");
        }
    }
}

?>

<?php require 'includes/header.php';?>
<div class="mx-auto text-center card text-white bg-warning mb-3" style="max-width: 18rem;">


    <?php if ($post && ($post->post_hash) === $_GET['key']): ?>
        <div class="card-header">Are you sure?</div>
        <div class="card-body">
            <form class="" action="" method="post">
                <a class="btn btn-secondary mr-1" href="post.php?id=<?=$post->id?>&key=<?=$post->post_hash?>">Cancel</a>
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
<?php require 'includes/footer.php';?>