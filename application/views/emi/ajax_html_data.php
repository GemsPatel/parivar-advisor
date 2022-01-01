<?php 
	$role_id = getField( "r_id" , "admin_user", "admin_user_id", (int)$this->session->userdata('admin_id'));
?>
<input type="hidden" id="hidden_srt" value="<?php echo $srt; ?>" />
<input type="hidden" id="hidden_field" value="<?php echo $field; ?>" /> 
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="content table-responsive table-full-width listAjax">
					<table class="table table-striped">
						<thead>
							<tr>
								<?php 
								$a = get_sort_order($this->input->get('s'),$this->input->get('f'),'c_firstname');
								$b = get_sort_order($this->input->get('s'),$this->input->get('f'),'c_emailid');
								$c = get_sort_order($this->input->get('s'),$this->input->get('f'),'c_phoneno');
								?>
								<th class="text-center">ID</th>
								<th class="text-center">S.N.</th>
								<th class="text-center" f="c_firstname" s="<?php echo @$a;?>">Name</th>
								<th class="text-center">Email ID</th>
								<th class="text-center" f="c_phoneno" s="<?php echo @$a;?>">Contact</th>
								<th class="text-center">Address</th>
								<th class="text-center">Reference</th>
								<th class="text-center">Paid</th>
								<th class="text-center">Status</th>
								<?php if( $role_id == 1 ) :?>
									<th class="text-center">Action</th>
								<?php endif;?>
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
										<td><?php echo $ar['c_emailid'];?></td>
										<td><?php echo $ar['c_phoneno'];?></td>
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
										<?php if( $role_id == 1 ) :?>
											<td>
												<a class="" href="<?php echo asset_url($this->controller.'/'.$this->controller.'PaymentForm?edit=true&item_id='._en($ar[$this->cAutoId]))?>" style="color: #397c33;" title="Payment"><span class="ti-money"></span></a>|
												<a class="" href="<?php echo asset_url($this->controller.'/'.$this->controller.'Print?item_id='._en($ar[$this->cAutoId]))?>" target="_blank" style="color: #397c33;" title="Print" ><span class="ti-printer"></span></a> |
												<a class="" href="<?php echo asset_url($this->controller.'/'.$this->controller.'Form?edit=true&item_id='._en($ar[$this->cAutoId]))?>" style="color: #397c33;" title="Edit"><span class="ti-pencil-alt"></span></a>
												<?php 
												if( $crid = checkIfRowExist( "SELECT customer_id FROM customer WHERE c_reference_id = ".$ar[$this->cAutoId] ) )
												{
													?>
													| <a class="" href="<?php echo asset_url('customer/customerGraph?item_id='._en($ar[$this->cAutoId]))?>" style="color: #091bf3;" title="Link"><span class="ti-link"></span></a>
													<?php 
												}
												?>
												| <a id="" onClick="deleteData( <?php echo $ar[$this->cAutoId]?> )" style="color: #ea0a0a; cursor: pointer;" title="Delete"><span class="ti-close"></span></a>
											</td>
										<?php endif;?>
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
function deleteData( id )
{
	if(confirm('Are you sure want to delete?'))
	{
		form_data = { id : id };
		var loc = (base_url+''+lcFirst(controller))+'/deleteData';
// 		form_data = $('#form').serialize();
		$.post(loc, form_data, function (data) {
			var arr = $.parseJSON(data);
			if(arr['type'] == "success")
			{
// 				$("input:checkbox[name=selected[]]:checked").each(function()
// 				{
// 					var row = document.getElementById($(this).val());
// 					if(row != '' && row != null && typeof(row) !== 'undefined')
// 						row.parentNode.removeChild(row);
// 				});
				location.reload();
			}
			$('#content').before(getNotificationHtml(arr['type'],arr['msg']));
		});
	}
}
</script>