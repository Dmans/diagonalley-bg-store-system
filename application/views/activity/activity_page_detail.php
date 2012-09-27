<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/main.css" />
		<title>活動資料</title>
	</head>
	<body>
		<h1>活動資料</h1>
		<? echo form_open('activity/activity_action/save'); ?>
			<div>活動名稱:<?=$act_name ?></div>
			<div>活動類型:<?=$act_type_desc ?></div>
			<div>活動說明:<?=$act_desc ?></div>
			<div>活動數值:<?=$act_value ?></div>
			<div>活動是否啟用:<?=$act_status_desc ?></div>
		</form>
	</body>
	
</html>

