<!Doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport"
content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<link rel="stylesheet" href="<?php echo base_url().'assets/bootstrap/css/bootstrap.min.css';  ?>">
</head>
<body>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<section class="content">
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
                                <tbody class="text-center" >
                                <tr>
                                    <td colspan="2" align="center" class="company_td"><span class="comname"><?php echo html_escape($company_info[0]['company_name']);?></span><br>
                                     <?php echo  html_escape($company_info[0]['address']); ?>  <br>
                                        <?php echo  html_escape($company_info[0]['mobile']); ?><br>
                                        <?php echo  html_escape($company_info[0]['email']); ?> <br>
                                        <?php echo  html_escape($company_info[0]['website']); ?>
                                    </td>

                                </tr>

                                <tr>
                                    <td colspan="2" align="center" class="bb_2">
                                        <div><b><?php echo html_escape($customer_name);  ?></b></div>
                                        <?php if ($customer_address) { ?>
                                        <div>
                                            <?php echo html_escape($customer_address);  ?>
                                        </div>
                                        <?php } ?>

                                        <?php if ($customer_mobile) { ?>
                                        <div><b>
                                                <?php echo html_escape($customer_mobile);  ?>
                                                </b></div>
                                        <?php }

                                        if ($customer_email) { ?>
                                        <div><?php echo html_escape($customer_email);  ?> </div>
                                        <?php } ?>
                                    </td>

                                </tr>
                                <br>
                                <tr>
                                    <td align="left" width="50%">
                                        <div><strong><?php echo display('invoice_no') ?> :
                                            </strong>
                                            <?php echo html_escape($invoice_no);  ?>
                                        </div>
                                    </td>
                                    <td align="right" width="50%">
                                        <div>
                                            <?php echo html_escape($final_date);  ?>
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

                                <?php foreach ($invoice_all_data as $item){  ?>
                                <tr>
                                    <th class="width_110"><?php echo html_escape($item['product_name'].'-'.$item['product_model']) ; ?></th>
                                    <td><?php  echo html_escape($item['quantity']);?></td>
                                    <td><?php echo $item['rate']; ?></td>
                                    <td><?php echo $item['discount']; ?></td>
                                    <td><?php echo(($position == 0) ? $currency.''.$item['total_price'] : $item['total_price'].''.$currency) ?></td>
                                </tr>
                                <?php }  ?>

                                
                                <tr>
                                    <td align="left"><nobr></nobr></td>
                                    <td align="left" colspan="3"><nobr><?php echo display('service_charge') ?></nobr></td>
                                    <td align="right"><nobr><?php echo(($position == 0) ? $currency.''.$service_charge: $service_charge.''.$currency) ?></nobr></td>
                                </tr>
                                <tr>
                                    <td align="left"><nobr></nobr></td>
                                    <td align="left" colspan="3"><nobr><?php echo display('shipping_charge') ?></nobr></td>
                                    <td align="right"><nobr><?php echo(($position == 0) ? $currency.''.$shipping_charge : $shipping_charge .''.$currency) ?></nobr></td>
                                </tr>
                                <tr>
                                    <td align="left"><nobr></nobr></td>
                                    <td align="left" colspan="3"><nobr><?php echo display('discount') ?></nobr></td>
                                    <td align="right"><nobr><?php echo(($position == 0) ? $currency.''.$subTotal_discount : $subTotal_discount.''.$currency); ?></nobr></td>
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
                                                    echo(($position == 0) ? "$currency 0" : "0 $currency");
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
                                    <td align="right"><nobr><strong><?php echo(($position == 0) ? $currency.''.$total_amount : $total_amount.''.$currency) ?></strong></nobr></td>
                                </tr>
                                <tr>
                                    <td align="left"><nobr></nobr></td>
                                    <td align="left" colspan="3"><nobr><?php echo display('paid_ammount') ?></nobr></td>
                                    <td align="right"><nobr><?php echo(($position == 0) ? $currency.''.$paid_amount : $paid_amount.''.$currency) ?></nobr></td>
                                </tr>
                                <tr>
                                    <td align="left"><nobr></nobr></td>
                                    <td align="left" colspan="3"><nobr><?php echo display('due') ?></nobr></td>
                                    <td align="right"><nobr><?php echo(($position == 0) ? $currency.''.$due_amount : $due_amount.''.$currency) ?></nobr></td>
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
    </div>
</div>

</div>
</section> <!-- /.content -->
</div> <!-- /.content-wrapper -->
<input type="hidden" id="pos_place" value="<?php echo @$this->input->get('place',TRUE); ?>">
<input type="hidden" id="base_url" value="<?php echo base_url(); ?>">
<script src="<?php echo MOD_URL.'dashboard/assets/js/pos_invoice_html_redirect.js'; ?>"></script>
</body>
</html>

