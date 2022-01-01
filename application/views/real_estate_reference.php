<style>
@media (min-width: 768px)
{
	.modal-dialog { width: 833px; margin: 30px auto; }
	.navbar { border-radius: 0px; }
	.navbar-brand, .navbar-nav>li>a { font-weight: 500; line-height: 24px; }
	/* .navbar-inverse { background-color: #fff; border-color: #fff; } */
	.nav>li>a { padding: 13px 20px 12px; }
	/* .nav.navbar-nav>li>a { color: #fff!important; } */
}
#reference-item #datatable-checkbox_wrapper .row:first-child{ display: none; }
</style>
<div class="modal fade" id="reference-item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-dialog-reference" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">x</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">References</h4>
			</div>

			<div class="modal-body">
				<table id="datatable-checkbox" class="table table-striped table-bordered bulk_action datatable-checkbox-reference">
					<thead>
						<tr>
							<th><input type="checkbox" id="check-all" class="flat"></th>
							<th>ID</th>
							<th>Slip ID</th>
							<th>Name</th>
							<th>Email ID</th>
							<th>Phone Number</th>
							<th>Address</th>
							<th>Reference</th>
							<th>Paid</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
		</div>
	</div>
</div>
	