<?php

require '../includes/init.php';

if (!Auth::isLoggedIn()) {
    header('Location: ../login.php?error=sign');
}

//Check the id is set in the GET method
if (isset($_GET['id'])) {
    //Make database connection
    $conn = require '../includes/db.php';
    $post = Post::getPostByID($conn, $_GET['id']);

    //Check if post is valid.
    if (!$post) {
        $post = null;
    }
}

//Check if request to update post has been made
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $previous_image = $post->post_img;
    if ($post->setImageFile($conn, null)) {

        if ($previous_image) {
            unlink("../uploads/{$previous_image}");
        }

        header("Location: post.php?id={$post->id}");

    }
}

?>


<?php require '../includes/header.php';?>
<?php require '../includes/nav.php';?>
<div class="mx-auto text-center card text-white bg-warning mb-3" style="max-width: 18rem;">


    <?php if (!empty($post) && $post !== null): ?>
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
<?php require '../includes/footer.php';?>