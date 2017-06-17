<html>
<head>
    <title>今日未打卡下班警示</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>

<h2>Hi <?php echo $usr_name?></h2>
<p>目前時間: <?=date("Y-m-d H:i:s") ?></p>
<div>你今天尚未打卡下班！，請登入系統打卡下班</div>
<table border="1">
	<tr>
		<th>店舖</th>
		<th>上班時間</th>
	</tr>
	<tr>
		<td><?php echo $sto_name?></td>
		<td><?php echo $chk_in_time?></td>
	</tr>
</table>

</body>
</html>