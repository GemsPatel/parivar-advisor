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
								<th class="text-center">ID</th>
								<th class="right">S.N.</th>
								<th class="right">Name</th>
								<th class="text-center">Contact</th>
								<th class="text-center">Level 1</th>
								<th class="text-center">Level 2</th>
								<th class="text-center">Level 3</th>
								<th class="text-center">Level 4</th>
								<th class="text-center">Level 5</th>
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
										<td><?php echo $ar['c_firstname']." ".$ar['c_middlename']." ".$ar['c_lastname'];?></td>
										<td class="text-center"><?php echo $ar['c_phoneno'];?></td>
										<td class="text-center"><span class="level_<?php echo $ar[$this->cAutoId];?>"><?php echo $ar['level_1'];?></span></td>
										<td class="text-center"><span class="level_<?php echo $ar[$this->cAutoId];?>"><?php echo $ar['level_2'];?></span></td>
										<td class="text-center"><span class="level_<?php echo $ar[$this->cAutoId];?>"><?php echo $ar['level_3'];?></span></td>
										<td class="text-center"><span class="level_<?php echo $ar[$this->cAutoId];?>"><?php echo $ar['level_4'];?></span></td>
										<td class="text-center"><span class="level_<?php echo $ar[$this->cAutoId];?>"><?php echo $ar['level_5'];?></span></td>
										<td class="text-center">
											<a class="pointer" onClick="updateBonus( '<?php echo asset_url($this->controller.'/'.$this->controller.'Form?edit=true&item_id='._en($ar[$this->cAutoId]))?>', <?php echo $ar[$this->cAutoId];?>, '<?php echo $ar['c_firstname']." ".$ar['c_middlename']." ".$ar['c_lastname'];?>' )" style="color: #397c33;" title="Bonus">
												<span class="ti-money"></span>
											</a>|
											<a class="" href="<?php echo asset_url($this->controller.'/'.$this->controller.'FrontPrint?edit=true&item_id='._en($ar[$this->cAutoId]).'&id='._en($ar['customer_id']) )?>" title="Print" target="_blank">
												<span class="ti-printer"></span>
											</a>
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
<script>
	function updateBonus( url, id, name )
	{
		if(confirm('Are you sure '+name+' want to Pay Bonus?'))
		{
			$.post( url, { id : id }, function (data) 
			{
				var arr = $.parseJSON(data);
				if(arr['type'] == "success")
				{
					$(".level_"+id).text("0");
				}
			});
		}
	}
</script>