<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

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
    <link href="<?php echo MOD_URL.'dashboard/assets/css/print.css'; ?>" rel="stylesheet" type="text/css"/>
<div class="panel-body">
<div bgcolor='#e4e4e4' text='#ff6633' link='#666666' vlink='#666666' alink='#ff6633' class='panel_body_div'>
    <table background='' bgcolor='#e4e4e4' width='100%' class='p_tb_20'
           cellspacing='0' border='0' align='center' cellpadding='0'>
        <tbody>
        <tr>
            <td>
                <table width='620' border='0' align='center' cellpadding='0' cellspacing='0'
                       bgcolor='#FFFFFF' class='bradius'>
                    <tbody>
                    <tr>
                        <td>
                            <table width='620' border='0' cellspacing='0' cellpadding='0'
                                   class='bb_1'>
                                <tbody>
                                <tr>
                                    <td align='left' valign='top'
                                        class='p_rl_5'>
                                        <table height='146' width='100%' border='0'
                                               cellpadding='3' cellspacing='3'
                                               class='b_right'>
                                            <tbody>
                                            <tr>
                                                <td valign='top'
                                                    class='tbl_td_css'>
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
                                    <td align='left' valign='top'
                                        class='p_rl_5'>
                                        <table height='146' width='100%' border='0'
                                               cellpadding='3' cellspacing='3'>
                                            <tbody>
                                            <tr>
                                                <td height='16' valign='top'
                                                    class='tbl_td_css2'>
                                                    <address>
                                                        <strong>{customer_name} </strong><br>
                                                        <abbr><?php echo display('address') ?>
                                                            :</abbr>
                                                        <?php if ($customer_address) { ?>
                                                            {customer_address}
                                                        <?php } ?>
                                                        <br>
                                                        <abbr><?php echo display('mobile') ?>
                                                            :</abbr>
                                                        <?php if ($customer_mobile) { ?>
                                                            {customer_mobile}
                                                        <?php }
                                                        if ($customer_email) { ?>
                                                            <br>
                                                            <abbr><?php echo display('email') ?>
                                                                :</abbr>
                                                            {customer_email}
                                                        <?php } ?>
                                                    </address>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                    <td align='left' valign='top'
                                        class='p_b_5p_b_5'>
                                        <table height='140' width='100%' border='0'
                                               cellpadding='3' cellspacing='3'>
                                            <tbody>
                                            <tr>
                                                <td height='10px' valign='top'
                                                    class='tbl_td_css3'>
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
                        <td valign='top'
                            class='tbl_td_css4'>
                            <p>
                                <section class='section_div'>
                                    <h3 align='center' class='invoice_text'>
                                        <span>INVOICE</span>
                                    </h3>
                                </section>
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td class='tbl_td_css5'>
                            <table width='100%' border='0' cellpadding='0' cellspacing='0'
                                   class='tbl_td_css6'>
                                <tbody>
                                <tr>
                                    <td>
                                        <table width='570' border='0' cellspacing='0'
                                               cellpadding='0'>
                                            <tbody>
                                            <tr>
                                                <td width='15'></td>

                                                <td width='10' align='center'
                                                    class='tbl_td_css7'>
                                                    <strong><?php echo display('sl') ?></strong>
                                                </td>

                                                <td width='100' align='center'
                                                    class='tbl_td_css7'>
                                                    <strong><?php echo display('product_name') ?></strong>
                                                </td>
                                                <td width='60' align='center'
                                                    class='tbl_td_css7'>
                                                    <strong><?php echo display('unit') ?></strong>
                                                </td>
                                                <td width='60' align='center'
                                                    class='tbl_td_css7'>
                                                    <strong><?php echo display('variant') ?></strong>
                                                </td>
                                                <td width='60' align='center'
                                                    class='tbl_td_css7'>
                                                    <strong><?php echo display('quantity') ?></strong>
                                                </td>
                                                <td width='60' align='center'
                                                    class='tbl_td_css7'>
                                                    <strong><?php echo display('rate') ?></strong>
                                                </td>
                                                <td width='60' align='center'
                                                    class='tbl_td_css7'>
                                                    <strong><?php echo display('discount') ?></strong>
                                                </td>
                                                <td width='60' align='center'
                                                    class='tbl_td_css7'>
                                                    <strong><?php echo display('ammount') ?></strong>
                                                </td>
                                            </tr>
                                            {invoice_all_data}
                                            <tr>
                                                <td width='15'></td>
                                                <td width='10' align='center' valign='top'
                                                    class='tbl_td_css8'>
                                                    {sl}
                                                </td>

                                                <td width='100' align='center' valign='top'
                                                    class='tbl_td_css8'>
                                                    {product_name} - ({product_model})
                                                </td>
                                                <td width='60' align='center' valign='top'
                                                    class='tbl_td_css8'>
                                                    {unit_short_name}
                                                </td>
                                                <td width='60' align='center' valign='top'
                                                    class='tbl_td_css8'>
                                                    {variant_name}
                                                </td>
                                                <td width='60' align='center' valign='top'
                                                    class='tbl_td_css8'>
                                                    {quantity}
                                                </td>
                                                <td width='60' align='center' valign='top'
                                                    class='tbl_td_css8'>
                                                    <?php echo(($position == 0) ? "$currency {rate}" : "{rate} $currency") ?>
                                                </td>
                                                <td width='60' align='center' valign='top'
                                                    class='tbl_td_css8'>
                                                    <?php echo(($position == 0) ? "$currency {discount}" : "{discount} $currency") ?>
                                                </td>
                                                <td width='60' align='center' valign='top'
                                                    class='tbl_td_css8'>
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
                        <td class='tbl_td_css5'>
                            <table width='0' border='0' align='left' cellpadding='0'
                                   cellspacing='0'>
                                <tbody>
                                <tr>
                                    <td>
                                        <p><strong>{invoice_details}</strong></p>
                                    </td>
                                </tr>
                                </tbody>
                            </table>

                            <table width='0' border='0' align='right' cellpadding='0'
                                   cellspacing='0'>
                                <tbody>
                                <tr>
                                    <td width='0' align='left' valign='top'
                                        class='tbl_td_css12'>
                                        <strong><?php echo display('discount') ?></strong>
                                    </td>
                                    <td width='100' align='right' valign='top'
                                        class='tbl_td_css12'>
                                        <?php echo(($position == 0) ? "$currency {subTotal_discount}" : "{subTotal_discount} $currency"); ?>
                                    </td>
                                </tr>

                                <?php
                                $this->db->select('a.*,b.tax_name');
                                $this->db->from('tax_collection_summary a');
                                $this->db->join('tax b', 'a.tax_id = b.tax_id');
                                $this->db->where('a.invoice_id', $invoice_id);
                                $this->db->where('a.tax_id', 'H5MQN4NXJBSDX4L');
                                $tax_info = $this->db->get()->row();

                                if ($tax_info) {
                                    ?>
                                    <tr>
                                        <td width='0' align='left' valign='top'
                                            class='tbl_td_css12'>
                                            <strong><?php echo html_escape($tax_info->tax_name) ?>
                                                :</strong>
                                        </td>
                                        <td width='100' align='right' valign='top'
                                            class='tbl_td_css12'>

                                            <?php
                                            if ($tax_info) {
                                                echo(($position == 0) ? $currency . " " . $tax_info->tax_amount : $tax_info->tax_amount . " " . $currency);
                                            } else {
                                                echo(($position == 0) ? "$currency 0" : "0 $currency");
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php }
                                $this->db->select('a.*,b.tax_name');
                                $this->db->from('tax_collection_summary a');
                                $this->db->join('tax b', 'a.tax_id = b.tax_id');
                                $this->db->where('a.invoice_id', $invoice_id);
                                $this->db->where('a.tax_id', '52C2SKCKGQY6Q9J');
                                $tax_info = $this->db->get()->row();
                                if ($tax_info) {
                                    ?>
                                    <tr>
                                        <td width='0' align='left' valign='top'
                                            class='tbl_td_css12'>
                                            <strong><?php echo html_escape($tax_info->tax_name) ?>
                                                :</strong>
                                        </td>
                                        <td width='100' align='right' valign='top'
                                            class='tbl_td_css12'>
                                            <?php
                                            if ($tax_info) {
                                                echo(($position == 0) ? $currency . " " . $tax_info->tax_amount : $tax_info->tax_amount . " " . $currency);
                                            } else {
                                                echo(($position == 0) ? "$currency 0" : "0 $currency");
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php }

                                $this->db->select('a.*,b.tax_name');
                                $this->db->from('tax_collection_summary a');
                                $this->db->join('tax b', 'a.tax_id = b.tax_id');
                                $this->db->where('a.invoice_id', $invoice_id);
                                $this->db->where('a.tax_id', '5SN9PRWPN131T4V');
                                $tax_info = $this->db->get()->row();

                                if ($tax_info) {
                                    ?>
                                    <tr>
                                        <td width='0' align='left' valign='top'
                                            class='tbl_td_css12'>
                                            <strong><?php echo html_escape($tax_info->tax_name) ?>
                                                :</strong>
                                        </td>
                                        <td width='100' align='right' valign='top'
                                            class='tbl_td_css12'>

                                            <?php
                                            if ($tax_info) {
                                                echo(($position == 0) ? $currency . " " . $tax_info->tax_amount : $tax_info->tax_amount . " " . $currency);
                                            } else {
                                                echo(($position == 0) ? "$currency 0" : "0 $currency");
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <?php if ($invoice_all_data[0]['service_charge'] != 0) { ?>
                                    <tr>
                                        <td align='left' valign='top'
                                            class='tbl_td_css12'>
                                            <strong><?php echo display('service_charge') ?>
                                                :</strong>
                                        </td>
                                        <td width='100' align='right' valign='top'
                                            class='tbl_td_css12'>
                                            <?php echo(($position == 0) ? "$currency {service_charge}" : "{service_charge} $currency") ?>
                                        </td>
                                    </tr>
                                <?php } ?>

                                <tr>
                                    <td align='left' valign='top'
                                        class='tbl_td_css12'>
                                        <strong><?php echo display('grand_total') ?>
                                            :</strong>
                                    </td>
                                    <td width='100' align='right' valign='top'
                                        class='tbl_td_css12'>
                                        <?php echo(($position == 0) ? "$currency {total_amount}" : "{total_amount} $currency") ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td align='left' valign='top'
                                        class='tbl_td_css16'>
                                        <strong><?php echo display('paid_ammount') ?>
                                            :</strong>
                                    </td>
                                    <td width='100' align='right' valign='top'
                                        class='tbl_td_css16'>
                                        <?php echo(($position == 0) ? "$currency {paid_amount}" : "{paid_amount} $currency") ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td align='left' valign='bottom'
                                        class='tbl_td_css14'>
                                        <strong><?php echo display('due') ?> :</strong>
                                    </td>
                                    <td width='100' align='right' valign='bottom'
                                        class='tbl_td_css15'>
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
<a class="btn btn-info" href="#" onclick="printPageDiv('printableArea')"><span
        class="fa fa-print"></span></a>
</div>
</div>
</div>
</div>
</section> <!-- /.content -->
</div> <!-- /.content-wrapper -->