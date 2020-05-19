<?php
require 'classes/Database.php';
require 'classes/Post.php';
require 'includes/auth.php';
session_start();

$db = new Database();
$conn = $db->getConn();
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
            <?php if (isLoggedIn()): ?>
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