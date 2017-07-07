<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>員工打卡紀錄查詢</title>
		<link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/main.css" />
		<link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/flick/jquery-ui-1.8.22.custom.css" />
		<link rel="stylesheet" media="screen" href="<?=base_url(); ?>bootstrap/css/bootstrap.min.css">
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery.min.js"></script>
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery-ui-1.8.22.custom.min.js"></script>
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery.ui.datepicker-zh-TW.js"></script>
		<script type="text/javascript" src="<?=base_url(); ?>bootstrap/js/bootstrap.min.js"></script>

		<script type="text/javascript">
			$(document).ready(function(){
			});

		</script>
	</head>
	<body>
		<h3>員工打卡紀錄查詢</h3>
		<div>
			<? echo form_open('employ/employ_action/employ_monthly_list'); ?>
				<div>查詢月份:
					<select name="year_month">
						<?php foreach ($month_options as $option): ?>
							<option value="<?php echo $option?>" <?php echo set_select('year_month', $option)?> ><?php echo $option?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div><input type="submit" value="查詢" class="btn btn-primary" /></div>
			</form>
		</div>
		<div class="row">
			<? if(isset($query_result)):  ?>
				<? foreach($query_result as $chk_user): ?>
					<div class="span10">
						<table class="table table-striped table-hover table-bordered table-condensed">
							<tr>
								<td colspan="4" style="text-align: left">員工:<?=$chk_user->usr_name ?></td>
							</tr>
							<tr>
								<th>上班打卡時間</th>
								<th>下班打卡時間</th>
                                <th>工作備註</th>
                                <th>審核備註</th>
								<th>工作時數(打卡時數)</th>
								<th>工作時數(審核時數)</th>

							</tr>
							<? foreach($chk_user->stores as $store): ?>
							    <tr>
							       <td colspan="6"><?=$store->store_data->sto_name ?></td>
							    </tr>
						        <? foreach($store->chks as $chk): ?>

								<tr>
									<td><?=$chk->chk_in_time ?></td>
									<td><?=$chk->chk_out_time ?></td>
									<td><?=nl2br($chk->chk_note) ?></td>
                                    <td><?=nl2br($chk->confirm_note) ?></td>
									<td><?=$chk->interval ?></td>
									<td><?=$chk->confirm_hours ?></td>
								</tr>
								<? endforeach ?>
								<tr>
								    <td></td>
								    <td></td>
								    <td></td>
                                    <td align="right">小計</td>
                                    <td><?=$store->summary->total_hours  ?></td>
                                    <td><?=$store->summary->total_confirm_hours  ?></td>
                                </tr>
							<? endforeach ?>
							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td align="right">總計</td>
								<td><?=$chk_user->total_hours  ?></td>
								<td><?=$chk_user->total_confirm_hours  ?></td>
							</tr>
						</table>
					</div>
				<? endforeach ?>
			<? endif ?>
		</div>
	</body>
</html>

