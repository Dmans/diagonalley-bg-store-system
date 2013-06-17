<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/main.css" />
		<title>維護活動</title>
	</head>
	<body>
		<h1>維護活動</h1>
		<? echo form_open('activity/activity_action/update'); ?>
			<input type="hidden" name="act_num" value="<?=$act_num ?>" />
			<div>活動名稱:<input type="text" name="act_name" maxlength="32" value="<?=set_value("act_name", $act_name) ?>" /></div>
			<div>活動類型:
				<? if($act_status==0): ?>
					<select name="act_type">
						<option value="0" <?= set_select('act_type', '0', ($act_type=='0')); ?>>加點</option>
						<option value="1" <?= set_select('act_type', '1', ($act_type=='1')); ?>>扣點</option>
						<option value="2" <?= set_select('act_type', '2', ($act_type=='2')); ?>>消費</option>
					</select>
				<? endif ?>
				<? if($act_status!=0): ?>
					<?=$act_type_desc ?>
				<? endif ?>
			</div>
			<div>活動說明:<input type="text" name="act_desc" maxlength="128" size="50" value="<?=set_value("act_desc",$act_desc) ?>" /></div>
			<div>活動數值:
				<? if($act_status==0): ?>
					<input type="text" name="act_value" maxlength="5" size="5" value="<?=set_value("act_value",$act_value) ?>" />
				<? endif ?>
				<? if($act_status!=0): ?>
					<?=$act_value ?>
				<? endif ?>
			</div>
			<div>活動是否啟用:
				<? if($act_status==0): ?>
					<input type="radio" name="act_status"  value="0" <?=set_radio("act_status", "0", ($act_status=='0')) ?> />暫存
				<? endif ?>
				<input type="radio" name="act_status"  value="1" <?=set_radio("act_status", "1", ($act_status=='1')) ?> />啟用
				<input type="radio" name="act_status"  value="2" <?=set_radio("act_status", "2", ($act_status=='2')) ?> />停用
			</div>
			<?=validation_errors('<div class="text-error">','</div>') ?>
			<div><input type="submit" value="維護活動" /></div>
		</form>
	</body>
	
</html>

