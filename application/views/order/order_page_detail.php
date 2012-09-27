<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/main.css" />
		<link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/flick/jquery-ui-1.8.22.custom.css" />
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery-ui-1.8.22.custom.min.js"></script>
		<title>訂單資料</title>
	</head>
	<body>
		<h1>訂單資料</h1>
		<div>訂單流水號:<?=$ord_num ?></div>
		<div>訂購會員帳號:<?=$usr_id ?></div>
		<div>訂購遊戲:<?=$gam_cname ?>(<?=$gam_ename ?>)</div>
		<div>訂單類型:<?=$ord_type_desc ?></div>
		<div>訂單金額:<?=$ord_svalue ?></div>
		<div>訂單狀態:<?=$ord_status_desc ?></div>
		<div>訂單成立日期:<?=$ord_date ?></div>
		<div>訂單成立者:<?=$ord_usr_name ?></div>
	</body>
	
</html>

