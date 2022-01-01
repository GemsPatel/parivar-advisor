<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<script type="text/javascript" src="./images/jquery-1.7.1.min.js"></script>
</head>
<body>
<div class="print">
  <table style="border-collapse: collapse; width: 900px; border-top: 1px solid #DDDDDD; border-left: 1px solid #DDDDDD;font-family:Verdana, Geneva, sans-serif;line-height: 22px;">
    <thead>
      <tr>
      	<td colspan="2" style="text-align:center; border-right: 1px solid #DDDDDD;padding:5px;font-weight:bold;">INVOICE</td>
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
          <b>Invoice No.: </b><?php echo $custArr[0]['c_slip_number']; ?><br>
          <b>Reg No.: </b>GUJSR204683<br>
          <b>Udhyog Reg No.: </b>GJ22A02235lH
         </td>
      </tr>
      <tr>
        <td colspan="2" style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #efefef; font-weight: bold; text-align: left; padding: 3px;"><b>Customer Details</b></td>        
      </tr>
    </thead>
    <tbody>
      <tr>
        <td colspan="2" style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;">
          <b>Name: </b> <?php echo $custArr[0]['c_firstname']." ".$custArr[0]['c_middlename']." ".$custArr[0]['c_lastname']; ?><br>
          <b>Skim: </b> <?php echo getField( "s_name" , "skim", "skim_id", $custArr[0]['skim_id'] ); ?><br>
          <b>Phone: </b> <?php echo $custArr[0]['c_phoneno']; ?><br>
          <b>Address: </b> <?php echo $custArr[0]['c_address']." ".$custArr[0]['c_state']." ".$custArr[0]['c_pincode']; ?><br>
          <b>Plot Size: </b> <?php echo $custArr[0]['c_plot_size']; ?><br>
        </td>        
      </tr>
    </tbody>
  </table>
  <table style="display: none; border-collapse: collapse; width: 900px; border-top: 1px solid #DDDDDD; border-left: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; margin-bottom: 20px;font-family:Verdana, Geneva, sans-serif;">
            <thead>
            	<tr>
		        <td colspan="10" style="font-size: 20px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #efefef; font-weight: bold; text-align: center; padding: 3px;"><b>You Helped Us</b></td>        
		      </tr>
              <tr style="font-size: 13px; border-bottom: 1px solid #DDDDDD; background-color: #efefef; font-weight: bold; text-align: center; padding: 3px; color: #222222;">
              	<td width="30" style="border-right: 1px solid #DDDDDD;">ID</td>
              	<td width="140" style="border-right: 1px solid #DDDDDD;">Slip ID</td>
                <td width="30" style="border-right: 1px solid #DDDDDD;">Name</td>
                <td width="60" style="border-right: 1px solid #DDDDDD;">Email ID</td>
                <td width="100" style="border-right: 1px solid #DDDDDD;">Contact</td>
                <td width="60" style="border-right: 1px solid #DDDDDD;">Address</td>
                <td width="80" style="border-right: 1px solid #DDDDDD;">Reference</td>
                <td width="60" style="border-right: 1px solid #DDDDDD;">Level</td>
                <td width="80" style="border-right: 1px solid #DDDDDD;">Commission</td>
                <td width="110" style="border-right: 1px solid #DDDDDD;">Paid</td>
              </tr>
            </thead>
            <tbody>
            	<?php 
				if( count($refArr) >0 )
				{
					foreach($refArr as $k=>$ar)
					{
						$level = exeQuery( "SELECT level FROM customer_discount_map WHERE customer_id = ".$customerId." AND reference_customer_id = ".$ar['customer_id'] );
						?>
						<tr style="border-bottom: 1px dotted #DDDDDD; border-collapse: collapse; font-size:12px; text-align:center; line-height: 25px;">
							<td style="border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD;"><?php echo $ar[$this->cAutoId];?></td>
							<td style="border-right: 1px solid #DDDDDD;"><?php echo $ar['c_slip_number'];?></td>
							<td style="border-right: 1px solid #DDDDDD;"><?php echo $ar['c_firstname']." ".$ar['c_middlename']." ".$ar['c_lastname'];?></td>
			                <td style="border-right: 1px solid #DDDDDD;"><?php echo $ar['c_phoneno'];?></td>
			                <td style="border-right: 1px solid #DDDDDD;"><?php echo $ar['c_emailid'];?></td>
			                <td style="border-right: 1px solid #DDDDDD;"><?php echo $ar['c_city'].", ".$ar['c_state'].", ".$ar['c_pincode'];?></td>
			                <td style="border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD;"><?php echo getField( "CONCAT( c_firstname, ' ', c_lastname )" , "customer", "customer_id", $ar['c_reference_id'] );?></td>
			                <td style="border-right: 1px solid #DDDDDD;"><?php echo (int)$level['level'];?></td>
			                <td style="border-right: 1px solid #DDDDDD;"><?php echo chainLevel( (int)$level['level']);?></td>
			                <td style="border-right: 1px solid #DDDDDD;"><?php echo getField( "SUM( cpm_payment )", "customer_payment_map", "customer_id", $ar['customer_id'] );?></td>
						</tr>
						<?php 
					}
				}
				else 
				{
					echo "<tr> <td colspan='10' style='text-align:center;'> No More Help Us. </td> </tr>";
				}
				?>
			</tbody>
  </table>
  <table style="border-collapse: collapse; width: 900px; border-top: 1px solid #DDDDDD; border-left: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; margin-bottom: 20px;font-family:Verdana, Geneva, sans-serif;">
            <thead>
            	<tr>
		        <td colspan="10" style="font-size: 20px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #efefef; font-weight: bold; text-align: center; padding: 3px;"><b>Payment Information</b></td>        
		      </tr>
              <tr style="font-size: 13px; border-bottom: 1px solid #DDDDDD; background-color: #efefef; font-weight: bold; text-align: center; padding: 3px; color: #222222;">
                <td width="30%" style="border-right: 1px solid #DDDDDD;"></td>
              	<td width="10%" style="border-right: 1px solid #DDDDDD;">No</td>
              	<td width="14%" style="border-right: 1px solid #DDDDDD;">Payment</td>
                <td width="14%" style="border-right: 1px solid #DDDDDD;">Date</td>
                <td width="30%" style="border-right: 1px solid #DDDDDD;"></td>
              </tr>
            </thead>
            <tbody>
            	<?php 
            	$payment = 0;
            	if( count($payArr) >0 )
				{
					$no = 1;
					foreach($payArr as $k=>$ar)
					{
						?>
						<tr style="border-bottom: 1px dotted #DDDDDD; border-collapse: collapse; font-size:12px; text-align:center; line-height: 25px;">
							<td style="border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD;"></td>
							<td style="border-right: 1px solid #DDDDDD;"><?php echo $no;?></td>
							<td style="border-right: 1px solid #DDDDDD;"><?php echo $ar['cpm_payment'];?></td>
			                <td style="border-right: 1px solid #DDDDDD;"><?php echo date( 'd-m-Y', strtotime( $ar['cmp_created_date'] ) );?></td>
			                <td style="border-right: 1px solid #DDDDDD;"></td>
						</tr>
						<?php 
						$no++;
						$payment+= $ar['cpm_payment'];
					}
				}
				else
				{
					?>
					<tr style="border-bottom: 1px dotted #DDDDDD; border-collapse: collapse; font-size:12px; text-align:center; line-height: 25px;">
						<td style="border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; height: 25px;"></td>
						<td style="border-right: 1px solid #DDDDDD;"></td>
						<td style="border-right: 1px solid #DDDDDD;"></td>
		                <td style="border-right: 1px solid #DDDDDD;"></td>
		                <td style="border-right: 1px solid #DDDDDD;"></td>
					</tr>
					<?php
				}
				echo '
					<tr style="border-bottom: 1px dotted #DDDDDD; border-collapse: collapse; font-size:12px; text-align:center; line-height: 25px;">
						<td style="border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD;"></td>
						<td style="border-right: 1px solid #DDDDDD; text-align: center;">Total Payment</td>
						<td style="border-right: 1px solid #DDDDDD; text-align: center;">'.$payment.'</td>
		                <td style="border-right: 1px solid #DDDDDD; text-align: center;">-</td>
		                <td style="border-right: 1px solid #DDDDDD;"></td>
					</tr>
					';
				?>
			</tbody>
  </table>
  <table style="border-collapse: collapse; width: 900px; border-top: 1px solid #DDDDDD; border-left: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; margin-bottom: 20px;font-family:Verdana, Geneva, sans-serif;">
				<tr style="border-bottom: 1px dotted #DDDDDD; border-collapse: collapse; font-size:12px; text-align:right; line-height: 25px;">
					<td width="88%" style="border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD;">Amout</td>
					<?php
					$cpm_payment = (int)getField( "SUM( cpm_payment )" , "customer_pay_map", "customer_id", $custArr[0]['customer_id'] );
					$c_payment_commission = getField( "SUM( discount )" , "customer_discount_map", "customer_id", $custArr[0]['customer_id'] );
					$com = ( $c_payment_commission / 100 ) * $cpm_payment;
					$tds = ( 5 / 100 ) * $cpm_payment;
					?>
					<td width="12%" style="border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD;"><?php echo "INR ".$custArr[0]['c_total_amt']; ?></td>
				</tr>
				<tr style="border-bottom: 1px dotted #DDDDDD; border-collapse: collapse; font-size:12px; text-align:right; line-height: 25px;">
					<td width="88%" style="border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD;">Commission Amout</td>
					<td width="12%" style="border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD;"><?php echo "INR ".round( $cpm_payment, 2 ); ?></td>
				</tr>
				<tr style="border-bottom: 1px dotted #DDDDDD; border-collapse: collapse; font-size:12px; text-align:right; line-height: 25px;">
					<td width="88%" style="border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD;">TDS Amout</td>
					<td width="12%" style="border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD;"><?php echo "INR ".round( $tds, 2 )." (5%)"; ?></td>
				</tr>
				<tr style="border-bottom: 1px dotted #DDDDDD; border-collapse: collapse; font-size:12px; text-align:right; line-height: 25px;">
					<td width="88%" style="border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD;">Total Amout</td>
					<td width="12%" style="border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD;"><?php echo "INR ".( ( $custArr[0]['c_total_amt'] - $cpm_payment ) + $tds );?></td>
				</tr>
				<tr>
                	<td colspan="2" style="border-top: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; padding:5px; line-height: 20px; font-size: 12px; background-color: #efefef; text-align:center">
                	<b>FOR PAYMENT: SBI BANK A/C NO.: 38022839608, IMCR: 395002094, IFSC CODE: SBIN0040536</b>                  
                </td>
              </tr>
  </table>
  <table style="border-collapse: collapse; width: 900px; border-top: 1px solid #DDDDDD; border-left: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; margin-bottom: 20px;font-family:Verdana, Geneva, sans-serif;">
  	<tr>
                <td width="65%" style="border-top: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; padding:5px; line-height: 20px; font-size: 12px; background-color: #efefef; text-align:center"><br><br><br><br>Receiver's Sign.</td>
                <td width="35%"  style="border-top: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; padding:5px; line-height: 20px; font-size: 12px; background-color: #efefef; text-align:right">
                	FOR, Parivar Advisor
                    <br><br><br>
                    Authorised Sign.
                </td>
              </tr>
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