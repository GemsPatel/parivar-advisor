<?php 
$dateFilter = array('customer','bonus');

if(in_array($this->router->class, $dateFilter)):
?>
<script language="javascript">
$(function() {
	if($( "#from" ).length > 0){
		console.log("from");
		// DATEPICKER FOR FILTER
		$( "#from" ).datepicker({
		  changeMonth: true,
   	  	  dateFormat : 'dd/mm/yy',
		  maxDate: "d",
		  numberOfMonths: 2,
		  onClose: function( selectedDate ) {
			  if(selectedDate != '')
				$( "#to" ).datepicker( "option", "minDate", selectedDate );
		  }
		});
	}
	if($( "#to" ).length > 0){
		console.log("to");
		// DATEPICKER FOR FILTER
		$( "#to" ).datepicker({
		  defaultDate: "+1w",
		  dateFormat : 'dd/mm/yy',
		  changeMonth: true,
		  numberOfMonths: 2,
		  maxDate: "d",
		  onClose: function( selectedDate ) {
			  if(selectedDate != '')
				$( "#from" ).datepicker( "option", "maxDate", selectedDate );
		  }
		});
	}

	<?php if($this->input->get('fromDate')){ ?>
			  $( "#to" ).datepicker( "option", "minDate", '<?php echo $this->input->get('fromDate'); ?>' );
	<?php };?>

	<?php if($this->input->get('toDate')){ ?>
			  $( "#from" ).datepicker( "option", "maxDate", '<?php echo $this->input->get('toDate'); ?>');
	<?php };?>

});
</script>
<?php endif;?>

<!-- pagination link -->
<?php if($links)
{ 
	?>
	<div class="links"><?php echo str_ireplace( "31.170.166.162", "admin.parivaradviser.online", $links);?></div>
	<div class="results hide"><?php echo form_dropdown('perPage',$per_page_drop,set_value('perPage',@$this->session->userdata('perPage')),'class="perPageDropdown" onchange="perPageManage(this)"'); ?></div>
	<?php 
}?>