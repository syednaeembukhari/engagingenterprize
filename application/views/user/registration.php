<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Registration</title>

	<style type="text/css">

	::selection { background-color: #E13300; color: white; }
	::-moz-selection { background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		margin: 40px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}

	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
		text-decoration: none;
	}

	a:hover {
		color: #97310e;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}

	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}

	#body {
		margin: 0 15px 0 15px;
		min-height: 96px;
	}

	p {
		margin: 0 0 10px;
		padding:0;
	}

	p.footer {
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}

	#container {
		margin: 10px;
		border: 1px solid #D0D0D0;
		box-shadow: 0 0 8px #D0D0D0;
	}
	.error{color:#990000}
	</style>
</head>
<body>

<div id="container">
	<h1>User Registration</h1>

	<div id="body">
		<?php echo  form_open_multipart('user/register','id="registrationform" class="registration"');?>

		<p>
			<?php echo form_label('First Name');?>
			<?php echo $regfrm['firstname'];?>
		</p>
		<p>
			<?php echo form_label('last Name');?>
			<?php echo $regfrm['lastname'];?>
		</p>
		<p>
			<?php echo form_label('Email');?>
			<?php echo $regfrm['email'];?>
		</p>
		<p>
			<?php echo form_label('Password');?>
			<?php echo $regfrm['pass'];?>
		</p>
		<p>
			<?php echo form_label('Re-type Password');?>
			<?php echo $regfrm['pass2'];?>
		</p>

		<button type="submit">Register</button>

		<?php echo form_close();?>
		<div class="error"><?php echo validation_errors();?></div>
		<div class="error"><?php echo $this->session->flashdata('message');?></div>
		 
		

		
	</div>

	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
</div>

</body>
</html>
