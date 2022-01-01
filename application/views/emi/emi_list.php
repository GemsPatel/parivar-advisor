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
					<div class="col-md-2">
						<div class="">
							<input type="text" name="c_slip_number" class="form-control border-input" placeholder="Slip Number" value="<?php echo (@$c_slip_number)?$c_slip_number:@$_GET['c_slip_number']; ?>">
						</div>
					</div>
					
					<div class="col-md-2 mt10 text-center">
						<a class="button w-100" onclick="$('#form').submit();" style="cursor: pointer;">Get EMI Box</a>
						</div>
				</form>
			<div></div>
		</div>
		
		<?php if( isset( $listArr ) ):?>
			<div class="content">
				<style>
					.error_msg p { font-size: 11px; color: red; }
					@media (min-width: 992px)
					{
					.table-full-width { margin-left: 10px; margin-right: 10px; }
					}
				</style>
				<div class="content">
					<div class="container-fluid">
						<div class="row">
							<div class="col-lg-2 col-md-12"> </div>
							<div class="col-lg-8 col-md-7">
								<div class="card">
									<div class="header">
										<h4 class="title"><?php  echo getField( "c_firstname", "customer", "customer_id", $this->cPrimaryId )." ".getField( "c_lastname", "customer", "customer_id", $this->cPrimaryId )?> Payment Information</h4>
									</div>
									
									<div class="content table-responsive table-full-width listAjax">
										<table class="table table-striped">
											<thead>
												<tr>
													<th class="text-center">No</th>
													<th class="text-center">Payment</th>
													<th class="text-center">Date</th>
												</tr>
											</thead>
											<tbody>
												<?php 
												$payment = 0;
												if( count($listArr) >0 )
												{
													$no = 1;
													foreach($listArr as $k=>$ar)
													{
														?>
														<tr id="<?php echo $ar['cpm_id'];?>">
															<td class="text-center"><?php echo $no;?></td>
															<td class="text-center"><?php echo $ar['cpm_payment'];?></td>
															<td class="text-center"><?php echo date( 'd-m-Y', strtotime( $ar['cmp_created_date'] ) );?></td>
														</tr>
													<?php 
														$no++;
														$payment+= $ar['cpm_payment'];
													}
												}
												echo "<tr> 
														<td class='text-center'>Total Payment </td>
														<td class='text-center'>$payment</td> 
														<td class='text-center'>-</td> 
													</tr>";
											?>
											</tbody>
										</table>
									</div>
									
									<div class="content">
										<form id="form" enctype="multipart/form-data" method="post" action="<?php echo asset_url($this->controller.'/'.$this->controller.'PaymentForm')?>">
											<input type="hidden" name="item_id" value="<?php echo (@$this->cPrimaryId != '') ? _en(@$this->cPrimaryId) : ''; ?>"  />
													
											<div class="row">
												<div class="col-md-3"></div>
												<div class="col-md-6">
													<div class="form-group">
														<label>Add More Payment (EMI)</label>
														<input type="text" name="cpm_payment" class="form-control border-input" placeholder="Customer Payment" value="<?php echo (@$cpm_payment)?$cpm_payment:@$_POST['cpm_payment']; ?>">
														<span class="error_msg"><?php echo (@$error)?form_error('cpm_payment'):''; ?></span>
													</div>
												</div>
												<div class="col-md-3"></div>
											</div>
				                                    
											<div class="text-center">
												<button type="submit" onclick="$('#form').submit();" class="btn btn-info btn-fill btn-wd">Submit</button>
												<?php 
												if( isset( $this->cPrimaryId ) && !empty( @$this->cPrimaryId) )
												{
													?>
													<button type="button" class="btn btn-info btn-fill btn-wd">
														<a href="<?php echo asset_url($this->controller.'/'.$this->controller.'Print?item_id='._en(@$this->cPrimaryId))?>" target="_blank" style="color: #fff;" >
															<span class="ti-printer">
																Print
															</span>
														</a>
													</button>
												<?php }?>
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
			</div>
		<?php endif;?>
	</div>
</div>
