<?php

require '../includes/init.php';

if (!Auth::isLoggedIn()) {
    header('Location: ../login.php?error=sign');
}

//Check the id is set in the GET method
if (isset($_GET['id'])) {
    //Make database connection
    $conn = require '../includes/db.php';
    $post = Post::getPostByID($conn, $_GET['id']);

    //Check if post is valid.
    if (!$post) {
        $post = null;
    }
}

//Check if request to update post has been made
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    try {
        if (empty($_FILES)) {
            throw new Exception('Invalid Upload');
        }
        switch ($_FILES['file']['error']) {
            case UPLOAD_ERR_OK:
                break;

            case UPLOAD_ERR_NO_FILE:
                throw new Exception('No file uploaded');
                break;

            case UPLOAD_ERR_INI_SIZE:
                throw new Exception('File is too large for server');
                break;

            default:
                throw new Exception('An Error Occured');
                break;
        }

        if ($_FILES['file']['size'] > 1000000) {
            throw new Exception('File is too large');
        }

        $mime_types = ['image/gif', 'image/png', 'image/jpeg'];

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_file($finfo, $_FILES['file']['tmp_name']);

        if (!in_array($mime_type, $mime_types)) {
            throw new Exception('Invalid file type');
        }

        $pathinfo = pathinfo($_FILES['file']['name']);

        $base = $pathinfo['filename'];
        $base = preg_replace('/[^a-zA-Z0-9_-]/', '', $base);
        $base = mb_substr($base, 0, 200);
        $filename = $base . "." . $pathinfo['extension'];
        $destination = "../uploads/{$filename}";

        $i = 1;
        while (file_exists($destination)) {
            $filename = $base . "-$i." . $pathinfo['extension'];
            $destination = "../uploads/{$filename}";
            $i++;
        }

        if (move_uploaded_file($_FILES['file']['tmp_name'], $destination)) {
            $previous_image = $post->post_img;

            if ($post->setImageFile($conn, $filename)) {

                if ($previous_image) {
                    unlink("../uploads/{$previous_image}");
                }

                header("Location: post.php?id={$post->id}");

            }
        } else {
            throw new Exception('Unable to save file');
        }
    } catch (Exception $th) {

        $error = $th->getMessage();
    }
}

?>


<?php require '../includes/header.php'?>
<?php require '../includes/nav.php';?>
<div class="container postsContainer">
    <?php if (!$post): ?>
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title"><?="No record of post with id: " . htmlspecialchars($_GET['id'])?></h5>
            </div>
        </div>
    <?php else: ?>
        <div>
        <?php if ($post->post_img): ?>
            <div>
            <img src="/uploads/<?=$post->post_img?>" alt="" srcset="" width="200px">
            </div>
          <?php endif;?>
        </div>

        <form method="post" enctype="multipart/form-data">
        <?php if (isset($error)): ?>
        <div class="alert alert-warning">
            <?=$error?>
        </div>
        <?php endif;?>
        <h2>Update Image</h2>
            <div class="form-group">
                <label for="file">Upload Image</label>
                <input type="file" name="file" id="file" class="form-control-file">
            </div>
            <button class="btn btn-primary">Update</button>
            <?php if ($post->post_img): ?>
            <a href="delete-image.php?id=<?=$post->id?>" class="btn btn-primary">DELETE</a>
        <?php endif;?>
        </form>

    <?php endif;?>
</div>

<?php require '../includes/footer.php'?>