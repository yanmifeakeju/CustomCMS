<?php
require 'includes/init.php';

$errors = [];
$message = '';
$subject = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        $errors[] = 'Please enter a valid email address';

    }

    if ($subject === '') {
        $errors[] = 'Please enter a subject';

    }

    if ($message === '') {
        $errors[] = 'Please enter a message';

    }

}

?>





<?php require 'includes/header.php'?>
<?php require 'includes/nav.php'?>
<div class="container">
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger" role="alert">
            <?php foreach ($errors as $error): ?>
                <ul>
                    <li><?=$error?></li>
                </ul>

            <?php endforeach;?>
            </div>

<?php endif;?>
<form class="px-4 py-3" method="post">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="username" name="email" placeholder="Email" value="<?=htmlspecialchars($email)?>">
        </div>
        <div class="form-group">
            <label for="subject">Subject</label>
            <input type="text" class="form-control" id="password" name="subject" placeholder="Subject" value="<?=htmlspecialchars($subject)?>">
        </div>
        <div class="form-group">
            <label for="message">Message</label>
            <textarea class="form-control" name="message" id="" cols="30" rows="10" placeholder="Message"><?=htmlspecialchars($message)?></textarea>

        </div>
        <button type="submit" class="btn btn-primary">Send</button>
    </form>

</div>


<?php require 'includes/footer.php'?>