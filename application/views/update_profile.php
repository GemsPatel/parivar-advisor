<style>
.error_msg p { font-size: 11px; color: red; }
.card .image  { height: 200px !important; }
.border_div {
	text-align: justify;
    width: 100%;
    height: auto;
    float: left;
    padding: 0px;
    margin: 30px 0 0 0;
    border: 1px solid #d9d9d9;
    border-radius: 4px;
}

.upload_cont {
    padding: 20px;
    font-family: Arial, Helvetica, sans-serif;
}

.upload_cont ul {
    margin: 0px;
}

ul {
    border: 0;
    margin: 0;
    padding: 0;
}

ol, ul {
    list-style: none;
}

.upload_cont ul li {
    padding: 0px;
    list-style: decimal;
    color: #999999;
    font-size: 12px;
    line-height: 18px;
    margin: 10px 0 10px 10px;
}
.upload_cont span {
    color: #666666;
    font-size: 13px;
    font-weight: bold;
}
</style>
<div class="content">
            <div class="container-fluid">
                <div class="row">
                	<div class="col-lg-2 col-md-12"> </div>
                    <div class="col-lg-8 col-md-7">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Update Profile</h4>
                            </div>
                            <div class="content">
                                <form id="form" enctype="multipart/form-data" method="post" action="<?php echo asset_url('updateProfile')?>">
                                    <input type="hidden" name="item_id" value="<?php echo (@$this->cPrimaryId != '') ? _en(@$this->cPrimaryId) : ''; ?>"  />
									
									<div class="row">
                                        <div class="col-md-12">
                                        	<label>Profile Image</label>
                                            <div class="image" style="padding:5px;" align="center">
												<?php $url = ( @$admin_profile_image) ? $admin_profile_image: ( ( @$_POST['admin_profile_image'] ) ? $_POST['admin_profile_image'] : ( 'images/no_image.jpg' ) ); ?>
												<img src="<?php echo load_image($url);?>" onclick="$('#prdImg_00').trigger('click');" id="prdPrevImage_00" class="image" style="margin-bottom:0px; cursor:pointer; padding:3px;" /><br />
												<input type="file" name="admin_profile_image" id="prdImg_00" onchange="readURL(this,'00');" style="display: none;">
												<input type="hidden" value="<?php echo $url;?>" name="admin_profile_image" id="hiddenPrdImg" />
											</div>
                                        </div>
                                    </div>
                                    
									<div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>First Name</label>
                                                <input type="text" name="admin_user_firstname" class="form-control border-input" placeholder="First Name" value="<?php echo (@$admin_user_firstname)?$admin_user_firstname:@$_POST['admin_user_firstname']; ?>">
                                                <span class="error_msg"><?php echo (@$error)?form_error('admin_user_firstname'):''; ?></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Last Name</label>
                                                <input type="text" name="admin_user_lastname" class="form-control border-input" placeholder="Last Name" value="<?php echo (@$admin_user_lastname)?$admin_user_lastname:@$_POST['admin_user_lastname']; ?>">
                                                <span class="error_msg"><?php echo (@$error)?form_error('admin_user_lastname'):''; ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Role</label>
                                                <?php $resultRoleArr = cmn_vw_getAllRoles(); ?>
												<select name="r_id" class="form-control border-input" readonly >
													<option value=""> Select Role</option>
													<?php 
													foreach ( $resultRoleArr as $res )
													{
														?>
														<option value="<?php echo $res['r_id'];?>" <?php echo ( @$r_id == $res['r_id'] ) ? 'selected' : ''; ?> ><?php echo $res['r_name'];?></option>
														<?php
													}
													?>
												</select>
                                                <span class="error_msg"><?php echo (@$error)?form_error('r_id'):''; ?></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Phone Number</label>
                                                <input type="text" name="admin_user_phone_no" class="form-control border-input" placeholder="Contact Number" value="<?php echo (@$admin_user_phone_no)?$admin_user_phone_no:@$_POST['admin_user_phone_no']; ?>">
                                                <span class="error_msg"><?php echo (@$error)?form_error('admin_user_phone_no'):''; ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                    	<div class="col-md-6">
                                            <div class="form-group">
                                                <label>Email ID</label>
                                                <input type="text" name="admin_user_emailid" class="form-control border-input" placeholder="Customer Email ID" value="<?php echo (@$admin_user_emailid)?$admin_user_emailid:@$_POST['admin_user_emailid']; ?>" disabled="disabled">
                                                <span class="error_msg"><?php echo (@$error)?form_error('admin_user_emailid'):''; ?></span>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group hide">
                                                <label>Password</label>
                                                <input type="text" name="" class="form-control border-input" placeholder="Password" value="<?php echo (@$admin_user_password) ? '' : @$_POST['admin_user_password']; ?>">
                                                <span class="error_msg"><?php echo (@$error)?form_error('admin_user_password'):''; ?></span>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label>Status</label>
                                                <select name="admin_user_status" class="form-control border-input" disabled="disabled" >
													<option value="1" <?php echo ( @$admin_user_status == 1 ) ? 'selected': ''; ?>> Enabled</option>
													<option value="0" <?php echo ( @$admin_user_status == 0 ) ? 'selected': ''; ?>> Disabled</option>
												</select>
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
        <script>
			function readURL(input,position) 
			{
				var inputId = input.id;
				var prevImgId = $('#'+inputId).parent().find('img').attr('id'); //find parent img id
				strInput = inputId.substring(0,inputId.indexOf("_") + 1);
				strPrevImg = prevImgId.substring(0,prevImgId.indexOf("_") + 1);
				//alert(strInput+"=="+strPrevImg);
				var imgName = $('#'+strInput+position).val();
				var ext = imgName.split('.').pop().toLowerCase();
				
				if($.inArray(ext, ['gif','png','jpg','jpeg'])) 
				{
					if (input.files && input.files[0]) 
					{
						var reader = new FileReader();
						reader.onload = function (e) 
						{
							$('#'+strPrevImg+position).attr('src', e.target.result);
							$('#'+inputId).next().val(imgName);
						}
						reader.readAsDataURL(input.files[0]);
					 }
				}
				else
				{
					$('#'+strPrevImg+position).attr('src','');
				}
			}
		</script>