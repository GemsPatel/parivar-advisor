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
                                <h4 class="title">Roles Information</h4>
                            </div>
                            <div class="content">
                                <form id="form" enctype="multipart/form-data" method="post" action="<?php echo asset_url($this->controller.'/'.$this->controller.'Form')?>">
                                    <input type="hidden" name="item_id" value="<?php echo (@$this->cPrimaryId != '') ? _en(@$this->cPrimaryId) : ''; ?>"  />
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label class="control-label" for="r_name">Role Name</label> 
												<input type="text" name="r_name" class="form-control border-input" placeholder="Role Name" value="<?php echo (@$r_name)?$r_name:@$_POST['r_name']; ?>">
											</div>
										</div>
									</div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Status</label>
                                                <select name="status" class="form-control border-input" >
                                                	<option value="1">Enable</option>
                                                	<option value="0">Disable</option>
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