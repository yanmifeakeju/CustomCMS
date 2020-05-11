<?php
require 'includes/auth.php';
session_start();

if (isset($_GET['error'])) {
    $error = 'Please log in .';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['username'] === 'akeju' && $_POST['password'] === 'dimdim') {
        $_SESSION['is_logged_in'] = true;

        session_regenerate_id();

        header('Location: index.php');
    } else {

        $error = "Incorrect login details. Sign Up if you don't have an account.";

    }
}
?>


<?php require 'includes/header.php'?>
<div class="container postsContainer">

    <form class="px-4 py-3" method="post">
        <?php if (isset($error) && $error !== ''): ?>
            <div class="alert alert-danger" role="alert">
                <?=$error?>
            </div>
        <?php endif?>
        <div class="form-group">
            <label for="username">Email address</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="Username">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
        </div>
        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="dropdownCheck">
            <label class="form-check-label" for="dropdownCheck">
                Remember me
            </label>
        </div>
        <button type="submit" class="btn btn-primary">Sign in</button>
    </form>
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="#">New around here? Sign up</a>
    <a class="dropdown-item" href="#">Forgot password?</a>
</div>
<?php require 'includes/footer.php'?>