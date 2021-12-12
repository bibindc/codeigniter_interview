<div class="row text-center">
    <h3>Update Users</h3>
    <p><?= $error ? $error : ''; ?></p>
</div>
<div class="row mt-2">
    <?php if (validation_errors()) { ?>
        <div class="alert alert-danger fade in">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <?php echo validation_errors(); ?>
        </div>
    <?php } ?>
    <?= form_open_multipart('admin/do_user_update', ['id' => 'user_form', 'class' => 'needs-validation', 'novalidate' => ""]) ?>
    <div class="col-md-6">
        <div class="form-group row">
            <label for="fname" class="col-sm-4 col-form-label">First Name:</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" name="fname" id="fname" value="<?= $user[0]->US_FirstName ?>">
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group row">
            <label for="lname" class="col-sm-4 col-form-label">Last Name:</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" name="lname" id="lname" value="<?= $user[0]->US_LastName ?>">
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group row">
            <label for="country" class="col-sm-4 col-form-label">Country:</label>
            <div class="col-sm-8">
                <select class="form-control" name="country" id="country">
                    <option value="">Select</option>
                    <?php foreach ($countries as $con) {
                        $sel = $user[0]->US_Country == $con->country_name ? 'selected' : '';
                        echo "<option value='$con->country_name' $sel >$con->country_name</option>";
                    } ?>
                </select>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group row">
            <label for="phone" class="col-sm-4 col-form-label">Phone (UK):</label>
            <div class="col-sm-8">
                <input type="tel" class="form-control" name="phone" id="phone" value="<?= $user[0]->US_Phone ?>">
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group row">
            <label for="email" class="col-sm-4 col-form-label">Email address:</label>
            <div class="col-sm-8">
                <input type="email" class="form-control" name="email" id="email" value="<?= $user[0]->US_Email ?>">
            </div>
        </div>
    </div>
    <!-- <div class="col-md-6">
        <div class="form-group row">
            <label for="pwd" class="col-sm-4 col-form-label">Password:</label>
            <div class="col-sm-8">
                <input type="password" class="form-control" name="pwd" id="pwd">
            </div>
        </div>
    </div> -->
    <div class="col-md-6">
        <div class="form-group row">
            <label for="dob" class="col-sm-4 col-form-label">DOB</label>
            <div class="col-sm-8">
                <input type="date" class="form-control" name="dob" id="dob" value="<?= $user[0]->US_Dob ?>">
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group row">
            <label for="subscribe" class="col-sm-4 col-form-label">Subscribe:</label>
            <div class="col-sm-8">
                <select class="form-control" name="subscribe" id="subscribe">
                    <option value="1" <?= $user[0]->US_Subscription == 1 ? 'selected' : '' ?>>Story</option>
                    <option value="2" <?= $user[0]->US_Subscription == 2 ? 'selected' : '' ?>> Comment</option>
                    <option value="3" <?= $user[0]->US_Subscription == 3 ? 'selected' : '' ?>>Poll</option>
                </select>
            </div>
        </div>
    </div>
    <!-- <div class="col-md-6">
        <div class="form-group row">
            <label for="user_status" class="col-sm-4 col-form-label">Status:</label>
            <div class="col-sm-8">
                <select class="form-control" name="user_status" id="user_status">
                    <option value="">Select</option>
                    <option value="1">Pending</option>
                    <option value="2">Approove</option>
                    <option value="3">Block</option>
                </select>
            </div>
        </div>
    </div> -->
    <div class="col-md-6">
        <input type="hidden" name="user_id" value="<?= $user[0]->US_Id ?>" />
        <button type="submit" class="btn btn-primary">Submit</button>
        <a class="btn btn-warning" href="<?= base_url() ?>index.php/admin">Back</a>
    </div>

</div>