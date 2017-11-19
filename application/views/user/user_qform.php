<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/flick/jquery-ui-1.8.22.custom.css" />
		<link rel="stylesheet" media="screen" href="<?=base_url(); ?>bootstrap/css/bootstrap.min.css">
		<script type="text/javascript" src="<?php echo base_url(); ?>scripts/jquery.min.js"></script>
		<script type="text/javascript" src="<?=base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?=base_url(); ?>scripts/common/ajaxForm.js"></script>
		<script>
			$(document).ready(function(){

			    $('button.editButton').click(function(){
				    var usrNum = $(this).attr("usr_num");
				    var url = "<?php echo site_url("user/user_action/update_form")."/" ?>"
				    showDetailContent(usrNum, url);
					
				});
				
				$('button.detailButton').click(function(){
				    var usrNum = $(this).attr("usr_num");
				    var url = "<?php echo site_url("user/user_action/page_detail")."/" ?>"
				    showDetailContent(usrNum, url);
					
				});
			});
		</script>
		<title>查詢使用者</title>
	</head>
	<body class="container-fluid">
		<h1>查詢使用者</h1>
		<? echo form_open('user/user_action/lists', 'id="listForm"'); ?>
			<div>帳號:<input type="text" name="usr_id" maxlength="32" value="<?php echo set_value("usr_id", "")?>"/></div>
			<div>名稱:<input type="text" name="usr_name" maxlength="32" value="<?php echo set_value("usr_name", "")?>" /></div>
			<div>信箱:<input type="text" name="usr_mail" maxlength="32" value="<?php echo set_value("usr_mail", "")?>" /></div>
			<div>帳號類型:
				<? if($user_usr_role==USR_ROLE_ROOT):  ?>
				    <input type="radio" name="usr_role"  value="0" <?=set_radio("usr_role","0")?>/>Root
				    <input type="radio" name="usr_role"  value="1" <?=set_radio("usr_role","1")?>/>店長
			    <? endif ?>
				<? if($user_usr_role==USR_ROLE_ROOT OR $user_usr_role==USR_ROLE_MANAGER):  ?>
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
			<?=validation_errors('<div class="text-danger">','</div>') ?>
			<div><input type="submit" value="查詢" class="btn btn-primary" /></div>
		</form>

		<div>
			<? if(!empty($query_result)):  ?>
				<h3>查詢結果</h3>
				<table class="table table-striped table-hover table-bordered table-condensed">
					<tr>
						<th>查詢/維護</th>
						<th>使用者帳號</th>
						<th>使用者名稱</th>
						<th>使用者信箱</th>
						<th>帳號類型</th>
						<th>啟用狀態</th>
						<th>上次修改日期</th>
						<? if($user_usr_role == USR_ROLE_ROOT): ?>
							<th>薪資</th>
							<th>登入失敗次數</th>
						<? endif ?>

					</tr>
					<? foreach ($query_result as $row) : ?>
						<tr>
							<td>
								<button class="btn btn-info btn-xs detailButton" usr_num=<?php echo $row->usr_num?>>查詢</button>
							<? if($user_usr_role==USR_ROLE_ROOT OR $user_usr_role==USR_ROLE_MANAGER): ?>
								<button class="btn btn-warning btn-xs editButton" usr_num=<?php echo $row->usr_num?>>維護</button>
							<? endif ?>
							
							</td>
							<td><?=$row->usr_id ?></td>
							<td><?=$row->usr_name ?></td>
							<td><?= $row->usr_mail ?></td>
							<td><?=$row->usr_role_desc ?></td>
							<td><?=$row->usr_status_desc ?></td>
							<td><?=$row->modify_date ?></td>
							<? if($user_usr_role == USR_ROLE_ROOT): ?>
								<td>
									<?php if($row->usr_role == USR_ROLE_PART_TIME): ?>
										時薪:<?=$row->usr_salary?>
									<?php endif;?>
									<?php if($row->usr_role == USR_ROLE_MANAGER OR $row->usr_role == USR_ROLE_EMPLOYEE): ?>
										<div>每月底薪:<?php echo $row->usr_monthly_salary?></div>
										<div>每月基本工時:<?php echo $row->usr_base_hours ?>小時</div>
									<?php endif;?>
									
								</td>
								<td><?=$row->usr_error_login ?></td>
							<? endif ?>
						</tr>
					<? endforeach  ?>
				</table>
			<? else : ?>
				<h3>尚未進行查詢或查無資料</h3>
			<? endif ?>
		</div>
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
    				<div class="modal-body">
    				</div>
				</div>
			</div>
		</div>
	</body>
</html>

