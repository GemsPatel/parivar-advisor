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
								$a = get_sort_order($this->input->get('s'),$this->input->get('f'),'c_firstname');
								?>
								<th width="1%">ID</th>
								<th width="10%" f="sms_content" s="<?php echo @$a;?>">Message</th>
								<th width="1%">Length</th>
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
										<td><?php echo $ar['sms_content'];?></td>
										<td><?php echo strlen( $ar['sms_content'] );?></td>
										<td><a id="" onClick="deleteData( <?php echo $ar[$this->cAutoId]?> )">DELETE</a></td>
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