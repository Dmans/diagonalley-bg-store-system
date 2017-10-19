<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/main.css" />
		<link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/flick/jquery-ui-1.8.22.custom.css" />
		<link rel="stylesheet" media="screen" href="<?=base_url(); ?>bootstrap/css/bootstrap.min.css">
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery.min.js"></script>
		<script type="text/javascript" src="<?=base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery-ui.min.js"></script>
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery.ui.datepicker-zh-TW.js"></script>
		
		<script>
            $(document).ready(function(){
                $("input#calDate").datepicker({
					dateFormat:'yy-mm-dd',
				});
    		});
		</script>
		<title>維護行事曆</title>
	</head>
	<body class="container-fluid">
		<h1>維護行事曆</h1>
		<? echo form_open('manage/calendar_action/update'); ?>
			<input type="hidden" name="cal_num" value="<?php echo $cal_num?>" />
			<div>日期:<input id="calDate" name="cal_date" type="text" value="<?php echo set_value('cal_date', $cal_date); ?>"></div>
			<div>日期類型:
				<select id="calType" name="cal_type">
					<option value="0" <?php echo set_select('cal_type', '0', $cal_type=='0'); ?>><?php echo $form_constants->transfer_cal_type(0)?></option>
					<option value="1" <?php echo set_select('cal_type', '1', $cal_type=='1'); ?>><?php echo $form_constants->transfer_cal_type(1)?></option>
				</select>
			</div>
			
			<div>日期說明:<input id="calDesc" name="cal_desc" type="text" value="<?php echo set_value('cal_desc', $cal_desc); ?>"></div>
			<?=validation_errors('<div class="text-danger">','</div>') ?>
			<div>
				<input type="submit" value="維護行事曆" class="btn btn-primary" />
				<input type="reset" value="重填" class="btn btn-default" />
			</div>
		</form>
	</body>

</html>

