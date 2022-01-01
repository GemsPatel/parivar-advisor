<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body>
<div class="print">
  <table style="border-collapse: collapse; width: 900px; border-top: 1px solid #DDDDDD; border-left: 1px solid #DDDDDD;font-family:Verdana, Geneva, sans-serif;line-height: 22px;">
    <thead>
      <tr>
      	<td colspan="2" style="text-align:center; border-right: 1px solid #DDDDDD;padding:5px;font-weight:bold;">REPORT</td>
      </tr>
      <tr>
        <td style="font-size: 12px; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px; width: 70%;">
          <h1 style="font-size:28px;">Parivar Advisor</h1>
          <span>Shop-28, Upal Tower, Nr Umiya Mataji Temple,</span><br>
          <span>Vaishali Cinema Road,</span><br>
          <span>Varacha, SURAT-395004</span><br>
          Phone No.: 9104191019<br>
          Email ID: PARIVARADVISOR@GMAIL.COM
        </td>
        <td style="text-align: -webkit-left !important; font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; vertical-align:bottom; padding: 7px;">
          <b>Date: </b> <?php echo date( 'd-m-Y' );?><br>
          <b>Invoice No.: </b><?php echo @$listArr[0]['c_slip_number']; ?><br>
          <b>Reg No.: </b>GUJSR204683<br>
          <b>Udhyog Reg No.: </b>GJ22A02235lH
         </td>
      </tr>
      <tr>
        <td colspan="2" style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #efefef; font-weight: bold; text-align: center; padding: 3px;"><b>Customer Details</b></td>        
      </tr>
      <tr>
      	<td colspan="2" style="padding: 5px;"></td>
      </tr>
    </thead>
  </table>
  <table style="border-collapse: collapse; width: 900px; border-top: 1px solid #DDDDDD; border-left: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; margin-bottom: 20px;font-family:Verdana, Geneva, sans-serif;">
            <thead>
              <tr style="font-size: 13px; border-bottom: 1px solid #DDDDDD; background-color: #efefef; font-weight: bold; text-align: center; padding: 3px; color: #222222;">
              	<td width="30" style="border-right: 1px solid #DDDDDD;">ID</td>
              	<td width="140" style="border-right: 1px solid #DDDDDD;">SIP Number</td>
                <td width="30" style="border-right: 1px solid #DDDDDD;">Name</td>
                <td width="60" style="border-right: 1px solid #DDDDDD;">Email ID</td>
                <td width="100" style="border-right: 1px solid #DDDDDD;">Contact</td>
                <td width="60" style="border-right: 1px solid #DDDDDD;">Address</td>
                <td width="80" style="border-right: 1px solid #DDDDDD;">Reference</td>
                <td width="110" style="border-right: 1px solid #DDDDDD;">Paid</td>
              </tr>
            </thead>
            <tbody>
            	<?php 
            	if( count($listArr) >0 )
				{
					$totalPayment = 0;
					foreach($listArr as $k=>$ar)
					{
						$total = 0;
						?>
						<tr style="border-bottom: 1px dotted #DDDDDD; border-collapse: collapse; font-size:12px; text-align:center; line-height: 25px; vertical-align: text-bottom;">
							<td style="border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD;"><?php echo $ar[$this->cAutoId];?></td>
							<td style="border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD;"><?php echo $ar['c_slip_number'];?></td>
							<td style="border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD;"><?php echo $ar['c_firstname']." ".$ar['c_middlename']." ".$ar['c_lastname'];?></td>
			                <td style="border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD;"><?php echo $ar['c_phoneno'];?></td>
			                <td style="border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD;"><?php echo $ar['c_emailid'];?></td>
			                <td style="border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD;"><?php echo $ar['c_city'].", ".$ar['c_state'].", ".$ar['c_pincode'];?></td>
			                <td style="border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD;"><?php echo getField( "CONCAT( c_firstname, ' ', c_lastname )" , "customer", "customer_id", $ar['c_reference_id'] );?></td>
			                <td style="border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD;">
			                	<?php 
			                	$paymentArr = executeQuery( "SELECT cpm_payment, cmp_created_date FROM customer_payment_map WHERE customer_id = ".$ar['customer_id'] );//." AND cmp_created_date >=".formatDate( "Y-m-d", $_GET['dateFrom'] )." AND cmp_created_date <= ".formatDate( "Y-m-d", $_GET['dateTo'] )
			                	if( !isEmptyArr( $paymentArr ) )
			                	{
			                		foreach ( $paymentArr as $pay )
			                		{
			                			$total += $pay['cpm_payment'];
			                			$totalPayment += $pay['cpm_payment'];
			                			echo "<span style='border-bottom: 1px solid #ddd;'>".formatDate( 'd-m-Y', $pay['cmp_created_date'] ).":".$pay['cpm_payment']."</span><br>";
			                		}
			                	}
			                	echo "<b style='text-aligh:left;'>".$total."</b>";
// 			                	$payment = (int)getField( "SUM( cpm_payment )", "customer_payment_map", "customer_id", $ar['customer_id'] );
// 			                		echo $total = $payment;
// 			                		$totalPayment += $total;
			                	?>
		                	</td>
						</tr>
						<?php 
					}
					?>
					<tr style="border-bottom: 1px dotted #DDDDDD; border-collapse: collapse; font-size:12px; text-align:center; line-height: 25px;">
						<td style="border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD;" colspan="7"><b>Total Payment</b></td>
		                <td style="border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD;"><?php echo $totalPayment;?></td>
					</tr>
					<?php 
				}
				else 
				{
					echo "<tr> <td colspan='10' style='text-align:center;'> No More Result Found. </td> </tr>";
				}
				?>
			</tbody>
  </table>
  
</div>
<style>
@media print {
  #printPageButton {
    display: none;
  }
}
</style>
<button id="printPageButton" onClick="window.print();" style="margin-right:15px; margin-top: 15px;">Print</button>
</body>
</html>