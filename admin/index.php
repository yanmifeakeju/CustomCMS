<?php
require "../includes/init.php";

$conn = require '../includes/db.php';

$paginator = new Paginator($_GET['page'] ?? 1, 10, Post::getTotal($conn));
$posts = Post::getPage($conn, $paginator->limit, $paginator->offset);

if (!Auth::requireLogin()) {
    header('Location: ../login.php?error=sign');
}

?>
<?php require '../includes/header.php';?>
<?php require '../includes/nav.php';?>

<div class="container postsContainer" role="main">
  <table class="table">
    <thead>
      <tr>
        <th>Title</th>
        <th>Created at</th>
        <th>Published</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($posts as $post): ?>
      <tr data-href="post.php?id=<?=$post['id']?>">
        <td><?=htmlspecialchars($post['title'])?></td>
        <td><?=htmlspecialchars($post['created_at'])?></td>
        <td><?=($post['published_at']) ? htmlspecialchars($post['published_at']) : 'Unpublished'?></td>
      </tr>
      <?php endforeach;?>
    </tbody>
  </table>

  <?php require '../includes/pagination.php'?>
</div>
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const rows = document.querySelectorAll('tr[data-href]');
    rows.forEach(row => {
      row.addEventListener('click', ()=> {
        window.location.href = row.dataset.href;
      })
    })
  });
</script>
<?php require '../includes/footer.php'?>