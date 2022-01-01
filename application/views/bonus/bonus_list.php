<?php 
	$role_id = getField( "r_id" , "admin_user", "admin_user_id", (int)$this->session->userdata('admin_id'));
?>
<style>
.ui-datepicker .ui-datepicker-title { line-height: 1em !importnat;}
.ui-datepicker .ui-datepicker-prev, .ui-datepicker .ui-datepicker-next { top: -3px !important; }
</style>
<div id="content">
	<div class="box">
		<div class="header">
			<div class="row searchBorder" >
				<form id="form" enctype="multipart/form-data" method="get" action="">
					<div class="col-md-2 mt10">
						<input type="number" name="c_slip_number" id="c_slip_number" class="form-control border-input" placeholder="Slip Number" value="<?php echo (@$c_slip_number)?$c_slip_number:@$_GET['c_slip_number']; ?>">
					</div>
					<div class="col-md-2 mt10">
						<input type="text" name="c_name" id="c_name" class="form-control border-input" placeholder="Customer Name" value="<?php echo (@$c_name)?$c_name:@$_GET['c_name']; ?>">
					</div>
					<div class="col-md-2 mt10">
						<input type="text" id="fromDate" name="dateFrom" required="required" class="form-control border-input" placeholder="Start Date" value="<?php echo (@$dateFrom)?$dateFrom:@$_GET['dateFrom']; ?>"/>
					</div>
					
					<div class="col-md-2 mt10">
						<input type="text" id="toDate" name="dateTo" required="required" class="form-control border-input" placeholder="End Date" value="<?php echo (@$dateto)?$dateto:@$_GET['dateto']; ?>"/>
					</div>
					
					<div class="col-md-2 text-center mt10">
						<a class="button w-100" onclick="$('#formReport').submit();" style="cursor: pointer;">Filter</a>
					</div>
					
					<div class="col-md-2 mt10 text-center">
						<a class="button w-100" href="<?php echo asset_url( $this->controller.'/export')?>">Export</a>
					</div>
				</form>
		</div>
		
		<div class="content">
			<?php $this->load->view($this->controller.'/ajax_html_data'); ?>
		</div>
	</div>
</div>

<script type="text/javascript">
	$("#c_slip_number").focus();
</script>