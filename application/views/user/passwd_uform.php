<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/main.css" />
		<link rel="stylesheet" media="screen" href="<?=base_url(); ?>bootstrap/css/bootstrap.min.css">
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery.min.js"></script>
		<script type="text/javascript" src="<?=base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
		<title>維護使用者密碼</title>
	</head>
	<body class="container-fluid">
		<h1>維護使用者密碼</h1>
		<? echo form_open('user/user_action/change_passwd'); ?>
			<div>舊密碼:<input type="password" name="old_usr_passwd" maxlength="32" /></div>
			<div>新密碼:<input type="password" name="usr_passwd" maxlength="32" /></div>
			<div>確認密碼:<input type="password" name="confirm_usr_passwd" maxlength="32" /></div>
			<?=validation_errors('<div class="text-danger">','</div>') ?>
			<div>
				<input type="submit" value="維護密碼" class="btn btn-primary" />
				<input type="reset" value="重填" class="btn btn-default" />
			</div>
		</form>
	</body>
	
</html>

