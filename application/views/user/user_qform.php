<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" media="screen" href="<?=base_url(); ?>bootstrap/css/bootstrap.min.css">
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="<?=base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
		<title>查詢使用者</title>
	</head>
	<body>
		<h1>查詢使用者</h1>
		<? echo form_open('user/user_action/lists'); ?>
			<div>帳號:<input type="text" name="usr_id" maxlength="32" /></div>
			<div>名稱:<input type="text" name="usr_name" maxlength="32" /></div>
			<div>信箱:<input type="text" name="usr_mail" maxlength="32" /></div>
			<div>帳號類型:
				<? if($usr_role==0):  ?>
				    <input type="radio" name="usr_role"  value="0" <?=set_radio("usr_role","0")?>/>Root
				    <input type="radio" name="usr_role"  value="1" <?=set_radio("usr_role","1")?>/>店長
			    <? endif ?>
				<? if($usr_role==0 OR $usr_role==1):  ?>
					<input type="radio" name="usr_role" value="2" <?=set_radio("usr_role","2")?>/>員工
					<input type="radio" name="usr_role" value="4" <?=set_radio("usr_role","4", TRUE)?>/>工讀生
				<? endif ?>
				<input type="radio" name="usr_role" value="3" <?=set_radio("usr_role","3")?> />會員
			</div>
			<div>啟用狀態:
				<input type="radio" name="usr_status"  value="0" <?=set_radio("usr_status","0")?> />停用
				<input type="radio" name="usr_status"  value="1" <?=set_radio("usr_status","1",TRUE)?>/>啟用
				<input type="radio" name="usr_status"  value="-1" <?=set_radio("usr_status","-1")?> />全部
			</div>
			<?=validation_errors('<div class="text-error">','</div>') ?>
			<div><input type="submit" value="查詢" class="btn btn-primary" /></div>
		</form>

		<div>
			<? if(isset($query_result)):  ?>
				<h3>查詢結果</h3>
				<table class="table table-striped table-hover table-bordered table-condensed">
					<tr>
						<th>查詢/維護</th>
						<th>使用者流水號</th>
						<th>使用者帳號</th>
						<th>使用者名稱</th>
						<th>使用者信箱</th>
						<th>帳號類型</th>
						<th>啟用狀態</th>
						<th>註冊日期</th>
						<th>上次修改日期</th>
						<? if($usr_role==0): ?>
							<th>登入失敗次數</th>
						<? endif ?>

					</tr>
					<? foreach ($query_result as $row) : ?>
						<tr>
							<td>
								<a href="<?=site_url("user/user_action/page_detail/".$row->usr_num) ?>" class="btn btn-info btn-mini">查詢</a>
							<? if($usr_role==0 OR $usr_role==1): ?>
								<a href="<?=site_url("user/user_action/update_form/".$row->usr_num) ?>" class="btn btn-warning btn-mini">維護</a>
							<? endif ?>
							</td>
							<td><?=$row->usr_num ?></td>
							<td><?=$row->usr_id ?></td>
							<td><?=$row->usr_name ?></td>
							<td><?= $row->usr_mail ?></td>
							<td><?=$row->usr_role_desc ?></td>
							<td><?=$row->usr_status_desc ?></td>
							<td><?=$row->register_date ?></td>
							<td><?=$row->modify_date ?></td>
							<? if($usr_role==0): ?>
								<td><?=$row->usr_error_login ?></td>
							<? endif ?>
						</tr>
					<? endforeach  ?>
				</table>
			<? else : ?>
				<h3>尚未進行查詢或查無資料</h3>
			<? endif ?>
		</div>
	</body>
</html>

