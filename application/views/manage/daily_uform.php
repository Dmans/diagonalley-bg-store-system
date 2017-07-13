<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/main.css" />
		<title>維護公告</title>
	</head>
	<body>
		<h3>維護公告</h3>
		<? echo form_open('manage/manage_action/daily_update'); ?>
			<input type="hidden" name="ddr_num" value="<?=$ddr_num ?>" />
			<div>公告內容:<br/>
				<textarea name="ddr_content" cols="50" rows="10"><?=set_value('ddr_content', $ddr_content); ?></textarea>
			</div>
			<div>公告類型:
				<input type="radio" name="ddr_type"  value="0" <?=set_radio("ddr_type","0",($ddr_type==0)?TRUE:FALSE) ?> />一般
				<input type="radio" name="ddr_type" value="1" <?=set_radio("ddr_type","1",($ddr_type==1)?TRUE:FALSE) ?> />置頂
			</div>
			<div>公告狀態:
				<input type="radio" name="ddr_status"  value="0" <?=set_radio("ddr_status","0",($ddr_status==0)?TRUE:FALSE) ?> />隱藏
				<input type="radio" name="ddr_status" value="1" <?=set_radio("ddr_status","1",($ddr_status==1)?TRUE:FALSE) ?> />公開
			</div>
			<?=validation_errors('<div class="text-danger">','</div>') ?>
			<div><input type="submit" value="維護公告" /><input type="reset" value="重填" /></div>
		</form>
	</body>
	
</html>

