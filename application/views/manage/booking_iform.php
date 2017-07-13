<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/main.css" />
		<link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/flick/jquery-ui-1.8.22.custom.css" />
		<link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/jquery-ui-timepicker.css" />
		<link rel="stylesheet" media="screen" href="<?=base_url(); ?>bootstrap/css/bootstrap.min.css">
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery-ui-1.8.22.custom.min.js"></script>
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery.ui.datepicker-zh-TW.js"></script>
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery-ui-timepicker.js"></script>
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery-ui-timepicker-zh-TW.js"></script>
		<script>
			$(document).ready(function(){
				$("input[id^='dbkDate']").datetimepicker({
					dateFormat:'yy-mm-dd',
					timeFormat: "hh:mm:ss",
					//showSecond: true,
					hour:12,
					hourGrid: 4,
					secondMax:0,
					secondMin:0
				});

				$('input#test').click(function(){
					$.getJSON('<?php echo site_url("manage/booking_ajax_action/get_available_tables") ?>', function (data) {
						
// 						console.log(data.test);
						$('select#dbkCount').append(
					        $("<option></option>").attr({
						        'value': data.pp,
						        'title': data.pp 
					        })
							.text(data.pp)
						);
						
					});
				});




				$('select#dbkCount').change(function(){
					var dbkcount=$("select#dbkCount option:selected").val();
					$.post("<?=site_url("manage/booking_ajax_action/get_count_tables") ?>",
						{dbk_count : dbkcount},
						function(data){
							console.log("data:" + data);
						}
					, "json");


				});
					
			});
			
		</script>
		<title>新增定位資料</title>
	</head>
	<body>
		<h3>新增定位資料</h3>
		<? echo form_open('manage/booking_action/save'); ?>
			<div>訂位店鋪:<?php echo $stores->sto_name?><input type="hidden" name="sto_num" value="<?php echo $stores->sto_num ?>" /></div>
			<div>訂位時間:<input type="text" id="dbkDate" name="dbk_date" /></div>
            <div>訂位人數:
                <select id="dbkCount" name="dbk_count">
                    <? for ($i=1; $i <= 10; $i++): ?>
                        <option value="<?=$i ?>" title="<?=$i ?>" ><?=$i ?></option>
                    <? endfor ?>
                </select>
            </div>
            <div>可訂位桌號:<input type="hidden" name="sto_num" /></div>
            <input type="hidden" name="sto_num" />
            <div>訂位大名:<input type="text" name="dbk_name" /></div>
            <div>訂位電話:<input type="text" name="dbk_phone" /></div>
			<div>備註:<br/>
				<textarea name="dbk_memo" cols="50" rows="10"></textarea>
			</div>
			<div>定位狀態:
				<input type="radio" name="dbk_status"  value="0" <?=set_radio("dbk_status","0") ?> />隱藏
				<input type="radio" name="dbk_status" value="1" <?=set_radio("dbk_status","1",TRUE) ?> />公開
			</div>
			<?=validation_errors('<div class="text-danger">','</div>') ?>
			<div><input type="submit" value="新增定位資料" /><input type="reset" value="重填" /></div>
		</form>
		<input id="test" type="button" value="Click Me!"  />
	</body>
	
</html>

