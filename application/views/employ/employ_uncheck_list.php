<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>未確認打卡資料</title>
		<link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/main.css" />
		<link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/flick/jquery-ui-1.8.22.custom.css" />
		<link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/jquery-ui-timepicker.css" />
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery-ui-1.8.22.custom.min.js"></script>
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery.ui.datepicker-zh-TW.js"></script>
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery-ui-timepicker.js"></script>
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery-ui-timepicker-zh-TW.js"></script>
		
		<script type="text/javascript">
			$(document).ready(function(){
				
				$('input[id^="confirmButton"]').each(function(){
					$(this).click(function(){
						var chkNum=$(this).parent().find('input#chkNum').val();
						$.post("<?=site_url("employ/employ_json_action/update_confirm") ?>",{
							"chk_num":chkNum,
							"confirm_hours": $('input#comfirmHours_'+chkNum).val()
						},
						function(data){
						
							if(data.redirect!=null && data.redirect==true){
								alert("登入逾時 請重新登入");
								parent.location.reload();
								return;
							}
							
							
							if(data.isSuccess==true){
								alert("已審核\n審核時間:"+data.confirm_date);
								$('td#confirmButtonArea_'+chkNum).html("已審核");
								$('td#confirmDateArea_'+chkNum).html(data.confirm_date);
							}else{
								alert("審核失敗! 請洽管理員");
							}
						},"json");
					});
				});
				
			});
			
		</script>
		
	</head>
	<body>
		<h3>未確認打卡資料</h3>
		<div>
			<table class="list_table">
				<tr>
					<th>序號</th>
					<th>打卡員工</th>
					<th>上班打卡時間</th>
					<th>下班打卡時間</th>
					<th>管理員審核</th>
					<th>管理員審核時間</th>
				</tr>
				<? foreach ($chks as $key=>$row) : ?> 
					<tr id="chkeckTr_<?=$row->chk_num ?>">
						<td><?=$key+1 ?></td>
						<td><?=$row->usr_name ?></td>
						<td><?=$row->chk_in_time ?></td>
						<td><?=$row->chk_out_time ?></td>
						<td id="confirmButtonArea_<?=$row->chk_num ?>">
							<input type="text" id="comfirmHours_<?=$row->chk_num ?>" value="<?=$row->interval ?>" maxlength="5" size="5" />hr(s)
							<input type="button" id="confirmButton_<?=$row->chk_num ?>" value="審核" />
							<input type="hidden" id="chkNum" value="<?=$row->chk_num ?>" />
							
						</td>
						<td id="confirmDateArea_<?=$row->chk_num ?>"></td>
					</tr>
				<? endforeach  ?>
			</table>
		</div>
		
		
	</body>
</html>

