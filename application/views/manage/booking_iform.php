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
				$("input[id^='dbkDate']").datepicker({
					dateFormat:'yy-mm-dd',
				});


				$('select#dbkCount').change(function(){
					$('span#dtbNumspan').text(" ");
					var dbkstore = $("input#stoNum ").val();
					var dbkcount = $("select#dbkCount option:selected").val();
					var dbkdate = $("input#dbkDate").val();
					var dbktime = $("select#dbkTime option:selected").val();
					$.getJSON("<?php echo site_url("manage/booking_ajax_action/get_count_tables") ?>",{
						dbk_count : dbkcount,
						sto_num : dbkstore,
						dbk_date : dbkdate,
						dbk_time : dbktime
						},
						function(data){
							var i;
							for(i=0;i<data.length; i++ ){
    							$('span#dtbNumspan').append(
    								$("<input></input>").attr({
    									type : "checkbox",//radio
    									id : "dtbNum",
    									name : "dtb_num[]",
    									value : data[i].dtb_num
    								})
    							)
    							.append(" 桌子名稱:")
    							.append(data[i].dtb_name)
    							.append(" 可容納人數:")
    							.append(data[i].dtb_max_cap)
    							.append("<br>");
    						}
//									console.log("data:" + data);
						});
				});


// 				$('select#dbkPhone').change(function(){
// 				    $('span#dbkspan').text(" ");
// 				    var dbkphone = $("input#dbkPhone").val();
//				    $.getJSON("<?php echo site_url("manage/booking_ajax_action/booking_list")?>",
// 					    {dbk_phone : dbkphone},
// 					    function(data){
// 						    var i;
// 						    for(i=0;i<data.length; i++){
// 						        $('span#dbkspan').append(" 桌子名稱:")
// 						        .append(data[i].dtb_name);
// 							}
							
// 						});
// 				});
			});
			
		</script>
		<title>新增定位資料</title>
	</head>
	<body>
		<h3>新增定位資料</h3>
		<? echo form_open('manage/booking_action/save'); ?>
			<div>訂位店鋪:<?php echo $stores->sto_name?><input type="hidden" id="stoNum" name="sto_num" value="<?php echo $stores->sto_num ?>" /></div>
			<div>訂位日期:<input type="text" id="dbkDate" name="dbk_date" /></div>
			<div>訂位時間:<select id="dbkTime" name="dbk_time">
							<option value="13:00" title="01:00" >01:00</option>
							<option value="13:30" title="01:30" >01:30</option>
							<option value="14:00" title="02:00" >02:00</option>
							<option value="14:30" title="02:30" >02:30</option>
							<option value="15:00" title="03:00" >03:00</option>
							<option value="18:10" title="06:10" >06:10</option>
							<option value="18:30" title="06:30" >06:30</option>
							<option value="19:00" title="07:00" >07:00</option>
							<option value="19:30" title="07:30" >07:30</option>
                		</select>
            </div>
            <div>訂位人數:
                <select id="dbkCount" name="dbk_count">
                    <? for ($i=1; $i <= 10; $i++): ?>
                        <option value="<?=$i ?>" title="<?=$i ?>" ><?=$i ?></option>
                    <? endfor ?>
                </select>
            </div>
            <div>可訂位桌號:<br><span id="dtbNumspan" ></span></div>
            <div>訂位大名:<input type="text" name="dbk_name" /></div>
            <div>訂位電話:<input type="text" id="dbkPhone" name="dbk_phone" /></div>
			<div>備註:<br/>
				<textarea name="dbk_memo" cols="50" rows="10"></textarea>
			</div>
			<div>定位狀態:
				<input type="radio" name="dbk_status"  value="0" <?=set_radio("dbk_status","0") ?> />隱藏
				<input type="radio" name="dbk_status" value="1" <?=set_radio("dbk_status","1",TRUE) ?> />公開
			</div>
			<?=validation_errors('<div class="text-danger">','</div>') ?>
			<div><input type="submit" value="新增定位資料" class="btn btn-primary"/><input type="reset" value="重填" class="btn btn-default"/></div>
		</form>
	</body>
	<!-- <body>
		<h3>訂位紀錄</h3>
		<div><br><span id="dbkspan"></span></div>
	</body> -->
	
</html>

