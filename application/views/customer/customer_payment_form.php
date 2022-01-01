<?php $role_id = getField( "r_id" , "admin_user", "admin_user_id", (int)$this->session->userdata('admin_id')); ?>
<style>
	.error_msg p { font-size: 11px; color: red; }
	@media (min-width: 992px)
	{
	.table-full-width { margin-left: 10px; margin-right: 10px; }
	}
	.table-striped > thead > tr > th, .table-striped > tbody > tr > th, .table-striped > tfoot > tr > th, .table-striped > thead > tr > td, .table-striped > tbody > tr > td, .table-striped > tfoot > tr > td{ padding: 6px 8px !important; }
</style>
<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-2 col-md-12"> </div>
			<div class="col-lg-8 col-md-7">
				<div class="card">
					<div class="header text-center">
						<h4 class="title"><?php  echo getField( "c_firstname", "customer", "customer_id", $this->cPrimaryId )." ".getField( "c_lastname", "customer", "customer_id", $this->cPrimaryId )?> Payment Information</h4>
					</div>
					
					<div class="content table-responsive table-full-width listAjax">
						<table class="table table-striped">
							<thead>
								<tr>
									<th class="text-center">No</th>
									<th class="text-center">Payment</th>
									<th class="text-center">Date</th>
									<?php if( $role_id == 1):?>
										<th class="text-center">Action</th>
									<?php endif;?>
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
										<tr id="payment_<?php echo $ar['cpm_id'];?>">
											<td class="text-center"><?php echo $no;?></td>
											<td class="text-center"><?php echo $ar['cpm_payment'];?></td>
											<td class="text-center"><?php echo date( 'd-m-Y', strtotime( $ar['cmp_created_date'] ) );?></td>
											<?php if( $role_id == 1):?>
												<td class="text-center">
													<a class="" href="#" onclick="updatePayment( <?php echo $ar['cpm_id'];?>, <?php echo $ar['cpm_payment'];?> )" style="color: #397c33;" title="Edit"><span class="ti-pencil-alt"></span></a>
												</td>
											<?php endif;?>
										</tr>
									<?php 
										$no++;
										$payment+= $ar['cpm_payment'];
									}
								}
								
								$cpm_payment = (int)getField( "SUM( cpm_payment )" , "customer_pay_map", "customer_id", $this->cPrimaryId);
								$c_payment_commission = getField( "SUM( discount )" , "customer_discount_map", "customer_id", $this->cPrimaryId);
								$com = ( $c_payment_commission / 100 ) * $cpm_payment;
								$tds = ( 5 / 100 ) * $cpm_payment;
								
// 								$cpm_payment = (int)getField( "SUM( cpm_payment )" , "customer_pay_map", "customer_id", $this->cPrimaryId);
								$customer = exeQuery( "SELECT c_total_amt, c_commission_pay_amt FROM customer WHERE customer_id = ".$this->cPrimaryId);
// 								$c_cmsn = getField( "SUM( discount )", "customer_discount_map", "customer_id", $this->cPrimaryId );
// 								$com = ( $c_cmsn / 100 ) * $cpm_payment;
// 								$tds = ( 5 / 100 ) * $com;
								
								if( $role_id == 1):
									echo "<tr> 
											<td class='text-center'>Total Payment </td>
											<td class='text-center'><b>$payment</b></td> 
											<td class='text-center'>-</td>
											<td class='text-center'>-</td> 
										</tr>
										<tr>
											<td class='text-center'>Amount</td>
											<td class='text-center'>INR ".(int)$customer['c_total_amt']."</td>
											<td class='text-center'></td>
											<td class='text-center'></td>
										</tr>
										<tr>
											<td class='text-center'>Commission Amount</td>
											<td class='text-center'> INR ".round( $cpm_payment, 2 )."</td>
											<td class='text-center'></td>
											<td class='text-center'></td>
										</tr>
										<tr>
											<td class='text-center'>TDS Amount</td>
											<td class='text-center'> INR ".round( $tds, 2 )." ( 5% )</td>
											<td class='text-center'></td>
											<td class='text-center'></td>
										</tr>
										<tr>
											<td class='text-center'>Payable Amount</td>
											<td class='text-center'> <b>INR ".( ( (int)$customer['c_total_amt'] - $cpm_payment ) + $tds )."</b></td>
											<td class='text-center'></td>
											<td class='text-center'></td>
										</tr>";
								else:
									echo "<tr>
										<td class='text-center'>Total Payment </td>
										<td class='text-center'><b>$payment</b></td>
										<td class='text-center'>-</td>
									</tr>
									<tr>
										<td class='text-center'>Amount</td>
										<td class='text-center'>INR ".(int)$customer['c_total_amt']."</td>
										<td class='text-center'></td>
									</tr>
									<tr>
										<td class='text-center'>Commission Amount</td>
										<td class='text-center'> INR ".round( $cpm_payment, 2 )."</td>
										<td class='text-center'></td>
									</tr>
									<tr>
										<td class='text-center'>TDS Amount</td>
										<td class='text-center'> INR ".round( $tds, 2 )." ( 5% )</td>
										<td class='text-center'></td>
									</tr>
									<tr>
										<td class='text-center'>Payable Amount</td>
										<td class='text-center'> <b>INR ".( ( (int)$customer['c_total_amt'] - $cpm_payment ) + $tds )."</b></td>
										<td class='text-center'></td>
									</tr>";
								endif;
							?><!--  - $cpm_payment -->
							<!-- ( ".$c_cmsn."% ) -->
							</tbody>
						</table>
					</div>
					
					<div class="content table-responsive table-full-width listAjax hide">
						<table class="table table-striped">
							<thead>
								<tr>
									<th class="text-center">Customer ID</th>
									<th class="text-center">Slip No.</th>
									<th class="text-center">Name</th>
									<th class="text-center">Level</th>
									<th class="text-center">Commission( % )</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$paymentChainArr = array();//executeQuery( "SELECT * FROM customer_discount_map WHERE reference_customer_id = ".$this->cPrimaryId." ORDER BY discount DESC");
								if( !empty( $paymentChainArr ) )
								{
									foreach ( $paymentChainArr as $k=>$chain )
									{
										$customerArr = exeQuery( "SELECT customer_id, c_slip_number, CONCAT( c_firstname, ' ', c_lastname ) as name FROM customer WHERE customer_id = ".$chain['customer_id'] );
										?>
										<tr>
											<td class="text-center"><?php echo $customerArr['customer_id'];?></td>
											<td class="text-center">
												<a class="" href="<?php echo asset_url( $this->controller.'/'.$this->controller.'Form?show=true&item_id='._en( $chain['reference_customer_id'] ) )?>" style="color: #397c33;" title="Show Details">
													<?php echo $customerArr['c_slip_number'];?>
												</a>
											</td>
											<td class="text-center"><?php echo $customerArr['name'];?></td>
											<td class="text-center"><?php echo $chain['level'];?></td>
											<?php 
											$discount = 0;
											if( $chain['level'] <=11 )
											{
												$discount = chainLevel( $chain['level'] );
											}
											?>
											<td class="text-center"><?php echo $discount."%" ;?></td>
										</tr>
										<?php 
									}
								}
								else
								{
									?>
									<tr>
										<th class="text-center" colspan="5">No Chain Found.</th>
									</tr>
									<?php 
								}
								?>
							</tbody>
						</table>
					</div>
					
					<div class="content table-responsive table-full-width listAjax">
						<table class="table table-striped">
							<thead>
								<tr>
									<th class="text-center">Level 1</th>
									<th class="text-center">Level 2</th>
									<th class="text-center">Level 3</th>
									<th class="text-center">Level 4</th>
									<th class="text-center">Level 5</th>
								</tr>
							</thead>
							<tbody>
								<?php $bonus = exeQuery( "SELECT * FROM bonus_map WHERE customer_id = ".$this->cPrimaryId ); ?>
								<tr>
									<th class="text-center"><?php echo (int)$bonus['level_1'];?></th>
									<th class="text-center"><?php echo (int)$bonus['level_2'];?></th>
									<th class="text-center"><?php echo (int)$bonus['level_3'];?></th>
									<th class="text-center"><?php echo (int)$bonus['level_4'];?></th>
									<th class="text-center"><?php echo (int)$bonus['level_5'];?></th>
								</tr>
							</tbody>
						</table>
					</div>
					
					<div class="content">
						<form id="form" enctype="multipart/form-data" method="post" action="<?php echo asset_url($this->controller.'/'.$this->controller.'PaymentForm')?>" onsubmit="return confirm('Do you really want to submit the form?');">
							<input type="hidden" name="item_id" value="<?php echo (@$this->cPrimaryId != '') ? _en(@$this->cPrimaryId) : ''; ?>"  />
							<?php if( $role_id != 3 ) : ?>		
								<div class="row">
									<div class="col-md-3"></div>
									<div class="col-md-6">
										<div class="form-group">
											<label>Add More Payment (EMI)</label>
											<input type="number" name="cpm_payment" id="cpm_payment" class="form-control border-input" placeholder="Customer Payment" value=""><?php //echo ( $cpm_payment - $payment)?>
											<span class="error_msg"><?php echo (@$error)?form_error('cpm_payment'):''; ?></span>
										</div>
									</div>
									<div class="col-md-3"></div>
								</div>
                            <?php endif;?>
                            
							<div class="text-center">
								<?php if( $role_id != 3 ) : ?>
									<button type="submit" onclick="$('#form').submit();" class="btn btn-info btn-fill btn-wd">Submit</button>
								<?php endif;?>
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
								<button type="button" class="btn btn-info btn-fill btn-wd"><a href="<?php echo asset_url($this->controller); ?>" style="color:#fff;">Cancel</a></button>
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
<script type="text/javascript">
	$("#cpm_payment").focus();

	function updatePayment( cpm_id, amt )
	{
		$( ".updatePayment" ).remove();
		
		var html = "";
		html+= "<tr class='updatePayment'>"; 
		html+= "<td style='text-align: center;'>Update Amount </td>";
		html+= "<td style='text-align: center;'>";
		html+= "<form id='formUpdatePayment' enctype='multipart/form-data' method='post' action='<?php echo asset_url($this->controller.'/'.$this->controller.'UpdateCPMPayment')?>'>";
		html+= "<input type='hidden' name='cpm_id' id='cpm_id' value='"+cpm_id+"'>";
		html+= "<input type='hidden' name='oldPayment' id='oldPayment' value='"+amt+"'>";
		html+= "<input type='hidden' name='item_id' value='"+<?php echo $this->cPrimaryId ?>+"'>";
		html+= "<input type='number' name='cpm_payment' id='cpm_payment' class='form-control border-input' value='"+amt+"'></form></td>"; 
		html+= "<td style='text-align: center;'>-</td>";
		html+= "<td style='text-align: center;'><button type='submit' onclick='$(\"#formUpdatePayment\").submit();return confirm(\"Do you really want to submit the form?\");' class='btn btn-info btn-fill btn-wd'>Update</button></td></tr>";

		$( "#payment_"+cpm_id ).after( html );
	}
</script>