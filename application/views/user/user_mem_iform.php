<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" media="screen" href="<?=base_url(); ?>bootstrap/css/bootstrap.min.css">
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery.min.js"></script>
		<script type="text/javascript" src="<?=base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
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
			<?=validation_errors('<div class="text-danger">','</div>') ?>
			<div>
				<input type="submit" value="新增會員" class="btn btn-primary" />
				<input type="reset" value="重填" class="btn btn-default" />
			</div>
		</form>
	</body>
	
</html>

