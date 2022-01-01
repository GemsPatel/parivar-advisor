<?php 
	$role_id = getField( "r_id" , "admin_user", "admin_user_id", (int)$this->session->userdata('admin_id'));
?>
<style>
.ui-datepicker .ui-datepicker-title { line-height: 1em !importnat;}
.ui-datepicker .ui-datepicker-prev, .ui-datepicker .ui-datepicker-next { top: -3px !important; }
.txt_client_name { margin-left: 14px; margin-top: auto; }
</style>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<div id="content">
	<div class="box">
		<div class="header">
			<div class="row searchBorder" >
				<form id="form" enctype="multipart/form-data" method="get" action="">
					<div class="col-md-2 mt10">
						<div class="">
							<input type="number" name="c_slip_number" id="c_slip_number" class="form-control border-input" placeholder="Slip Number" value="<?php echo (@$c_slip_number)?$c_slip_number:@$_GET['c_slip_number']; ?>">
						</div>
					</div>
					
					<div class="col-md-4 mt10">
						<input type="text" id="c_customer" name="c_customer" value="<?php echo @$_GET['c_customer']?>" autocomplete="off" class="form-control border-input" placeholder="Type to get customer details">        
						<ul class="dropdown-menu txt_client_name" role="menu" aria-labelledby="dropdownMenu"  id="DropdownClientName"></ul>
					</div>
					
					<div class="col-md-2 mt10 text-center">
						<a class="button w-100" onclick="$('#form').submit();" style="cursor: pointer;">Get EMI Box</a>
						</div>
				</form>

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