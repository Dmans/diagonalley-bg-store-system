<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" media="screen" href="<?=base_url(); ?>bootstrap/css/bootstrap.min.css">
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery.min.js"></script>
		<script type="text/javascript" src="<?=base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
		<title>使用者資料</title>
	</head>
	<body>
		<h1>使用者資料</h1>
			<div>使用者流水號:<?=$user->usr_num ?></div>
			<div>使用者帳號:<?=$user->usr_id ?></div>
			<div>使用者名稱:<?=$user->usr_name ?></div>
			<div>使用者信箱:<?=$user->usr_mail ?></div>
			<?php if($user->usr_role == 4): ?>
				<div>使用者時薪:<?php echo $user->usr_hourly_salary ?></div>
			<?php endif; ?>
			<div>帳號類型:<?=$user->usr_role_desc ?></div>
			<div>啟用狀態:<?=$user->usr_status_desc ?></div>
			<div>使用者備註:<br/>
				<?=(isset($user->usr_memo))?nl2br($user->usr_memo):"" ?>
			</div>
	</body>
	
</html>

