<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/main.css" />
		<title>上架遊戲資料</title>
	</head>
	<body>
		<h1>上架遊戲資料</h1>
		<div>上架遊戲序號:<?=$gid->gid_num ?></div>
		<div>遊戲中文名稱:<?=$gid->gam_cname ?></div>
		<div>遊戲英文名稱:<?=$gid->gam_ename ?></div>
		<div>遊戲上架狀態:<?=$gid->gid_enabled_desc ?></div>
		<div>遊戲使用狀態:<?=$gid->gid_status_desc ?></div>
		<div>遊戲是否可出租:<?=$gid->gid_rentable_desc ?></div>
	</body>
	
</html>

