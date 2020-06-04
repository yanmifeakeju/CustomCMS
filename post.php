<?php
require 'includes/init.php';

$conn = require 'includes/db.php';

if (isset($_GET['id'])) {
    $posts = Post::getWithCategories($conn, $_GET['id'], true);

}
?>

<?php require 'includes/header.php';?>
<?php require 'includes/nav.php';?>

<div class="container postsContainer">
  <div id="posts">
    <?php if ($posts): ?>
      <div class="card mb-3">
        <div class="card-body">
          <h4 class="card-title"><?=htmlspecialchars($posts[0]['title'])?></h4>
          <time datetime="<?=$posts[0]['published_at']?>">
            <?php $datetime = new DateTime($posts[0]['published_at'])?>
            <?="Published At: " . "<strong>" . $datetime->format("j F, y") . "</strong>"?>
            <!-- <?=implode(" ", (explode(" ", $datetime->format("j F, y"))))?> -->
          </time>
          <?php if ($posts[0]['post_img']): ?>
            <div>
              <img src="/uploads/<?=$posts[0]['post_img']?>" alt="" srcset="" width="200px">
            </div>
          <?php endif;?>
          <p class="card-text"><?=htmlspecialchars($posts[0]['content'])?></p>
          <?php if ($posts[0]['category_name']): ?>
            <br>
          <ul class="list-group list-group-horizontal">
            <?php foreach ($posts as $post): ?>
             <li class="list-group-item"><?=$post['category_name']?></li>
          <?php endforeach;?>
          </ul>
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