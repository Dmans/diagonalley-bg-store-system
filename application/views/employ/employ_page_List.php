<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>個人打卡鐘</title>
		<link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/main.css" />
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery-1.7.2.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				
				$('input#checkinButton').click(function(){
					$('input#checkinButton').attr("disabled","disabled");
					$.post("<?=site_url("employ/employ_json_action/save") ?>",
					function(data){
						if(data.redirect!=null && data.redirect==true){
							alert("登入逾時 請重新登入");
							parent.location.reload();
							return;
						}
						
						console.log(data);
						
						if(data.isSuccess==true){
							alert("完成上班打卡\n打卡時間:"+data.chk.chk_in_time);
							location.reload();
						}else{
							alert("尚有未完成打卡");
							$('input#checkinButton').removeAttr("disabled");
						}
					},"json");
				});
				
				$('input#checkoutButton').click(function(){
					$('input#checkoutButton').attr("disabled","disabled");
					$.post("<?=site_url("employ/employ_json_action/update") ?>",{
						"chk_num":$('input#chkNum').val()
					},
					function(data){
						
						if(data.redirect!=null && data.redirect==true){
							alert("登入逾時 請重新登入");
							parent.location.reload();
							return;
						}
						
						if(data.isSuccess==true){
							
							alert("完成下班打卡 辛苦了!\n打卡時間:"+data.chk_out_time);
							location.reload();
						}else{
							alert("打卡失敗 請重新打卡");
							$('input#checkoutButton').removeAttr("disabled");
						}
					},"json");
				});
				
				
			});
			
		</script>
	</head>
	<body>
		<h3>個人打卡鐘</h3>
		<div>
			<div>打卡使用者:<span style="font-weight: bold;"><?=$usr_name ?></span></div>
		</div>
		<div>
			<input type="button" id="checkinButton" value="上班打卡" />
		</div>
		<div>
			
				<table class="list_table">
					<tr>
						<th>序號</th>
						<th>上班打卡時間</th>
						<th>下班打卡時間</th>
						<th>管理員審核</th>
						<th>管理員審核時間</th>
						<th>審核時數</th>
					</tr>
					<? if(isset($chks) and $chks!=NULL): ?>
						<? foreach ($chks as $key=>$row) : ?> 
							<tr id="chkeckTr_<?=$row->chk_num ?>">
								<td><?=$key+1 ?></td>
								<td><?=$row->chk_in_time ?></td>
								<td style="font-weight: bold;">
									<? if(isset($row->chk_out_time)): ?>
										<?=$row->chk_out_time ?>
									<? endif ?>
									
									<? if(!isset($row->chk_out_time)): ?>
										<input type="button" id="checkoutButton" value="下班打卡" />
										<input type="hidden" id="chkNum" value="<?=$row->chk_num ?>" />
									<? endif ?>
								</td>
								<td><?=(isset($row->confirm_usr_num))?"已審核":"未審核" ?></td>
								<td><?=(isset($row->confirm_date))?$row->confirm_date:"" ?></td>
								<td><?=(isset($row->confirm_hours))?$row->confirm_hours:"" ?></td>
							</tr>
						<? endforeach  ?>
					<? endif ?>
				</table>
		</div>
		
		
	</body>
</html>

