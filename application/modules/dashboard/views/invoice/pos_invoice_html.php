<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
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
                    <table border="0" width="38%">
                        <tbody><tr>
                            <td>
                                <br><table class="table">
                                    <tbody><tr>
                                        
                                        <td colspan="2" align="center" class="bb_2"><span class="comname"><?php echo html_escape($company_info[0]['company_name']); ?></span><br>
                                <?php echo html_escape($company_info[0]['address']); ?><br>
                                <abbr><?php echo display('mobile') ?>:</abbr> 
                                <?php echo html_escape($company_info[0]['mobile']); ?><br>
                                <abbr><?php echo display('email') ?>:</abbr>
                                <?php echo html_escape($company_info[0]['email']); ?><br>
                                <abbr><?php echo display('website') ?>:</abbr>
                                <?php echo html_escape($company_info[0]['website']); ?>
                                        </td>
                                        
                                    </tr>

                                    <tr>
                                        <td align="left" class="width_50p">
                                            <div><b><?php echo html_escape($customer_name) ?></b></div>
                                            <?php if ($customer_address) { ?>
                                            <div>
                                                <?php echo html_escape($customer_address) ?>
                                            </div>
                                            <?php } ?>

                                            <?php if ($customer_mobile) { ?>
                                            <div><b>
                                            <?php echo html_escape($customer_mobile); ?>
                                                    </b></div>
                                            <?php }

                                            if ($customer_email) { ?>
                                            <div>   <?php echo html_escape($customer_email) ?></div>
                                            <?php } ?>
                                        </td>
                                        <td align="right" class="width_50p">
                                            <div><strong><?php echo display('invoice_no') ?>
                                                    </strong><br>
                                               <?php echo html_escape($invoice_no) ?> 
                                            </div>
                                            <div>
                                                <strong><?php echo display('date') ?>
                                                    </strong><br>
                                                <?php echo html_escape($final_date) ?>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody></table>

                                <table class="table">
                                    <tbody align="right">
                                    <tr>
                                        <th><?php echo display('product_name') ?></th>
                                        <th><?php echo display('quantity') ?></th>
                                        <th><?php echo display('rate') ?>(<?php echo $currency; ?>)</th>
                                        <th><?php echo display('discount') ?>(<?php echo $currency; ?>)</th>
                                        <th><?php echo display('total') ?></th>
                                    </tr>
                                    <?php foreach($invoice_all_data as $invoice){ ?>
                                    <tr>
                                        <th class="width_110"><?php echo html_escape($invoice['product_name']); ?> - (<?php echo html_escape($invoice['product_model']); ?>)</th>
                                        <td><?php echo html_escape($invoice['quantity']); ?></td>
                                        <td><?php echo html_escape($invoice['rate']); ?></td>
                                        <td><?php echo html_escape($invoice['discount']) ?></td>
                                        <td><?php echo(($position == 0) ? $currency." ".$invoice['total_price'] : $invoice['total_price']." ".$currency) ?></td>
                                    </tr>
                                   <?php } ?>
                                    
                                    <tr>
                                        <td align="left"><nobr></nobr></td>
                                        <td align="left" colspan="3"><nobr><?php echo display('service_charge') ?></nobr></td>
                                        <td align="right"><nobr><?php echo(($position == 0) ? $currency." ".$service_charge : $service_charge." ".$currency) ?></nobr></td>
                                    </tr>
                                    <tr>
                                        <td align="left"><nobr></nobr></td>
                                        <td align="left" colspan="3"><nobr><?php echo display('shipping_charge') ?></nobr></td>
                                        <td align="right"><nobr><?php echo(($position == 0) ? $currency." ".$shipping_charge : $shipping_charge." ". $currency) ?></nobr></td>
                                    </tr>
                                    <tr>
                                        <td align="left"><nobr></nobr></td>
                                        <td align="left" colspan="3"><nobr><?php echo display('discount') ?></nobr></td>
                                        <td align="right"><nobr><?php echo(($position == 0) ? $currency." ".$subTotal_discount : $subTotal_discount." ".$currency); ?></nobr></td>
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
                                        <td align="left"><nobr></nobr></td>
                                        <td align="left" colspan="3"><nobr><strong><?php echo html_escape($tax_info->tax_name) ?></strong></nobr></td>
                                        <td align="right"><nobr><strong> <?php
                                                    if ($tax_info) {
                                                        echo(($position == 0) ? $currency . " " . $tax_info->tax_amount : $tax_info->tax_amount . " " . $currency);
                                                    } else {
                                                        echo(($position == 0) ? $currency." "."0" : "0 $currency");
                                                    }
                                                    ?></strong></nobr></td>
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
                                        <td align="left"><nobr></nobr></td>
                                        <td align="left" colspan="3"><nobr><strong><?php echo html_escape($tax_info->tax_name) ?></strong></nobr></td>
                                        <td align="right"><nobr><strong><?php
                                                    if ($tax_info) {
                                                        echo(($position == 0) ? $currency . " " . $tax_info->tax_amount : $tax_info->tax_amount . " " . $currency);
                                                    } else {
                                                        echo(($position == 0) ? "$currency 0" : "0 $currency");
                                                    }
                                                    ?></strong></nobr></td>
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
                                        <td align="left"><nobr></nobr></td>
                                        <td align="left" colspan="3"><nobr><strong><?php echo html_escape($tax_info->tax_name) ?></strong></nobr></td>
                                        <td align="right"><nobr><strong><?php
                                                    if ($tax_info) {
                                                        echo(($position == 0) ? $currency . " " . $tax_info->tax_amount : $tax_info->tax_amount . " " . $currency);
                                                    } else {
                                                        echo(($position == 0) ? "$currency 0" : "0 $currency");
                                                    }
                                                    ?></strong></nobr></td>
                                    </tr>
                                    <?php } ?>

                                    <tr>
                                        <td align="left"><nobr></nobr></td>
                                        <td align="left" colspan="3"><nobr><strong><?php echo display('grand_total') ?></strong></nobr></td>
                                        <td align="right"><nobr><strong><?php echo(($position == 0) ? $currency." ".$total_amount : $total_amount." ".$currency) ?></strong></nobr></td>
                                    </tr>
                                    <tr>
                                        <td align="left"><nobr></nobr></td>
                                        <td align="left" colspan="3"><nobr><?php echo display('paid_ammount') ?></nobr></td>
                                        <td align="right"><nobr><?php echo(($position == 0) ? $currency." ".$paid_amount : $paid_amount." ".$currency) ?></nobr></td>
                                    </tr>
                                    <tr>
                                        <td align="left"><nobr></nobr></td>
                                        <td align="left" colspan="3"><nobr><?php echo display('due') ?></nobr></td>
                                        <td align="right"><nobr><?php echo(($position == 0) ? $currency." ".$due_amount : $due_amount." ".$currency) ?></nobr></td>
                                    </tr>
                                    </tbody></table>
                                <table width="100%">
                                    <tbody><tr class="mt_20">
                                        <td>
                                            <div class="sign sign_office"><?php echo display('sign_office') ?></div>
                                        </td>
                                        <td><div class="sign sign_office"><?php echo display('customer_sign') ?></div></td>
                                    </tr>
                                    <tr align="center">
                                        <td colspan="2"><?php echo display('thank_you_for_shopping_with_us')  ?></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        </tbody></table>
                </div>
            </div>

            <div class="panel-footer text-left">
                <a class="btn btn-danger"
                   href="<?php echo base_url('dashboard/Cinvoice'); ?>"><?php echo display('cancel') ?></a>
                <a class="btn btn-info" href="#" onclick="printPageDiv('printableArea')"><span class="fa fa-print"></span></a>
            </div>
        </div>
    </div>

</div>
</section> <!-- /.content -->
</div> <!-- /.content-wrapper -->
