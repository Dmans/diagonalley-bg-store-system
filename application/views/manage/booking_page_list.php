<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>客戶定位資料列表</title>
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/main.css" />
		<script type="text/javascript" src="<?php echo base_url(); ?>scripts/jquery-1.7.2.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
			});
		</script>
	</head>
	<body>
		<h3>客戶定位資料</h3>
		<div>訂位流水號:<?php echo $bookings->dbk_num ?></div>
		<div>訂位紀錄者:<?php echo $bookings->usr_name ?></div>
		<div>訂位店鋪:<?php echo $bookings->sto_name ?></div>
		<div>訂位時間:<?php echo $bookings->dbk_date ?></div>
		<div>客戶稱謂:<?php echo $bookings->dbk_name ?></div>
		<div>客戶人數:<?php echo $bookings->dbk_count ?></div>
		<div>客戶電話:<?php echo $bookings->dbk_phone ?></div>
		<div>訂位桌名稱:<?php echo $bookings->dtb_name ?></div>
		<div>訂位狀態:<?php if($bookings->dbk_status==0){
		                      echo "隱藏";
		                 }
		                 if ($bookings->dbk_status==1){
		                      echo "公開";
		                 }
		                 if ($bookings->dbk_status==2){
		                     echo "到店";
                         }
                         if ($bookings->dbk_status==3){
                             echo "取消";
                         }?></div>
		<div>客戶備註:<br/>
			<?php echo (isset($bookings->dbk_memo))?nl2br($bookings->dbk_memo):"" ?>
		</div>
	</body>
</html>