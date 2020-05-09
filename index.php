<?php
require 'includes/db.php';

$conn = getDB();

$sql = "SELECT *
        FROM posts";

$query = mysqli_query($conn, $sql);

if ($query === false) {
    echo mysqli_error($conn);
} else {
    $posts = mysqli_fetch_all($query, MYSQLI_ASSOC);
}
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

  </div>
</div>
<?php require 'includes/footer.php'?>