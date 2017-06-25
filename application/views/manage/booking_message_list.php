<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>客戶定位資料</title>
		<link rel="stylesheet" media="screen" href="<?php echo base_url(); ?>bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/main.css" />
		<script type="text/javascript" src="<?php echo base_url(); ?>scripts/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
			});
		</script>
	</head>
	<body>
		<h1>客戶定位資料</h1>
		<div class="text-error">僅顯示查詢日後兩週的定位資料! 時間越接近的越上面</div>
		<? if(isset($bookings) && count($bookings)>0): ?>
			<table class="table table-hover table-bordered table-condensed">
				<tr>
<!-- 				店舖 定位時間 定位人數 稱謂 電話 備註 -->
					<th width="10%">店鋪</th>
					<th width="18%">訂位日期</th>
					<th width="10%">訂位人數</th>
					<th width="10%">訂位人稱謂</th>
					<th width="10%">電話</th>
					<th text-center width="70%">定位資訊</th>
				</tr>
				<? foreach ($bookings as $key=>$row) : ?> 
					<tr>
						<td valign="top"><?php echo $row->sto_name ?></td>
						<td valign="top"><?php echo $row->dbk_date ?></td>
						<td valign="top"><?php echo $row->dbk_count ?>位</td>
						<td valign="top"><?php echo $row->dbk_name ?></td>
						<td valign="top"><?php echo $row->dbk_phone ?></td>
						<td >
							<div style="text-align: left"><?php echo nl2br($row->dbk_memo) ?></div>
						</td>
					</tr>
				<? endforeach  ?>
			</table>
		<? endif ?>
	</body>
</html>

