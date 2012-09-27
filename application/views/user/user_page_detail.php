<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/main.css" />
		<title>使用者資料</title>
	</head>
	<body>
		<h1>使用者資料</h1>
			<div>使用者流水號:<?=$user->usr_num ?></div>
			<div>使用者帳號:<?=$user->usr_id ?></div>
			<div>使用者名稱:<?=$user->usr_name ?></div>
			<div>帳號類型:<?=$user->usr_role_desc ?></div>
			<div>啟用狀態:<?=$user->usr_status_desc ?></div>
			<div>使用者備註:<br/>
				<?=(isset($user->usr_memo))?nl2br($user->usr_memo):"" ?>
			</div>
	</body>
	
</html>

