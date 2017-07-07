<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<!-- <link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/main.css" /> -->
		<link rel="stylesheet" media="screen" href="<?=base_url(); ?>bootstrap/css/bootstrap.min.css">
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery.min.js"></script>
		<script type="text/javascript" src="<?=base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
		<title>維護遊戲</title>
	</head>
	<body>
		<h1>維護遊戲</h1>
		<? echo form_open('game/game_action/game_update'); ?>
			<div>遊戲流水號:<?=$gam_num ?><input type="hidden" name="gam_num" value="<?=set_value("gam_num",$gam_num) ?>" /></div>
			<div>遊戲中文名稱:<input type="text" name="gam_cname" maxlength="32" value="<?=set_value("gam_cname",$gam_cname) ?>" /></div>
			<div>遊戲英文名稱:<input type="text" name="gam_ename" maxlength="32" value="<?=set_value("gam_ename",$gam_ename) ?>" /></div>
			<div>遊戲庫存:<?=$gam_storage ?></div>
			<div>遊戲庫位:<input type="text" name="gam_locate" maxlength="32" value="<?=set_value("gam_locate",$gam_locate) ?>" /></div>
			<div>遊戲牌套尺寸:<input type="text" name="gam_cardsize" maxlength="32" value="<?=set_value("gam_cardsize",$gam_cardsize) ?>" /></div>
			<div>遊戲牌數量:<input type="text" name="gam_cardcount" maxlength="12" size="12" value="<?=set_value("gam_cardcount",$gam_cardcount) ?>" /></div>
			<div>遊戲售價:<input type="text" name="gam_svalue" maxlength="5" value="<?=set_value("gam_svalue",$gam_svalue) ?>"/></div>
			<div>遊戲成本價:<?=$gam_cvalue ?></div>
			<div>遊戲條碼:
				<? if($barcode != NULL) : ?>
					<a href="<?=site_url("game/game_action/game_barcode_update_form/".$gam_num) ?>" ><?=$barcode->bar_code ?></a>
				<? else : ?>
					尚未連結對應條碼 <a href="<?=site_url("game/game_action/game_barcode_update_form/".$gam_num) ?>"class="btn btn-primary btn-mini">新增條碼</a>
				<? endif ?>
			</div>
			<div>遊戲是否為庫存商品(可出售):
				<input type="radio" name="gam_sale"  value="0" <?=set_radio("gam_sale","0",($gam_sale==0)?TRUE:FALSE) ?> />否
				<input type="radio" name="gam_sale"  value="1" <?=set_radio("gam_sale","1",($gam_sale==1)?TRUE:FALSE) ?> />是
			</div>
			<div>遊戲備註:<br/>
				<textarea name="gam_memo" cols="50" rows="10"><?=set_value("gam_memo",$gam_memo) ?></textarea>
			</div>
			
			<div><input type="submit" value="維護遊戲" /><input type="reset" value="重填" /></div>
		</form>
		<!-- <div>
			<h1>異動遊戲庫存</h1>
			<? echo form_open('game/game_action/game_storage_update'); ?>
				<input type="hidden" name="gam_num" value="<?=set_value("gam_num",$gam_num) ?>" />
				<div>異動庫存:
					<input type="radio" name="modify_option"  value="Y" checked="checked" />增加
					<input type="text" name="modify_gam_storage" maxlength="5" />套</div>
				</div>
				<div>遊戲成本:
					<input type="text" name="gam_cvalue" maxlength="5" />
				</div>
				<div><input type="submit" value="異動庫存" /><input type="reset" value="重填" /></div>
			</form>
		</div> -->
		<?=validation_errors('<div class="text-error">','</div>') ?>
	</body>
	
</html>

