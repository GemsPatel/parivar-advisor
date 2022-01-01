<style>
a.button{
    text-decoration: none;
    color: #FFFFFF;
    background-color: #68B3C8;
    opacity: 1;
    display: inline-block;
    padding: 5px 15px 5px 15px;
    border-radius: 10px 10px 10px 10px;
    margin-top: 10px;
    margin-bottom: 10px;
    margin-right: 15px;
}

.searchBorder
{
	border-radius: 15px;
    border: 2px solid #68b3c8;
    padding: 15px;
    margin-left: 15px;
    margin-right: 15px;
    margin-bottom: 15px;
    margin-top: 15px;
}
</style>
<div id="content">
	<div class="box">
		<div class="header hide">
			<form id="form" enctype="multipart/form-data" method="get" action="">
				<div class="row searchBorder" >
					<div class="col-md-1"> </div>
					<div class="col-md-4">
						<div class="">
							<input type="text" name="c_firstname_filter" class="form-control border-input" placeholder="Customer/Reference Name" value="<?php echo (@$c_firstname_filter)?$c_firstname_filter:@$_GET['c_firstname_filter']; ?>">
						</div>
					</div>
					<div class="col-md-3">
						<div class="">
							<input type="text" name="c_phoneno_filter" class="form-control border-input" placeholder="Contact Number" value="<?php echo (@$c_lastname_filter)?$c_lastname_filter:@$_GET['c_lastname_filter']; ?>">
						</div>
					</div>
					<div class="col-md-2">
						 <div class="">
							<a class="button" onclick="$('#form').submit();" style="cursor: pointer;">Filter</a>
						</div>
					</div>
					<div class="col-md-2 text-right">
						<div class="">
							<a class="button" href="<?php echo asset_url( $this->controller.'/'.$this->controller.'Form')?>">Insert</a>
						</div>
					</div>
				</div>
			</form>
		</div>
		<div class="content">
			<?php $this->load->view($this->controller.'/ajax_html_data'); ?>
		</div>
	</div>
</div>