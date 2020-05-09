<?php
require 'includes/db.php';
require 'includes/posts.php';
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $conn = getDB();
    $post = getPost($conn, $_GET['id'], 'id, post_hash');

}
if ($post) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' & $post['post_hash'] === $_GET['key']) {
        $sql = 'DELETE
                FROM posts
                WHERE id = ?
                AND post_hash = ?';

        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt !== false) {
            mysqli_stmt_bind_param($stmt, 'is', $post['id'], $post['post_hash']);

            if (mysqli_stmt_execute($stmt)) {
                header('Location: index.php');
            } else {
                echo mysqli_stmt_error($stmt);
            }
        } else {
            echo mysqli_error($conn);
        }

    }
}

?>

<?php require 'includes/header.php';?>
<div class="mx-auto text-center card text-white bg-warning mb-3" style="max-width: 18rem;">


    <?php if ($post && ($post['post_hash']) === $_GET['key']): ?>
        <div class="card-header">Are you sure?</div>
        <div class="card-body">
            <form class="" action="" method="post">
                <a class="btn btn-secondary mr-1" href="post.php?id=<?=$post['id']?>&key=<?=$post['post_hash']?>">Cancel</a>
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