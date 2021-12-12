<?php
if(!$objSession->userdata('logged_in') || ($objSession->userdata('user_type')!=1) )
{
	echo "<script type='text/javascript' language='javascript'> alert('Invalid session. Please Login again.'); </script>";
	redirect('login', 'refresh');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <link href="<?= base_url() ?>common/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="<?= base_url() ?>common/js/jquery-3.3.1.min.js"></script>
    <script src="<?= base_url() ?>common/js/bootstrap.bundle.min.js"></script>
    <style>
        .mt-2 {
            margin-top: 2rem;
        }
        .float-right{
            padding: 1rem;
            float: right !important;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row mt-2">
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <a class="navbar-brand" href="#">Admin Console</a>
                    </div>
                    <ul class="nav navbar-nav">
                        <li><a href="<?= base_url() ?>index.php/admin">Users</a></li>
                    </ul>
                    <a class="float-right" href="<?= base_url() ?>index.php/login/logout">Logout</a>
                </div>
            </nav>
        </div>