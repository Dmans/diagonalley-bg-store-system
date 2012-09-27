<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/main.css" />
		<title>新增使用者</title>
	</head>
	<body>
		<h1>新增使用者</h1>
		<? echo form_open('user/user_action/save'); ?>
			<div>使用者帳號:<input type="text" name="usr_id" maxlength="32" /></div>
			<div>使用者名稱:<input type="text" name="usr_name" maxlength="32" /></div>
			<div>使用者密碼:<input type="password" name="usr_passwd" maxlength="32" /></div>
			<div>確認使用者密碼:<input type="password" name="confirm_usr_passwd" maxlength="32" /></div>
			<div>使用者帳號類型:
				<? if($usr_role==0):  ?><input type="radio" name="usr_role"  value="1" />店長<? endif ?>
				<input type="radio" name="usr_role"  value="2" />員工
				<input type="radio" name="usr_role"  value="3" checked="checked" />會員
			</div>
			<div>使用者啟用狀態:啟用</div>
			<div>使用者備註:<br/>
				<textarea name="usr_memo" cols="50" rows="10"></textarea>
			</div>
			<?=validation_errors('<div class="error">','</div>') ?>
			<div><input type="submit" value="新增使用者" /><input type="reset" value="重填" /></div>
		</form>
	</body>
	
</html>

