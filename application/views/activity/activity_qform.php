<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/main.css" />
		<title>查詢活動</title>
	</head>
	<body>
		<h1>查詢活動</h1>
		<? echo form_open('activity/activity_action/act_list'); ?>
			<div>活動流水號:<input type="text" name="act_num" maxlength="32" /></div>
			<div>活動名稱:<input type="text" name="act_name" maxlength="128" /></div>
			<div>活動類型:
				<input type="radio" name="act_type"  value="1" <?=set_radio("act_type","1")?>/>加點
				<input type="radio" name="act_type" value="2" <?=set_radio("act_type","2")?>/>扣點
				<input type="radio" name="act_type" value="3" <?=set_radio("act_type","3")?> />消費
				<input type="radio" name="act_type"  value="-1" <?=set_radio("act_type","-1",TRUE)?>/>全部
			</div>
			<div>活動啟用狀態:
				<input type="radio" name="act_status"  value="0" <?=set_radio("act_status","0")?> />暫存
				<input type="radio" name="act_status"  value="1" <?=set_radio("act_status","1",TRUE)?>/>啟用
				<input type="radio" name="act_status"  value="2" <?=set_radio("act_status","2")?>/>停用
				<input type="radio" name="act_status"  value="-1" <?=set_radio("act_status","-1")?> />全部
			</div>
			<?=validation_errors('<div class="text-danger">','</div>') ?>
			<div><input type="submit" value="查詢" /></div>
		</form>
		
		<div>
			<? if(isset($query_result)):  ?>
				<h3>查詢結果</h3>
				<table>
					<tr>
						<td>查詢/維護</td>
						<td>活動流水號</td>
						<td>活動名稱</td>
						<td>活動類型</td>
						<td>活動啟用狀態</td>
						<td>註冊日期</td>
					</tr>
					<? foreach ($query_result as $row) : ?> 
						<tr>
							<td>
								<a href="<?=site_url("activity/activity_action/page_detail/".$row->act_num) ?>">查詢</a>
								<? if($row->act_status==0): ?>
									/<a href="<?=site_url("activity/activity_action/update_form/".$row->act_num) ?>">維護</a>
								<? endif ?>
							</td>
							<td><?=$row->act_num ?></td>
							<td><?=$row->act_name ?></td>
							<td><?=$row->act_type_desc ?></td>
							<td><?=$row->act_status_desc ?></td>
							<td><?=$row->register_date ?></td>
						</tr>
					<? endforeach  ?>
				</table>
			<? else : ?>
				<h3>尚未進行查詢或查無資料</h3>
			<? endif ?>
		</div>
	</body>
</html>
