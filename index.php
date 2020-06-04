<?php
require 'includes/init.php';
$conn = require 'includes/db.php';

$paginator = new Paginator($_GET['page'] ?? 1, 5, Post::getTotal($conn, true));
$posts = Post::getPage($conn, $paginator->limit, $paginator->offset, true);

// var_dump($posts);
// exit;
?>

<?php require 'includes/header.php';?>
<?php require 'includes/nav.php';?>
<div class="container postsContainer">
  <?php if (!empty($posts)): ?>

    <?php foreach ($posts as $post): ?>
      <div class="card mb-3">
        <div class="card-body">
          <h4 class="card-title"><?=htmlspecialchars($post['title'])?></h4>

          <?php if ($post['category_names']): ?>

          <ul class="list-group list-group-horizontal">
            <?php foreach ($post['category_names'] as $category): ?>
             <li class="list-group-item"><?=($category) ? $category : 'Uncategorised'?></li>
          <?php endforeach;?>
          </ul>
          <?php endif;?>
          <time datetime="<?=$post['published_at']?>">
            <?php $datetime = new DateTime($post['published_at'])?>
            <?="Published At: " . "<strong>" . $datetime->format("j F, y") . "</strong>"?>
          </time>
          <br>
            <br>

          <p class="card-text"><?=htmlspecialchars($post['content'])?></p>
          <a href="post.php?id=<?=$post['id']?>&key=<?=$post['post_hash']?>" class="card-link">
            <i class="fa fa-eye"></i>
          </a>
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
  <?php require 'includes/pagination.php'?>
</div>
<?php require 'includes/footer.php'?>