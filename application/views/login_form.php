<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<!-- <link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/main.css" /> -->
		<link  rel="stylesheet" media="screen" href="<?=base_url(); ?>bootstrap/css/bootstrap.min.css">
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery.min.js"></script>
		<script type="text/javascript" src="<?=base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
		<style type="text/css">
	      body {
	        padding-top: 40px;
	        padding-bottom: 40px;
	        background-color: #f5f5f5;
	      }

	      .form-signin {
	        max-width: 300px;
	        padding: 19px 29px 29px;
	        margin: 0 auto 20px;
	        background-color: #fff;
	        border: 1px solid #e5e5e5;
	        -webkit-border-radius: 5px;
	           -moz-border-radius: 5px;
	                border-radius: 5px;
	        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
	           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
	                box-shadow: 0 1px 2px rgba(0,0,0,.05);
	      }
	      .form-signin .form-signin-heading{
	        margin-bottom: 10px;
	      }
	      .form-signin input[type="text"],
	      .form-signin input[type="password"] {
	        font-size: 16px;
	        height: auto;
	        margin-bottom: 15px;
	        padding: 7px 9px;
	      }

    </style>
		<title>登入<?php echo SYSTEM_NAME ?>管理介面</title>
	</head>
	<body>
		<div class="container">
			<?=form_open('login_action/login', array('class'=>'form-signin')); ?>
			<h2 class="form-signin-heading">登入<?php echo SYSTEM_NAME ?>管理介面</h2>
					<input type="text" name="usr_id" maxlength="64"  class="form-control" placeholder="Account"/>
					<input type="password" name="usr_passwd" maxlength="32"  class="form-control" placeholder="Password"/>
				<?=validation_errors('<div class="text-danger">','</div>') ?>
				<input type="submit" value="Login" class="btn btn-lg btn-primary" />
			</form>
		</div>
        <div class="container text-center">
                        <img src="<?=base_url(); ?>images/logo/diagonalley.jpg" class="img-rounded"/>
                        <img src="<?=base_url(); ?>images/logo/baker.jpg" class="img-rounded"/>
                        <img src="<?=base_url(); ?>images/logo/sherlock.jpg" class="img-rounded"/>
        </div>
	</body>
</html>

