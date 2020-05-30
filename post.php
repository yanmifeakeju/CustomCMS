<?php
require 'includes/init.php';

$conn = require 'includes/db.php';

if (isset($_GET['id'])) {
    $post = Post::getPostByID($conn, $_GET['id']);
} else {
    $post = null;
}
?>

<?php require 'includes/header.php';?>
<?php require 'includes/nav.php';?>

<div class="container postsContainer">
  <div id="posts">
    <?php if ($post): ?>
      <div class="card mb-3">
        <div class="card-body">
          <h4 class="card-title"><?=htmlspecialchars($post->title)?></h4>
          <?php if ($post->post_img): ?>
            <div>
            <img src="/uploads/<?=$post->post_img?>" alt="" srcset="" width="200px">
            </div>
          <?php endif;?>
          <p class="card-text"><?=htmlspecialchars($post->content)?></p>
        </div>
      </div>
    <?php else: ?>
      <div class="card mb-3">
        <div class="card-body">
          <h5 class="card-title">No article found</h5>
        </div>
      </div>
    <?php endif;?>
  </div>
</div>

<?php require 'includes/footer.php';?>