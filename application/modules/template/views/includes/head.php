<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
<title><?php echo (isset($title)) ? $title : "Isshue Multistore System" ?></title>
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Alegreya+Sans:ital,wght@0,100;0,300;0,400;0,500;0,700;0,800;0,900;1,100;1,300;1,400;1,500;1,700;1,800;1,900&family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&display=swap" rel="stylesheet">

<?php
$CI =& get_instance();
$CI->load->model('dashboard/Color_backends');
$colors = $CI->Color_backends->retrieve_color_editdata();
?>
<!-- Favicon and touch icons -->
<link rel="shortcut icon" href="<?php echo base_url((!empty($setting['favicon'])?$setting['favicon']:'assets/img/icons/favicon.png')) ?>" type="image/x-icon">

<!-- Favicon and touch icons -->
<link rel="shortcut icon" href="<?php if (isset($Soft_settings[0]['logo'])) {
    echo base_url() . $Soft_settings[0]['favicon'];
} ?>" type="image/x-icon">
<link rel="apple-touch-icon" type="image/x-icon"
      href="<?php echo base_url() ?>assets/dist/img/ico/apple-touch-icon-57-precomposed.png">
<link rel="apple-touch-icon" type="image/x-icon" sizes="72x72"
      href="<?php echo base_url() ?>assets/dist/img/ico/apple-touch-icon-72-precomposed.png">
<link rel="apple-touch-icon" type="image/x-icon" sizes="114x114"
      href="<?php echo base_url() ?>assets/dist/img/ico/apple-touch-icon-114-precomposed.png">
<link rel="apple-touch-icon" type="image/x-icon" sizes="144x144"
      href="<?php echo base_url() ?>assets/dist/img/ico/apple-touch-icon-144-precomposed.png">
<!-- Start Global Mandatory Style-->
<!-- jquery-ui css -->
<link href="<?php echo base_url('assets/plugins/jquery-ui/jquery-ui.min.css') ?>" rel="stylesheet" type="text/css"/>

<!-- Bootstrap -->
<link href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css?v=0') ?>" rel="stylesheet" type="text/css"/>
<!-- Validator css -->
<link href="<?php echo base_url() ?>assets/css/cmxform.css" rel="stylesheet" type="text/css"/>
<!-- iCheck -->
<link href="<?php echo base_url() ?>assets/plugins/icheck/skins/all.css" rel="stylesheet" type="text/css"/>

<!-- Toastr -->
<link href="<?php echo base_url() ?>assets/plugins/toastr/toastr.css" rel="stylesheet" type="text/css"/>
<!-- Bootstrap rtl -->
<?php if (($setting['rtr'] == 1)) { ?>
    <link href="<?php echo base_url('assets/bootstrap-rtl/bootstrap-rtl.min.css') ?>" rel="stylesheet" type="text/css"/>
<?php } ?>

<!-- Font Awesome -->
<link href="<?php echo base_url('assets/font-awesome/css/font-awesome.min.css') ?>" rel="stylesheet" type="text/css"/>
<!-- Themify icons -->
<link href="<?php echo base_url('assets/css/themify-icons.css') ?>" rel="stylesheet" type="text/css"/>
<!-- Pe-icon -->
<link href="<?php echo base_url('assets/pe-icon-7-stroke/css/pe-icon-7-stroke.css') ?>" rel="stylesheet" type="text/css"/>
<!-- datatable -->
<link href="<?php echo base_url('assets/datatables/css/dataTables.min.css') ?>" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url() ?>assets/dist/css/styleBD.min.css" rel="stylesheet" type="text/css"/>
<!-- modals css -->
<link href="<?php echo base_url() ?>assets/plugins/modals/component.css" rel="stylesheet" type="text/css"/>
<!-- summernote css -->
<link href="<?php echo base_url() ?>assets/plugins/summernote/summernote.css" rel="stylesheet" type="text/css"/>
<!-- select2.min -->
<link href="<?php echo base_url('assets/css/select2.min.css') ?>" rel="stylesheet" type="text/css"/>
<!-- Input tag css -->
<link href="<?php echo base_url() ?>assets/css/bootstrap-tagsinput.css" rel="stylesheet" type="text/css"/>



<link href="<?php echo base_url('assets/css/flash.css') ?>" rel="stylesheet" type="text/css"/>
<!-- Lobipanel css -->
<link href="<?php  echo base_url('assets/css/lobipanel.min.css') ?>" rel="stylesheet" type="text/css"/>
<!-- Pace css -->
<!-- timepicker -->
<link href="<?php echo base_url('assets/css/jquery-ui-timepicker-addon.min.css') ?>" rel="stylesheet" type="text/css"/>
<!-- End Global Mandatory Style-->

<link href="<?php echo base_url('assets/dist/css/custom.css') ?>" rel="stylesheet" type="text/css"/>
<!-- Theme style rtl -->
<?php if (($setting['rtr'] == 1)) { ?>
	<link href="<?php echo base_url('assets/css/custom-rtl.min.css') ?>" rel="stylesheet" type="text/css"/>
<?php } ?>

<!-- Include module style -->
<?php
    $path = 'application/modules/';
    $map  = directory_map($path);
    if (is_array($map) && sizeof($map) > 0){
      $segment1 = $this->uri->segment(1);
    foreach ($map as $key => $value) {
      $keyval = preg_replace('/[^A-Za-z0-9\-]/', '', $key);
      if($segment1 == $keyval){
        $css  = str_replace("\\", '/', $path.$key.'assets/css/style.css');  
        if (file_exists($css)) {
            echo "<link href=".base_url($css)." rel=\"stylesheet\">";
        }
        } 
    }
    }   
?>


<!-- jQuery -->
<script src="<?php echo base_url('assets/js/jquery.min.js') ?>" type="text/javascript"></script>
<!-- jquery-ui --> 
<script src="<?php echo base_url('assets/plugins/jquery-ui/jquery-ui.min.js') ?>" type="text/javascript"></script>
<!-- Bootstrap -->
<script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js') ?>" type="text/javascript"></script>
<!-- Validate -->
<script src="<?php echo base_url() ?>assets/js/jquery.validate.min.js" type="text/javascript"></script>
<!-- Sweetalert -->
<script src="<?php echo base_url('assets/plugins/sweetalert/sweetalert2.all.js') ?>"></script>
<!-- Dynamic color -->
<?php $this->load->view('template/includes/color', array('colors' => $colors));?>


