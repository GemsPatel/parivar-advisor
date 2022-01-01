 <div class="content">
 	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-4 col-sm-12"></div>
			<div class="col-lg-4 col-sm-12">
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
			</div>
			<div class="col-lg-4 col-sm-12"></div>
		</div>
	</div>
	<?php 
	if( isset( $result) && count( $result) >0 )
	{
		?>
		<div class="container-fluid">
			<div class="row">
				<?php 
// 				pr($result);
				foreach ( $result as $r )
				{
					customerGraph( $r ); 
				}
				?>
			</div>
		</div>
		<?php
	}
	else 
	{
		?>
		<div class="row">
			<div class="col-lg-4 col-sm-12"></div>
			<div class="col-lg-4 col-sm-12">
				<div class="card">
					<div class="content">
						<div class="row text-center">
							<p>No more result found</p>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-4 col-sm-12"></div>
		</div>
		<?php 
	}
	?>
</div>
<?php 
function customerGraph( $rows )
{
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
}
function displayGraph( $row )
{
	?>
	<div class="col-lg-3 col-sm-12">
		<div class="card">
			<div class="content">
				<div class="row text-center">
					<p>
						<i class="ti-user"></i> <?php echo $row['c_slip_number'].": ";?>
						<a href="<?php echo asset_url('customer/customerForm?show=true&item_id='._en($row['customer_id']))?>" style="color: #397c33;" target="_blank">
							<?php echo $row['c_firstname']." ".$row['c_lastname'];?>
						</a>
					</p>
				</div>
				<div class="footer">
					<hr />
					<div class="stats">
						<i class="ti-mobile"></i> <?php echo $row['c_phoneno'];?>
					</div>
				</div>
				<div class="footer">
					<div class="stats">
						<i class="ti-email"></i> <?php echo $row['c_emailid'];?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
}
?>