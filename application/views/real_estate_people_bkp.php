<?php $this->load->view('header');?>
	<nav class="navbar navbar-inverse">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>                        
				</button>
				<a class="navbar-brand" href="#">Logo</a>
			</div>
			<div class="collapse navbar-collapse" id="myNavbar">
				<ul class="nav navbar-nav">
					<li class="active"><a href="#">Home</a></li>
					<li><a href="#">About</a></li>
					<li><a href="#">Projects</a></li>
					<li><a href="#">Contact</a></li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li>
						<a href="<?php echo asset_url('lgs');?>"><span class="glyphicon glyphicon-log-in"></span> Login</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>
		
	<div class="container mh560">
		<div class="row">
			<div class="col-lg-12 mt20">
				<div class="pull-left">
					<form action="<?php echo asset_url('real_estateGetRecord');?>" id="search-item">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<input type="text" name="customer_name" class="form-control border-input" placeholder="Customer/Referemce Name" value="" data-error="Please enter title.">
								</div>
							</div>
					
							<div class="col-md-4 hide">
								<div class="form-group">
									<input type="text" name="reference_name" class="form-control border-input" placeholder="Reference Name" value="" data-error="Please enter title.">
								</div>
							</div>
							
							<div class="col-md-4">
								<div class="form-group">
									<input type="text" name="contact" class="form-control border-input" placeholder="Contact Number" value="" data-error="Please enter title.">
								</div>
							</div>
							
							<div class="col-md-1">
								<div class="form-group">
									<button type="submit" class="btn crud-search btn-success" style="margin-bottom: -15px;">Search</button>
								</div>
							</div>
						</div>
					</form>
				</div>
				
				<div class="pull-right">
					<button type="button" class="btn btn-success" data-toggle="modal" data-target="#create-item">Create Item</button>
				</div>
			</div>
		</div>

		<table class="table table-bordered tbl_scroll">
			<thead>
				<tr>
					<th>ID</th>
					<th>Slip ID</th>
					<th>Name</th>
					<th>Email ID</th>
					<th>Phone Number</th>
					<th>Address</th>
					<th>Reference</th>
					<th>Paid</th>
					<th class="hide">Action</th>
				</tr>
			</thead>
			<tbody> </tbody>
		</table>
		<ul id="pagination" class="pagination-sm"></ul>
		
		<!-- Create Item Modal -->
		<?php $this->load->view('real_estate_add');?>
		<!-- /Create Item Modal -->

		<!-- Edit Item Modal -->
		<?php $this->load->view('real_estate_edit');?>
		<!-- /Edit Item Modal -->
		
		<!-- Reference Item Modal -->
		<?php $this->load->view('real_estate_reference');?>
		<!-- /Reference Item Modal -->
					
	</div>
<?php $this->load->view('footer');?>