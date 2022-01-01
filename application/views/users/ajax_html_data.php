<style>
a { cursor: pointer; }
</style>
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
								?>
								<th class="">ID</th>
								<th class="">Name</th>
								<th class="">Mobile Number</th>
								<th class="">Email</th>
								<th class="">Role</th>
								<th class="">Status</th>
								<th class="">Action</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							if( count($listArr) >0 )
							{
								foreach($listArr as $k=>$ar)
								{
									if( $ar['admin_user_id'] != 1 && $ar['admin_user_id'] != 2 )
									{
										?>
										<tr id="<?php echo $ar[$this->cAutoId];?>">
											<td><?php echo $ar[$this->cAutoId];?></td>
											<td><?php echo $ar['admin_user_firstname']." ".$ar['admin_user_lastname'];?></td>
											<td><?php echo $ar['admin_user_phone_no'];?></td>
											<td><?php echo $ar['admin_user_emailid'];?></td>
											<td><?php echo $ar['r_name'];?></td>
											<td class="">
												<?php 
												if($ar['admin_user_status']==1)
													echo '<a id="ajaxStatusEnabled" rel="0" data-="'.$ar[$this->cAutoId].'" title="Enabled"><img src="'.asset_url('images/enabled.gif').'" alt="enabled"/></a>';
												else
													echo '<a id="ajaxStatusEnabled" rel="1" data-="'.$ar[$this->cAutoId].'" title="Disabled"><img src="'.asset_url('images/disabled.gif').'" alt="disabled"/></a>';
												?>
											</td>
											<td class="">
												<?php 
												if( $ar['r_id'] != 1 ):?>
													<a class="" href="<?php echo asset_url($this->controller.'/'.$this->controller.'Form?edit=true&item_id='._en($ar[$this->cAutoId]))?>" style="color: #397c33;" title="Edit"><span class="ti-pencil-alt"></span></a>
												<?php endif;?>
												
												<?php if( $ar[$this->cAutoId] == $this->session->userdata('admin_id')):?>
													<a class="" href="<?php echo asset_url($this->controller.'/'.$this->controller.'Form?edit=true&item_id='._en($ar[$this->cAutoId]))?>" style="color: #397c33;" title="Edit"><span class="ti-pencil-alt"></span></a>
												<?php endif;?>
												
												<?php if( $ar['r_id'] != 1 ):?>
												| <a id="" href="" onClick="deleteData( <?php echo $ar[$this->cAutoId]?> )" style="color: #ea0a0a;" title="Delete"><span class="ti-close"></span></a>
												<?php endif;?>
											</td>
										</tr>
									<?php
									}
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
		$.post(loc, form_data, function (data) {
			var arr = $.parseJSON(data);
			if(arr['type'] == "success")
			{
				location.reload();
			}
			$('#content').before(getNotificationHtml(arr['type'],arr['msg']));
		});
	}
}
</script>