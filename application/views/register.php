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
        <div id="formContent2">
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

            <div class="Regform">
                <h4>Registration</h4>
                <?= form_open_multipart('login/do_signup', ['id' => 'reg_form', 'class' => 'needs-validation', 'novalidate' => ""]) ?>
                <input type="text" id="first_name" class="fadeIn second" name="first_name" placeholder="First Name" required>
                <input type="text" id="last_name" class="fadeIn second" name="last_name" placeholder="Last Name" required>
                <input type="email" id="user_email" class="fadeIn second" name="user_email" placeholder="Email Id" required>
                <input type="password" id="user_pass" class="fadeIn third" name="user_pass" placeholder="Password" required>
                <select id="country" class="fadeIn third" name="country">
                    <option value="">Select</option>
                    <?php foreach ($countries as $con) {
                        $sel = $con->id == 238 ? 'selected' : '';
                        echo "<option value='$con->country_name' $sel >$con->country_name</option>";
                    } ?>
                </select>
                <input type="text" id="phone" class="fadeIn second" name="phone" placeholder="Phone Number" required>
                <input type="date" id="dob" class="fadeIn second" name="dob" placeholder="DOB" required>
                <select id="subscription" class="fadeIn third" name="subscription">
                    <option value="1">Story</option>
                    <option value="2">Comment</option>
                    <option value="3">Poll</option>
                </select>
                <input type="submit" id="loginBtn" class="fadeIn fourth btn-success" value="Register">
                <p>Already have an account, Please <a href="<?= base_url() ?>" class="doLoginBtn">SignIn</a></p>
            </div>
        </div>
    </div>
</body>

</html>