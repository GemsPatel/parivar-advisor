<?php
$role_id = getField( "r_id" , "admin_user", "admin_user_id", (int)$this->session->userdata('admin_id'));
?>
<style>
.ui-datepicker .ui-datepicker-title { line-height: 1em !importnat;}
.ui-datepicker .ui-datepicker-prev, .ui-datepicker .ui-datepicker-next { top: -3px !important; }
.open .dropdown-menu { margin-top: 0px; }
</style>
<div id="content">
	<div class="box">
		<div class="header">
			<div class="row searchBorder" >
				<form id="form" enctype="multipart/form-data" method="get" action="">
					<div class="col-md-2 mt10">
						<input type="number" name="c_slip_number" id="c_slip_number" class="form-control border-input" placeholder="Slip Number" value="<?php echo (@$c_slip_number)?$c_slip_number:@$_GET['c_slip_number']; ?>">
						<input type="hidden" name="customer_id" id="customer_id" value="<?php echo @(int)$_GET['customer_id']; ?>">
					</div>
					
					<div class="col-md-2 text-center mt10">
						<a class="button w-100" onclick="$('#form').submit();" style="cursor: pointer;">Get EMI Box</a>
					</div>
					
					<div class="col-md-4 mt10">
						<!-- <input type="text" name="c_customer" id="c_customer" class="form-control border-input" placeholder="Enter name/mobile number" value="<?php //echo (@$c_customer)?$c_customer:@$_GET['c_customer']; ?>">-->
						<input type="text" id="c_customer" name="c_customer" value="<?php echo @$_GET['c_customer']?>" autocomplete="off" class="form-control border-input" placeholder="Type to get customer details">        
						<ul class="dropdown-menu txt_client_name" role="menu" aria-labelledby="dropdownMenu"  id="DropdownClientName"></ul>
					</div>
					
					<div class="col-md-2 mt10 hide">
						<input type="text" id="c_phoneno" name="c_phoneno_filter" value="<?php echo @$_GET['c_phoneno_filter']?>" autocomplete="off" class="form-control border-input" placeholder="Enter Mobile number">        
						<ul class="dropdown-menu txt_client_phoneno" role="menu" aria-labelledby="dropdownMenu"  id="DropdownClientPhoneno"></ul>
					</div>
					
					<div class="col-md-2 text-center mt10">
						<a class="button w-100" onclick="$('#form').submit();" style="cursor: pointer;">Search</a>
					</div>
					
					<div class="col-md-2 text-center mt10">
						<a class="button w-100" href="<?php echo asset_url( $this->controller.'/'.$this->controller.'Form')?>">Insert</a>
					</div>
				</form>
			</div>
			<div class="row searchBorder" >
				<?php if( $role_id == 1 ) :?>
					<form id="formReport" enctype="multipart/form-data" method="get" action="<?php echo asset_url('customer/getReport');?>" target="_blank">
						<div class="col-md-3 text-center mt10">
							<input type="text" id="dateFrom" name="dateFrom" required="required" class="form-control border-input" placeholder="01-1-2019" value="<?php echo (@$dateFrom)?$dateFrom:@$_GET['dateFrom']; ?>"/>
						</div>
						
						<div class="col-md-3 text-center mt10">
							<input type="text" id="dateTo" name="dateTo" required="required" class="form-control border-input" placeholder="31-1-2019" value="<?php echo (@$dateto)?$dateto:@$_GET['dateto']; ?>"/>
						</div>
						
						<div class="col-md-2 text-center mt10">
							<a class="button w-100" onclick="$('#formReport').submit();" style="cursor: pointer;">Get Report</a>
						</div>
						
					</form>
				<?php endif;?>
			<div></div>
		</div>
		
		<div class="content">
			<?php $this->load->view($this->controller.'/ajax_html_data'); ?>
		</div>
	</div>
</div>

<script type="text/javascript">
	$("#c_slip_number").focus();
</script>