<?php
require 'includes/db.php';
require 'includes/posts.php';

//Declare form varibles
$formTitle = 'Edit Post';
$state = 'Update';
$button = 'Update Post';

$conn = getDB();
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $post = getPost($conn, $_GET['id']);
    if ($post) {
        $postID = $post['id'];
        $title = $post['title'];
        $content = $post['content'];
        $state = $post['post_hash'];
    }
} else {
    $post = $_GET['id'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['state'] === $state) {
    $title = $_POST['title'];
    $content = $_POST['content'];

    $errors = validatePost($title, $content);

    if (empty($errors)) {
        $sql = "UPDATE
                posts
                SET
                title = ?,
                content = ?
                WHERE
                id = ?";

        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt !== false) {
            mysqli_stmt_bind_param($stmt, 'ssi', $title, $content, $postID);
            if (mysqli_stmt_execute($stmt)) {
                $title = '';
                $content = '';
                header("Location: post.php?id={$postID}");

            }
        } else {
            echo mysqli_error($conn);
        }
    }
}

?>


<?php require 'includes/header.php'?>
<?php if (is_string($post) || $post === null): ?>
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

<?php require 'includes/footer.php'?>