<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title><?php echo $title;?></title>

        <!-- Bootstrap -->
        <link href="<?php echo base_url();?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo base_url();?>assets/installer/css/style.css" rel="stylesheet">
    </head>
    <body>
        <div class="page-wrapper">
            <div class="content-wrapper">
                <div class="container"> 
                    <!-- begin of row -->
                    <div class="row"> 
                        <div class="box px-sm-15"> 
                            <div class="page-content">
                                <div class="outer-container">
                                    <div class="box-inner">
                                        <div class="inner">
                                            <img src="<?php echo base_url()?>assets/installer/img/004-startup.png" alt="">
                                            <div class="p_content">
                                                <h5>installer successfully deleted</h5>
                                                <p>please click the button to launch application.</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <a href="<?php echo base_url()?>" class="btn btn-success btn-right">Launch Now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.End of page wrapper -->
                    <footer class="footer text-center">
                        <div class="container">
                            <div class="fText">Developed by <a target="_blank" href="https://www.bdtask.com/">bdtask</a></div>
                        </div>
                    </footer>
                    <!-- /.End of footer -->
                </div> 
                
            </div>
        </div>
        <script src="<?php echo base_url()?>assets/js/jquery.min.js"></script>
        <script src="<?php echo base_url()?>assets/bootstrap/js/bootstrap.min.js"></script>
    </body>
</html>