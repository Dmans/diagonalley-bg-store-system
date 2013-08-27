<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>New Web Project</title>
		<link rel="stylesheet" media="screen" href="<?=base_url(); ?>bootstrap/css/bootstrap.min.css">
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="<?=base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				$('input#searchGamName').change(function(){
					$('#gameListTable tr[id^="gameTr_"]').hide();
					var search=$(this).val().toLowerCase();
					$("tr[id^='gameTr_'] td.gamNameTarget").filter(function(){
						return ($(this).text().toLowerCase().indexOf(search)>=0) ;
					}).parent().show();
				});
			});
		</script>
	</head>
	<body>
		<h3>遊戲資料列表</h3>
		<div>遊戲名稱:<input type="text" id="searchGamName" /></div>
		<table id="gameListTable" class="table table-striped table-hover table-bordered table-condensed">
			<tr>
				<? if($usr_role==0 OR $usr_role==1): ?>	
					<th>查詢/維護</th>
					<th>維護分類</th>
				<? endif ?>
<!-- 				<th>遊戲流水號</th> -->
				<th>遊戲中文名稱</th>
				<th>遊戲英文名稱</th>
				<th>遊戲庫存</th>
				<th>遊戲庫位</th>
				<th>遊戲牌套尺寸</th>
				<th>遊戲牌數量</th>
				<th>遊戲售價</th>
				<th>遊戲備註</th>
				<? if($usr_role==0 OR $usr_role==1): ?>
					<th>刪除</th>	
					<th>上架遊戲</th>
				<? endif ?>
			</tr>
			<? foreach ($games as $row) : ?> 
				<tr id="gameTr_<?=$row->gam_num ?>">
					<? if($usr_role==0 OR $usr_role==1): ?>	
						<td>
							<a href="<?=site_url("game/game_action/game_page_detail/".$row->gam_num) ?>" class="btn btn-info btn-small">查詢</a>
							/<a href="<?=site_url("game/game_action/game_update_form/".$row->gam_num) ?>" class="btn btn-warning btn-small">維護</a>
						</td>
						<td>
							<a href="<?=site_url("game/game_action/game_tag_update_form/".$row->gam_num) ?>">維護分類</a>
						</td>
						
						
					<? endif ?>
					<td><?=$row->gam_num ?></td>
					<td class="gamNameTarget"><?=$row->gam_cname ?></td>
					<td class="gamNameTarget"><?=$row->gam_ename ?></td>
					<td><?=$row->gam_storage ?></td>
					<td><?=$row->gam_locate ?></td>
					<td><?=$row->gam_cardsize ?></td>
					<td><?=$row->gam_cardcount ?></td>
					<td><?=$row->gam_svalue ?></td>
					<td><?=(isset($row->gam_memo))?nl2br($row->gam_memo):"" ?></td>
					<? if($usr_role==0 OR $usr_role==1): ?>	
						<td><a href="<?=site_url("game/game_action/game_remove/".$row->gam_num) ?>">刪除</a></td>
						<td><a href="<?=site_url("game/game_action/gid_save_form/".$row->gam_num) ?>">新增上架遊戲</a></td>
					<? endif ?>
				</tr>
			<? endforeach  ?>
		</table>
	</body>
</html>

