<?php require 'includes/header.php' ?>
<div class="container">
<div class="card card-body card-form mt-5">
    <form action="">
      <h1>Say Something</h1>
      <p class="lead">What's on your mind?</p>
      <div class="form-group">
        <input type="text" id="title" class="form-control" placeholder="Post Title">
      </div>
      <div class="form-group">
        <textarea id="body" class="form-control" placeholder="Post Body"></textarea>
      </div>
      <input type="hidden" id="id" value="">
      <button class="post-submit btn btn-primary btn-block">Post It</button>
</form>
    </div>
    </div>
<?php  require 'includes/footer.php'?>