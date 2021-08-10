<!---------================================
    Printable Page
    inline/interna css/js required here
=========================================-->
<?php
    $CI =& get_instance();
    $CI->load->model('Soft_settings');
    $Soft_settings = $CI->Soft_settings->retrieve_setting_editdata();
    $image =  $Soft_settings[0]['invoice_logo'];
    $invoice_logo = "my-assets/image/logo/".substr($image, strrpos($image, '/') + 1);

?>
<!-- Order pdf start -->
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&display=swap" rel="stylesheet">

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-bd">
            <div id="printableArea">
                <link href="<?php echo MOD_URL.'dashboard/assets/css/pdf.css'; ?>" rel="stylesheet" type="text/css"/>
                <div class="panel-body">
                    <div class="row h_200">
                        <div class="col-sm-8 inv_logo_div">
                            <img src="<?php if (isset($invoice_logo)) {echo getcwd().'/'.$invoice_logo; }?>" class="" alt="" class="inv_logo">
                            <br>
                            <span class="label label-success-outline m-r-15 p-10" ><?php echo display('order_to') ?></span>
                            {company_info}
                            <address class="mt_10">
                                <strong>{company_name}</strong><br>
                                {address}<br>
                                <abbr><b><?php echo display('mobile') ?>:</b></abbr> {mobile}<br>
                                <abbr><b><?php echo display('email') ?>:</b></abbr> 
                                {email}<br>
                                <abbr><b><?php echo display('website') ?>:</b></abbr> 
                                {website}
                            </address>
                            {/company_info}
                        </div>
                        
                        <div class="col-sm-4 text-left order_div">
                            <h2 class="m-t-0"><?php echo display('order') ?></h2>
                            <div><?php echo display('order_no') ?>: {order_no}</div>
                            <div><?php echo display('order_date') ?>: {final_date}</div>
                            <?php if(!empty($payinfo)){ ?>
                            <div><strong><?php echo display('payment_method') ?>: <?php echo (($payinfo['payment_id'] > 1)?ucfirst($payinfo['payment_method']):'Cash on Delivery') ?></strong></div>
                            <?php } ?>
                            <br>

                            <span class="label label-success-outline m-r-15"><?php echo display('order_from') ?></span>
                              <address class="mt_10"> 
                                  <strong>{customer_name} </strong><br>
                                    <abbr><?php echo display('address') ?>:</abbr>
                                    <?php if ($customer_address) { ?>
	                                <c class="m_p_0">{customer_address}</c>
	                                <?php }  ?><br>
                                    <abbr><?php echo display('mobile') ?>:</abbr><?php if ($customer_mobile) { ?>{customer_mobile}<?php }if ($customer_email) { ?>
                                    <br>
                                    <abbr><?php echo display('email') ?>:</abbr>{customer_email}
                                   	<?php } ?>
                            </address>
                        </div>
                    </div> <hr>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered cizgili" border="0" cellspacing="0" cellpadding="0">
                            <thead>
                                 <tr>
                                    <th><?php echo display('sl') ?></th>
                                    <th><?php echo display('product_name') ?></th>
                                    <th><?php echo display('variant') ?></th>
                                    <th><?php echo display('unit') ?></th>
                                    <th><?php echo display('quantity') ?></th>
                                    <th><?php echo display('rate') ?></th>
                                    <th><?php echo display('discount') ?></th>
                                    <th><?php echo display('ammount') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                {order_all_data}
                                <tr>
                                	<td>{sl}</td>
                                    <td><strong>{product_name} - ({product_model})</strong></td>
                                    <td>{variant_name}</td>
                                    <td>{unit_short_name}</td>
                                    <td>{quantity}</td>
                                    <td><?php echo (($position==0)?"$currency {rate}":"{rate} $currency") ?></td>
                                    <td><?php echo (($position==0)?"$currency {discount}":"{discount} $currency") ?></td>
                                    <td><?php echo (($position==0)?"$currency {total_price}":"{total_price} $currency") ?></td>
                                </tr>
                                {/order_all_data}
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 mt_10">
                        	<div class="details_div">
                                <p><strong>{details}</strong></p>
                            </div>

                            <div class="details_div2">

		                        <table class="table table-striped table-bordered cizgili" border="0" cellspacing="0" cellpadding="0">
		                            <?php if ($order_all_data[0]['discount'] != 0) {?>
	                            	<tr>
	                            		<th class="b1"><?php echo display('total_discount') ?> : </th>
	                            		<td><?php echo (($position==0)?"$currency {order_discount}":"{order_discount} $currency") ?> </td>
	                            	</tr>
		                            <?php } 
									$this->db->select('a.*,b.tax_name');
									$this->db->from('order_tax_col_summary a');
									$this->db->join('tax b','a.tax_id = b.tax_id');
									$this->db->where('a.order_id',$order_id);
									$this->db->where('a.tax_id','H5MQN4NXJBSDX4L');
									$tax_info = $this->db->get()->row();

									if ($tax_info) { ?>
			                    	<tr>
			                    		<th class="b1 total_cgst"><?php echo html_escape($tax_info->tax_name) ?> :</th>
			                    		<td class="total_cgst"><?php echo (($position==0)?$currency.$tax_info->tax_amount:$tax_info->tax_amount.$currency); ?>
			                    		</td>
			                    	</tr>
									<?php } 
									$this->db->select('a.*,b.tax_name');
									$this->db->from('order_tax_col_summary a');
									$this->db->join('tax b','a.tax_id = b.tax_id');
									$this->db->where('a.order_id',$order_id);
									$this->db->where('a.tax_id','52C2SKCKGQY6Q9J');
									$tax_info = $this->db->get()->row();

									if ($tax_info) { ?>
			                    	<tr>
			                    		<th class="b1 total_sgst"><?php echo html_escape($tax_info->tax_name) ?> :</th>
			                    		<td class="total_sgst"><?php echo (($position==0)?$currency.$tax_info->tax_amount:$tax_info->tax_amount.$currency);?>
			                    		</td>
			                    	</tr>
									<?php } 
									$this->db->select('a.*,b.tax_name');
									$this->db->from('order_tax_col_summary a');
									$this->db->join('tax b','a.tax_id = b.tax_id');
									$this->db->where('a.order_id',$order_id);
									$this->db->where('a.tax_id','5SN9PRWPN131T4V');
									$tax_info = $this->db->get()->row();

									if ($tax_info) {
									?>
			                    	<tr>
			                    		<th class="b1 total_igst"><?php echo html_escape($tax_info->tax_name) ?> :</th>
			                    		<td class="total_igst"><?php echo (($position==0)?$currency.$tax_info->tax_amount:$tax_info->tax_amount.$currency); ?>
			                    		</td>
			                    	</tr>
									<?php } ?>
                                    <?php if ($order_all_data[0]['service_charge'] != 0) {?>
                                    <tr>
                                        <th class="b1 service_charge"><?php echo display('service_charge') ?> :</th>
                                        <td class="service_charge"><?php echo (($position==0)?"$currency {service_charge}":"{service_charge} $currency") ?></td>
                                    </tr>
                                    <?php } ?>
	                            	<tr>
	                            		<th class="b1 grand_total"><?php echo display('grand_total') ?> :</th>
	                            		<td class="grand_total"><?php echo (($position==0)?"$currency {total_amount}":"{total_amount} $currency") ?></td>
	                            	</tr>
	                            	<tr>
	                            		<th class="b1"><?php echo display('paid_ammount') ?> : </th>
	                            		<td><?php echo (($position==0)?"$currency {paid_amount}":"{paid_amount} $currency") ?></td>
	                            	</tr>				 
		                            <?php if ($order_all_data[0]['due_amount'] != 0) { ?>
	                            	<tr>
	                            		<th class="b1" ><?php echo display('due') ?> : </th>
	                            		<td><?php echo (($position==0)?"$currency {due_amount}":"{due_amount} $currency") ?></td>
	                            	</tr>
	                            	<?php } ?>
	                            </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Order pdf end -->