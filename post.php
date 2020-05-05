<?php 
require 'includes/db.php';

if (isset($_GET['id']) && is_numeric($_GET['id']) ) {
  $id = $_GET['id'];
} else {
  $id = 0;
}
$sql = "SELECT id, title, content 
        FROM posts
        WHERE id = $id";

$query = mysqli_query($conn, $sql);

if ($query === false) {
  echo mysqli_error($conn);
} else {
  $post = mysqli_fetch_assoc($query);
}
?>

<?php require 'includes/header.php';  ?>

<div class="container postsContainer">
    <div id="posts">
      <?php if($post !== null): ?>
    <div class="card mb-3">
          <div class="card-body">
            <h4 class="card-title"><?= $post['title'] ?></h4>
            <p class="card-text"><?= $post['content'] ?></p>
            <a href="editpost.php?id=<?= $post['id']?>" class="card-link">
              <i class="fa fa-pencil"></i>
            </a>
            <a href="deletepost.php?id=<?= $post['id']?>"class="card-link" >
            <i class="fa fa-remove"></i>
          </a>
          </div>
        </div>
    <?php  else :?>
      <div class="card mb-3">
        <div class="card-body">
          <h5 class="card-title">No article found</h5>
        </div>
      </div>
    <?php endif;?>
<?php require 'includes/footer.php';?>