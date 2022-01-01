<style>
.content {
    padding: 30px 15px;
}
.container-fluid {
    padding-right: 15px;
    padding-left: 15px;
    margin-right: auto;
    margin-left: auto;
}
.card {
    border-radius: 6px;
    box-shadow: 0 2px 2px rgba(204, 197, 185, 0.5);
    background-color: #FFFFFF;
    color: #252422;
    margin-bottom: 20px;
    position: relative;
    z-index: 1;
}
.card .content {
    padding: 15px 15px 15px 15px;
}
.table {
    margin-bottom: 0px !important;
        width: 100%;
    max-width: 100%;
        background-color: transparent;
}
.card .table tbody td:first-child, .card .table thead th:first-child {
    padding-left: 15px;
}
.table-striped > thead > tr > th, .table-striped > tbody > tr > th, .table-striped > tfoot > tr > th, .table-striped > thead > tr > td, .table-striped > tbody > tr > td, .table-striped > tfoot > tr > td {
    padding: 15px 8px;
}
.table > thead > tr > th {
    border-bottom-width: 0;
    font-size: 1.25em;
    font-weight: 300;
    line-height: 1.42857143;
}
.text-center {
    text-align: center;
}
.table-striped tbody > tr:nth-of-type(2n+1) {
    background-color: #fff;
}
.table > tbody > tr {
    position: relative;
}
.row {
    margin-right: 15px;
    margin-left: 15px;
}
.card .header {
    padding: 20px 20px 0;
}
.card .title {
    margin: 0;
    color: #252422;
    font-weight: 300;
}
h4, .h4 {
    font-size: 1.5em;
    line-height: 1.2em;
}
</style>
<div class="container-fluid">
	<div class="row">
		<div class="card">
			<div class="content table-responsive table-full-width listAjax">
				<div class="header">
					<h4 class="title">Pratik1 Kakadiya Payment Information</h4>
				</div>
				<table class="table table-striped" border="1">
					<thead>
						<tr>
							<th class="text-center">ID</th>
							<th class="text-center">Slip ID</th>
							<th class="text-center" f="c_firstname" s="<?php echo @$a;?>">Name</th>
							<th class="text-center">Email ID</th>
							<th class="text-center" f="c_phoneno" s="<?php echo @$a;?>">Contact</th>
							<th class="text-center">Address</th>
							<th class="text-center">Reference</th>
							<th class="text-center">Paid</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						if( count($refArr) >0 )
						{
							foreach($refArr as $k=>$ar)
							{
								?>
								<tr id="<?php echo $ar[$this->cAutoId];?>">
									<td><?php echo $ar[$this->cAutoId];?></td>
									<td><?php echo $ar['c_slip_number'];?></td>
									<td><?php echo $ar['c_firstname']." ".$ar['c_middlename']." ".$ar['c_lastname'];?></td>
									<td><?php echo $ar['c_phoneno'];?></td>
									<td><?php echo $ar['c_emailid'];?></td>
									<td><?php echo $ar['c_city'].", ".$ar['c_state'].", ".$ar['c_pincode'];?></td>
									<td>
										<a href="<?php echo asset_url('customer/customerForm?show=true&item_id='._en($ar['c_reference_id']))?>">
											<?php echo getField( "CONCAT( c_firstname, ' ', c_lastname )" , "customer", "customer_id", $ar['c_reference_id'] );?>
										</a>
									</td>
									<td><?php echo $ar['c_book_amt'];?></td>
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
			</div>
		<div>
	</div>
</div>

<div class="container-fluid">
	<div class="row">
		<div class="card">
			<div class="content table-responsive table-full-width listAjax">
				<div class="header">
					<h4 class="title">Payment Information</h4>
				</div>
				<table class="table table-striped" border="1">
					<thead>
						<tr>
							<th class="text-center">No</th>
							<th class="text-center">Payment</th>
							<th class="text-center">Date</th>
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
								<tr id="<?php echo $ar['cpm_id'];?>">
									<td class="text-center"><?php echo $no;?></td>
									<td class="text-center"><?php echo $ar['cpm_payment'];?></td>
									<td class="text-center"><?php echo date( 'd-m-Y', strtotime( $ar['cmp_created_date'] ) );?></td>
								</tr>
							<?php 
								$no++;
								$payment+= $ar['cpm_payment'];
							}
						}
						echo "<tr> 
								<td class='text-center'>Total Payment </td>
								<td class='text-center'>$payment</td> 
								<td class='text-center'>-</td> 
							</tr>";
					?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<style>
@media print {
  #printPageButton {
    display: none;
  }
}
</style>
<button id="printPageButton" onClick="window.print();" style="margin-right:15px; margin-top: 15px;">Print</button>