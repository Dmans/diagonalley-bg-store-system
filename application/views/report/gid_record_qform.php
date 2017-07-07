<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/main.css" />
		<link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/flick/jquery-ui-1.8.22.custom.css"  />
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery.min.js"></script>
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery-ui-1.8.22.custom.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function() {
				$( "#dateFrom" ).datepicker({
					defaultDate: "+1w",
					dateFormat: "yy-mm-dd",
					changeMonth: true,
					numberOfMonths: 3,
					onSelect: function( selectedDate ) {
						$( "#dateTo" ).datepicker( "option", "minDate", selectedDate );
					}
				});
				$( "#dateTo" ).datepicker({
					defaultDate: "+1w",
					dateFormat: "yy-mm-dd",
					changeMonth: true,
					numberOfMonths: 3,
					onSelect: function( selectedDate ) {
						$( "#dateFrom" ).datepicker( "option", "maxDate", selectedDate );
					}
				});
			});
		</script>
		<title>遊戲使用報表</title>
	</head>
	<body>
		<h1>遊戲使用報表</h1>
		<? echo form_open('report/report_action/gid_record_list'); ?>
		
			<div>查詢區間:
				<input type="text" id="dateFrom" name="date_from" />~
				<input type="text" id="dateTo" name="date_to" />
			</div>
			<?=validation_errors('<div class="text-error">','</div>') ?>
			<div><input type="submit" value="查詢" /></div>
		</form>
		
		<div>
			<? if(isset($query_result)):  ?>
				<h3>查詢結果</h3>
				<table>
					<tr>
						<td>查詢/維護</td>
						<td>使用者流水號</td>
						<td>使用者帳號</td>
						<td>使用者名稱</td>
						<td>帳號類型</td>
						<td>啟用狀態</td>
						<td>註冊日期</td>
						<td>上次修改日期</td>
						
					</tr>
					<? foreach ($query_result as $row) : ?> 
						<tr>
							<td>
								<a href="<?=site_url("user/user_action/page_detail/".$row->usr_num) ?>">查詢</a>
							<? if($usr_role==0 OR $usr_role==1): ?>
								/<a href="<?=site_url("user/user_action/update_form/".$row->usr_num) ?>">維護</a>
							<? endif ?>
							</td>
							<td><?=$row->usr_num ?></td>
							<td><?=$row->usr_id ?></td>
							<td><?=$row->usr_name ?></td>
							<td><?=$row->usr_role_desc ?></td>
							<td><?=$row->usr_status_desc ?></td>
							<td><?=$row->register_date ?></td>
							<td><?=$row->modify_date ?></td>
						</tr>
					<? endforeach  ?>
				</table>
			<? else : ?>
				<h3>尚未進行查詢或查無資料</h3>
			<? endif ?>
		</div>
	</body>
</html>
