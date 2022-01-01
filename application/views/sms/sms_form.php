<style>
span p { color: red; }
</style>
<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-8 col-md-7">
				<div class="card">
					<div class="header">
						<h4 class="title">SMS</h4>
					</div>
					<div class="content">
						<form id="form" enctype="multipart/form-data" method="post" action="<?php echo asset_url($this->controller.'/smsForm')?>">
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label>Message</label>
										<textarea rows="5" id="charNum" name="sms_content" class="form-control border-input" onkeyup="countChar(this)" placeholder="Here can be your sms description"><?php echo (@$sms_content)?$sms_content:@$_POST['sms_content']; ?></textarea>
										<span class="error_msg"><?php echo (@$error)?form_error('sms_content'):''; ?></span>
										<span><span id="totalChar">0</span> of 160 number of characters that will be accepted as Message box.</span>
									</div>
								</div>
								
							</div>
							<div class="text-center">
							<?php $total_send = exeQuery( "SELECT COUNT(1) as customer FROM customer WHERE c_status != 0" );?>
								<button type="submit" onclick="$('#form').submit();" class="btn btn-info btn-fill btn-wd">Send (<?php echo $total_send['customer'];?>)</button>
							</div>
							<div class="clearfix"></div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	function countChar(val) 
	{
		var len = val.value.length;
        if (len >= 500) 
		{
			val.value = val.value.substring(0, 500);
        } 
        else 
		{
			$('#charNum').text(500 - len);
        }

        $('#totalChar').text(len);
	};
</script>