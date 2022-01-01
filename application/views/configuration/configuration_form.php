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
							<h4 class="title">Configuration Information</h4>
						</div>
						<div class="content">
							<form id="form" enctype="multipart/form-data" method="post" action="<?php echo asset_url($this->controller.'/'.$this->controller.'Form')?>">
								<input type="hidden" name="item_id" value="<?php echo (@$this->cPrimaryId != '') ? _en(@$this->cPrimaryId) : ''; ?>"  />
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label class="control-label" for="config_key"><span class="required">*</span> Config Key:</label> 
											<input type="text" class="form-control border-input" name="config_key" size="75" value="<?php echo (@$config_key)?$config_key:set_value('config_key');?>" style="text-transform:uppercase" <?php echo (@$this->cPrimaryId) ? 'disabled="disabled"': ''; ?> />
											<span class="error_msg"><?php echo (@$error)?form_error('config_key'):''; ?> </span>
											<small class="small_text">For developer reference, do not edit if not required.</small>
										</div>
									</div>
								</div>
									
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label class="control-label" for="config_display_name"><span class="required">*</span> Config Name:</label>
											<input class="form-control border-input" type="text" name="config_display_name" maxlength="200" size="75" value="<?php echo (@$config_display_name) ? $config_display_name : set_value('config_display_name');?>">
                     						<span class="error_msg"><?php echo (@$error)?form_error('config_display_name'):''; ?> </span>
										</div>
									</div>
								</div>
								
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label class="control-label" for="config_value"><span class="required">*</span> Config Value:</label>
											<input type="text" name="config_value" class="form-control border-input" placeholder="Config Value" value="<?php echo (@$config_value)?$config_value:@$_POST['config_value']; ?>">
											<span class="error_msg"><?php echo (@$error)?form_error('config_value'):''; ?></span>
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
		</div>
	</div>
</div>