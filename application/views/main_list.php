<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		
		<link rel="stylesheet" media="screen" href="<?=base_url(); ?>bootstrap/css/bootstrap.min.css">
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="<?=base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
		<title>管理介面</title>
	</head>
	<body>
		<h2>管理介面</h2>
		<div>使用者:<?=$usr_name?></div>
		<? if($usr_role==0 OR $usr_role==1): ?>
		<!-- <div><a target="content" href="https://docs.google.com/spreadsheet/ccc?key=0AoJXiZQFD49ndHhBc05mNFlnaXdDQ2djMFgyLWlPU0E#gid=0">系統提案表</a></div> -->
		<!-- <div><a target="content" href="https://www.google.com/calendar/embed?src=nhn4r2e6tgca9gjm3seu0o3fe0%40group.calendar.google.com&ctz=Asia/Taipei">行事曆</a></div> -->
		<? endif ?>
		<div><a href="javascript:parent.location.reload();">回首頁</a></div>
	</body>
</html>

