<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>公告欄</title>
		<link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/main.css" />
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery.min.js"></script>
	</head>
	<body>
		<h1>店內公告欄</h1>
		<? if(isset($top_dailys) && count($top_dailys)>0): ?>
			<h3>置頂公告</h3>
			<table class="list_table">
				<tr>
					<th width="100">公告日期</th>
					<th width="50%">公告內容</th>
					<th>公告者</th>
				</tr>
				<? foreach ($top_dailys as $key=>$row) : ?> 
					<tr>
						<td><?=$row->register_date ?></td>
						<td>
							<div style="text-align: left"><?=nl2br($row->ddr_content) ?></div>
						</td>
						<td><?=$row->usr_name ?></td>
					</tr>
				<? endforeach  ?>
			</table>
		<? endif ?>
		<? if(isset($dailys) && count($dailys)>0): ?>
			<h3>一般公告</h3>
			<table class="list_table">
				<tr>
					<th width="100">公告日期</th>
					<th width="50%">公告內容</th>
					<th>公告者</th>
				</tr>
				<? foreach ($dailys as $key=>$row) : ?> 
					<tr>
						<td><?=$row->register_date ?></td>
						<td>
							<div style="text-align: left"><?=nl2br($row->ddr_content) ?></div>
						</td>
						<td><?=$row->usr_name ?></td>
					</tr>
				<? endforeach  ?>
			</table>
		<? endif ?>
	</body>
</html>

