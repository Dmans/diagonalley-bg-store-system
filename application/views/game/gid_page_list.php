<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>New Web Project</title>
		<link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/main.css" />
	</head>
	<body>
		<h3>遊戲上架資料列表</h3>
		<table class="list_table">
			<tr>
				<th>查詢/維護</th>
				<th>遊戲上架流水號</th>
				<th>遊戲中文名稱</th>
				<th>遊戲英文名稱</th>
				<th>遊戲上架狀態</th>
				<th>遊戲使用狀態</th>
				<th>遊戲是否可出租</th>
				
			</tr>
			<? foreach ($gids as $row) : ?> 
				<tr>
					<td>
						<a href="<?=site_url("game/game_action/gid_page_detail/".$row->gid_num) ?>">查詢</a>
					<? if($usr_role==0 OR $usr_role==1): ?>
						/<a href="<?=site_url("game/game_action/gid_update_form/".$row->gid_num) ?>">維護</a>
					<? endif ?>
					</td>
					<td><?=$row->gid_num ?></td>
					<td><?=$row->gam_cname ?></td>
					<td><?=$row->gam_ename ?></td>
					<td><?=$row->gid_enabled_desc ?></td>
					<td><?=$row->gid_status_desc ?></td>
					<td><?=$row->gid_rentable_desc ?></td>
					
				</tr>
			<? endforeach  ?>
		</table>
	</body>
</html>

