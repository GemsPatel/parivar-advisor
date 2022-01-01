<style>
.card .footer 
{
    line-height: 10px !important;
}
.mt10 { margin-top: 10px; }
</style>
 <div class="content">
 	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-1 col-sm-12"></div>
			<div class="col-lg-10 col-sm-12">
				<div class="card">
					<div class="content">
						<?php $customer = exeQuery( "SELECT * FROM customer WHERE customer_id = ".$customer_id); ?>
						<div class="row text-center">
							<p><?php echo $customer['c_firstname']." ".$customer['c_lastname'];?></p>
						</div>
						<div class="footer">
							<hr />
							<div class="stats">
								<i class="ti-mobile"></i> <?php echo $customer['c_phoneno'];?>
							</div>
							<div class="stats">
								<i class="ti-email"></i> <?php echo $customer['c_emailid'];?>
							</div>
						</div>
					</div>
				</div>
				<div class="card">
					<div class="content">
						<ul id="tree1">
							<li>
								<a>
									<div class="">
										<?php echo $customer['c_firstname']." ".$customer['c_lastname'];?>
									</div>
									<div class="footer">
										<div class="stats">
											<i class="ti-mobile"></i> <?php echo $customer['c_phoneno'];?>
										</div>
										<div class="stats">
											<i class="ti-email"></i> <?php echo $customer['c_emailid'];?>
										</div>
									</div>
								</a>
								<?php 
								if( isset( $result) && count( $result) >0 )
								{
									foreach ( $result as $r )
									{
										customerGraph( $r );
									}
								}
								?>
			                </li>
	            		</ul>
					</div>
				</div>
			</div>
			<div class="col-lg-1 col-sm-12"></div>
		</div>
	</div>
</div>
<?php 
function customerGraph( $rows )
{
	echo "<ul>";
	if( isset( $rows['children'] ) )
	{
		displayGraph( $rows );
		
		foreach ( $rows['children'] as $r )
			customerGraph( $r );
	}
	else 
	{
		displayGraph( $rows );
	}
	echo "</ul>";
}
function displayGraph( $row )
{
	?>
	<li class="mt10">
		<div class="">
			<i class="ti-user"></i> <?php echo $row['c_slip_number'].": ";?>
			<a href="<?php echo asset_url('customer/customerForm?show=true&item_id='._en($row['customer_id']))?>" style="color: #397c33;" target="_blank">
				<?php echo $row['c_firstname']." ".$row['c_lastname'];?>
			</a>
		</div>
		<div class="footer">
			<div class="stats">
				<i class="ti-mobile"></i> <?php echo $row['c_phoneno'];?>
			</div>
			<br>
			<div class="stats">
				<i class="ti-email"></i> <?php echo $row['c_emailid'];?>
			</div>
			<br>
			<div class="stats">
				<i class="ti-money"></i> <?php echo (int)getField( "SUM( cpm_payment )" , "customer_payment_map", "customer_id", $row['customer_id'] );?>
			</div>
		</div>
	</li>
	<?php
}
?>