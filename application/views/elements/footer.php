		<footer class="footer">
            <div class="container-fluid">
                <div class="copyright pull-center">
                    &copy; <script>document.write(new Date().getFullYear())</script>, made with <i class="fa fa-heart heart"></i> by <a href="http://www.cloudwebs.net/">Cloudwebs</a>
                </div>
            </div>
        </footer>
    </div>
</div>
<div class="fixed-plugin">
    <div class="dropdown show-dropdown">
        <a href="#" data-toggle="dropdown">
        	<i class="fa fa-cog fa-2x"> </i>
		</a>
		<ul class="dropdown-menu">
			<li class="header-title">Sidebar Background</li>
				<li class="adjustments-line text-center">
					<a href="javascript:void(0)" class="switch-trigger background-color">
                        <span class="badge filter badge-white active" data-color="white"></span>
                        <span class="badge filter badge-black" data-color="black"></span>
					</a>
				</li>
				<li class="header-title">Sidebar Active Color</li>
					<li class="adjustments-line text-center">
						<a href="javascript:void(0)" class="switch-trigger active-color">
	                        <span class="badge filter badge-primary" data-color="primary"></span>
	                        <span class="badge filter badge-info" data-color="info"></span>
	                        <span class="badge filter badge-success" data-color="success"></span>
	                        <span class="badge filter badge-warning" data-color="warning"></span>
	                        <span class="badge filter badge-danger active" data-color="danger"></span>
						</a>
					</li>
				</ul>
			</div>
		</div>
	</body>
    <!--   Core JS Files   -->
    <script src="<?php echo asset_url('js/jquery-1.10.2.js')?>" type="text/javascript"></script>
	<script src="<?php echo asset_url('js/bootstrap.min.js')?>" type="text/javascript"></script>
	<!--  Checkbox, Radio & Switch Plugins -->
	<script src="<?php //echo asset_url('js/bootstrap-checkbox-radio.js')?>"></script>
	<!--  Charts Plugin -->
	<script src="<?php //echo asset_url('js/chartist.min.js')?>"></script>
    <!--  Notifications Plugin    -->
    <script src="<?php //echo asset_url('js/bootstrap-notify.js')?>"></script>
    <script src="<?php //echo asset_url('js/paper-dashboard.js')?>"></script>
	<script src="<?php //echo asset_url('js/demo.js')?>"></script>
	<script src="<?php //echo asset_url('js/jquery.sharrre.js')?>"></script>
	
	<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6/jquery.min.js" type="text/javascript"></script> -->
	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js" type="text/javascript"></script>
	<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="Stylesheet"type="text/css"/>
	<script type="text/javascript">
	$(function () {
	    $("#dateFrom").datepicker({
	        numberOfMonths: 1,
	        onSelect: function (selected) {
	            var dt = new Date(selected);
	            dt.setDate(dt.getDate() + 1);
	            $("#dateTo").datepicker("option", "minDate", dt);
	        }
	    });
	    $("#dateTo").datepicker({
	        numberOfMonths: 1,
	        onSelect: function (selected) {
	            var dt = new Date(selected);
	            dt.setDate(dt.getDate() - 1);
	            $("#dateFrom").datepicker("option", "maxDate", dt);
	        }
	    });
	});
	</script>
	
</html>