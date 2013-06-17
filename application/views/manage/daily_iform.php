<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/main.css" />
		<title>新增公告</title>
	</head>
	<body>
		<h3>新增公告</h3>
		<? echo form_open('manage/manage_action/daily_save'); ?>
			<div>公告內容:<br/>
				<textarea name="ddr_content" cols="50" rows="10"></textarea>
			</div>
			<div>公告類型:
				<input type="radio" name="ddr_type"  value="0" <?=set_radio("ddr_type","0",TRUE) ?> />一般
				<input type="radio" name="ddr_type" value="1" <?=set_radio("ddr_type","1") ?> />置頂
			</div>
			<div>公告狀態:
				<input type="radio" name="ddr_status"  value="0" <?=set_radio("ddr_status","0") ?> />隱藏
				<input type="radio" name="ddr_status" value="1" <?=set_radio("ddr_status","1",TRUE) ?> />公開
			</div>
			<?=validation_errors('<div class="text-error">','</div>') ?>
			<div><input type="submit" value="新增公告" /><input type="reset" value="重填" /></div>
		</form>
	</body>
	
</html>

