<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!doctype html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap -->
  <link href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet" type="text/css"/>

  <title>Password Reset</title>
</head>
<body>
 <div class="container">
   <div class="row justify-content-center align-items-center">
    <div class="col-md-8 col-md-offset-2">
      <!-- Alert Message -->
    <?php
        $message = $this->session->flashdata('message');
        if (isset($message)) {
    ?>
    <div class="alert alert-info alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <?php echo $message ?>                    
    </div>
    <?php 
        }
        $error_message = $this->session->flashdata('error_message');
        if (isset($error_message)) {
    ?>
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <?php echo $error_message ?>                    
    </div>
  <?php } ?>

    <div class="panel panel-default">
      <div class="panel-heading">
        Reset Password
        <a class="btn btn-success ft_right" href="<?php  echo base_url(); ?>">Go Back</a>

      </div>
      <div class="panel-body">
       <?php echo form_open('password_update',array('class' => 'form-vertical', 'id' => 'password_update','name' => 'password_update'))?> 

        <div class="form-group row">
          <label for="password" class="col-sm-4 col-form-label">New Password</label>
          <div class="col-sm-8">
            <input type="password" class="form-control" name="password" id="password" placeholder="Password">
            <input type="hidden" name="token" value="<?php echo html_escape($token);?>">
          </div>
        </div>
        <div class="form-group row">
          <label for="password" class="col-sm-4 col-form-label"></label>
          <div class="col-sm-8">
            <input type="submit" class="btn btn-success" value="Submit">
          </div>
        </div>
        <?php echo form_close()?>
      
    </div>
  </div>
  </div>
  </div>
  <!-- jQuery -->
  <script src="<?php echo base_url('assets/js/jquery.min.js') ?>" type="text/javascript"></script>

  <script src="<?php echo base_url('assets/js/popper.min.js') ?>" type="text/javascript"></script>
    <!-- Bootstrap -->
  <script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js') ?>" type="text/javascript"></script>

</body>
</html>