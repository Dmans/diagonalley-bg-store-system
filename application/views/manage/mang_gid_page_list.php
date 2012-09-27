<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>店內上架遊戲管理</title>
		<link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/main.css" />
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery-1.7.2.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				$('input[id^="unuseButton"]').each(function(index,element){
					$(element).click(function(){
						var gidNum=$(this).parent().find('input[id^=gidNum]').val();
						var grdNum=$('input#grdNum_'+gidNum).val();
						console.log(grdNum);
						$.post("<?=site_url("manage/manage_ajax_action/gid_status_update") ?>",{
							"gid_num":gidNum,
							"gid_status":0,
						    "grd_num":grdNum
						},
						function(data){
							if(data.isSuccess==true){
								// console.log(data);
								$('#gidButtons_'+gidNum).children('input').show();
								$('#unuseButton_'+gidNum).hide();
								$('#gidStatusDesc_'+gidNum).html("店內(未使用)");
								$('#gameTr_'+gidNum).attr('class','gid_status_style_0');
							}
						},"json");
						
					});
				});
				
				$('input[id^="usedButton"]').each(function(index,element){
					$(element).click(function(){
						var gidNum=$(this).parent().find('input[id^=gidNum]').val();
						var grdNum=$('input#grdNum_'+gidNum).val();
						$.post("<?=site_url("manage/manage_ajax_action/gid_status_update") ?>",{
							"gid_num":gidNum,
							"gid_status":1
							
						},
						function(data){
							if(data.isSuccess==true){
								alert("成功新增一次紀錄");
								// console.log(data);
								$('#gidButtons_'+gidNum).children('input').show();
								// $('#rentButton_'+gidNum).hide();
								// $('#usedButton_'+gidNum).hide();
								// $('#gidStatusDesc_'+gidNum).html("店內(使用中)");
								
								// $('#grdNum_'+gidNum).val(data.grd_num);
								// $('#gameTr_'+gidNum).attr('class','gid_status_style_1');
							}
						},"json");
						
					});
				});
				
				$('input[id^="rentButton"]').each(function(index,element){
					$(element).click(function(){
						var gidNum=$(this).parent().find('input[id^=gidNum]').val();
						$.post("<?=site_url("manage/manage_ajax_action/gid_status_update") ?>",{
							"gid_num":gidNum,
							"gid_status":2
						},
						function(data){
							console.log(data.isSuccess);
							if(data.isSuccess==true){
								$('#gidButtons_'+gidNum).children('input').show();
								$('#rentButton_'+gidNum).hide();
								$('#usedButton_'+gidNum).hide();
								$('#gidStatusDesc_'+gidNum).html("出租中");
								$('#grdNum_'+gidNum).val(data.grd_num);
								// $('#gameTr_'+gidNum).css({"background-color":"#005702","color":"white"});
								$('#gameTr_'+gidNum).attr('class','gid_status_style_2');
							}
						},"json");
						
					});
				});
				
				$('input#searchGamName').change(function(){
					$('#gameListTable tr[id^="gameTr_"]').hide();
					var search=$(this).val().toLowerCase();
					$("tr[id^='gameTr_'] td.gamNameTarget").filter(function(){
						return ($(this).text().toLowerCase().indexOf(search)>=0) ;
					}).parent().show();
				});
				
			});
			
		</script>
	</head>
	<body>
		<h3>店內上架遊戲管理</h3>
		<div>
			<div>查詢介面</div>
			<div>遊戲名稱:<input type="text" id="searchGamName" /></div>
		</div>
		<table id="gameListTable" class="list_table">
			<tr>
				<th>遊戲上架流水號</th>
				<th>遊戲中文名稱</th>
				<th>遊戲英文名稱</th>
				<th>遊戲目前狀態</th>
				<th>修改遊戲狀態</th>
			</tr>
			<? foreach ($gids as $key=>$row) : ?> 
				<tr id="gameTr_<?=$row->gid_num ?>" class="gid_status_style_<?=$row->gid_status ?>">
					<td><?=$row->gid_num ?></td>
					<td class="gamNameTarget"><?=$row->gam_cname ?></td>
					<td class="gamNameTarget"><?=$row->gam_ename ?></td>
					<td id="gidStatusDesc_<?=$row->gid_num ?>" ><?=$row->gid_status_desc ?></td>
					<td id="gidButtons_<?=$row->gid_num ?>">
						<input type="hidden" name="gid_num[<?=$key ?>]" id="gidNum_<?=$row->gid_num ?>" value="<?=$row->gid_num ?>" />
						<input type="hidden" name="grd_num[<?=$key ?>]" id="grdNum_<?=$row->gid_num ?>" value="<?=(isset($row->grd_num))?$row->grd_num:'' ?>" />
						<input type="button" id="usedButton_<?=$row->gid_num ?>" value="店內使用+1次" <?=($row->gid_status==1 or $row->gid_status==2)?'style="display:none"':'' ?>/>
						<input type="button" id="unuseButton_<?=$row->gid_num ?>" value="店內(未使用)" <?=($row->gid_status==0)?'style="display:none"':'' ?> />
						<? if($row->gid_rentable!=0): ?>
							<input type="button" id="rentButton_<?=$row->gid_num ?>" value="出租中" <?=($row->gid_status==2 or $row->gid_status==1)?'style="display:none"':'' ?>/>
						<? endif ?>	
					</td>
				</tr>
			<? endforeach  ?>
		</table>
	</body>
</html>

