<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/main.css" />
		<link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/flick/jquery-ui-1.8.22.custom.css" />
		<link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/jquery-ui-timepicker.css" />
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery.min.js"></script>
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery-ui-1.8.22.custom.min.js"></script>
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery.ui.datepicker-zh-TW.js"></script>
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery-ui-timepicker.js"></script>
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery-ui-timepicker-zh-TW.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
					//另一種寫法input#dbkDate
				$("input[id^='dbkDate']").datetimepicker({
					dateFormat:'yy-mm-dd',
					timeFormat: "hh:mm:ss",
					//showSecond: true,
					hour:12,
					hourGrid: 4,
					secondMax:0,
					secondMin:0
				});
				
			});
			
		</script>
		<title>維護定位資料</title>
	</head>
	<body>
		<h3>維護定位資料</h3>
		<? echo form_open('manage/booking_action/update'); ?>
			<input type="hidden" name="dbk_num" value="<?=$dbk_num ?>" />
			<div>定位時間:<input type="text" id="dbkDate" name="dbk_date" value="<?=set_value('dbk_date', $dbk_date); ?>" /></div>
			<div>定位資訊:<br/>
				<textarea name="dbk_memo" cols="50" rows="10"><?=set_value('dbk_memo', $dbk_memo); ?></textarea>
			</div>
			<div>定位狀態:
				<input type="radio" name="dbk_status"  value="0" <?=set_radio("dbk_status","0",($dbk_status==0)?TRUE:FALSE) ?> />隱藏
				<input type="radio" name="dbk_status" value="1" <?=set_radio("dbk_status","1",($dbk_status==1)?TRUE:FALSE) ?> />公開
			</div>
			<?=validation_errors('<div class="text-error">','</div>') ?>
			<div><input type="submit" value="維護定位資料" /><input type="reset" value="重填" /></div>
		</form>
	</body>
	
</html>

