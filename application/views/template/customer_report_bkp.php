<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="content table-responsive table-full-width listAjax">
					<table class="table table-striped" border="1">
						<thead>
							<tr>
								<th class="text-center">ID</th>
								<th class="text-center">Slip ID</th>
								<th class="text-center" f="c_firstname" s="<?php echo @$a;?>">Name</th>
								<th class="text-center">Email ID</th>
								<th class="text-center" f="c_phoneno" s="<?php echo @$a;?>">Contact</th>
								<th class="text-center">Address</th>
								<th class="text-center">Reference</th>
								<th class="text-center">Paid</th>
								<th class="text-center">Status</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							if( count($listArr) >0 )
							{
								foreach($listArr as $k=>$ar)
								{
									?>
									<tr id="<?php echo $ar[$this->cAutoId];?>">
										<td><?php echo $ar[$this->cAutoId];?></td>
										<td><?php echo $ar['c_slip_number'];?></td>
										<td><?php echo $ar['c_firstname']." ".$ar['c_middlename']." ".$ar['c_lastname'];?></td>
										<td><?php echo $ar['c_phoneno'];?></td>
										<td><?php echo $ar['c_emailid'];?></td>
										<td><?php echo $ar['c_city'].", ".$ar['c_state'].", ".$ar['c_pincode'];?></td>
										<td>
											<a href="<?php echo asset_url('customer/customerForm?show=true&item_id='._en($ar['c_reference_id']))?>">
												<?php echo getField( "CONCAT( c_firstname, ' ', c_lastname )" , "customer", "customer_id", $ar['c_reference_id'] );?>
											</a>
										</td>
										<td><?php echo $ar['c_book_amt'];?></td>
										<td class="text-center">
											<?php 
											if($ar['c_status']==1)
												echo '<a id="ajaxStatusEnabled" rel="0" data-="'.$ar[$this->cAutoId].'" title="Enabled"><img src="'.asset_url('images/enabled.gif').'" alt="enabled"/></a>';
											else
												echo '<a id="ajaxStatusEnabled" rel="1" data-="'.$ar[$this->cAutoId].'" title="Disabled"><img src="'.asset_url('images/disabled.gif').'" alt="disabled"/></a>';
											?>
										</td>
									</tr>
								<?php 
								}
							}
							else 
							{
								echo "<tr> <td colspan='10' class='text-center'> No More Result Found. </td> </tr>";
							}
						?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<style>
@media print {
  #printPageButton {
    display: none;
  }
}
</style>
<button id="printPageButton" onClick="window.print();" style="margin-right:15px; margin-top: 15px;">Print</button>