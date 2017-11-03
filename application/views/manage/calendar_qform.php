<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" media="screen" href="<?=base_url(); ?>bootstrap/css/bootstrap.min.css">
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery.min.js"></script>
		<script type="text/javascript" src="<?=base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>scripts/jquery.numeric.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>scripts/underscore-min.js"></script>
		<title>查詢維護行事曆</title>
	</head>
	<body  class="container-fluid">
		<h1>查詢維護行事曆</h1>
		<? echo form_open('manage/calendar_action/lists'); ?>
			<div>日期類型:
				<select id="calType" name="cal_type">
				<option value="-1" <?php echo set_select('cal_type', -1)?>>全部</option>
					<option value="0" <?php echo set_select('cal_type', '0'); ?>><?php echo $form_constants->transfer_cal_type(0)?></option>
					<option value="1" <?php echo set_select('cal_type', '1'); ?>><?php echo $form_constants->transfer_cal_type(1)?></option>
				</select>
			</div>
			<?=validation_errors('<div class="text-danger">','</div>') ?>
			<div><input type="submit" value="查詢" class="btn btn-primary" /></div>
		</form>
		
		<div>
			<? if(isset($query_result) AND !empty($query_result)):  ?>
				<h3>查詢結果</h3>
				<table class="table table-striped table-hover table-bordered table-condensed">
					<tr>
						<th>維護</th>
						<th>日期</th>
						<th>日期類型</th>
						<th>日期說明</th>
						<th>刪除</th>
					</tr>
					<? foreach ($query_result as $row) : ?> 
						<tr>
							<td>
								<a href="<?=site_url("manage/calendar_action/update_form/".$row->cal_num) ?>" class="btn btn-warning btn-xs">維護</a>
							</td>
							<td><?php echo $row->cal_date ?></td>
							<td><?php echo $form_constants->transfer_cal_type($row->cal_type)?></td>
							<td><?php echo $row->cal_desc ?></td>
							<td>
								<a href="<?=site_url("manage/calendar_action/remove/".$row->cal_num) ?>" class="btn btn-danger btn-xs">刪除</a>
							</td>
						</tr>
					<? endforeach  ?>
				</table>
			<? else : ?>
				<h3>尚未進行查詢或查無資料</h3>
			<? endif ?>
		</div>
	</body>
</html>
