<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/main.css" />
		<title>維護上架遊戲</title>
	</head>
	<body>
		<h1>維護上架遊戲</h1>
		<? echo form_open('game/game_action/gid_update'); ?>
			<input type="hidden" name="gid_num" value="<?=$gid_num ?>" />
			<div>上架遊戲序號:<?=$gid_num ?></div>
			<div>遊戲中文名稱:<?=$gam_cname ?></div>
			<div>遊戲英文名稱:<?=$gam_ename ?></div>
			<div>遊戲上架狀態:
				<input type="radio" name="gid_enabled"  value="0" <?=set_radio("gid_enabled","0",($gid_enabled==0)?TRUE:FALSE) ?> />下架
				<input type="radio" name="gid_enabled"  value="1" <?=set_radio("gid_enabled","1",($gid_enabled==1)?TRUE:FALSE) ?> />上架
			</div>
			<div>遊戲使用狀態:<?=$gid_status_desc ?></div>
			<div>遊戲是否可出租:
				<input type="radio" name="gid_rentable"  value="0" <?=set_radio("gid_rentable","0",($gid_rentable==0)?TRUE:FALSE) ?> />否
				<input type="radio" name="gid_rentable"  value="1" <?=set_radio("gid_rentable","1",($gid_rentable==1)?TRUE:FALSE) ?> />是
			</div>
			<?=validation_errors('<div class="text-error">','</div>') ?>
			<div><input type="submit" value="維護上架遊戲" /><input type="reset" value="重填" /></div>
		</form>
	</body>
</html>

