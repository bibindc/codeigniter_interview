<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <link href="<?= base_url() ?>common/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="<?= base_url() ?>common/js/jquery-3.3.1.min.js"></script>
    <script src="<?= base_url() ?>common/js/bootstrap.bundle.min.js"></script>
    <link href="<?= base_url() ?>common/css/custom.css" rel="stylesheet">
    <!------ Include the above in your HEAD tag ---------->
</head>

<body>
    <div class="wrapper fadeInDown">
        <div id="formContent">
            <!-- Tabs Titles -->

            <!-- Icon -->
            <div class="fadeIn first headcls p-4">
                <h2>Welcome to the application</h2>
            </div>
            <p class="text-warning"><?= $error ? $error : '' ?></p>
            <?php if (validation_errors()) { ?>
                <div class="alert alert-danger fade in">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <?php echo validation_errors(); ?>
                </div>
            <?php } ?>
            <!-- Login Form -->
            <div class="loginform">
                <h4>SignIn</h4>
                <?= form_open_multipart('login/do_login', ['id' => 'login_form', 'class' => 'needs-validation', 'novalidate' => ""]) ?>
                <input type="text" id="login_email" class="fadeIn second" name="login_email" placeholder="Login email" required>
                <input type="password" id="login_pass" class="fadeIn third" name="login_pass" placeholder="Password" required>
                <input type="text" id="login_captcha" class="fadeIn third" name="login_captcha" placeholder="Enter Captcha" required>
                <?php if($image){
                    echo "<img src='$image'/>";
                }?>
                <input type="submit" id="loginBtn" class="fadeIn fourth btn-primary" value="Log In">
                <p>If you don't have account, Please <a href="<?=base_url()?>index.php/login/register" class="doRegBtn">Register</a></p>
            </div>
            
        </div>
    </div>
</body>

</html>