<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<?php
    $CI =& get_instance();
    $CI->load->model('Soft_settings');
    $Soft_settings = $CI->Soft_settings->retrieve_setting_editdata();
?>
<footer class="main-footer">
    <strong>
    	<?php if (isset($Soft_settings[0]['footer_text'])) { echo htmlspecialchars_decode($Soft_settings[0]['footer_text']); }?>
   	</strong><i class="fa fa-heart color-green"></i>
</footer>