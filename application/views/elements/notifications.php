<?php

$nt_arr = array('danger','info', 'success', 'error', 'warning');

foreach($nt_arr as $nt)
{
	$flMessage = getFlashMessage($nt);
	if($flMessage != '')
	{
		$noti = $nt;
		break;
	}
}

if(isset($noti)):
?>
	<script type="text/javascript">
		type = '<?php echo $noti;?>'; 
		message = '<?php echo $flMessage?>'; 
	</script>
<?php	
endif;
?>
