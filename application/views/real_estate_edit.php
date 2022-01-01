<div class="modal fade" id="edit-item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">x</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">Edit</h4>
			</div>

			<div class="modal-body">
				<form data-toggle="validator" action="" method="put" id="formEdit">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label" for="c_slip_number">Slip Number</label> 
								<input type="text" name="c_slip_number" id="c_slip_number" class="form-control border-input" placeholder="Slip Number" value="" required="required" data-error="Please enter title.">
								<div class="help-block with-errors"></div>
							</div>
						</div>
				
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label" for="c_reference_id">Reference</label> 
								<input type="text" name="c_reference_id" id="c_reference_id" class="form-control border-input" placeholder="Reference" value="" required="required" data-error="Please enter title.">
								<div class="help-block with-errors"></div>
							</div>
						</div>
					</div>
				
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label" for="c_firstname">First Name</label> 
								<input type="text" name="c_firstname" id="c_firstname" class="form-control border-input" placeholder="First Name" value="" required="required" data-error="Please enter title.">
								<div class="help-block with-errors"></div>
							</div>
						</div>
				
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label" for="c_lastname">Last Name</label> 
								<input type="text" name="c_lastname" id="c_lastname" class="form-control border-input" placeholder="Last Name" value="" required="required" data-error="Please enter title.">
								<div class="help-block with-errors"></div>
							</div>
						</div>
					</div>
				
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label" for="c_emailid">Email ID</label> 
								<input type="text" name="c_emailid" id="c_emailid" class="form-control border-input" placeholder="Customer Email ID" value="" required="required" data-error="Please enter title.">
								<div class="help-block with-errors"></div>
							</div>
						</div>
				
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label" for="c_phoneno">Phone Number</label> 
								<input type="text" name="c_phoneno" id="c_phoneno" class="form-control border-input" placeholder="Contact Number" value="" required="required" data-error="Please enter title.">
								<div class="help-block with-errors"></div>
							</div>
						</div>
					</div>
				
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label class="control-label" for="c_city">City</label> 
								<input type="text" name="c_city" id="c_city" class="form-control border-input" placeholder="City" value="" required="required" data-error="Please enter title.">
								<div class="help-block with-errors"></div>
							</div>
						</div>
						
						<div class="col-md-4">
							<div class="form-group">
								<label class="control-label" for="c_state">State</label> 
								<input type="text" name="c_state" id="c_state" class="form-control border-input" placeholder="State" value="" required="required" data-error="Please enter title.">
								<div class="help-block with-errors"></div>
							</div>
						</div>
				
						<div class="col-md-4">
							<div class="form-group">
								<label class="control-label" for="c_pincode">Pin Code</label> 
								<input type="number" name="c_pincode" id="c_pincode" class="form-control border-input" placeholder="ZIP Code" value="" required="required" data-error="Please enter title.">
								<div class="help-block with-errors"></div>
							</div>
						</div>
					</div>
				
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label" for="c_about">Extra Note</label>
								<textarea rows="4" name="c_about" id="c_about" class="form-control border-input" placeholder="Here can be your description" required="required" data-error="Please enter title."></textarea>
								<div class="help-block with-errors"></div>
							</div>
						</div>
					</div>
				
					<div class="form-group">
						<button type="submit" class="btn btn-success crud-submit-edit" style="margin-bottom: -15px;">Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
	