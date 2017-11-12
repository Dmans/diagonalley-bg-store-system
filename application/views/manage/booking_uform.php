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
		<script type="text/javascript">
			$(document).ready(function(){
					//另一種寫法input#dbkDate
				$("input[id^='dbkDate']").datepicker({
					dateFormat:'yy-mm-dd',
				});


				//日期.change部分
				$('input#dbkDate').change(function(){
					$('span#dtbNumspan').text(" ");
					var dbkstore = $("input#stoNum ").val();
					var dbkdate = $("input#dbkDate").val();
					var dbktime = $("select#dbkTime option:selected").val();
					$.getJSON("<?php echo site_url("manage/booking_ajax_action/get_count_tables") ?>",{
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

				//時間.change部分
				$('select#dbkTime').change(function(){
					$('span#dtbNumspan').text(" ");
					var dbkstore = $("input#stoNum ").val();
					var dbkdate = $("input#dbkDate").val();
					var dbktime = $("select#dbkTime option:selected").val();
					$.getJSON("<?php echo site_url("manage/booking_ajax_action/get_count_tables") ?>",{
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
			});
			
			
		</script>
		<title>維護定位資料</title>
	</head>
	<body>
		<h3>維護定位資料</h3>
		<? echo form_open('manage/booking_action/update'); ?>
			<div>訂位店鋪:<?php echo $dbk->sto_name?><input type="hidden" id="stoNum" name="sto_num" value="<?php echo $dbk->sto_num ?>" /></div>
			<input type="hidden" name="dbk_num" value="<?=$dbk->dbk_num ?>" />
			<div>定位日期:<input type="text" id="dbkDate" name="dbk_date" value="<?=set_value('dbk_date', $dbk->dbk_date); ?>" /></div>
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
            <div>訂位人數:<input type="text" name="dbk_count" value="<?=$dbk->dbk_count?>"/></div>
            <div>可訂位桌號:<br><span id="dtbNumspan" >
            	<? foreach ($dtb_nums as $key => $row) : ?>
            		<input type="checkbox" id="store_<?php echo $key ?>"
                    name="dtb_nums[]" value="<?php echo $row->dtb_num?>"
                    <?php echo (in_array($row->dtb_num, $dbk->dtb_num))?'checked="checked"':'' ?> />桌子名稱:<?php echo $row->dtb_name ?> 可容納人數:<?php echo $row->dtb_max_cap ?></br>
            	<? endforeach ?>
            
            </span></div>
            <div>訂位大名:<input type="text" name="dbk_name" value="<?=$dbk->dbk_name ?>"/></div>
            <div>訂位電話:<input type="text" id="dbkPhone" name="dbk_phone" value="<?=$dbk->dbk_phone ?>"/></div>
			<div>備註:<br/>
				<textarea name="dbk_memo" cols="50" rows="10"><?=set_value('dbk_memo', $dbk->dbk_memo); ?></textarea>
			</div>
			<div>定位狀態:
				<input type="radio" name="dbk_status"  value="0" <?=set_radio("dbk_status","0") ?> />隱藏
				<input type="radio" name="dbk_status" value="1" <?=set_radio("dbk_status","1",TRUE) ?> />公開
			</div>
<!-- 			<div>定位狀態:
				<input type="radio" name="dbk_status"  value="0" <?=set_radio("dbk_status","0",($dbk_status==0)?TRUE:FALSE) ?> />隱藏
				<input type="radio" name="dbk_status" value="1" <?=set_radio("dbk_status","1",($dbk_status==1)?TRUE:FALSE) ?> />公開
 			</div> -->
			<?=validation_errors('<div class="text-danger">','</div>') ?>
			<div><input type="submit" value="維護定位資料" class="btn btn-primary" /><input type="reset" value="重填" class="btn btn-default"/></div>
		</form>
	</body>
	
</html>

