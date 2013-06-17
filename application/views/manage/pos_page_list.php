<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>銷售紀錄查詢</title>
	<link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/main.css" />
</head>
<? if(isset($query_result)):  ?>
	<div>
		<table class="table table-striped table-hover table-borderedtable-condensed">
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
					<td><a href="<?=site_url("manage/pos_action/update_form/".$pos->pod_num) ?>">維護</a></td>
					<td><?=$pos->pod_date ?></td>
					<td><?=$pos->tag->tag_name ?></td>
					<td><?=$pos->pod_desc ?></td>
					<td><?=$pos->pod_svalue ?></td>
					<td><a href="<?=site_url("manage/pos_action/remove/".$pos->pod_num) ?>">刪除</a></td>
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
			<tr>
				<tr>
					<th colspan="4">總計</th>
					<td colspan="2"><?=$query_result->cal_result->total_svalue ?></td>
				</tr>
			</tr>
		</table>
		
	</div>
<? endif ?>

