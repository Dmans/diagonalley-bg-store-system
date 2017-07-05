<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/main.css" />
		<link rel="stylesheet" media="screen" href="<?=base_url(); ?>bootstrap/css/bootstrap.min.css">
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery.min.js"></script>
		<script type="text/javascript" src="<?=base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
		<title>新增遊戲</title>
	</head>
	<body>
		<h1>新增遊戲</h1>
		<? echo form_open('game/game_action/game_save'); ?>
			<div>遊戲中文名稱:<input type="text" name="gam_cname" maxlength="32" value="<?=set_value("gam_cname","") ?>" /></div>
			<div>遊戲英文名稱:<input type="text" name="gam_ename" maxlength="32" value="<?=set_value("gam_ename","") ?>" /></div>
			<!-- <div>遊戲庫存:<input type="text" name="gam_storage" maxlength="5" value="<?=set_value("gam_storage","") ?>" /></div> -->
			<input type="hidden" name="gam_storage" value="0" />
			<div>遊戲庫位:<input type="text" name="gam_locate" maxlength="32" value="<?=set_value("gam_locate","") ?>" /></div>
			<div>遊戲牌套尺寸:<input type="text" name="gam_cardsize" maxlength="32" value="<?=set_value("gam_cardsize","") ?>" /></div>
			<div>遊戲牌數量:<input type="text" name="gam_cardcount" maxlength="12" size="12" value="<?=set_value("gam_cardcount","") ?>" /></div>
			<div>遊戲售價:<input type="text" name="gam_svalue" maxlength="5" value="<?=set_value("gam_svalue","") ?>"/></div>
			<div>遊戲成本價:<input type="text" name="gam_cvalue" maxlength="5" value="<?=set_value("gam_cvalue","") ?>"/></div>
			<div>遊戲是否為庫存商品(可出售):
				<input type="radio" name="gam_sale"  value="0" <?=set_radio("gam_sale","0") ?> />否
				<input type="radio" name="gam_sale"  value="1" <?=set_radio("gam_sale","1",TRUE) ?> />是
			</div>
			<div>遊戲備註:<br/>
				<textarea name="gam_memo" cols="50" rows="10"><?=set_value("gam_memo","") ?></textarea>
			</div>
			<?=validation_errors('<div class="text-error">','</div>') ?>
			<div><input type="submit" value="新增遊戲" class="btn btn-primary" /><input type="reset" value="重填" class="btn" /></div>
		</form>
	</body>
	
</html>

