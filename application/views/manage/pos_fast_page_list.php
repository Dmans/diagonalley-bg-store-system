<!DOCTYPE html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>快速銷售按鈕列表</title>
	<link rel="stylesheet" media="screen" href="<?=base_url(); ?>bootstrap/css/bootstrap.min.css">
	<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery.min.js"></script>
	<script type="text/javascript" src="<?=base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
</head>
	<h3>快速銷售按鈕列表</h3>
	<div class="col-md-10">
		<table class="table table-striped table-hover table-bordered table-condensed">
			<tr>
				<th>維護</th>
				<th>銷售類型</th>
				<th>銷售說明</th>
				<th>銷售金額</th>
				<th>按鈕排序</th>
				<th>刪除銷售按鈕</th>
			</tr>
			<? foreach($pfs_list as $pfs): ?>
				<tr>
					<td><a href="<?=site_url("manage/pos_action/pos_fast_button_update_form/".$pfs->pfs_num) ?>" class="btn btn-warning btn-xs" >維護</a></td>
					<td><?=$pfs->tag->tag_name ?></td>
					<td><?=$pfs->pod_desc ?></td>
					<td><?=$pfs->pod_svalue ?></td>
					<td><?=$pfs->pfs_order ?></td>
					<td><a href="<?=site_url("manage/pos_action/pos_fast_button_remove/".$pfs->pfs_num) ?>" class="btn btn-danger btn-xs" >刪除</a></td>
				</tr>
			<? endforeach ?>
		</table>
		
	</div>
