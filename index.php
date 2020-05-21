<?php
require 'includes/init.php';

$conn = require 'includes/db.php';
$posts = Post::getAll($conn);

?>

<?php require 'includes/header.php';?>

<div class="container postsContainer">
  <div id="posts">
    <?php if (!empty($posts)): ?>

      <?php foreach ($posts as $post): ?>
        <div class="card mb-3">
          <div class="card-body">
            <h4 class="card-title"><?=htmlspecialchars($post['title'])?></h4>
            <p class="card-text"><?=htmlspecialchars($post['content'])?></p>
            <?php if (Auth::isLoggedIn()): ?>
            <a href="post.php?id=<?=$post['id']?>&key=<?=$post['post_hash']?>" class="card-link">
              <i class="fa fa-eye"></i>
            </a>
            <?php endif;?>
          </div>
        </div>
      <?php endforeach;?>
    <?php else: ?>
      <div class="card mb-3">
        <div class="card-body">
          <h5 class="card-title">No article found</h5>
        </div>
      </div>
    <?php endif;?>

  </div>
</div>
<?php require 'includes/footer.php'?>