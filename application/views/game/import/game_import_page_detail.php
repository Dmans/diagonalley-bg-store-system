<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" media="screen" href="<?=base_url(); ?>bootstrap/css/bootstrap.min.css">
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="<?=base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
		<title>遊戲入庫單詳細資料</title>
	</head>
	<body>
		<h3>遊戲入庫單詳細資料</h3>
			
		<table id="gimTable" class="table table-striped table-hover table-bordered table-condensed">
			<tr>
				<th>遊戲入庫單號</th>
				<th>遊戲入庫時間</th>
				<th>入庫人員</th>	
			</tr>
			<tr>
				<td><?=$gim_detail->gim_num ?></td>
				<td><?=$gim_detail->gim_date ?></td>
				<td><?=$gim_detail->usr_name ?></td>
			</tr>
		</table>
		
		<table class="table table-striped table-hover table-bordered table-condensed">
			<tr>
				<th>入庫遊戲名稱</th>
				<th>入庫數量</th>
				<th>遊戲成本</th>
				<th>入庫前成本</th>
				<th>入庫後成本</th>
				<th>進貨來源</th>
			</tr>
			<? foreach ($gim_detail->gii_list as $key => $gii) : ?>
			<tr>
				<td><?=$gii->game->gam_num." ".$gii->game->gam_cname ?></td>
				<td><?=$gii->gii_ivalue ?></td>
				<td><?=$gii->gii_imp_cvalue ?></td>
				<td><?=$gii->gii_old_cvalue ?></td>
				<td><?=$gii->gii_new_cvalue ?></td>
				<td><?=$gii->gii_source ?></td>
			</tr>	
			<? endforeach ?>
		</table>
	</body>
</html>

