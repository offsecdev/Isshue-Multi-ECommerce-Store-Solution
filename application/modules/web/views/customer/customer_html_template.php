<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo (isset($title)) ? $title : "Isshue Multistore System" ?></title>
        <?php
            $CI =& get_instance();
           
        ?>
        <link href="https://fonts.googleapis.com/css2?family=Alegreya+Sans:ital,wght@0,100;0,300;0,400;0,500;0,700;0,800;0,900;1,100;1,300;1,400;1,500;1,700;1,800;1,900&family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&display=swap" rel="stylesheet">
        <!-- Favicon and touch icons -->
        <link rel="shortcut icon" href="<?php if (isset($Soft_settings[0]['logo'])) {
               echo base_url().$Soft_settings[0]['favicon']; }?>" type="image/x-icon">
        <link rel="apple-touch-icon" type="image/x-icon" href="<?php echo base_url()?>assets/dist/img/ico/apple-touch-icon-57-precomposed.png">
        <link rel="apple-touch-icon" type="image/x-icon" sizes="72x72" href="<?php echo base_url()?>assets/dist/img/ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="<?php echo base_url()?>assets/dist/img/ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon" type="image/x-icon" sizes="144x144" href="<?php echo base_url()?>assets/dist/img/ico/apple-touch-icon-144-precomposed.png">
        <!-- Start Global Mandatory Style-->

        <!-- jquery-ui css -->
        <link href="<?php echo base_url()?>assets/plugins/jquery-ui/jquery-ui.min.css" rel="stylesheet" type="text/css"/>
        <!-- Bootstrap -->
        <link href="<?php echo base_url()?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url()?>assets/css/cmxform.css" rel="stylesheet" type="text/css"/>
        <?php
            if ($Soft_settings[0]['rtr'] == 1) {
        ?>
        <!-- Bootstrap rtl -->
        <link href="<?php echo base_url()?>assets/bootstrap-rtl/bootstrap-rtl.min.css" rel="stylesheet" type="text/css"/>
        <?php
            }
        ?>
        <!-- Font Awesome -->
        <link href="<?php echo base_url()?>assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
        <!-- Themify icons -->
        <link href="<?php echo base_url()?>assets/themify-icons/themify-icons.min.css" rel="stylesheet" type="text/css"/>
        <!-- Pe-icon -->
        <link href="<?php echo base_url()?>assets/pe-icon-7-stroke/css/pe-icon-7-stroke.css" rel="stylesheet" type="text/css"/>
        <!-- Data Tables -->
        <link href="<?php echo base_url()?>assets/plugins/datatables/dataTables.min.css" rel="stylesheet" type="text/css"/>
        <!-- Theme style -->
        <link href="<?php echo base_url()?>assets/dist/css/styleBD.min.css" rel="stylesheet" type="text/css"/>
        <!-- modals css -->
        <link href="<?php echo base_url()?>assets/plugins/modals/component.css" rel="stylesheet" type="text/css"/>
        <!-- Select2 min.css -->
        <link href="<?php echo base_url()?>assets/css/select2.min.css" rel="stylesheet" type="text/css"/>  
         <!-- Input tag css -->
        <link href="<?php echo base_url()?>assets/css/bootstrap-tagsinput.css" rel="stylesheet" type="text/css"/>
        <?php
            if ($Soft_settings[0]['rtr'] == 1) {
        ?>
        <!-- Theme style rtl -->
        <link href="<?php echo base_url()?>assets/dist/css/styleBD-rtl.css" rel="stylesheet" type="text/css"/>
        <?php
            }
        ?>
        <link href="<?php echo base_url()?>assets/dist/css/custom.css" rel="stylesheet" type="text/css"/>
        <!-- jQuery -->
        <script src="<?php echo base_url()?>assets/js/jquery.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url()?>assets/js/jquery.validate.min.js" type="text/javascript"></script>
        
        

    </head>
    <body class="hold-transition sidebar-mini <?php if (isset($sidebar_collapse)) { echo $sidebar_collapse;}?>" oncontextmenu="return false">
        <div class="se-pre-con"></div>
        <input type ="hidden" name="base_url" id="base_url" value="<?php echo base_url(); ?>">
        <input type ="hidden" name="CSRF_TOKEN" id="CSRF_TOKEN" value="<?php echo $this->security->get_csrf_hash(); ?>">
        <?php
        if(!empty($this->session->userdata('language'))){
            $language_id= $this->session->userdata('language');
        }else{
            $language_id= 'english';
        }
        ?>
        <input type ="hidden" name="language_id" id="language_id" value="<?php echo html_escape($language_id) ?>">
        <script src="<?php echo base_url() ?>assets/js/global_js.js" defer type="text/javascript"></script>

         <?php   

        if(!empty($this->session->userdata('language'))){
            $language_id= $this->session->userdata('language');
            
        }else{

            $language_id= 'english';
        }
     ?>


        <input type ="hidden" name="CSRF_TOKEN" id="CSRF_TOKEN" value="<?php echo $this->security->get_csrf_hash(); ?>">
        <input type ="hidden" name="language_id" id="language_id" value="<?php echo $language_id ?>">
        <!-- Site wrapper -->
        <div class="wrapper">
            <?php 
            $this->load->view('web/customer/include/customer_header');
            ?>
                <?php
                if(isset($template_lib) && !empty($template_lib)){ ?>
                    {content}
                <?php }else{
                 echo $this->load->view($module.'/'.$page);
                }?>
                
            <?php
            $this->load->view('web/customer/include/customer_footer');
            ?>
        </div>
        <!-- ./wrapper -->

        <!-- Start Core Plugins-->
        <!-- jquery-ui --> 
        <script src="<?php echo base_url()?>assets/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
        <!-- Bootstrap -->
        <script src="<?php echo base_url()?>assets/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <!-- SlimScroll -->
        <script src="<?php echo base_url()?>assets/plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <!-- FastClick -->
        <script src="<?php echo base_url()?>assets/plugins/fastclick/fastclick.min.js" type="text/javascript"></script>
        <!-- AdminBD frame -->
        <script src="<?php echo base_url()?>assets/dist/js/frame.min.js" type="text/javascript"></script>
        <!-- Sparkline js -->
        <script src="<?php echo base_url()?>assets/plugins/sparkline/sparkline.min.js" type="text/javascript"></script>
        <!-- Counter js -->
        <script src="<?php echo base_url()?>assets/plugins/counterup/waypoints.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url()?>assets/plugins/counterup/jquery.counterup.min.js" type="text/javascript"></script>
        <!-- dataTables js -->
        <script src="<?php echo base_url()?>assets/plugins/datatables/dataTables.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url()?>assets/plugins/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js" type="text/javascript"></script>
        <!-- Dashboard js -->
        <script src="<?php echo base_url()?>assets/dist/js/dashboard.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url()?>assets/js/select2.min.js" type="text/javascript"></script>
        <!-- Modal js -->
        <script src="<?php echo base_url()?>assets/plugins/modals/classie.js" type="text/javascript"></script>
        <script src="<?php echo base_url()?>assets/plugins/modals/modalEffects.js" type="text/javascript"></script>  
        <!-- Bootstrap tag inputs js -->
        <script src="<?php echo base_url()?>assets/js/bootstrap-tagsinput.js" type="text/javascript"></script>
        <!-- Summernote js -->
        <script src="<?php echo base_url()?>assets/plugins/summernote/summernote.min.js" type="text/javascript"></script>
        <script defer src="<?php echo MOD_URL.'web/assets/customer/customer_ajax.js'; ?>"></script>
        <!-- Custom js -->
        <script src="<?php echo base_url()?>my-assets/js/admin_js/custom.js" type="text/javascript"></script>
        <!-- Customer Panel JS -->
        <script src="<?php echo MOD_URL.'web/assets/js/customer_html_template.js'; ?>"></script>

    </body>
</html>