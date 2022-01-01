<?php 
	$role_id = (int)$this->session->userdata('role_id');
?>
<input type="hidden" id="hidden_srt" value="<?php echo $srt; ?>" />
<input type="hidden" id="hidden_field" value="<?php echo $field; ?>" /> 
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="content table-responsive table-full-width listAjax">
					<table id="datatable" class="table table-striped">
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
// 							$paymentChainArr = executeQuery( "SELECT * FROM customer_discount_map WHERE reference_customer_id = ".(int)$this->session->userdata( 'admin_customer_id' )." AND level != 0 ORDER BY discount DESC" );
							if( !empty( $listArr) )
							{
								foreach ( $listArr as $k=>$chain )
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
					<div class="pagination">
						<?php 
						$this->load->view('elements/table_footer');
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
