<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php $this->load->view('includes/head') ?>
    </head>
    <body class="hold-transition sidebar-mini <?php echo (@$this->uri->segment(3)=='pos_invoice'?'sidebar-collapse':'') ?>">
        <!-- Site wrapper -->
        <div class="wrapper">
 <?php
    $url = $this->uri->segment(1);
    if ($url != "admin") {?>
            <header class="main-header">
           
         <?php     $this->load->view('includes/header');?>
   
             
            </header>
<?php } ?>
 
            <!-- Left side column. contains the sidebar -->
              <?php
    $url = $this->uri->segment(1);
    if ($url != "admin") {?>
            <aside class="main-sidebar color1">
                <!-- sidebar -->
              
        <?php  $this->load->view('includes/sidebar'); ?>
 
               
            </aside>
 <?php  } ?>

<?php echo $this->load->view($module.'/'.$page) ?>

<?php
    $url = $this->uri->segment(1);
    if ($url != "admin") {?>

            <footer class="main-footer color2">
                <div class="pull-right hidden-xs">
                    <?php echo (!empty($setting['address'])?htmlspecialchars_decode($setting['address']):null) ?> 
                </div>
                &copy; <?php echo date("Y"); ?>
                <strong>
                    <?php echo (!empty($setting['footer_text'])?htmlspecialchars_decode($setting['footer_text']):null) ?>
                </strong>
                    <a href="<?php echo current_url() ?>">
                    <?php echo (!empty($setting['title'])?htmlspecialchars_decode($setting['title']):null) ?></a>
            </footer>

            <?php }?>
        </div> <!-- ./wrapper -->
 
        <!-- Start Core Plugins-->
        <?php $this->load->view('includes/js') ?>
    </body>
</html>
