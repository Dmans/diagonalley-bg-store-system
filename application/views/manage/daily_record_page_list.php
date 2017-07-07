<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>店內公告欄列表</title>
		<link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/main.css" />
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
			});
		</script>
	</head>
	<body>
		<h3>店內公告欄列表(個人)</h3>
		<div><a href="<?=site_url("manage/manage_action/daily_save_form") ?>">新增店內公告</a></div>
		<table class="list_table">
			<tr>
				<th width="100">公告日期</th>
				<th width="50%">公告內容</th>
				<th>維護</th>
				<th>公告類型</th>
				<th>公告狀態</th>
				<th>刪除</th>
			</tr>
			<? foreach ($dailys as $key=>$row) : ?> 
				<tr>
					<td valign="top"><?=$row->register_date ?></td>
					<td>
						<div style="text-align: left"><?=nl2br($row->ddr_content) ?></div>
					</td>
					<td><a href="<?=site_url("manage/manage_action/daily_update_form/".$row->ddr_num) ?>">維護</a></td>
					<td><?=$row->ddr_type_desc ?></td>
					<td><?=$row->ddr_status_desc ?></td>
					<td><a href="<?=site_url("manage/manage_action/daily_remove/".$row->ddr_num) ?>">刪除</a></td>
				</tr>
			<? endforeach  ?>
		</table>
	</body>
</html>

