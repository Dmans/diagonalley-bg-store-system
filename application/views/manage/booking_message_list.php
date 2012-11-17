<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>客戶定位資料</title>
		<link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/main.css" />
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery-1.7.2.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
			});
		</script>
	</head>
	<body>
		<h1>客戶定位資料</h1>
		<div class="error">僅顯示查詢日後兩週的定位資料! 時間越接近的越上面</div>
		<? if(isset($bookings) && count($bookings)>0): ?>
			<table class="list_table">
				<tr>
					<th width="100px">定位日期</th>
					<th width="70%">定位資訊</th>
				</tr>
				<? foreach ($bookings as $key=>$row) : ?> 
					<tr>
						<td valign="top"><?=$row->dbk_date ?></td>
						<td >
							<div style="text-align: left"><?=nl2br($row->dbk_content) ?></div>
						</td>
					</tr>
				<? endforeach  ?>
			</table>
		<? endif ?>
	</body>
</html>

