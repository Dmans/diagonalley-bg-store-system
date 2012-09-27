<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>員工打卡紀錄查詢</title>
		<link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/main.css" />
		<link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/flick/jquery-ui-1.8.22.custom.css" />
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery-ui-1.8.22.custom.min.js"></script>
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery.ui.datepicker-zh-TW.js"></script>
		
		
		<script type="text/javascript">
			$(document).ready(function(){
				$.datepicker.setDefaults( $.datepicker.regional["zh-TW"] );
				$( "#dateFrom" ).datepicker({
					changeMonth: true,
					numberOfMonths: 3,
					dateFormat:'yy/mm/dd',
					onSelect: function( selectedDate ) {
						$( "#dateTo" ).datepicker( "option", "minDate", selectedDate );
					}
				});
				$( "#dateTo" ).datepicker({
					changeMonth: true,
					numberOfMonths: 3,
					dateFormat:'yy/mm/dd',
					onSelect: function( selectedDate ) {
						$( "#dateFrom" ).datepicker( "option", "maxDate", selectedDate );
					}
				});
			});
			
		</script>
	</head>
	<body>
		<h3>員工打卡紀錄查詢</h3>
		<div>
			<? echo form_open('employ/employ_action/employ_monthly_list'); ?>
				<div>查詢區間:
					從<input type="text" id="dateFrom" name="chk_start_date"/>
					到<input type="text" id="dateTo" name="chk_end_date"/>
				</div>
				<div><input type="submit" value="查詢" /></div>
			</form>
		</div>
		<div>
			<? if(isset($query_result)):  ?>
				<? foreach($query_result as $chk_user): ?>
					<div>
						<table class="list_table">
							<tr>
								<td colspan="4" style="text-align: left">員工:<?=$chk_user->usr_name ?></td>
							</tr>
							<tr>
								<th>上班打卡時間</th>
								<th>下班打卡時間</th>
								<th>工作時數(打卡時數)</th>
								<th>工作時數(審核時數)</th>
							</tr>
							<? foreach($chk_user->chks as $chk): ?>
								<tr>
									<td><?=$chk->chk_in_time ?></td>
									<td><?=$chk->chk_out_time ?></td>
									<td><?=$chk->interval ?></td>
									<td><?=$chk->confirm_hours ?></td>
								</tr>
							<? endforeach ?>
							<tr>
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

