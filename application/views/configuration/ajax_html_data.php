<style>
a { cursor: pointer; }
</style>
<input type="hidden" id="hidden_srt" value="<?php echo $srt; ?>" />
<input type="hidden" id="hidden_field" value="<?php echo $field; ?>" /> 
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="content table-responsive table-full-width">
					<table class="table table-striped">
						<thead>
							<tr>
								<?php
								$a = get_sort_order($this->input->get('s'),$this->input->get('f'),'config_display_name');
								$b = get_sort_order($this->input->get('s'),$this->input->get('f'),'config_key');
								$c = get_sort_order($this->input->get('s'),$this->input->get('f'),'modified_date');
							  	?>
								<th class="left" f="config_display_name" s="<?php echo @$a;?>">Config Name</th>
								<th class="left" f="config_key" s="<?php echo @$b;?>">Key</th>
								<th class="left">Value</th>
								<th class="left" f="modified_date" s="<?php echo @$c;?>">Modified Date</th>
								<td class="right">Action</td>
							</tr>            
						</thead>
						<tbody>
							<?php 
					    	if(count($listArr)):
								foreach($listArr as $k=>$ar):
								?>
									<tr id="<?php echo $ar[$this->cAutoId];?>">
										<td class="left"><?php echo $ar['config_display_name'];?></td>
										<td class="left"><?php echo $ar['config_key'];?></td>
										<td class="left"><?php echo $ar['config_value'];?></td>
										<td class="left"><?php echo formatDate('d m, Y <b>h:i a</b>',$ar['modified_date']);?></td>
										<td class="text-center">
											<a class="" href="<?php echo asset_url($this->controller.'/'.$this->controller.'Form?edit=true&item_id='._en($ar[$this->cAutoId]))?>" style="color: #397c33;">EDIT</a>
											| <a id="" onClick="deleteData( <?php echo $ar[$this->cAutoId]?> )" style="color: #ea0a0a;">DELETE</a>
										</td>
									</tr>
								<?php 
						  		endforeach;
						   	else:
							 	echo "<tr class='text-center'><td colspan='5'>No results!</td></tr>";
							endif; 
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