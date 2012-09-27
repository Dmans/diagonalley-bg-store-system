<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/main.css" />
		<title>新增上架遊戲</title>
	</head>
	<body>
		<h1>新增上架遊戲</h1>
		<? echo form_open('game/game_action/gid_save'); ?>
			<input type="hidden" name="gam_num" value="<?=$gam_num ?>" />
			<div>遊戲中文名稱:<?=$gam_cname ?></div>
			<div>遊戲英文名稱:<?=$gam_ename ?></div>
			<div>遊戲上架狀態: 上架
			<div>遊戲使用狀態: 店內(未使用) 
			<div>遊戲是否可出租:
				<input type="radio" name="gid_rentable"  value="0" <?=set_radio("gid_rentable","0") ?> />否
				<input type="radio" name="gid_rentable"  value="1" <?=set_radio("gid_rentable","1",TRUE) ?> />是
			</div>
			<?=validation_errors('<div class="error">','</div>') ?>
			<div><input type="submit" value="新增上架遊戲" /><input type="reset" value="重填" /></div>
		</form>
	</body>
	
</html>

