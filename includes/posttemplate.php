<div class="container postsContainer">
    <div id="posts">
      <?php   var_dump($post) ?>
      <?php if(!empty($post)): ?>
    <div class="card mb-3">
          <div class="card-body">
            <h4 class="card-title"><?= $post['title'] ?></h4>
            <p class="card-text"><?= $post['content'] ?></p>
            <a href="post.php?id=<?= $post['id']?>" class="card-link">
              <i class="fa fa-pencil"></i>
            </a>
            <a href="post.php?id=<?= $post['id']?>"class="card-link" >
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