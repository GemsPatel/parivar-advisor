<?php 
	$role_id = (int)$this->session->userdata('role_id');
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="content table-responsive table-full-width listAjax">
					<table class="table table-striped">
						<thead>
							<tr>
								<th class="text-center">ID</th>
								<th class="text-center">S.N.</th>
								<th class="text-center">Name</th>
								<th class="text-center">Total</th>
								<th class="text-center">Pay</th>
								<th class="text-center">Payable</th>
								<th class="text-center">Paid</th>
								<th class="text-center">Action</th>
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
										<td>
											<a href="<?php echo asset_url('customer/customerForm?show=true&item_id='._en( $ar[$this->cAutoId] ) )?>" title="Show Full Detail">
												<?php echo $ar['c_firstname']." ".$ar['c_middlename']." ".$ar['c_lastname'];?></td>
											</a>
										<td><?php echo $cpm_payment = getField( "SUM( cpm_payment )" , "customer_pay_map", "customer_id", $ar[$this->cAutoId] );?></td>
										<td><?php echo $ar['c_commission_pay_amt'];?></td>
										<td class="text-center"><?php echo ( $cpm_payment - $ar['c_commission_pay_amt'] );?></td>
										<td class="text-center">
											<input name="pay" value="0" id="pay<?php echo $ar[$this->cAutoId];?>">
										</td>
										<td class="text-center">
											<a onClick="payCommissionData( <?php echo $ar[$this->cAutoId]?>, <?php echo $ar['c_commission_pay_amt']?> )" style="color: #FFF;" title="Pay"><button type="button" class="btn btn-info btn-fill btn-wd">PAY</button></a>
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
					<div class="pagination">
						<?php $this->load->view('elements/table_footer');?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php $this->load->view('real_estate_reference');?>
<script>
function payCommissionData( id, paid )
{
	var pay = $( "#pay"+id ).val();
	if(confirm('Are you sure you want to Pay Rs.'+pay+' ?'))
	{
		var form_data = { id : id, pay : pay, paid : paid };
		var loc = (base_url+''+lcFirst(controller))+'/updatePayment';

		$.post(loc, form_data, function (data) {
			var arr = $.parseJSON(data);
// 			console.log( arr.type );
			
// 			if(arr.type == "success")
// 			{
				location.reload();
// 			}
			
			$('#content').before(getNotificationHtml(arr['type'],arr['msg']));
		});
	}
}
</script>