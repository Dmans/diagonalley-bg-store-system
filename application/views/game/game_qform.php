<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<!-- <link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/main.css" /> -->
		<link rel="stylesheet" media="screen" href="<?=base_url(); ?>bootstrap/css/bootstrap.min.css">
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="<?=base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
		<title>查詢遊戲資料</title>
	</head>
	<body>
		<h1>查詢遊戲資料</h1>
		<? echo form_open('game/game_action/game_list'); ?>
			<div>遊戲中文名稱:<input type="text" name="gam_cname" maxlength="32" value="<?=set_value("gam_cname","") ?>" /></div>
			<div>遊戲英文名稱:<input type="text" name="gam_ename" maxlength="32" value="<?=set_value("gam_ename","") ?>" /></div>
			<div>遊戲分類:
				<select name="tag_num">
					<option value="-1">請選擇</option>
					<? if(count($tags)>0): ?>
						<? foreach ($tags as $key => $tag): ?>
							<option value="<?=$tag->tag_num ?>"><?=$tag->tag_name ?></option>
						<? endforeach ?>
					<? endif ?>
				</select>
			</div>
			<div>遊戲庫存量:
					<select name="gam_storage">
					<option value="-1">請選擇</option>
					<option value="999">有</option>
					<option value="0">無</option>
				</select>
			</div>
			<div>遊戲是否可出售:
				<select name="gam_sale">
					<option value="-1">請選擇</option>
					<option value="1">是</option>
					<option value="0">否</option>
				</select>
			</div>
			<?=validation_errors('<div class="text-error">','</div>') ?>
			<div>
				<input type="submit" value="查詢遊戲"  class="btn btn-primary" />
				<input type="reset" value="重填" class="btn" />
			</div>
		</form>
		<? if(isset($query_result)):  ?>
			<table id="gameListTable" class="table table-striped table-hover table-bordered table-condensed">
				<tr>
					<? if($usr_role==0 OR $usr_role==1): ?>	
						<th style="width: 100px">查詢/維護</th>
						
					<? endif ?>
					<th style="width: 80px">維護分類</th>
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
						<th style="width: 80px">刪除</th>	
						<!-- <th>上架遊戲</th> -->
					<? endif ?>
				</tr>
				<? foreach ($query_result as $row) : ?> 
					<tr id="gameTr_<?=$row->gam_num ?>">
						<? if($usr_role==0 OR $usr_role==1): ?>	
							<td>
								<a href="<?=site_url("game/game_action/game_page_detail/".$row->gam_num) ?>" class="btn btn-info btn-mini">查詢</a>
								<a href="<?=site_url("game/game_action/game_update_form/".$row->gam_num) ?>" class="btn btn-warning btn-mini">維護</a>
							</td>
						<? endif ?>
						<td>
							<a href="<?=site_url("game/game_action/game_tag_update_form/".$row->gam_num) ?>"class="btn btn-success btn-mini">維護分類</a>
						</td>
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
							<td><a href="<?=site_url("game/game_action/game_remove/".$row->gam_num) ?>" class="btn btn-danger btn-mini">刪除</a></td>
							<!-- <td><a href="<?=site_url("game/game_action/gid_save_form/".$row->gam_num) ?>">新增上架遊戲</a></td> -->
						<? endif ?>
					</tr>
				<? endforeach  ?>
			</table>
		<? endif ?>
	</body>
	
</html>

