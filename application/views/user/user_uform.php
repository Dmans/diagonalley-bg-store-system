<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/main.css" />
		<title>維護使用者</title>
	</head>
	<body>
		<h1>維護使用者</h1>
		<? echo form_open('user/user_action/update'); ?>
			<div>使用者流水號:<?=$update_user->usr_num ?><input type="hidden" name="usr_num" value="<?=$update_user->usr_num ?>" /></div>
			<div>使用者帳號:<?=$update_user->usr_id ?></div>
			<div>使用者名稱:<input type="text" name="usr_name" maxlength="32" value="<?=$update_user->usr_name ?>" /></div>
			<div>帳號類型:
				<? if($usr_role==0):  ?><input type="radio" name="usr_role"  value="1" <?=($update_user->usr_role==1)?'checked="checked"':'' ?> />店長<? endif ?>
				<input type="radio" name="usr_role"  value="2" <?=($update_user->usr_role==2)?'checked="checked"':'' ?> />員工
				<input type="radio" name="usr_role"  value="3" <?=($update_user->usr_role==3)?'checked="checked"':'' ?> />會員
			</div>
			<div>啟用狀態:
				<input type="radio" name="usr_status"  value="0" <?=($update_user->usr_status==0)?'checked="checked"':'' ?> />停用
				<input type="radio" name="usr_status"  value="1" <?=($update_user->usr_status==1)?'checked="checked"':'' ?> />啟用
			</div>
			<div>使用者備註:<br/>
				<textarea name="usr_memo" cols="50" rows="10"><?=(isset($update_user->usr_memo))?$update_user->usr_memo:"" ?></textarea>
			</div>
			<?=validation_errors('<div class="error">','</div>') ?>
			<div><input type="submit" value="維護使用者" /><input type="reset" value="重填" /></div>
		</form>
	</body>
	
</html>

