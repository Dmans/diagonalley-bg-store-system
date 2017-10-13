<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>客戶定位資料</title>
		<link rel="stylesheet" media="screen" href="<?php echo base_url(); ?>bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/main.css" />
		<script type="text/javascript" src="<?php echo base_url(); ?>scripts/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){

				$('input[id^="checkInBooking"]').each(function(){
					$(this).click(function(){
						var dbkNum=$('input#checkIndbkNum').val();
						var stoNum=$('input#checkInstoNum').val();
						$.getJSON("<?=site_url("manage/booking_ajax_action/checkin_booking") ?>",{
							dbk_num : dbkNum,
						    dbk_status : 2,
						    },
						function(data){
						    alert("客人到店");
							parent.location.reload();
							return;
						});
						
					});
				});
				
				$('input[id^="cancelBooking"]').each(function(){
					$(this).click(function(){
						var dbkNum=$('input#canceldbkNum').val();
						var stoNum=$('input#cancelstoNum').val();
						$.getJSON("<?=site_url("manage/booking_ajax_action/checkin_booking") ?>",{
							dbk_num : dbkNum,
							dbk_status : 3,
							},
						function(data){
						    alert("客人取消");
						    parent.location.reload();
						});
					});
				});

			    (function () {
			        var target = "__current_datetime__";
			        var padLeft = function(str) {
			            str = "00" + str;
			            return str.substring(str.length-2)
			        };
			        var getCurrentDateTime = function() {
			            var d = new Date();
			            return d.getFullYear() + "&#24180;"
			                + padLeft(d.getMonth()+1) + "&#26376;"
			                + padLeft(d.getDate()) + "&#26085; "
			                + padLeft(d.getHours()) + ":"
			                + padLeft(d.getMinutes()) + ":"
			                + padLeft(d.getSeconds());
			        };
			        var updateCurrentDateTime = function(id) {
			            document.getElementById(id).innerHTML = getCurrentDateTime();
			        };
			        updateCurrentDateTime(target);
			        setInterval(function() {
			            updateCurrentDateTime(target);
			        }, 99);
			    }) ()


				
			    $("#tabs a").first().tab("show");
				
			    $("#tabs a").click(function(e){
					e.preventDefault();
					$(this).tab("show");
				});
			});
			
		</script>
	</head>
	<body>
		<h1>客戶定位資料</h1>
		<div role="tabpanel">
		 <ul id="tabs" class="nav nav-tabs nav-justified" role="tadlist">
		 <?php foreach ($stores as $key=>$row) : ?> 
				<li role="presentation"><a href="#tab_<?php echo $row->sto_num?>" aria-controls="tab_1" role="tab" data-toggle="tab"><?php echo $row->sto_name?></a>
		<?php endforeach  ?>
		</ul>
		<div class="tab-content">
			<?php foreach ($stores as $key=>$rows) : ?> 
			    <span id="__current_datetime__"></span>
    			<div role="tabpanel" class="tab-pane fade in active" id="tab_<?php echo $rows->sto_num?>">
    				<div class="text-danger">僅顯示查詢日後兩週的定位資料! 時間越接近的越上面</div>
    				<? if(isset($bookings) && count($bookings)>0): ?>
    				<table class="table table-hover table-bordered table-condensed">
    					<tr>
    <!-- 				店舖 定位時間 定位人數 稱謂 電話 備註 -->
    						<th width="5%">到店</th>
    						<th width="10%">店鋪</th>
    						<th width="18%">訂位日期</th>
    						<th width="7%">訂位人數</th>
    						<th width="10%">訂位人稱謂</th>
    						<th width="10%">電話</th>
    						<th text-center width="30%">定位資訊</th>
    						<th width="5%">取消</th>
    					</tr>
    					<? foreach ($bookings as $key=>$row) : ?> 
    					<?php if($rows->sto_num==$row->sto_num):?>
    					<tr>
    						<td id="checkInBooking_<?=$row->dbk_num ?>">
    							<input type="button" id="checkInBooking_<?=$row->dbk_num ?>" value="到店" class="btn btn-primary btn-xs"/>
    							<input type="hidden" id="checkIndbkNum" value="<?=$row->dbk_num ?>" />
    						</td>
    						<td valign="top"><?php echo $row->sto_name ?></td>
    						<td valign="top"><?php echo $row->dbk_date ?></td>
    						<td valign="top"><?php echo $row->dbk_count ?>位</td>
    						<td valign="top"><?php echo $row->dbk_name ?></td>
    						<td valign="top"><?php echo $row->dbk_phone ?></td>
    						<td >
    							<div style="text-align: left"><?php echo nl2br($row->dbk_memo) ?></div>
    						</td>
    						<td id="cancelBooking_<?=$row->dbk_num ?>">
    							<input type="button" id="cancelBooking_<?=$row->dbk_num ?>" value="取消" class="btn btn-danger btn-xs"/>
    							<input type="hidden" id="canceldbkNum" value="<?=$row->dbk_num ?>" />
    						</td>
    					</tr>
    					<?php endif ;?>
    					<? endforeach  ?>
    				</table>
    				<? endif ?>
    			</div>
			<? endforeach  ?>

		</div>
		</div>
		
	</body>
</html>

