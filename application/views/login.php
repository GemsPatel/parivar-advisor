<?php $controller = $this->router->class; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta http-equiv="X-UA-Compatible" content="IE=9" />
		<script type="text/javascript" src="<?php echo asset_url('js/jquery.min.js'); ?>"></script>
		<script type="text/javascript">
			var base_url = "<?php echo base_url(); ?>";
			var controller = "<?php echo ucfirst(@$controller); ?>";
		</script>
		<title>Administrator Login</title>
		
		<link href="<?php echo asset_url('css/admin_login_style.css?v=0.1'); ?>" rel="stylesheet" type="text/css" />
		<style>
			.forgot_pass
			{
				text-decoration: none;
			    font-size: 16px;
			    color: wheat;
			}
			.notification div {
			    display: block;
			    font-style: normal;
			    padding: 10px 10px 10px 36px;
			    line-height: 1.5em;
			    background-color: #fb89a6;
			    font-size: 12px;
			    color: #fff;
			}
			.hide { display: none; }
			
			.error_msg p { font-size: 13px; color: #ff3366; text-align: left; }
		</style>
	</head>
	<body>
		<div class="cont" id="box_bg">
			<div class="demo" id="content">
				<div class="login" id="login">
					<div class="login__check"></div>
					<?php $this->load->view('elements/notifications'); ?>
					<form method="post">
						<div class="login__form">
							<div class="login__row">
								<svg class="login__icon name svg-icon" viewBox="0 0 20 20">
									<path d="M0,20 a10,8 0 0,1 20,0z M10,0 a4,4 0 0,1 0,8 a4,4 0 0,1 0,-8" />
								</svg>
								<input type="text" value="<?php echo set_value('admin_user_emailid'); ?>" name="admin_user_emailid" class="login__input name" placeholder="Email ID"/>
								<span class="error_msg"><?php echo (@$error)?form_error('admin_user_emailid'):''; ?></span>
							</div>
							<div class="login__row">
								<svg class="login__icon pass svg-icon" viewBox="0 0 20 20">
									<path d="M0,20 20,20 20,8 0,8z M10,13 10,16z M4,8 a6,8 0 0,1 12,0" />
								</svg>
								<input type="password" name="admin_user_password" class="login__input pass" placeholder="Password"/>
								<span class="error_msg"><?php echo (@$error)?form_error('admin_user_password'):''; ?></span>
								<span class="error_msg" style="font-size: 13px; color: #ff3366; text-align: left;"><?php echo (@$invalid)?$invalid:''; ?></span>
							</div>
							<button type="submit" name="admin_login" class="login__submit">Sign in</button>
							<a href="<?php echo asset_url('lgs/forgotPassword'); ?>" class="forgot_pass">Forgot Your Password?</a>
							<br></br>
							<span><a href="<?php echo asset_url();?>" style="text-decoration: none; font-size: 16px; color: #fff;">Back to Home</a></span>
						</div>
					</form>
				</div>
			</div>
		</div>
		
		<script type="text/javascript" src="<?php echo asset_url('js/admin_login.js'); ?>"></script>
	</body>
</html>