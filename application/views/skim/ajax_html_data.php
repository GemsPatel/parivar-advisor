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
								$a = get_sort_order($this->input->get('s'),$this->input->get('f'),'s_name');
								?>
								<th width="1%">ID</th>
								<th width="10%" f="sms_content" s="<?php echo @$a;?>">Skim Name</th>
								<th width="1%">Status</th>
								<th width="1%">Action</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							if(count($listArr))
							{
								foreach($listArr as $k=>$ar)
								{
									?>
									<tr id="<?php echo $ar[$this->cAutoId];?>">
										<td><?php echo $ar[$this->cAutoId];?></td>
										<td><?php echo $ar['s_name'];?></td>
										<td class="">
											<?php 
											if($ar['s_status']==1)
												echo '<a id="ajaxStatusEnabled" rel="0" data-="'.$ar[$this->cAutoId].'" title="Enabled"><img src="'.asset_url('images/enabled.gif').'" alt="enabled"/></a>';
											else
												echo '<a id="ajaxStatusEnabled" rel="1" data-="'.$ar[$this->cAutoId].'" title="Disabled"><img src="'.asset_url('images/disabled.gif').'" alt="disabled"/></a>';
											?>
										</td>
										<td>
											<a class="" href="<?php echo asset_url($this->controller.'/'.$this->controller.'Form?edit=true&item_id='._en($ar[$this->cAutoId]))?>" style="color: #397c33;" title="Edit"><span class="ti-pencil-alt"></span></a>
											| <a id="" href="" onClick="deleteData( <?php echo $ar[$this->cAutoId]?> )" style="color: #ea0a0a;" title="Delete"><span class="ti-close"></span></a>
										</td>
									</tr>
								<?php 
								}
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