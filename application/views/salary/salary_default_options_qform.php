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
		<title>查詢維護常用薪資附加項目</title>
	</head>
	<body  class="container-fluid">
		<h1>查詢維護常用薪資附加項目</h1>
		<? echo form_open('salary/salary_default_options_action/lists'); ?>
			<div>項目說明:<input type="text" name="dsdo_desc" maxlength="128" /></div>
			<div>項目類型:
				<select id="dsdoType" name="dsdo_type">
					<option value="0" <?php echo set_select('dsdo_type', 0)?>><?php echo $form_constants->transfer_dso_type(0)?></option>
					<option value="1" <?php echo set_select('dsdo_type', 1)?>><?php echo $form_constants->transfer_dso_type(1)?></option>
					<option value="2" <?php echo set_select('dsdo_type', 2)?>><?php echo $form_constants->transfer_dso_type(2)?></option>
					<option value="3" <?php echo set_select('dsdo_type', 3)?>><?php echo $form_constants->transfer_dso_type(3)?></option>
				</select>
			</div>
			<?=validation_errors('<div class="text-danger">','</div>') ?>
			<div><input type="submit" value="查詢" class="btn btn-primary" /></div>
		</form>
		
		<div>
			<? if(isset($query_result)):  ?>
				<h3>查詢結果</h3>
				<table class="table table-striped table-hover table-bordered table-condensed">
					<tr>
						<th>維護</th>
						<th>項目類型</th>
						<th>項目說明</th>
						<th>項目金額</th>
						<th>刪除</th>
					</tr>
					<? foreach ($query_result as $row) : ?> 
						<tr>
							<td>
								<a href="<?=site_url("salary/salary_default_options_action/update_form/".$row->dsdo_num) ?>" class="btn btn-warning btn-xs">維護</a>
							</td>
							<td><?php echo $form_constants->transfer_dso_type($row->dsdo_type)?></td>
							<td><?php echo $row->dsdo_desc ?></td>
							<td><?php echo $row->dsdo_value ?></td>
							<td>
								<a href="<?=site_url("salary/salary_default_options_action/remove/".$row->dsdo_num) ?>" class="btn btn-danger btn-xs">刪除</a>
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
