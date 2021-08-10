<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!---------================================
Printable Page
inline/interna css/js required here
=========================================-->
<?php
$CI =& get_instance();
$CI->load->model('Soft_settings');
$Soft_settings = $CI->Soft_settings->retrieve_setting_editdata();
?>
<script src="<?php echo MOD_URL.'dashboard/assets/js/print.js'; ?>"></script>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
<div class="header-icon">
<i class="pe-7s-note2"></i>
</div>
<div class="header-title">
<h1><?php echo display('invoice_details') ?></h1>
<small><?php echo display('invoice_details') ?></small>
<ol class="breadcrumb">
<li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
<li><a href="#"><?php echo display('invoice') ?></a></li>
<li class="active"><?php echo display('invoice_details') ?></li>
</ol>
</div>
</section>
<!-- Main content -->
<section class="content">
<!-- Alert Message -->
<?php
$message = $this->session->userdata('message');
if (isset($message)) {
?>
<div class="alert alert-info alert-dismissable">
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
<?php echo $message ?>
</div>
<?php
$this->session->unset_userdata('message');
}
$error_message = $this->session->userdata('error_message');
if (isset($error_message)) {
?>
<div class="alert alert-danger alert-dismissable">
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
<?php echo $error_message ?>
</div>
<?php
$this->session->unset_userdata('error_message');
}
?>
<div class="row">
<div class="col-sm-12">
<div class="panel panel-bd">
<div id="printableArea">
<link href="<?php echo MOD_URL.'dashboard/assets/css/pos_quotation_html.css'; ?>" rel="stylesheet" type="text/css"/>
<div class="panel-body">
    <div bgcolor='#e4e4e4' text='#ff6633' link='#666666' vlink='#666666' alink='#ff6633' class="print_div">
        <table background='' bgcolor='#e4e4e4' width='100%' class="p_b_20" cellspacing='0' border='0' align='center' cellpadding='0'>
            <tbody>
            <tr>
                <td>
                    <table width='620' border='0' align='center' cellpadding='0' cellspacing='0'
                           bgcolor='#FFFFFF' class="bradius_5">
                        <tbody>
                        <tr>
                            <td>
                                <table class="bb_1" width='620' border='0' cellspacing='0' cellpadding='0'>
                                    <tbody>
                                    <tr>
                                        <td align='left' valign='top' class="p_b_5" >
                                            <table height='146' width='100%' border='0' cellpadding='3' cellspacing='3' class="br_1" >
                                                <tbody>
                                                <tr>
                                                    <td valign='top' class="cominfo">
                                                        {company_info}
                                                        <address class="mt_10">
                                                            <strong>{company_name}</strong><br>
                                                            {address}<br>
                                                            <abbr><?php echo display('mobile') ?>
                                                                :</abbr> {mobile}<br>
                                                            <abbr><?php echo display('email') ?>
                                                                :</abbr>
                                                            {email}<br>
                                                            <abbr><?php echo display('website') ?>
                                                                :</abbr>
                                                            {website}
                                                        </address>
                                                        {/company_info}
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                        <td align='left' valign='top' class="p_b_5" >
                                            <table height='146' width='100%' border='0'
                                                   cellpadding='3' cellspacing='3'>
                                                <tbody>
                                                <tr>
                                                    <td height='16' valign='top' class="cus_name">
                                                        <address>
                                                            <strong>{customer_name} </strong><br>
                                                            <abbr><?php echo display('address') ?>
                                                                :</abbr>
                                                            <?php
                                                            if ($customer_address) {
                                                                ?>
                                                                {customer_address}
                                                                <?php
                                                            }
                                                            ?>
                                                            <br>
                                                            <abbr><?php echo display('mobile') ?>
                                                                :</abbr>
                                                            <?php
                                                            if ($customer_mobile) {
                                                                ?>
                                                                {customer_mobile}
                                                                <?php
                                                            }
                                                            if ($customer_email) {
                                                                ?>
                                                                <br>
                                                                <abbr><?php echo display('email') ?>
                                                                    :</abbr>
                                                                {customer_email}
                                                                <?php
                                                            }
                                                            ?>
                                                        </address>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                        <td align='left' valign='top' class="pb_5">
                                            <table height='140' width='100%' border='0' cellpadding='3' cellspacing='3'>
                                                <tbody>
                                                <tr>
                                                    <td height='10px' valign='top' class="colpad">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td valign='top'>
                                                        <strong><?php echo display('invoice_no') ?>
                                                            :</strong>
                                                        {invoice_no}
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td valign='top'>
                                                        <strong><?php echo display('billing_date') ?>
                                                            :</strong>
                                                        {final_date}
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td valign='top' class="colpad2" >
                                <p>
                                    <section class="section_css">
                                        <h3 align='center' class="invoice_title">
                                            <span>INVOICE</span>
                                        </h3>
                                    </section>
                                </p>
                            </td>
                        </tr>

                        <tr>
                            <td class="colpad3">
                                <table width='100%' border='0' cellpadding='0' cellspacing='0' class="tbl_css">
                                    <tbody>
                                    <tr>
                                        <td>
                                            <table width='570' border='0' cellspacing='0'
                                                   cellpadding='0'>
                                                <tbody>
                                                <tr>
                                                    <td width='15'> 
                                                    </td>

                                                    <td width='10' align='left' class="sl_rowcss">
                                                        <strong><?php echo display('sl') ?></strong>
                                                    </td>

                                                    <td width='100' align='right' class="colpad4">
                                                        <strong><?php echo display('product_name') ?></strong>
                                                    </td>
                                                    <td width='60' align='right' class="colpad4">
                                                        <strong><?php echo display('quantity') ?></strong>
                                                    </td>
                                                    <td width='60' align='right'
                                                         class='colpad4'>
                                                        <strong><?php echo display('rate') ?></strong>
                                                    </td>
                                                    <td width='60' align='right'
                                                         class='colpad4'>
                                                        <strong><?php echo display('discount') ?></strong>
                                                    </td>
                                                    <td width='60' align='right'
                                                         class='colpad4'>
                                                        <strong><?php echo display('ammount') ?></strong>
                                                    </td>
                                                </tr>
                                                {invoice_all_data}
                                                <tr>
                                                    <td width='15'> 
                                                    </td>
                                                    <td width='10' align='left' valign='top'
                                                         class='colpad5'>
                                                        {sl}
                                                    </td>

                                                    <td width='100' align='right' valign='top'
                                                         class='colpad5'>
                                                        {product_name} - ({product_model})
                                                        {unit}
                                                    </td>
                                                    <td width='60' align='right' valign='top'
                                                         class='colpad5'>
                                                        {quantity}
                                                    </td>
                                                    <td width='60' align='right' valign='top'
                                                         class='colpad5'>
                                                        <?php echo(($position == 0) ? "$currency {rate}" : "{rate} $currency") ?>
                                                    </td>
                                                    <td width='60' align='right' valign='top'
                                                         class='colpad5'>
                                                        <?php echo(($position == 0) ? "$currency {discount}" : "{discount} $currency") ?>
                                                    </td>
                                                    <td width='60' align='right' valign='top'
                                                         class='colpad5'>
                                                        <?php echo(($position == 0) ? "$currency {total_price}" : "{total_price} $currency") ?>
                                                    </td>
                                                </tr>
                                                {/invoice_all_data}

                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>

                        <tr align='left'>
                            <td class="tbl_css2">
                                <table width='0' border='0' align='left' cellpadding='0'
                                       cellspacing='0'>
                                    <tbody>
                                    <tr>
                                        <td>
                                            <p>
                                                <strong><?php echo display('thank_you_for_choosing_us') ?></strong>
                                            </p>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>

                                <table width='0' border='0' align='right' cellpadding='0'
                                       cellspacing='0'>
                                    <tbody>
                                    <tr>
                                        <td width='0' align='left' valign='top' 
                                             class='colpad6'>
                                            <strong><?php echo display('discount') ?></strong>
                                        </td>
                                        <td width='100' align='right' valign='top'
                                             class='colpad7'>
                                            <?php echo(($position == 0) ? "$currency {subTotal_discount}" : "{subTotal_discount} $currency") ?>
                                        </td>
                                    </tr>


                                    <tr>
                                        <td width='0' align='left' valign='top'
                                             class='colpad6'>
                                            <strong><?php echo display('total_cgst') ?>
                                                :</strong>
                                        </td>
                                        <td width='100' align='right' valign='top'
                                             class='colpad7'>

                                            <?php
                                            $this->db->select('*');
                                            $this->db->from('tax_collection_summary');
                                            $this->db->where('invoice_id', $invoice_id);
                                            $this->db->where('tax_id', 'H5MQN4NXJBSDX4L');
                                            $tax_info = $this->db->get()->row();
                                            if ($tax_info) {
                                                echo(($position == 0) ? $currency . " " . $tax_info->tax_amount : $tax_info->tax_amount . " " . $currency);
                                            } else {
                                                echo(($position == 0) ? "$currency 0" : "0 $currency");
                                            }
                                            ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td width='0' align='left' valign='top'
                                             class='colpad6'>
                                            <strong><?php echo display('total_sgst') ?>
                                                :</strong>
                                        </td>
                                        <td width='100' align='right' valign='top'
                                             class='colpad7'>

                                            <?php
                                            $this->db->select('*');
                                            $this->db->from('tax_collection_summary');
                                            $this->db->where('invoice_id', $invoice_id);
                                            $this->db->where('tax_id', '52C2SKCKGQY6Q9J');
                                            $tax_info = $this->db->get()->row();
                                            if ($tax_info) {
                                                echo(($position == 0) ? $currency . " " . $tax_info->tax_amount : $tax_info->tax_amount . " " . $currency);
                                            } else {
                                                echo(($position == 0) ? "$currency 0" : "0 $currency");
                                            }
                                            ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td width='0' align='left' valign='top'
                                             class='colpad6'>
                                            <strong><?php echo display('total_igst') ?>
                                                :</strong>
                                        </td>
                                        <td width='100' align='right' valign='top'
                                             class='colpad7'>

                                            <?php
                                            $this->db->select('*');
                                            $this->db->from('tax_collection_summary');
                                            $this->db->where('invoice_id', $invoice_id);
                                            $this->db->where('tax_id', '5SN9PRWPN131T4V');
                                            $tax_info = $this->db->get()->row();
                                            if ($tax_info) {
                                                echo(($position == 0) ? $currency . " " . $tax_info->tax_amount : $tax_info->tax_amount . " " . $currency);
                                            } else {
                                                echo(($position == 0) ? "$currency 0" : "0 $currency");
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align='left' valign='top'
                                            class='colpad8'>
                                            <strong><?php echo display('grand_total') ?>
                                                :</strong>
                                        </td>
                                        <td width='100' align='right' valign='top'
                                            class='colpad7'>
                                            <?php echo(($position == 0) ? "$currency {total_amount}" : "{total_amount} $currency") ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td align='left' valign='top'
                                            class='colpad9'>
                                            <strong><?php echo display('paid_ammount') ?>
                                                :</strong>
                                        </td>
                                        <td width='100' align='right' valign='top'
                                            class='colpad7'>
                                            <?php echo(($position == 0) ? "$currency {paid_amount}" : "{paid_amount} $currency") ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align='left' valign='bottom'
                                            class='colpad10'>
                                            <strong><?php echo display('due') ?> :</strong>
                                        </td>
                                        <td width='100' align='right' valign='bottom'
                                            class='colpad11'>
                                            <strong><?php echo(($position == 0) ? "$currency {due_amount}" : "{due_amount} $currency") ?></strong>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
</div>

<div class="panel-footer text-left">
<a class="btn btn-danger"
   href="<?php echo base_url('Cinvoice'); ?>"><?php echo display('cancel') ?></a>
<a class="btn btn-info" href="#" onclick="printDiv('printableArea')"><span
            class="fa fa-print"></span></a>

</div>
</div>
</div>
</div>
</section> <!-- /.content -->
</div> <!-- /.content-wrapper -->