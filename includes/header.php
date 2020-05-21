<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://bootswatch.com/4/cosmo/bootstrap.min.css">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
  <link rel="stylesheet" href="/css/style.css">
  <title>CustomCMS</title>
</head>

<body>
  <nav class="navbar navbar-dark bg-primary mb-3">
    <div class="container">
      <a href="index.php" class="navbar-brand">CustomCMS</a>
      <ul class="nav nav-tab justify-content-end">
        <?php if (Auth::isLoggedIn()): ?>
          <li class="nav-item">
            <a class="nav-link" href="newpost.php">Write a Post</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="logout.php">Log Out</a>
          </li>
          <?php else: ?>
            <li class="nav-item">
            <a class="nav-link" href="login.php">Login</a>
          </li>
        <?php endif;?>

      </ul>
    </div>
  </nav>

  <!-- <div class='navbar navbar-fixed-top'>
  <nav class='navbar-inner header'>
    <div class='container'>
      <div class='brand'>
        IN THE CLOUDS <i class="fa fa-cloud" style="text-shadow: 1px 1px white, -1px -1px #666;"></i>
      </div>
      <ul class='nav pull-right'>
        <li>
          <a class='nav-link'>
            TUTORIALS
          </a>
        </li>
        <li>
          <a class='nav-link'>
            MODELS
          </a>
        </li>
        <li>
          <a class='nav-link'>
            PLACES
          </a>
        </li>
        <li class='dropdown'>
          <a class='dropdown-toggle nav-link' data-toggle='dropdown'>
            DROP
            <ul class='dropdown-menu text-center'>
              <li>
                <a>
                  Example 1
                </a>
              </li>
              <li>
                <a>
                  Example 2
                </a>
              </li>
              <li>
                <a>
                  Example 3
                </a>
              </li>
            </ul>
          </a>
        </li>
      </ul>
      <div class='triangle-down center'>
        <p>
          <i class='fa fa-chevron-down fa-2x isDown' id='toggle'></i>
        </p>
      </div>
    </div>
  </nav -->