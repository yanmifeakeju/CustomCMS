<div class="container">
  <div class="card card-body card-form mt-5">
    <?php if (!empty($errors)): ?>

      <div class="alert alert-warning">
        <ul>
          <?php foreach ($errors as $error): ?>
            <li><?=$error?></li>
          <?php endforeach;?>
        </ul>
      </div>

    <?php endif;?>
    <form action="" method="post">
      <h1><?=$formTitle?></h1>
      <div class="form-group">
        <input name="title" type="text" id="title" class="form-control" placeholder="Post Title" value="<?=htmlspecialchars($title)?>">
      </div>
      <div class="form-group">
        <textarea name="content" id="content" class="form-control" placeholder="Write A Post" style="height:500px;"><?=htmlspecialchars($content)?></textarea>
      </div>
      <input name="state" type="hidden" id="id" value="<?=$state?>">

      <button name="submit" class="post-submit btn btn-primary btn-block"><?=$button?></button>
    </form>
  </div>
</div>