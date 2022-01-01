<style>
/* .nav.navbar-nav>li>a{ color: #d0dff5!important; } */
</style>
<nav class="navbar navbar-default">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar bar1"></span>
				<span class="icon-bar bar2"></span>
				<span class="icon-bar bar3"></span>
			</button>
			<a class="navbar-brand" href="<?php echo asset_url( ( @$this->controller) ? @$this->controller : 'lgs/changePassword' );?>"><?php echo pgTitle( ( @$this->controller) ? @$this->controller : 'change Password' );?></a>
		</div>
		<?php $admin_id = (int)$this->session->userdata('admin_id');?>
		<div class="collapse navbar-collapse">
			<ul class="nav navbar-nav navbar-right">
				<li class="hide">
					<a href="<?php echo asset_url();?>" target="_blank">
						<i class="ti-eye"></i>
						<p>View Front</p>
					</a>
				</li>
				<li class="hide">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="ti-alarm-clock"></i>
						<p>
							<?php 
							$today = strtotime( date( 'Y-m-d' ) );
							$finish = strtotime( getField( "admin_lock_date", "admin_user", "admin_user_id", $admin_id ) );
							
							//difference
							$diff = $finish - $today;
							
							$daysleft = floor( $diff / ( 60*60*24 ) );
							
							echo $daysleft." Days Left";
							?>
						</p>
					</a>
				</li>
				<?php
				$commission = "";
				if( (int)$this->session->userdata('is_login') == 2 )
				{
					$commission = "<span style='color:red; font-size: 18px; font-weight: 600;'>INR ".$commission.(int)getField( "SUM( cpm_payment )" , "customer_pay_map", "customer_id", (int)$this->session->userdata('admin_customer_id') )."</span> ";
				}
				?>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<p><?php echo $commission.getField( "admin_user_firstname", "admin_user", "admin_user_id", $admin_id );?></p>
						<b class="caret"></b>
					</a>
					<ul class="dropdown-menu">
						<li class="hide"><a href="<?php echo asset_url('updateProfile?profile=true&item_id='._en( $admin_id ));?>">Update Profile</a></li>
						<li><a href="<?php echo asset_url('lgs/changePassword')?>">Change Password</a></li>
						<li><a href="<?php echo asset_url('lgs/logout');?>">Logout</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</nav>