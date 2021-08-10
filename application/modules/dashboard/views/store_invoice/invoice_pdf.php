<?php

date_default_timezone_set(DEF_TIMEZONE);
 $date = date('Y-m-d'); ?>
<!-- Invoice pdf start -->
<link href="<?php echo MOD_URL.'dashboard/assets/css/pdf.css'; ?>" rel="stylesheet" type="text/css"/>
<table class="table">
	<thead>
		{company_info}
		<tr>
			<th colspan="9"><center><h2> {company_name}</h2></center></th>
		</tr>
		<tr>
			<th colspan="9"><center>{address}</center></th>
		</tr>
		<tr>
			<th colspan="9"><center>PHONE : {mobile}</center></th>
		</tr>
		{/company_info}
		<tr>
			<th colspan="3">&nbsp;</th>
			<th colspan="3"><span class="memo">MEMO</span></th>
			<th colspan="3"><?php 
$s = date("M-d-Y g:i:s A", time());  ?></th>
		</tr>
		<tr>
			<th>Date </th>
			<th>:</th>
			<th><?php echo $date; ?></th>
			<th colspan="3" class="text-right">Invoice No &nbsp; : &nbsp; {invoice_no}</th>
			<th colspan="3" class="text-right">Memo No &nbsp; : &nbsp; {invoice_id}</th>
		</tr>
		<tr>
			<th>Customer Name </th>
			<th>:</th>
			<th colspan="7" class="text-left">{customer_name}</th>
		</tr>
		<tr>
			<th >Address </th>
			<th>:</th>
			<th colspan="7" class="text-left">{customer_address}</th>
		</tr>

	</thead>
</table>
<table border="1" width="100%" class="tbl_pdf">
	<thead>
		<tr>
			<th>Sl</th>
			<th>Item Information</th>
			<th>Total Quantity</th>
			<th>Rate</th>
			<th>Amount</th>
		</tr>
	</thead>
	<tbody>
	{invoice_all_data}
		<tr>
			<td>{sl}</td>
			<td>{product_name}&nbsp; &nbsp; {product_model}</td>
			<td>{quantity}</td>
			<td>{rate}</td>
			<td>{total_price}</td>
		</tr>
	{/invoice_all_data}
	</tbody>
	<tfoot>
		<tr>
			<td>&nbsp;</td>
			<td class="text-right"><b>Grand total:</b></td>		
			<td><b>{subTotal_quantity}</b></td>		
			<td>&nbsp;</td>			
			<td class="text-right"><b>{total_amount}</b></td>
		</tr>
	</tfoot>
</table>

<table border="0" width="97%" class="tbl_pdf2">
	<thead>
		<tr>
			<th>
				<div  class="prepared_by">
					Prepared By
				</div>
			</th>
			<th>
				<div  class="prepared_by">
					Received By
				</div>
			</th>
			<th>
				<div  class="prepared_by">
					Checked By
				</div>
			</th>
			<th>
				<div  class="prepared_by">
					Authorised By
				</div>
			</th>
		</tr>
	</thead>
</table>
<!-- Invoice pdf end -->