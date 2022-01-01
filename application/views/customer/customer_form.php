<style>
	.error_msg p { font-size: 11px; color: red; }
</style>
<div class="content">
            <div class="container-fluid">
                <div class="row">
                	<div class="col-lg-2 col-md-12"> </div>
                    <div class="col-lg-8 col-md-7">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Customer Information</h4>
                            </div>
                            <div class="content">
                                <form id="form" enctype="multipart/form-data" method="post" action="<?php echo asset_url($this->controller.'/customerForm')?>">
                                    <input type="hidden" name="item_id" value="<?php echo (@$this->cPrimaryId != '') ? _en(@$this->cPrimaryId) : ''; ?>"  />
									<div class="row">
										<div class="col-md-4">
											<div class="form-group">
												<label class="control-label" for="c_slip_number">Slip Number</label> 
												<input type="text" name="c_slip_number" class="form-control border-input" placeholder="Slip Number" value="<?php echo (@$c_slip_number)?$c_slip_number:@$_POST['c_slip_number']; ?>">
												<span class="error_msg"><?php echo (@$error)?form_error('c_slip_number'):''; ?></span>
											</div>
										</div>
									
										<div class="col-md-8">
											<div class="form-group">
												<label class="control-label" for="c_reference_id">SIP Number( Slip Number of Agent )</label> 
												<input type="hidden" name="c_reference_id" id="c_reference_id" value="<?php echo (@$c_reference_id)?$c_reference_id:@$_POST['c_reference_id']; ?>"  >
												<?php if( false ){ $resultArr = cmn_vw_getAllCustomer(); ?>
												<select name="" class="form-control border-input" required="required" >
													<option value="0"> Select Reference</option>
													<?php 
													foreach ( $resultArr as $res )
													{
														?>
														<option value="<?php echo $res['customer_id'];?>" <?php echo ( @$c_reference_id == $res['customer_id'] || @$_POST['c_reference_id'] == $res['customer_id'] ) ? 'selected' : ''; ?> ><?php echo $res['c_name'];?></option>
														<?php
													}
													?>
												</select>
												<?php }?>
												<input type="text" id="c_customer_reference_id" name="c_customer_reference_id" value="<?php echo (@$c_customer_reference_id)?$c_customer_reference_id:@$_POST['c_customer_reference_id']; ?>" autocomplete="off" class="form-control border-input" placeholder="Type to get customer details">        
												<ul class="dropdown-menu txt_client_name" style="margin: 0;" role="menu" aria-labelledby="dropdownMenu"  id="DropdownClientName"></ul>
												<span class="error_msg"><?php echo (@$error)?form_error('c_reference_id'):''; ?></span>
											</div>
										</div>
									</div>
									
									<div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>First Name</label>
                                                <input type="text" name="c_firstname" class="form-control border-input" placeholder="First Name" value="<?php echo (@$c_firstname)?$c_firstname:@$_POST['c_firstname']; ?>">
                                                <span class="error_msg"><?php echo (@$error)?form_error('c_firstname'):''; ?></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Middle Name</label>
                                                <input type="text" name="c_middlename" class="form-control border-input" placeholder="Moddle Name" value="<?php echo (@$c_middlename)?$c_middlename:@$_POST['c_middlename']; ?>">
                                                <span class="error_msg"><?php echo (@$error)?form_error('c_middlename'):''; ?></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Last Name</label>
                                                <input type="text" name="c_lastname" class="form-control border-input" placeholder="Last Name" value="<?php echo (@$c_lastname)?$c_lastname:@$_POST['c_lastname']; ?>">
                                                <span class="error_msg"><?php echo (@$error)?form_error('c_lastname'):''; ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Email ID</label>
                                                <input type="text" name="c_emailid" class="form-control border-input" placeholder="Customer Email ID" value="<?php echo (@$c_emailid)?$c_emailid:@$_POST['c_emailid']; ?>">
                                                <span class="error_msg"><?php echo (@$error)?form_error('c_emailid'):''; ?></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Phone Number</label>
                                                <input type="text" name="c_phoneno" class="form-control border-input" placeholder="Contact Number" value="<?php echo (@$c_phoneno)?$c_phoneno:@$_POST['c_phoneno']; ?>">
                                                <span class="error_msg"><?php echo (@$error)?form_error('c_phoneno'):''; ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Address</label>
                                                <textarea rows="3" name="c_address" class="form-control border-input" placeholder="Here can be your address"><?php echo (@$c_address)?$c_address:@$_POST['c_address']; ?></textarea>
                                                <span class="error_msg"><?php echo (@$error)?form_error('c_address'):''; ?></span>
                                            </div>
                                        </div>
                                    </div>
                                     <div class="row">
                                     	<div class="col-md-4">
                                            <div class="form-group">
                                                <label>City</label>
                                                <input type="text" name="c_city" class="form-control border-input" placeholder="City" value="<?php echo (@$c_city)?$c_city:@$_POST['c_city']; ?>">
                                                <span class="error_msg"><?php echo (@$error)?form_error('c_city'):''; ?></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>State</label>
                                                <input type="text" name="c_state" class="form-control border-input" placeholder="State" value="<?php echo (@$c_state)?$c_state:@$_POST['c_state']; ?>">
                                                <span class="error_msg"><?php echo (@$error)?form_error('c_state'):''; ?></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Pin Code</label>
                                                <input type="number" name="c_pincode" class="form-control border-input" placeholder="ZIP Code" value="<?php echo (@$c_pincode)?$c_pincode:@$_POST['c_pincode']; ?>">
                                                <span class="error_msg"><?php echo (@$error)?form_error('c_pincode'):''; ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" id="plot_size">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Skim Name</label>
                                                <?php $resultSkimArr = cmn_vw_getAllSkim(); ?>
												<select name="skim_id" class="form-control border-input" required="required" >
													<option value=""> Select Skim</option>
													<?php 
													foreach ( $resultSkimArr as $res )
													{
														?>
														<option value="<?php echo $res['skim_id'];?>" <?php echo ( @$skim_id== $res['skim_id'] || @$_POST['skim_id'] == $res['skim_id']) ? 'selected' : ''; ?> ><?php echo $res['s_name'];?></option>
														<?php
													}
													?>
												</select>
												<span class="error_msg"><?php echo (@$error)?form_error('skim_id'):''; ?></span>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Plot Size</label>
												<select name="c_plot_size" id="c_plot_size" class="form-control border-input" required="required" >
													<option value=""> Size</option>
													<option value="14 X 36" <?php echo ( @$c_plot_size == "14 X 36" || @$_POST['c_plot_size'] == "14 X 36") ? 'selected' : ''; ?> > 14 X 36</option>
													<option value="16 X 36" <?php echo ( @$c_plot_size == "16 X 36" || @$_POST['c_plot_size'] == "16 X 36") ? 'selected' : ''; ?>> 16 X 36</option>
													<option value="other" <?php echo ( @$c_plot_size == "other" || @$_POST['c_plot_size'] == "other") ? 'selected' : ''; ?>> Other</option>
												</select>
												<span class="error_msg"><?php echo (@$error)?form_error('c_plot_size'):''; ?></span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Booking Amount</label>
                                                <input type="number" name="c_book_amt" class="form-control border-input" placeholder="Booking Amount" value="<?php echo (@$c_book_amt)?$c_book_amt:@$_POST['c_book_amt']; ?>">
                                                <span class="error_msg"><?php echo (@$error)?form_error('c_book_amt'):''; ?></span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Total Amount</label>
                                                <input type="number" name="c_total_amt" class="form-control border-input" placeholder="Paid Amount" value="<?php echo (@$c_total_amt)?$c_total_amt:@$_POST['c_total_amt']; ?>">
                                                <span class="error_msg"><?php echo (@$error)?form_error('c_total_amt'):''; ?></span>
                                            </div>
                                        </div>
                                     </div>
                                    <div class="row">
                                     	<div class="col-md-6">
                                            <div class="form-group">
                                                <label>Payment Option</label>
												<select name="c_payment_option" id="c_payment_option" class="form-control border-input" required="required" >
													<!-- <option value=""> Select Payment Option</option> -->
													<option value="2" selected> Bank</option>
													<option value="1" <?php echo ( @$c_payment_option == 1 || @$_POST['c_payment_option'] == 1) ? 'selected' : ''; ?>> On Hand</option>
												</select>
												<span class="error_msg"><?php echo (@$error)?form_error('c_payment_option'):''; ?></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6 hide">
                                            <div class="form-group">
                                                <label>Commission Level</label>
												<select name="" id="c_payment_commission" class="form-control border-input" required="required" >
													<option value="0"> Select Payment Commission</option>
													<option value="10" <?php echo ( @$c_payment_commission == 10 || @$_POST['c_payment_commission'] == 10 ) ? 'selected' : ''; ?>> 10%</option>
													<option value="4" <?php echo ( @$c_payment_commission == 4 || @$_POST['c_payment_commission'] == 4 ) ? 'selected' : ''; ?>> 4%</option>
													<option value="3" <?php echo ( @$c_payment_commission == 3 || @$_POST['c_payment_commission'] == 3 ) ? 'selected' : ''; ?>> 3%</option>
													<option value="2" <?php echo ( @$c_payment_commission == 2 || @$_POST['c_payment_commission'] == 2 ) ? 'selected' : ''; ?>> 2%</option>
													<option value="1" <?php echo ( @$c_payment_commission == 1 || @$_POST['c_payment_commission'] == 1 ) ? 'selected' : ''; ?>> 1%</option>
												</select>
												<span class="error_msg"><?php echo (@$error)?form_error('c_payment_option'):''; ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row on_bank <?php echo ( isset( $c_payment_option ) && $c_payment_option != 2 ) ? 'hide': ''; ?>">
                                    	<div class="col-md-9">
                                            <div class="form-group">
                                            	<label>Bank Name</label>
                                                <input type="text" name="c_bank_name" class="form-control border-input" placeholder="Bank Name" value="<?php echo (@$c_bank_name)?$c_bank_name:@$_POST['c_bank_name']; ?>">
                                                <span class="error_msg"><?php echo (@$error)?form_error('c_bank_name'):''; ?></span>
                                            </div>
                                        </div>
                                        
                                     	<div class="col-md-3">
                                            <div class="form-group">
                                                <label>Check Number</label>
												<input type="text" name="c_check_number" class="form-control border-input" placeholder="Enter all check number seprate by comma (,)" value="<?php echo (@$c_check_number)?$c_check_number:@$_POST['c_check_number']; ?>">
                                                <span class="error_msg"><?php echo (@$error)?form_error('c_check_number'):''; ?></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Note/About us</label>
                                                <textarea rows="5" name="c_about" class="form-control border-input" placeholder="Here can be your description"><?php echo (@$c_about)?$c_about:@$_POST['c_about']; ?></textarea>
                                                <span class="error_msg"><?php echo (@$error)?form_error('c_about'):''; ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" onclick="$('#form').submit();" class="btn btn-info btn-fill btn-wd">Insert</button>
                                    </div>
                                    <div class="clearfix"></div>
                                </form>
                            </div>
                        </div>
                    </div>
					<div class="col-lg-2 col-md-12"> </div>

                </div>
            </div>
        </div>
<script type="text/javascript">

	$( "#c_payment_option" ).change(function() {
		
		$( ".on_bank" ).addClass('hide');
		if(this.value == 2)
		{
			$( ".on_bank" ).removeClass('hide');
		}
	});

	$( "#c_plot_size" ).change(function() {
		
		if(this.value == 'other')
		{
			var html = '';
			html+= '<div class="row" style="margin-left: 0px;">';
			html+= '<div class="col-md-12">';
			html+= '<div class="form-group">';
			html+= '<label>Other Plot Details</label>';
			html+= '<input type="text" name="c_plot_size" class="form-control border-input" placeholder="Enter plot size" value="<?php echo (@$c_plot_size)?$c_plot_size:@$_POST['c_plot_size']; ?>" style="width: 98%;">';
			html+= '<span class="error_msg"><?php echo (@$error)?form_error('c_plot_size'):''; ?></span>';
			html+= '</div> </div> </div>';
			$( "#plot_size" ).append( html );
		}
	});
</script>