<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/main.css" />
		<title>登入介面</title>
	</head>
	<body>
		<h1>登入管理介面</h1>
		<div>
			<? echo form_open('login_action/login'); ?>
				<div>
					Account: <input type="text" name="usr_id" maxlength="64" />
				</div>
				<div>
					Password: <input type="password" name="usr_passwd" maxlength="32" />
				</div>
				<?=validation_errors('<div class="error">','</div>') ?>
				<input type="submit" value="Login" />
			</form>
		</div>
	</body>
</html>

