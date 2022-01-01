<?php $this->load->view('header');?>
<nav class="navbar navbar-inverse">
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-5"></div>
			<div class="col-sm-4" style="margin-left: 60px;">
				<ul class="nav navbar-nav">
					<li>
						<a href="<?php echo asset_url('lgs');?>"><span class="glyphicon glyphicon-log-in"></span> Login</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
</nav>
<style>
.search_border{
    border-radius: 10px;
    border: 2px solid #68b3c8;
    padding: 10px;
    margin-left: 15px;
    margin-right: 15px;
    margin-bottom: 10px;
    margin-top: 10px;
}
.mt3{ margin-top: 3px !important; }
.mt1{ margin-top: 2px !important; }
#datatable-checkbox tr th:first-child{ text-align: center !important }
#datatable-checkbox tbody tr .odd td:first-child{ text-align: center !important }
#datatable-checkbox tbody tr .even td:first-child{ text-align: center !important }
table.dataTable thead .sorting_asc:after{ display: none; }
img1 { 
	position: absolute;
   top: 50%;
   left: 50%;
   width: 500px;
   height: 500px;
   margin-top: -250px; /* Half the height */
   margin-left: -250px; /* Half the width */
    }
/* img{position: absolute;
    top: 50%;
    left: 50%;
    width: 350px;
    height: 350px;
    margin-top: -230px;
    margin-left: -175px;} */
</style>
<div class="container">
	<div class="main_container">
		<!-- <img src="<?php //echo asset_url("images/Logo.png?v=0.1");?>">-->
		<div class="hide" style="margin-top: 10px;">
			<form id="search_item_form" onsubmit="return false;">
				<div class="row search_border">
					<div class="col-md-2 mt3">
						<input type="text" style="margin-left: -5px;" name="customer_name" class="form-control border-input" placeholder="Customer/Referemce Name" value="" data-error="Please enter title.">
					</div>
				
					<div class="col-md-2 mt3">
						<input type="text" name="contact" class="form-control border-input" placeholder="Contact Number" value="" data-error="Please enter title.">
					</div>
					
					<div class="col-md-2 mt3">
						<input type="text" name="c_slip_number" class="form-control border-input" placeholder="Slip Number" value="" data-error="Please enter slip number.">
					</div>
						
					<div class="col-md-3 mt3">
						<input type="hidden" name="startDate" value="<?php //echo date( 'Y-m-01', strtotime( date('Y-m-d') ) ); ?>" id="startDate" >
						<input type="hidden" name="endDate" value="<?php //echo date( 'Y-m-t', strtotime( date('Y-m-d') ) ); ?>" id="endDate" >
						<div id="reportrange" class="pull-right validate_reportrange" style="cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
							<i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
							<span id="validation_leads_tbl"></span> 
							<b class="caret"></b>
						</div>
					</div>
						
					<div class="col-md-1 mt2">
						<button type="submit" style="width: 100px;" class="btn crud-search btn-success" id="search_item_btn">Search</button>
					</div>
	
					<div class="col-md-2 mt2 hide" style="text-align: center;">
						<button type="button" class="btn btn-success" data-toggle="modal" data-target="#create-item">Create Item</button>
					</div>			
				</div>
			</form>
		</div>
		<div class="row search_border hide">
			<div class="x_panel">
				<div class="x_content">
					<table id="datatable-checkbox" class="table table-striped table-bordered bulk_action datatable-checkbox">
						<thead>
							<tr>
								<!-- <th><input type="checkbox" id="check-all" class="flat"></th> -->
								<th>ID</th>
								<th>Slip ID</th>
								<th>Name</th>
								<th>Email ID</th>
								<th>Phone Number</th>
								<th>Address</th>
								<th>Reference</th>
								<th>Paid</th>
								<th>Date</th>
							</tr>
						</thead>
						<tbody>
							
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="clearfix"></div>
		<div class="row hide">
			<div class="col-md-3">
				<div id="dataTblExport" style="margin-left: 15px;"></div>
			</div>
			<div class="col-md-8"></div>
			<div class="col-md-1"></div>
			<div class="clearfix"></div>
		</div>
	</div>
	
	<!-- Create Item Modal -->
	<?php //$this->load->view('real_estate_add');?>
	<!-- /Create Item Modal -->

	<!-- Edit Item Modal -->
	<?php //$this->load->view('real_estate_edit');?>
	<!-- /Edit Item Modal -->
	
	<!-- Reference Item Modal -->
	<?php //$this->load->view('real_estate_reference');?>
	<!-- /Reference Item Modal -->
		
	<!-- /page content -->
</div>

<?php $this->load->view('footer');?>