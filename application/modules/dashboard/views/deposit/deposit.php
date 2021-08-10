<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="well">
	<div class="deposits_list" >Deposit list</div>
</div>
<?php
if(!empty($deposits_list)){
?>
<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>#</th>
			<th>Date</th>
			<th>Description</th>
			<th>Amout</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
	{deposits_list}
		<tr>
			<td>{sl}</td>
			<td>{final_date}</td>
			<td>{description}</td>
			<td>{amount}</td>
			<td>
				<center>
					<a href="<?php echo base_url().'cdeposit/deposit_update_form/{deposit_id}'; ?>"><i title="Edit" class="icon-edit"></i></a>
				</center>
			</td>
		</tr>
	{/deposits_list}
	</tbody>
</table>
<div id="pagin"><center>{links}</center></div>
<?php
}else{
?>
<div class="NoDataFound"><center>No Data Found</center></div>
<?php
}
?>
