<div class="container">
  <div class="card card-body card-form mt-5">
    <?php if (!empty($post->getErrors())): ?>

      <div class="alert alert-warning">
        <ul>
          <?php foreach ($post->getErrors() as $error): ?>
            <li><?=$error?></li>
          <?php endforeach;?>
        </ul>
      </div>

    <?php endif;?>
    <form action="" method="post">
      <h1><?=$formTitle?></h1>
      <div class="form-group">
        <input name="title" type="text" id="title" class="form-control" placeholder="Post Title" value="<?=htmlspecialchars($post->title)?>">
      </div>
      <fieldset>
        <legend>Categories</legend>
        <?php foreach ($categories as $cateogry): ?>
          <div class="form-check form-check-inline">
            <input
             name="categories[]"
             class="form-check-input"
             type="checkbox"
             id="<?=$cateogry['name']?>" value="<?=$cateogry['id']?>"
            <?=in_array($cateogry['id'], $postCategories) ? 'checked' : ''?>
      >
            <label class="form-check-label" for="<?=($cateogry['name'])?>"><?=ucfirst(htmlspecialchars($cateogry['name']))?></label>
          </div>
        <?php endforeach;?>
      </fieldset>
      <div class="form-group">
        <textarea name="content" id="content" class="form-control" placeholder="Write A Post" style="height:500px;"><?=htmlspecialchars($post->content)?></textarea>
      </div>
      <input name="state" type="hidden" id="id" value="<?=($post->post_hash) ? $post->post_hash : 'Add'?>">

      <button name="submit" class="post-submit btn btn-primary btn-block"><?=$button?></button>
    </form>
  </div>
</div>