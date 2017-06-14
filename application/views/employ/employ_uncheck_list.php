<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>未確認打卡資料</title>
		<link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/main.css" />
		<link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/flick/jquery-ui-1.8.22.custom.css" />
		<link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/jquery-ui-timepicker.css" />
		<link rel="stylesheet" media="screen" href="<?=base_url(); ?>bootstrap/css/bootstrap.min.css">
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery-ui-1.8.22.custom.min.js"></script>
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery.ui.datepicker-zh-TW.js"></script>
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery-ui-timepicker.js"></script>
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery-ui-timepicker-zh-TW.js"></script>
		<script type="text/javascript" src="<?=base_url(); ?>bootstrap/js/bootstrap.min.js"></script>

		<script type="text/javascript">
			$(document).ready(function(){

				$('input[id^="confirmButton"]').each(function(){
					$(this).click(function(){
						var chkNum=$(this).parent().find('input#chkNum').val();
						var confirmHours = $('input#confirmHours_' + chkNum).val();
						$.post("<?=site_url("employ/employ_json_action/update_confirm") ?>",{
							chk_num : chkNum,
							confirm_hours : confirmHours,
							confirm_note : $('textarea#confirmNote_' + chkNum).val()
						},
						function(data){

							if(data.redirect!=null && data.redirect==true){
								alert("登入逾時 請重新登入");
								parent.location.reload();
								return;
							}


							if(data.isSuccess==true){
								alert("已審核\n審核時間:"+data.confirm_date);
								var confirmNote = $('textarea#confirmNote_' + chkNum).val().replace(/\n\r?/g, "<br />");
								$('td#confirmButtonArea_'+chkNum).html(
								    "已審核, 審核時數：" + confirmHours + "<br/>" +
								    "審核備註:<br/>" + confirmNote
							    );
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
		<div class="row">
			<div class="span10">
				<table class="table table-striped table-hover table-bordered table-condensed">
					<tr>
						<th>序號</th>
						<th>員工名稱</th>
						<th>所在店舖</th>
						<th>上班/下班打卡時間</th>
                        <th>員工打卡註記</th>
						<th>管理員審核</th>
						<th>管理員審核時間</th>
					</tr>
					<? foreach ($chks as $key=>$row) : ?>
						<tr id="chkeckTr_<?=$row->chk_num ?>">
							<td><?=$key+1 ?></td>
							<td><?=$row->usr_name ?></td>
							<td><?=$row->sto_name ?></td>
							<td>
							    上班: <?=$row->chk_in_time ?> </br>
							    下班: <?=$row->chk_out_time ?>
						    </td>
							<td>
							    <div>打卡時數: <?=$row->interval ?></div>
							    <? if (!empty($row->chk_note)): ?>
						            <div>工作備註:</div>
						            <div><?=nl2br($row->chk_note) ?></div>
							    <? endif ?>
						    </td>
							<td id="confirmButtonArea_<?=$row->chk_num ?>">
								<input style="width:50px;" type="text" id="confirmHours_<?=$row->chk_num ?>" value="<?=$row->interval ?>" maxlength="5" size="5" />hr(s)
								<input type="button" id="confirmButton_<?=$row->chk_num ?>" value="審核" class="btn <?=($row->interval>11)?'btn-danger':'btn-primary' ?>"/>
								<input type="hidden" id="chkNum" value="<?=$row->chk_num ?>" />
                                <div>
                                    <textarea id="confirmNote_<?=$row->chk_num ?>" name="confirm_note" class="form-control" rows="3" placeholder="審核備註"></textarea>
                                </div>
							</td>
							<td id="confirmDateArea_<?=$row->chk_num ?>"></td>
						</tr>
					<? endforeach  ?>
				</table>
			</div>
		</div>

	</body>
</html>

