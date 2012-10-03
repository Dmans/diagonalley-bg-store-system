<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/main.css" />
		<title>查詢遊戲資料</title>
	</head>
	<body>
		<h1>查詢遊戲資料</h1>
		<? echo form_open('game/game_action/game_list'); ?>
			<div>遊戲中文名稱:<input type="text" name="gam_cname" maxlength="32" value="<?=set_value("gam_cname","") ?>" /></div>
			<div>遊戲英文名稱:<input type="text" name="gam_ename" maxlength="32" value="<?=set_value("gam_ename","") ?>" /></div>
			<div>遊戲是否可出售:
				<select name="gam_sale">
					<option value="-1">請選擇</option>
					<option value="1">是</option>
					<option value="0">否</option>
				</select>
			</div>
			<?=validation_errors('<div class="error">','</div>') ?>
			<div><input type="submit" value="查詢遊戲" /><input type="reset" value="重填" /></div>
		</form>
		<? if(isset($query_result)):  ?>
			<table id="gameListTable" class="list_table">
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
				<? foreach ($query_result as $row) : ?> 
					<tr id="gameTr_<?=$row->gam_num ?>">
						<? if($usr_role==0 OR $usr_role==1): ?>	
							<td>
								<a href="<?=site_url("game/game_action/game_page_detail/".$row->gam_num) ?>">查詢</a>
								/<a href="<?=site_url("game/game_action/game_update_form/".$row->gam_num) ?>">維護</a>
							</td>
							<td>
								<a href="<?=site_url("game/game_action/game_tag_update_form/".$row->gam_num) ?>">維護分類</a>
							</td>
							
							
						<? endif ?>
	<!-- 					<td><?=$row->gam_num ?></td> -->
						<td><?=$row->gam_cname ?></td>
						<td><?=$row->gam_ename ?></td>
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
		<? endif ?>
		
	</body>
	
</html>

