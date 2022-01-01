<style>
.error_msg p { font-size: 13px; color: red; }
</style>

<div class="content">
            <div class="container-fluid">
                <div class="row">
                	<div class="col-lg-2 col-md-12"></div>
                    <div class="col-lg-8 col-md-7">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Customer Information</h4>
                            </div>
                            <div class="content">
                                <form id="form" enctype="multipart/form-data" method="post" action="<?php echo asset_url('lgs/changePassword')?>">
                                    <div class="row">
                                    	<div class="col-md-3"></div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Old Password</label>
                                                <input type="password" name="old_password" class="form-control border-input" placeholder="Current Password" value="">
                                                <span class="error_msg"><?php echo (@$error)?form_error('old_password'):''; ?></span>
                                            </div>
                                        </div>
                                        <div class="col-md-3"></div>
                                    </div>
                                    
                                    <div class="row">
                                    	<div class="col-md-3"></div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>New Password</label>
                                                <input type="password" name="new_password" class="form-control border-input" placeholder="New Password" value="">
                                                <span class="error_msg"><?php echo (@$error)?form_error('new_password'):''; ?></span>
                                            </div>
                                        </div>
                                        <div class="col-md-3"></div>
                                    </div>

                                    <div class="row">
                                    	<div class="col-md-3"></div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Confirm Password</label>
                                                <input type="password" name="confirm_password" class="form-control border-input" placeholder="New Confirm Password" value="">
                                                <span class="error_msg"><?php echo (@$error)?form_error('confirm_password'):''; ?></span>
                                            </div>
                                        </div>
                                        <div class="col-md-3"></div>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" onclick="$('#form').submit();" class="btn btn-info btn-fill btn-wd">Change Password</button>
                                    </div>
                                    <div class="clearfix"></div>
                                </form>
                            </div>
                        </div>
                    </div>
					<div class="col-lg-2 col-md-12"></div>

                </div>
            </div>
        </div>