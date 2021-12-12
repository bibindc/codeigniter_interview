<?php
if (!$objSession->userdata('logged_in') || ($objSession->userdata('user_type') != 2)) {
    echo "<script type='text/javascript' language='javascript'> alert('Invalid session. Please Login again.'); </script>";
    redirect('login', 'refresh');
}
$sub = array(
    1 => 'Story',
    2 => 'Comment',
    3 => 'Poll'
);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <link href="<?= base_url() ?>common/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link href="<?= base_url() ?>common/css/customer.css" rel="stylesheet" >
    <script src="<?= base_url() ?>common/js/jquery-3.3.1.min.js"></script>
    <script src="<?= base_url() ?>common/js/bootstrap.bundle.min.js"></script>
   
</head>

<body>
    <div class="container">
        <div class="row mt-2">
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <a class="navbar-brand" href="#">Consumer Portal</a>
                    </div>
                    <ul class="nav navbar-nav">
                        <li><a href="<?= base_url() ?>index.php/customer">Data (subscribed for <?= $sub[$objSession->userdata('user_subscribe')] ?>)</a></li>
                    </ul>
                    <a class="float-right" href="<?= base_url() ?>index.php/login/logout">Logout</a>
                </div>
            </nav>
        </div>