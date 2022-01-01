 <style>
	.table-striped tbody > tr:nth-of-type(2n+1) { background-color: initial !important; }
	.table-striped > thead > tr > th, .table-striped > tbody > tr > th, .table-striped > tfoot > tr > th, .table-striped > thead > tr > td, .table-striped > tbody > tr > td, .table-striped > tfoot > tr > td { padding: 6px 8px; }
</style>
 <div class="content">
	<div class="container-fluid">
		<?php 
		if( (int)$this->session->userdata('role_id') == 1)
		{
			?>
			<!-- Customer Report -->
			<div class="row">
				<div class="col-lg-3 col-sm-6">
					<div class="card">
						<div class="content">
							<div class="row">
								<div class="col-xs-5">
									<div class="icon-big icon-warning text-center">
										<i class="ti-server"></i>
									</div>
								</div>
								<div class="col-xs-7">
									<div class="numbers">
										<p>Customer</p>
										<?php echo $last_day['last_day'];?>
									</div>
								</div>
							</div>
							<div class="footer">
								<hr />
								<div class="stats">
									<i class="ti-face-smile"></i> Last Day
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-sm-6">
					<div class="card">
						<div class="content">
							<div class="row">
								<div class="col-xs-5">
									<div class="icon-big icon-success text-center">
										<i class="ti-wallet"></i>
									</div>
								</div>
								<div class="col-xs-7">
									<div class="numbers">
										<p>Customer</p>
										<?php echo $last_month['last_month'];?>
									</div>
								</div>
							</div>
							<div class="footer">
								<hr />
								<div class="stats">
									<i class="ti-face-smile"></i> Last Month
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-sm-6">
					<div class="card">
						<div class="content">
							<div class="row">
								<div class="col-xs-5">
									<div class="icon-big icon-danger text-center">
										<i class="ti-calendar"></i>
									</div>
								</div>
								<div class="col-xs-7">
									<div class="numbers">
										<p>Customer</p>
										<?php echo $current_year['current_year'];?>
									</div>
								</div>
							</div>
							<div class="footer">
								<hr />
								<div class="stats">
									<i class="ti-face-smile"></i> Current Year
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-sm-6">
					<div class="card">
						<div class="content">
							<div class="row">
								<div class="col-xs-5">
									<div class="icon-big icon-info text-center">
										<i class="ti-comments-smiley"></i>
									</div>
								</div>
								<div class="col-xs-7">
									<div class="numbers">
										<p>Customer</p>
										<?php echo $total['total'];?>
									</div>
								</div>
							</div>
							<div class="footer">
								<hr />
								<div class="stats">
									<i class="ti-reload"></i> Total
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<!-- Payment Commission Report -->
			<div class="row">
				<div class="col-lg-3 col-sm-6">
					<div class="card">
						<div class="content">
							<div class="row">
								<div class="col-xs-5">
									<div class="icon-big icon-warning text-center">
										<i class="ti-comments-smiley"></i>
									</div>
								</div>
								<div class="col-xs-7">
									<div class="numbers">
										<p>Commission</p>
										<?php echo $commission_last_day['last_day'];?>
									</div>
								</div>
							</div>
							<div class="footer">
								<hr />
								<div class="stats">
									<i class="ti-face-smile"></i> Last Day
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-sm-6">
					<div class="card">
						<div class="content">
							<div class="row">
								<div class="col-xs-5">
									<div class="icon-big icon-success text-center">
										<i class="ti-wallet"></i>
									</div>
								</div>
								<div class="col-xs-7">
									<div class="numbers">
										<p>Commission</p>
										<?php echo $commission_last_month['last_month'];?>
									</div>
								</div>
							</div>
							<div class="footer">
								<hr />
								<div class="stats">
									<i class="ti-face-smile"></i> Last Month
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-sm-6">
					<div class="card">
						<div class="content">
							<div class="row">
								<div class="col-xs-5">
									<div class="icon-big icon-danger text-center">
										<i class="ti-calendar"></i>
									</div>
								</div>
								<div class="col-xs-7">
									<div class="numbers">
										<p>Commission</p>
										<?php echo $commission_current_year['current_year'];?>
									</div>
								</div>
							</div>
							<div class="footer">
								<hr />
								<div class="stats">
									<i class="ti-face-smile"></i> Current Year
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-sm-6">
					<div class="card">
						<div class="content">
							<div class="row">
								<div class="col-xs-5">
									<div class="icon-big icon-info text-center">
										<i class="ti-server"></i>
									</div>
								</div>
								<div class="col-xs-7">
									<div class="numbers">
										<p>Commission</p>
										<?php echo $commission_total['total'];?>
									</div>
								</div>
							</div>
							<div class="footer">
								<hr />
								<div class="stats">
									<i class="ti-face-smile"></i> Total
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		
		<?php 
		}

		if( (int)$this->session->userdata('is_login') == 2 )
		{
			?>
			<div class="content table-responsive table-full-width listAjax hide">
				<div class="row">
					<div class="col-lg-4 col-sm-12"></div>
					<div class="col-lg-4 col-sm-12 text-center"><p style="color: #EB5E28;">Reference Report</p></div>
					<div class="col-lg-4 col-sm-12"></div>
				</div>
				<div class="row">
					<div class="col-lg-4 col-sm-12"></div>
					<div class="col-lg-4 col-sm-12">
						<div class="card">
							<div class="content">
								<?php $customer = exeQuery( "SELECT * FROM customer WHERE customer_id = ".$customer_id); ?>
								<div class="row text-center">
									<p><?php echo $customer['c_firstname']." ".$customer['c_lastname'];?></p>
								</div>
								<div class="footer">
									<hr />
									<div class="stats">
										<i class="ti-mobile"></i> <?php echo $customer['c_phoneno'];?>
									</div>
									<div class="stats">
										<i class="ti-email"></i> <?php echo $customer['c_emailid'];?>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-4 col-sm-12"></div>
				</div>
				
				<?php 
				if( isset( $result) && count( $result) >0 )
				{
					?>
					<div class="row">
						<?php 
						foreach ( $result as $r )
						{
							?>
							<div class="col-lg-3 col-sm-12">
								<div class="card">
									<div class="content">
										<div class="row text-center">
											<p>
												<i class="ti-user"></i> <?php echo $r['c_slip_number'].": ";?>
												<a href="<?php echo asset_url('customer/customerForm?show=true&item_id='._en($r['customer_id']))?>" style="color: #397c33;" target="_blank">
													<?php echo $r['c_firstname']." ".$r['c_lastname'];?>
												</a>
											</p>
										</div>
										<div class="footer">
											<hr />
											<div class="stats">
												<i class="ti-mobile"></i> <?php echo $r['c_phoneno'];?>
											</div>
										</div>
										<div class="footer">
											<div class="stats">
												<i class="ti-email"></i> <?php echo $r['c_emailid'];?>
											</div>
										</div>
										<div class="footer">
											<div class="stats">
												<i class="ti-money"></i> <?php echo (int)getField( "SUM( cpm_payment )" , "customer_payment_map", "customer_id", $r['customer_id'] );?>
											</div>
										</div>
									</div>
								</div>
							</div>
							<?php 
						}
						?>
					</div>
					<?php 
				}
				?>
			</div>
			
			<div class="content table-responsive table-full-width listAjax">
				
				<div class="row">
					<div class="col-lg-4 col-sm-12"></div>
					<div class="col-lg-4 col-sm-12 text-center"><p style="color: #EB5E28;">Payment Report</p></div>
					<div class="col-lg-4 col-sm-12"></div>
				</div>
				
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
									<td class="text-center"><?php echo "INR ".$ar['cpm_payment'];?></td>
									<td class="text-center"><?php echo date( 'd-m-Y', strtotime( $ar['cmp_created_date'] ) );?></td>
								</tr>
							<?php 
								$no++;
								$payment+= $ar['cpm_payment'];
							}
						}
						echo "<tr> 
								<td class='text-center'>Total Payment </td>
								<td class='text-center'>INR $payment</td> 
								<td class='text-center'>-</td> 
							</tr>";
					?>
					</tbody>
				</table>
			</div>
			
			<div class="content table-responsive table-full-width listAjax hide">
				
				<div class="row">
					<div class="col-lg-4 col-sm-12"></div>
					<div class="col-lg-4 col-sm-12 text-center"><p style="color: #EB5E28;">Payment EVM Report</p></div>
					<div class="col-lg-4 col-sm-12"></div>
				</div>
				
				<table class="table table-striped">
					<thead>
						<tr>
							<th class="text-center">No</th>
							<th class="text-center">Name</th>
							<th class="text-center">Cell Number</th>
							<th class="text-center">Total EVM</th>
							<th class="text-center">Total Payment</th>
							<th class="text-center">Book Amount</th>
							<th class="text-center">Total Amount</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						if( count($resultPayment) >0 )
						{
							$no = 1;
							foreach($resultPayment as $k=>$ar)
							{
								?>
								<tr id="<?php echo $ar['customer_id'];?>">
									<td class="text-center"><?php echo $no;?></td>
									<td class="text-center"><?php echo $ar['customer_name'];?></td>
									<td class="text-center"><?php echo $ar['phone_no'];?></td>
									<td class="text-center"><?php echo $ar['total_evm'];?></td>
									<td class="text-center"><?php echo "INR ".(int)$ar['total_payment'];?></td>
									<td class="text-center"><?php echo "INR ".$ar['c_book_amt'];?></td>
									<td class="text-center"><?php echo "INR ".$ar['c_total_amt'];?></td>
								</tr>
							<?php 
								$no++;
							}
						}
					?>
					</tbody>
				</table>
			</div>
			
			<?php 
// 			$data['paymentChainArr'] = $paymentChainArr;
// 			$data['start'] = $start;
// 			$data['total_records'] = $total_records;
// 			$data['per_page_drop'] = $per_page_drop;
// 			$data['srt'] = $srt; // sort order
// 			$data['field'] = $field; // sort field name

			$this->load->view('commission_report_ajax_html_data', $paymentChainArr );
		}
		?>
	</div>
</div>