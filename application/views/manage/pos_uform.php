<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/main.css" />
		<link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/flick/jquery-ui-1.8.22.custom.css" />
		<link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/jquery-ui-timepicker.css" />
		<link rel="stylesheet" media="screen" href="<?=base_url(); ?>bootstrap/css/bootstrap.min.css">
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery-ui-1.8.22.custom.min.js"></script>
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery.ui.datepicker-zh-TW.js"></script>
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery-ui-timepicker.js"></script>
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery-ui-timepicker-zh-TW.js"></script>
		<script type="text/javascript" src="<?=base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				$( "#podDate" ).datetimepicker({
					dateFormat:'yy-mm-dd',
					timeFormat: "hh:mm:ss",
					//showSecond: true,
					hourGrid: 4,
					secondMax:0,
					secondMin:0
				});
			});
			
		</script>
		<title>維護銷售資料</title>
	</head>
	<body>
		<h3>維護銷售資料</h3>
		<? echo form_open('manage/pos_action/update'); ?>
			<input type="hidden" name="pod_num" value="<?=$pod_num ?>" />
			<div>銷售時間:<input type="text" id="podDate" name="pod_date" value="<?=set_value('pod_date', $pod_date); ?>" /></div>
			<div>銷售類型:<?=$tag_name ?></div>
			<div>銷售說明:<input type="text" name="pod_desc" maxlength="256" size="64" value="<?=set_value('pod_desc', $pod_desc); ?>" /></div>
			<div>銷售金額:<input type="text" name="pod_svalue" maxlength="12" size="10" value="<?=set_value('pod_svalue', $pod_svalue); ?>" /></div>
			<div>銷售狀態:
				<? if($pod_status==0): ?>
					<input type="radio" name="pod_status"  value="0" <?=set_radio("pod_status","0",($pod_status==0)?TRUE:FALSE) ?> />暫存
				<? endif ?>
				<input type="radio" name="pod_status"  value="1" <?=set_radio("pod_status","1",($pod_status==1)?TRUE:FALSE) ?> />成立
			</div>
			<?=validation_errors('<div class="error">','</div>') ?>
			<div><input type="submit" value="維護銷售資料" /><input type="reset" value="重填" /></div>
		</form>
	</body>
</html>

