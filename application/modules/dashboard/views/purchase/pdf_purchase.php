<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Pdf view supplier  -->
<table class="table table-striped table-condensed table-bordered">
	<thead>
		<tr>
			<th colspan="2">Date :&nbsp;{final_date}</th>
			<th colspan="2">Name : &nbsp;<span class="fw_normal">{supplier_name}</span></th>
			<th>Invoice-No :&nbsp; {chalan_no}</th>
		</tr>
		<tr>
			<th colspan="5">&nbsp;</th>
		</tr>
		<tr>
			<th>#</th>
			<th>Product Name</th>
			<th>Total Quantity</th>
			<th>Rate</th>
			<th>Total Amount</th>
		</tr>
	</thead>
	<tbody>
	{purchase_all_data}
		<tr>
			<td>{sl}</td>
			<td>{product_name}</td>
			<td>{quantity}</td>
			<td>{rate}</td>
			<td>{total_amount}</td>
		</tr>
	{/purchase_all_data}
	</tbody>
	<tfoot>
		<tr>
			<td class="text-right" colspan="4"><b>Grand total:</b></td>
			<td class="text-right">{sub_total_amount}</td>
		</tr>
	</tfoot>
</table>
<!-- Pdf view supplier  -->
