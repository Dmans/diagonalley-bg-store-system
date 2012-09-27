<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/main.css" />
		<title>新增會員</title>
	</head>
	<body>
		<h1>新增會員</h1>
		<? echo form_open('user/user_action/member_save'); ?>
			<div>會員e-mail:<input type="text" name="usr_id" maxlength="128" value="<?=set_value('usr_id', ""); ?>" /></div>
			<div>會員名稱:<input type="text" name="usr_name" maxlength="32" value="<?=set_value('usr_name', ""); ?>" /></div>
			<div>會員備註:<br/>
				<textarea name="usr_memo" cols="50" rows="10"></textarea>
			</div>
			<?=validation_errors('<div class="error">','</div>') ?>
			<div><input type="submit" value="新增會員" /><input type="reset" value="重填" /></div>
		</form>
	</body>
	
</html>

