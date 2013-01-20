<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>管理介面</title>
	</head>
	<body>
		<h1>管理介面</h1>
		<div>使用者:<?=$usr_name?></div>
		<? if($usr_role==0 OR $usr_role==1): ?>
		<div><a target="content" href="https://docs.google.com/spreadsheet/ccc?key=0AoJXiZQFD49ndHhBc05mNFlnaXdDQ2djMFgyLWlPU0E#gid=0">系統提案表</a></div>
		<div><a target="content" href="https://www.google.com/calendar/embed?src=nhn4r2e6tgca9gjm3seu0o3fe0%40group.calendar.google.com&ctz=Asia/Taipei">行事曆</a></div>
		<? endif ?>
		<div><a href="javascript:parent.location.reload();">回首頁</a></div>
	</body>
</html>

