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
				<div class="card" style="padding: 10px;">
					<div class="header text-center">
						<h4 class="title"><?php  echo getField( "c_firstname", "customer", "customer_id", $listArr[0]['customer_id'] )." ".getField( "c_lastname", "customer", "customer_id", $listArr[0]['customer_id'])?> Payment Information</h4>
					</div>
					
					<div class="content table-responsive table-full-width listAjax">
						<table class="table table-striped">
							<thead>
								<tr>
									<th class="text-center">No</th>
									<th class="text-center">Level 1</th>
									<th class="text-center">Level 2</th>
									<th class="text-center">Level 3</th>
									<th class="text-center">Level 4</th>
									<th class="text-center">Level 5</th>
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
										<tr id="payment_<?php echo $ar['bonus_print_id'];?>">
											<td class="text-center"><?php echo $ar['bonus_print_id'];?></td>
											<td class="text-center"><?php echo $ar['level_1'];?></td>
											<td class="text-center"><?php echo $ar['level_2'];?></td>
											<td class="text-center"><?php echo $ar['level_3'];?></td>
											<td class="text-center"><?php echo $ar['level_4'];?></td>
											<td class="text-center"><?php echo $ar['level_5'];?></td>
											<td class="text-center"><?php echo date( 'd-m-Y', strtotime( $ar['bm_created_date'] ) );?></td>
										</tr>
									<?php
									}
								}?>
							</tbody>
						</table>
					</div>
					
				</div>
			</div>
			<div class="col-lg-2 col-md-12"> </div>
		</div>
	</div>
</div>