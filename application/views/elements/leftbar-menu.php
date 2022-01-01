<?php 
$role_id = (int)$this->session->userdata('role_id');
?>
<div class="sidebar" data-background-color="white" data-active-color="danger">
	<div class="sidebar-wrapper">
		<style>.logo{ font-size: 15px; text-align: center; }</style>
		<div class="logo">
			Parivar Advisor
		</div>
		<ul class="nav">
			
			<li class="<?php echo (@$this->controller == "dashboard") ? 'active' : '';?>">
				<a href="<?php echo asset_url('dashboard');?>">
					<i class="ti-panel"></i>
					<p>Dashboard</p>
				</a>
			</li>

			<?php if( $role_id ==1 ):?>
				<li class="<?php echo (@$this->controller == "users") ? 'active' : '';?>">
					<a href="<?php echo asset_url('users');?>">
						<i class="ti-user"></i>
						<p>Roles User</p>
					</a>
				</li>
			
				<li class="<?php echo (@$this->controller == "skim") ? 'active' : '';?>">
					<a href="<?php echo asset_url('skim');?>">
						<i class="ti-id-badge"></i>
						<p>Skim</p>
					</a>
				</li>
			<?php endif;?>
			
			<?php 
			$customer_url = asset_url('customer');
			
			if( (int)$this->session->userdata('is_login') == 2 )
			{
				$customer_url = asset_url('customer/customerPaymentForm?item_id='._en( (int)$this->session->userdata( 'admin_customer_id' ) ) );
			}
			?>
			<li class="<?php echo (@$this->controller == "customer") ? 'active' : '';?>">
				<a href="<?php echo $customer_url;?>">
					<i class="ti-user"></i>
					<p>Customer</p>
				</a>
			</li>
			
			<li class="hide <?php echo (@$this->controller == "emi") ? 'active' : '';?>">
				<a href="<?php echo asset_url('emi');?>">
					<i class="ti-user"></i>
					<p>EMI Data</p>
				</a>
			</li>
			
			<?php if( $role_id == 1 ):?>
				<li class="<?php echo (@$this->controller == "roles") ? 'active' : '';?>">
					<a href="<?php echo asset_url('roles');?>">
						<i class="ti-view-list-alt"></i>
						<p>Roles</p>
					</a>
				</li>
			
				<li class="<?php echo (@$this->controller == "commission") ? 'active' : '';?>">
					<a href="<?php echo asset_url('commission');?>">
						<i class="ti-settings"></i>
						<p>Commission</p>
					</a>
				</li>
				
				<li class="<?php echo (@$this->controller == "bonus") ? 'active' : '';?>">
					<a href="<?php echo asset_url('bonus');?>">
						<i class="ti-money"></i>
						<p>Bonus</p>
					</a>
				</li>
			<?php endif;?>
		</ul>
	</div>
</div>
