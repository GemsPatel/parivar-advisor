<style>
span p { color: red; }
</style>
<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-3 col-md-12"> </div>
			<div class="col-lg-6 col-md-7">
				<div class="card">
					<div class="header">
						<h4 class="title">Skim</h4>
					</div>
					<div class="content">
						<form id="form" enctype="multipart/form-data" method="post" action="<?php echo asset_url($this->controller.'/'.$this->controller.'Form')?>">
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label>Skim Name</label>
										<input type="text" name="s_name" class="form-control border-input" placeholder="Skim Name" value="<?php echo (@$s_name)?$s_name:@$_POST['s_name']; ?>">
										<span class="error_msg"><?php echo (@$error)?form_error('s_name'):''; ?></span>
									</div>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<label>Status</label>
									<select name="s_status" class="form-control border-input" >
										<option value="1">Enabled</option>
										<option value="0">Disbled</option>
									</select>
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
			<div class="col-lg-3 col-md-12"> </div>
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