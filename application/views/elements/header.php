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
	
	    <!-- Bootstrap core CSS     -->
	    <link href="<?php echo asset_url('css/bootstrap.min.css')?>" rel="stylesheet" />
	    
	    <!-- Bootstrap core CSS     -->
	    <link href="<?php echo asset_url('css/stylesheet.css?v='.time())?>" rel="stylesheet" />
	
	    <!-- Animation library for notifications   -->
	    <link href="<?php echo asset_url('css/animate.min.css?v='.time())?>" rel="stylesheet"/>
	
	    <!--  Paper Dashboard core CSS    -->
	    <link href="<?php echo asset_url('css/paper-dashboard.css?v='.time())?>" rel="stylesheet"/>
	
		<script type="text/javascript" src="<?php echo asset_url('js/jquery.min.js'); ?>"></script>
		<script type="text/javascript" src="<?php echo asset_url('js/admin.js?v='.time()); ?>"></script>
	
		<!-- Paper Dashboard Core javascript and methods -->
		<script src="<?php echo asset_url('js/paper-dashboard.js?v='.time())?>"></script>
		
	    <!--  Fonts and icons     -->
	    <link href="<?php echo asset_url('css/font-awesome.min.css');?>" rel="stylesheet">
	    <link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>
	    <link href="<?php echo asset_url('css/themify-icons.css');?>" rel="stylesheet">
	
	<script language="javascript" type="text/javascript">
		var base_url = "<?php echo asset_url(); ?>";
		var asset_url = "<?php echo asset_url(); ?>";
		var controller = "<?php echo ucfirst(@$this->controller); ?>";
		var baseDomain = '<?php echo base_domain(); ?>';	//base domain for XMPP service
	</script>
	</head>
	<body>
		<style> div.dropdown.show-dropdown {display: none;} </style>
		<div class="wrapper">
			<?php $this->load->view('elements/leftbar-menu');?>
			<div class="main-panel">
				<?php $this->load->view('elements/header-menu');?>