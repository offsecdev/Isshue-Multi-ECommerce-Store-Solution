<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Bank cash or bank select start-->
<link rel="stylesheet" type="text/css" href="<?php echo MOD_URL.'dashboard/assets/css/inflow.css'; ?>">
<script src="<?php echo MOD_URL.'dashboard/assets/js/edit_inout.js'; ?>"></script>

<!-- Add new income start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('add_income') ?></h1>
            <small><?php echo display('add_new_income') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('accounts') ?></a></li>
                <li class="active"><?php echo display('add_income') ?></li>
            </ol>
        </div>
    </section>

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

        <!-- New supplier -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('add_income') ?> </h4>
                        </div>
                    </div>
                  <?php echo form_open_multipart('dashboard/Caccounts/inflow_entry',array('class' => 'form-vertical','id' => 'insert_deposit' ))?>
                    <div class="panel-body">
                    	<?php $today = date('Y-m-d'); ?>
                    	<div class="form-group row">
                            <label for="amount" class="col-sm-3 col-form-label"><?php echo display('payment_date') ?></label>
                            <div class="col-sm-6">
                                <input type="text" name="transection_date" data-date-format="yyyy-mm-dd" value="<?php echo html_escape($today); ?>" id="amount"  class="datepicker form-control"/>
                            </div>
                        </div>

						<div class="form-group row" id="payment_from_1">
					        <label for="amount" class="col-sm-3 col-form-label"><?php echo display('payment_from') ?></label>
					        <div class="col-sm-6">
						        <input type="text"  name="customer_name" class="form-control customerSelection" placeholder='<?php echo display('customer_name') ?>' id="customer_name" />
						        <input id="SchoolHiddenId" class="customer_hidden_value" type="hidden" name="customer_id">
					        </div>
                            <div class="checkbox checkbox-primary col-sm-3 m-t-5">
                                <input onClick="active_customer('payment_from_1')" type="checkbox" id="myRadioButton_1" class="checkbox_account" name="customer_confirm" checked="checked">
                                <label for="myRadioButton_1"> <?php echo display('customer') ?> </label>
                            </div>
					    </div>

					    <div class="form-group row" id="payment_from_2">
					        <label for="amount" class="col-sm-3 col-form-label"><?php echo display('payment_from') ?></label>
					        <div class="col-sm-6">
						        <input type="text"  name="customer_name_others" class="form-control" placeholder='<?php echo display('payee_name') ?>' id="customer_name_others" />
					        </div>
                            <div class="checkbox checkbox-primary col-sm-3 m-t-5">
                                <input  onClick="active_customer('payment_from_2')" type="checkbox" id="myRadioButton_2" class="checkbox_account" name="customer_confirm_others"> 
                                <label for="myRadioButton_2"> <?php echo display('customer') ?> </label>
                            </div>
					    </div>

					    <div class="form-group row">
					        <label for="amount" class="col-sm-3 col-form-label"><?php echo display('payment_type') ?></label>
					        <div class="col-sm-6">
						        <select onchange="bank_info_show(this)" name="payment_type" class="form-control">
									<option value="1"> <?php echo display('cash') ?> </option>
									<option value="2"> <?php echo display('cheque') ?> </option>
									<option value="3"> <?php echo display('pay_order') ?> </option>
								</select>
					        </div>
					    </div>

					    <div id="bank_info_hide">
					    	<div class="form-group row">
						        <label for="amount" class="col-sm-3 col-form-label"><?php echo display('cheque_or_pay_order_no') ?></label>
						        <div class="col-sm-6">
							        <input type="test" id="amount" class="form-control"  name="cheque_no" placeholder="<?php echo display('cheque_or_pay_order_no') ?>" />
						        </div>
						    </div>
						    <div class="form-group row">
						        <label for="amount" class="col-sm-3 col-form-label"><?php echo display('date') ?></label>
						        <div class="col-sm-6">
							        <input type="text" name="cheque_mature_date" data-date-format="yyyy-mm-dd" value="<?php echo html_escape($today); ?>" id="amount"  class="datepicker form-control"/>
						        </div>
						    </div>

						    <div class="form-group row">
						        <label for="amount" class="col-sm-3 col-form-label"><?php echo display('bank_name') ?></label>
						        <div class="col-sm-6">
							        <select name="bank_name"  class="form-control">
							            {bank}
										<option value="{bank_id}"> {bank_name}</option>
							            {/bank}
									</select>
						        </div>
						    </div>
					    </div>
                        <div class="form-group row">
                            <label for="account_table" class="col-sm-3 col-form-label"><?php echo display('payment_account') ?></label>
                            <div class="col-sm-6">
                               <select name="account_table" class="form-control" id="account_table">
                                    {accounts}
									<option value="{account_table_name}"> {account_name} </option>
				                    {/accounts}
								</select>
                            </div>
                        </div>

                       	<div class="form-group row">
                            <label for="amount" class="col-sm-3 col-form-label"><?php echo display('ammount') ?></label>
                            <div class="col-sm-6">
								<input type="number" class="form-control" id="amount" name="amount" required placeholder="<?php echo display('ammount') ?>" />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-sm-3 col-form-label"><?php echo display('description') ?></label>
                            <div class="col-sm-6">
                                <textarea class="form-control" name="description" id="description" rows="3" placeholder="<?php echo display('description') ?>" required=""></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                            <div class="col-sm-6">
                            	<input type="reset" id="add-deposit" class="btn btn-danger" name="add-deposit" value="<?php echo display('reset') ?>" />

                                <input type="submit" id="add-deposit" class="btn btn-primary" name="add-deposit" value="<?php echo display('save') ?>" />
                            </div>
                        </div>
                    </div>
                    <?php echo form_close()?>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Add new income end -->



