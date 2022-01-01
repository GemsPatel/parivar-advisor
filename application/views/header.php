<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<link rel="apple-touch-icon" sizes="76x76" href="<?php echo asset_url('img/apple-icon.png');?>">
		<link rel="icon" type="image/png" sizes="96x96" href="<?php echo asset_url('img/favicon.png');?>">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<title>Parivar Advisor</title>

		<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
	    <meta name="viewport" content="width=device-width" />
	
		<!-- Canonical SEO -->
	    <link rel="canonical" href=""/>
	
		<!-- Bootstrap -->
	    <link href="<?php echo asset_url('vendors/bootstrap/dist/css/bootstrap.min.css')?>" rel="stylesheet">
	    <!-- Font Awesome -->
	    <link href="<?php echo asset_url('vendors/font-awesome/css/font-awesome.min.css')?>" rel="stylesheet">
	    <!-- iCheck -->
	    <link href="<?php echo asset_url('vendors/iCheck/skins/flat/green.css')?>" rel="stylesheet">
	    <!-- Datatables -->
	    <link href="<?php echo asset_url('vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')?>" rel="stylesheet">
	    <link href="<?php echo asset_url('vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css')?>" rel="stylesheet">
	    <link href="<?php echo asset_url('vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css')?>" rel="stylesheet">
	    <link href="<?php echo asset_url('vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css')?>" rel="stylesheet">
	    <link href="<?php echo asset_url('vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css')?>" rel="stylesheet">
	
		<!-- bootstrap-daterangepicker -->
    	<link href="<?php echo asset_url('vendors/bootstrap-daterangepicker/daterangepicker.css')?>" rel="stylesheet">
    	
	    <!-- Custom Theme Style -->
	    <link href="<?php echo asset_url('vendors/custom.min.css')?>" rel="stylesheet">
		
		<script language="javascript" type="text/javascript">
			var base_url = "<?php echo asset_url(); ?>";
			var asset_url = "<?php echo asset_url(); ?>";
			var controller = "<?php echo ucfirst(@$this->controller); ?>";
			var baseDomain = '<?php echo base_domain(); ?>';	//base domain for XMPP service
		</script>
		
		<style>
			html { 
				  background: url(<?php echo asset_url("images/Logo.jpg?v=0.1");?>) no-repeat center center fixed; 
				  -webkit-background-size: cover;
				  -moz-background-size: cover;
				  -o-background-size: cover;
				  background-size: cover;
				  height: 100%; 
				}
		</style>
	</head>
	<body>
		