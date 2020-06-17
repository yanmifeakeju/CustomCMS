<nav class="navbar navbar-dark bg-primary mb-3">
  <div class="container">
    <a href="/index.php" class="navbar-brand">CustomCMS</a>
    <ul class="nav nav-tab justify-content-end">
      <?php if (Auth::isLoggedIn()): ?>
        <li class="nav-item">
        <a class="nav-link" href="/admin/">Admin</a>
        </li>
        <li class="nav-item">

            <a class="nav-link" href="/admin/newpost.php">Write Post</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/logout.php">Log Out</a>
        </li>
      <?php else: ?>
        <li class="nav-item">
        <a class="nav-link" href="/admin/">Admin</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/contact.php">Contact Us</a>
        </li>
      <?php endif;?>

    </ul>
  </div>
</nav>