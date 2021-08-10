<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Suppliers sales report start -->
<h3>Sales Report</h3>
<?php $today = date('Y-m-d'); ?>
	<div class="row-fluid">
		<div>
			<?php echo form_open('#', array('class' => 'well form-inline')); ?>
				<label class="select">Search By Date: From</label>
					<input type="text" name="from_date"  value="<?php echo $today; ?>" data-date-format="yyyy-mm-dd" class="datepicker"/>
				<label class="select">To</label>
					<input type="text" name="to_date" data-date-format="yyyy-mm-dd" class="datepicker"/>
				<button type="submit" class="btn">Search</button>
			<?php echo form_close(); ?>
		</div>
	</div>
<?php
if(!empty($sales_info)){
?>
<table class="table table-striped table-condensed table-bordered">
	<thead>
		<tr>
			<th>Product Name </th>
			<th>Quantity </th>
			<th> Max Rate </th>
			<th> Min Rate </th>
			<th> Average Rate </th>
			<th>Amount</th>
		</tr>
	</thead>
	<tbody>
	{sales_info}
		<tr>
			
			<td>
				<a href="<?php echo base_url().'Cinvoice/invoice_inserted_data/{invoice_id}'; ?>">
					{product_name}
				</a>
			</td>
			<td>{quantity}</td>
			<td>{max_rate}</td>
			<td>{min_rate}</td>
			<td>{average_rate}</td>
			<td>{total}</td>
			
		</tr>
	{/sales_info}
	</tbody>
	<tfoot>
		<tr>
			<td colspan="3">&nbsp;</td>
			<td><b>{sales_amount}</b></td>
		</tr>
	</tfoot>
</table>

<?php
}else{
?>
<div class="NoDataFound"><center>No Data Found</center></div>
<?php
}
?>
<!-- Suppliers sales report start -->



<!-- Supplier Sales Report Start -->
<div class="content-wrapper">
	<section class="content-header">
	    <div class="header-icon">
	        <i class="pe-7s-note2"></i>
	    </div>
	    <div class="header-title">
	        <h1>Sales Report</h1>
	        <small>Supplier Sales Report</small>
	        <ol class="breadcrumb">
	            <li><a href="index.html"><i class="pe-7s-home"></i> Home</a></li>
	            <li><a href="#">Supplier</a></li>
	            <li class="active">Sales Report</li>
	        </ol>
	    </div>
	</section>

	<!-- Search Supplier -->
	<section class="content">
		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4>Sales Report</h4>
		                </div>
		            </div>
		            <div class="panel-body">
	  					<?php echo form_open('#',array('class' => 'form-inline'))?>
	  					<?php $today = date('Y-m-d'); ?>
						<label class="select">Search By Date: From</label>
						<input type="text" name="from_date"  value="<?php echo $today; ?>" data-date-format="yyyy-mm-dd" class="datepicker"/>
						<label class="select">To</label>
							<input type="text" name="to_date" data-date-format="yyyy-mm-dd" class="datepicker"/>
						<button type="submit" class="btn">Search</button>
						<?php echo form_close()?>
		            </div>
		        </div>
		    </div>
		</div>

		<!-- Sales Report -->
		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4>Sales Report</h4>
		                </div>
		            </div>
		            <div class="panel-body">
		                <div class="table-responsive">
		                    <table id="dataTableExample2" class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th>Product Name </th>
										<th>Quantity </th>
										<th> Max Rate </th>
										<th> Min Rate </th>
										<th> Average Rate </th>
										<th>Amount</th>
									</tr>
								</thead>
								<tbody>
								{sales_info}
									<tr>
										
										<td>
											<a href="<?php echo base_url().'Cinvoice/invoice_inserted_data/{invoice_id}'; ?>">
												{product_name}
											</a>
										</td>
										<td>{quantity}</td>
										<td>{max_rate}</td>
										<td>{min_rate}</td>
										<td>{average_rate}</td>
										<td>{total}</td>
										
									</tr>
								{/sales_info}
								</tbody>
								<tfoot>
									<tr>
										<td colspan="3">&nbsp;</td>
										<td><b>{sales_amount}</b></td>
									</tr>
								</tfoot>
		                    </table>
		                </div>
		            </div>
		        </div>
		    </div>
		</div>
	</section>
</div>
<!-- Supplier Sales Report End -->