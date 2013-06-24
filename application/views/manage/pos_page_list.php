<!DOCTYPE html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>銷售紀錄查詢</title>
	<link rel="stylesheet" media="screen" href="<?=base_url(); ?>bootstrap/css/bootstrap.min.css">
	<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery-1.7.2.min.js"></script>
	<script type="text/javascript" src="<?=base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
</head>
<? if(isset($query_result)):  ?>
	<div class="span10">
		<table class="table table-striped table-hover table-bordered table-condensed">
			<tr>
				<th>維護銷售紀錄</th>
				<th>銷售時間</th>
				<th>銷售類型</th>
				<th>銷售說明</th>
				<th>銷售金額</th>
				<th>刪除銷售紀錄</th>
			</tr>
			<? foreach($query_result->pos_list as $pos): ?>
				<tr>
					<td><a href="<?=site_url("manage/pos_action/update_form/".$pos->pod_num) ?>" class="btn btn-warning btn-mini" >維護</a></td>
					<td><?=$pos->pod_date ?></td>
					<td><?=$pos->tag->tag_name ?></td>
					<td><?=$pos->pod_desc ?></td>
					<td><?=$pos->pod_svalue ?></td>
					<td><a href="<?=site_url("manage/pos_action/remove/".$pos->pod_num) ?>" class="btn btn-danger btn-mini" >刪除</a></td>
				</tr>
			<? endforeach ?>
			<tr>
				<th colspan="4">分項小計</th>
				<td colspan="2"></td>
			</tr>
			<? foreach($query_result->cal_result->tag_sub_svalue as $tag_sub_svalue): ?>
				<tr>
					<td colspan="4"><?=$tag_sub_svalue->tag_name ?></td>
					<td colspan="2"><?=$tag_sub_svalue->sub_svalue ?></td>
				</tr>
			<? endforeach ?>
			<tr class="success">
				<th colspan="4">總計</th>
				<td colspan="2"><?=$query_result->cal_result->total_svalue ?></td>
			</tr>
		</table>
		
	</div>
<? endif ?>

