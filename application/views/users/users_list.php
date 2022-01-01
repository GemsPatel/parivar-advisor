<div id="content">
	<div class="box">
		<div class="header">
			<form id="form" enctype="multipart/form-data" method="get" action="">
				<div class="row searchBorder" >
					<div class="col-md-3 mt10">
						<input type="text" name="name_filter" class="form-control border-input" placeholder="Name" value="<?php echo (@$name_filter)?$name_filter:@$_GET['name_filter']; ?>">
					</div>
					<div class="col-md-3 mt10">
						<input type="text" name="mobile_filter" class="form-control border-input" placeholder="Contact Number" value="<?php echo (@$mobile_filter)?$mobile_filter:@$_GET['mobile_filter']; ?>">
					</div>
					<div class="col-md-3 mt10">
						<?php $resultRoleArr = cmn_vw_getAllRoles(); ?>
						<select name="r_id" class="form-control border-input" required="required" >
							<option value="0"> Select Role</option>
							<?php 
							foreach ( $resultRoleArr as $res )
							{
								?>
								<option value="<?php echo $res['r_id'];?>" <?php echo ( @$r_id == $res['r_id'] ) ? 'selected' : ''; ?> ><?php echo $res['r_name'];?></option>
								<?php
							}
							?>
						</select>
					</div>
					<div class="col-md-1 mt10 text-center">
						<a class="button" onclick="$('#form').submit();" style="cursor: pointer;">Filter</a>
					</div>
					<div class="col-md-1 text-right mt10">
						<a class="button w-100" href="<?php echo asset_url( $this->controller.'/'.$this->controller.'Form')?>">Insert</a>
					</div>
				</div>
			</form>
		</div>
		<div class="content">
			<?php $this->load->view($this->controller.'/ajax_html_data'); ?>
		</div>
	</div>
</div>