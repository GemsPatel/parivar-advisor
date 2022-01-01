<!DOCTYPE HTML>
<html>
	<head>
		<title>Reset Password</title>
		<link href="https://p.w3layouts.com/demos/reset_password_form/web/css/style.css" rel="stylesheet" type="text/css" media="all" />
		<!-- Custom Theme files -->
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="keywords" content="Reset Password Form skywayplus" />
		<!--google fonts-->
		<link href='//fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900' rel='stylesheet' type='text/css'>
		<script src='//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'></script>
		<style>
			.element-main p { font-size: 0.7em !important; }
			.error_msg p{ color: red; font-size: 0.7em !important; margin-top: -15px; }
			.success_msg p{ color: green; font-size: 0.7em !important; margin-top: -15px; }
		</style>
	</head>
	
	<body>
		<div class="elelment">
			<h2>Reset Password Form</h2>
			<div class="element-main">
				<h1>Forgot Password</h1>
				<p>Please enter your email id registered on admin panel. Password
					email link will be sent on this email id.</p>
				<form method="post" action="<?php echo asset_url('lgs/forgotPassword')?>">
					<input type="text" value="<?php echo set_value('forgot_email'); ?>" class="login user" name="forgot_email" placeholder="Enter Your Email Id" />
					<span class="error_msg"><?php echo (@$error)?form_error('forgot_email'):''; ?></span>
					<span class="success_msg"><p><?php echo (@$success)?$success:''; ?></p></span>
					<input type="submit" value="Submit" name="admin_forgot_pass" class="button green" />
				</form>
				<div style="text-align: center; margin: 13px 0px -25px;">
					<span><a href="<?php echo asset_url();?>" style="text-decoration: none;">Back to Home</a></spam>
				</div>
			</div>
		</div>
	
		<div class="copy-right">
			<p>© 2019 Reset Password. All rights reserved</p>
		</div>
	</body>
</html>