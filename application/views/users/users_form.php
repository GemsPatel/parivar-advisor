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
                                <h4 class="title">Admin Information</h4>
                            </div>
                            <div class="content">
                                <form id="form" enctype="multipart/form-data" method="post" action="<?php echo asset_url($this->controller.'/'.$this->controller.'Form')?>">
                                    <input type="hidden" name="item_id" value="<?php echo (@$this->cPrimaryId != '') ? _en(@$this->cPrimaryId) : ''; ?>"  />
									
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
												<select name="r_id" class="form-control border-input" required="required" >
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
                                                <input type="text" name="admin_user_emailid" class="form-control border-input" placeholder="Customer Email ID" value="<?php echo (@$admin_user_emailid)?$admin_user_emailid:@$_POST['admin_user_emailid']; ?>">
                                                <span class="error_msg"><?php echo (@$error)?form_error('admin_user_emailid'):''; ?></span>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Password</label>
                                                <input type="text" name="admin_user_password" class="form-control border-input" placeholder="Password" value="<?php echo (@$admin_user_password) ? "" : @$_POST['admin_user_password']; ?>">
                                                <span class="error_msg"><?php echo (@$error)?form_error('admin_user_password'):''; ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                    	<div class="col-md-12">
                                            <div class="form-group">
                                                <label>Status</label>
                                                <select name="admin_user_status" class="form-control border-input" required="required" >
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