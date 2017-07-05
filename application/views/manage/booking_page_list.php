<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>客戶定位資料列表</title>
		<link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/main.css" />
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
			});
		</script>
	</head>
	<body>
		<h3>客戶定位資料列表</h3>
		<div><a href="<?=site_url("manage/booking_action/save_form") ?>">新增定位資料</a></div>
		<div class="text-error">僅顯示查詢日以後的定位資料! 時間越接近的越上面</div>
		<table class="list_table">
			<tr>
				<th width="100">定位日期</th>
				<th width="50%">定位資訊</th>
				<th>維護</th>
				<th>刪除</th>
			</tr>
			<? foreach ($bookings as $key=>$row) : ?> 
				<tr>
					<td valign="top"><?=$row->dbk_date ?></td>
					<td>
						<div style="text-align: left"><?=nl2br($row->dbk_memo) ?></div>
					</td>
					<td><a href="<?=site_url("manage/booking_action/update_form/".$row->dbk_num) ?>">維護</a></td>
					<td><a href="<?=site_url("manage/booking_action/remove/".$row->dbk_num) ?>">刪除</a></td>
				</tr>
			<? endforeach  ?>
		</table>
	</body>
</html>

