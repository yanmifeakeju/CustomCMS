<?php
require '../includes/init.php';

$conn = require '../includes/db.php';

if (isset($_GET['id'])) {
    $posts = Post::getWithCategories($conn, $_GET['id']);
} else {
    $post = null;
}
?>

<?php require '../includes/header.php';?>
<?php require '../includes/nav.php';?>

<div class="container postsContainer">
  <div id="posts">
    <?php if ($posts): ?>
      <div class="card mb-3">
        <div class="card-body">
          <h4 class="card-title"><?=htmlspecialchars($posts[0]['title'])?></h4>
          <?=($posts[0]['published_at']) ? htmlspecialchars($posts[0]['published_at']) : '<strong>Unpublished</br></br></strong>'?>
          <?php if ($posts[0]['post_img']): ?>
            <div>
              <img src="/uploads/<?=$posts[0]['post_img']?>" alt="" srcset="" width="200px">
            </div>
          <?php endif;?>
          <p class="card-text"><?=htmlspecialchars($posts[0]['content'])?></p>
          <?php if ($posts[0]['category_name']): ?>
            <span>Categories:</span>
          <ul class="list-group list-group-horizontal">
            <?php foreach ($posts as $post): ?>
             <li class="list-group-item"><?=$post['category_name']?></li>
          <?php endforeach;?>
          </ul>
          <?php endif;?>

          <?php if (Auth::isLoggedIn()): ?>
            <a href="editpost.php?id=<?=$posts[0]['id']?>" class="card-link">
              <i class="fa fa-pencil"></i>
            </a>
            <a href="deletepost.php?id=<?=$posts[0]['id']?>" class="card-link">
              <i class="fa fa-remove"></i>
            </a>
            <a href="edit-image.php?id=<?=$posts[0]['id']?>" class="card-link"><i class="fa fa-camera-retro"></i></a>
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

<?php require '../includes/footer.php';?>