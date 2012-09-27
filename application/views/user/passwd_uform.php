<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/main.css" />
		<title>維護使用者密碼</title>
	</head>
	<body>
		<h1>維護使用者密碼</h1>
		<? echo form_open('user/user_action/change_passwd'); ?>
			<div>舊密碼:<input type="password" name="old_usr_passwd" maxlength="32" /></div>
			<div>新密碼:<input type="password" name="usr_passwd" maxlength="32" /></div>
			<div>確認密碼:<input type="password" name="confirm_usr_passwd" maxlength="32" /></div>
			<?=validation_errors('<div class="error">','</div>') ?>
			<div><input type="submit" value="維護密碼" /><input type="reset" value="重填" /></div>
		</form>
	</body>
	
</html>

