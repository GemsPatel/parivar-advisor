<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<script type="text/javascript" src="./images/jquery-1.7.1.min.js"></script>
</head>
<body>
<?php 
$custArr = exeQuery( "SELECT * FROM customer WHERE customer_id = ".(int)_de( $_GET['id'] ) );
?>
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
          <b>Invoice No.: </b><?php echo $custArr['c_slip_number']; ?><br>
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
          <b>Name: </b> <?php echo $custArr['c_firstname']." ".$custArr['c_middlename']." ".$custArr['c_lastname']; ?><br>
          <b>Skim: </b> <?php echo getField( "s_name" , "skim", "skim_id", $custArr['skim_id'] ); ?><br>
          <b>Phone: </b> <?php echo $custArr['c_phoneno']; ?><br>
          <b>Address: </b> <?php echo $custArr['c_address']." ".$custArr['c_state']." ".$custArr['c_pincode']; ?><br>
          <b>Plot Size: </b> <?php echo $custArr['c_plot_size']; ?><br>
        </td>        
      </tr>
    </tbody>
  </table>
  <table style="border-collapse: collapse; width: 900px; border-top: 1px solid #DDDDDD; border-left: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; margin-bottom: 20px;font-family:Verdana, Geneva, sans-serif;">
            <thead>
            	<tr>
		        <td colspan="10" style="font-size: 20px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #efefef; font-weight: bold; text-align: center; padding: 3px;"><b>You Helped Us</b></td>        
		      </tr>
              <tr style="font-size: 13px; border-bottom: 1px solid #DDDDDD; background-color: #efefef; font-weight: bold; text-align: center; padding: 3px; color: #222222;">
				<td width="30" style="border-right: 1px solid #DDDDDD;">ID</td>
              	<td width="30" style="border-right: 1px solid #DDDDDD;">Level 1</td>
              	<td width="30" style="border-right: 1px solid #DDDDDD;">Level 2</td>
              	<td width="30" style="border-right: 1px solid #DDDDDD;">Level 3</td>
              	<td width="30" style="border-right: 1px solid #DDDDDD;">Level 4</td>
              	<td width="30" style="border-right: 1px solid #DDDDDD;">Level 5</td>
                <td width="40" style="border-right: 1px solid #DDDDDD;">Date</td>
              </tr>
            </thead>
            <tbody>
            	<?php 
            	if( count($listArr) >0 )
				{
					foreach($listArr as $k=>$ar)
					{
						?>
						<tr style="border-bottom: 1px dotted #DDDDDD; border-collapse: collapse; font-size:12px; text-align:center; line-height: 25px;">
							<td style="border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD;"><?php echo $ar[$this->cAutoId];?></td>
							<td style="border-right: 1px solid #DDDDDD;"><?php echo $ar['level_1'];?></td>
							<td style="border-right: 1px solid #DDDDDD;"><?php echo $ar['level_2'];?></td>
			                <td style="border-right: 1px solid #DDDDDD;"><?php echo $ar['level_3'];?></td>
			                <td style="border-right: 1px solid #DDDDDD;"><?php echo $ar['level_4'];?></td>
			                <td style="border-right: 1px solid #DDDDDD;"><?php echo $ar['level_5'];?></td>
			                <td style="border-right: 1px solid #DDDDDD;"><?php echo date( 'd-m-Y', strtotime( $ar['bm_created_date'] ) );?></td>
						</tr>
						<?php 
					}
				}
				else 
				{
					echo "<tr> <td colspan='10' style='text-align:center;'> No more bonus found. </td> </tr>";
				}
				?>
			</tbody>
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