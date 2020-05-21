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

<div class="container postsContainer">
  <div id="posts">
    <?php if ($post): ?>
      <div class="card mb-3">
        <div class="card-body">
          <h4 class="card-title"><?=htmlspecialchars($post->title)?></h4>
          <p class="card-text"><?=htmlspecialchars($post->content)?></p>
          <?php if (Auth::isLoggedIn()): ?>
            <a href="editpost.php?id=<?=$post->id?>&key=<?=$post->post_hash?>" class="card-link">
              <i class="fa fa-pencil"></i>
            </a>
            <a href="deletepost.php?id=<?=$post->id?>&key=<?=$post->post_hash?>" class="card-link">
              <i class="fa fa-remove"></i>
            </a>
          <?php endif;?>
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