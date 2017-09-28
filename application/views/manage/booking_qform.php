<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" media="screen" href="<?=base_url(); ?>bootstrap/css/bootstrap.min.css">
        <script type="text/javascript" src="<?=base_url(); ?>scripts/jquery.min.js"></script>
		<script type="text/javascript" src="<?=base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
		<title>查詢當前訂位資料</title>
	</head>
	<body>
		<h1>查詢訂位資料</h1>
		<? echo form_open('manage/booking_action/lists'); ?>
			<div>客戶名稱:<input type="text" name="dbk_name" maxlength="32" /></div>
			<div>店鋪名稱:
				<select name="sto_num">
                    <? foreach ($stores as $store): ?>
                        <option value="<?php echo $store->sto_num ?>" title="<?php echo $store->sto_name ?>" ><?php echo $store->sto_name ?></option>
                    <? endforeach ?>
                </select>
            </div>
			<div>客戶手機:<input type="text" name="dbk_phone" maxlength="32" /></div>
			<?php //echo validation_errors('<div class="text-danger">','</div>') ?>
			<div><input type="submit" value="查詢" class="btn btn-primary" /></div>
		</form>
		<h1>查詢歷史訂位資料</h1>
		<?php echo form_open('manage/booking_action/booking_historical_lists');?>
			<div>查詢月份:
					<select name="year_month">
						<?php foreach ($month_options as $option): ?>
							<option value="<?php echo $option?>" <?php echo set_select('year_month', $option)?> ><?php echo $option?></option>
						<?php endforeach; ?>
					</select>
				</div>
			<div>客戶手機:<input type="text" name="dbk_phone" maxlength="32" /></div>
			<?php //echo validation_errors('<div class="text-danger">','</div>') ?>
			<div><input type="submit" value="查詢" class="btn btn-primary" /></div>
		</form>	
		<div>
			<? if(!empty($query_result)):  ?>
				<h3>查詢結果</h3>
				<table class="table table-striped table-hover table-bordered table-condensed">
					<tr>
						<th>維護</th>
						<th>店鋪</th>
						<th>訂位日期</th>
						<th>客戶稱謂</th>
						<th>電話</th>
						<th>客戶人數</th>
					</tr>
					<? foreach ($query_result as $row) : ?>
						<tr>
						
							<td>
								<a href="<?=site_url("manage/booking_action/booking_page_list/".$row->dbk_num) ?>" class="btn btn-info btn-xs">詳細</a>
								<a href="<?=site_url("manage/booking_action/update_form/".$row->dbk_num) ?>" class="btn btn-warning btn-xs">維護</a>
							</td>
							<td><?php echo $row->sto_name ?></td>
							<td><?php echo $row->dbk_date ?></td>
							<td><?php echo $row->dbk_name ?></td>
							<td><?php echo $row->dbk_phone ?></td>
							<td><?php echo $row->dbk_count ?></td>
						</tr>
					<? endforeach  ?>
				</table>
			<? else : ?>
				<h3>尚未進行查詢或查無資料</h3>
			<? endif ?>
		</div>
	</body>
</html>