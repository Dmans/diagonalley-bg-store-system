<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>個人打卡鐘</title>
		<link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/main.css" />
		<link rel="stylesheet" media="screen" href="<?=base_url(); ?>bootstrap/css/bootstrap.min.css">
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery.min.js"></script>
		<script type="text/javascript" src="<?=base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				$('input#checkinButton').click(function(){
					$('input#checkinButton').attr("disabled","disabled");
					$.post("<?=site_url("employ/employ_json_action/save/") ?>", {
					    sto_num : <?=$store->sto_num ?>
					},
					function(data) {
						if(data.redirect!=null && data.redirect==true){
							alert("登入逾時 請重新登入");
							parent.location.reload();
							return;
						}

						// console.log(data);

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
						chk_num : $('input#chkNum').val(),
						chk_note : $('textarea#chkNote').val()
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
	<body class="container-fluid">
		<h3>個人打卡鐘</h3>
		<div>
			<div>打卡使用者:<span style="font-weight: bold;"><?=$usr_name ?></span></div>
			<div>打卡店鋪:<span style="font-weight: bold;"><?=$store->sto_name ?></span></div>
		</div>
		<div>
			<input type="button" id="checkinButton" value="上班打卡" class="btn btn-primary"/>
		</div>
		<div class="row">
			<div class="col-md-9">本月打卡紀錄
				<table class="table table-striped table-hover table-bordered table-condensed">
					<tr>
						<th>序號</th>
						<th>上班打卡時間</th>
						<th>下班打卡時間</th>
						<th>工作備註</th>
						<th>管理員審核</th>
						<th>管理員審核時間</th>
						<th>審核時數</th>
					</tr>
					<? if(isset($current_check) and $current_check!=NULL): ?>
						<? foreach ($current_check as $key=>$row) : ?>
							<tr id="chkeckTr_<?=$row->chk_num ?>">
								<td><?=$key+1 ?></td>
								<td><?=$row->chk_in_time ?></td>
								<td style="font-weight: bold;">
									<? if(isset($row->chk_out_time)): ?>
										<?=$row->chk_out_time ?>
									<? endif ?>

									<? if(!isset($row->chk_out_time)): ?>

										<input type="button" id="checkoutButton" value="下班打卡" class="btn btn-success"/>
										<input type="hidden" id="chkNum" value="<?=$row->chk_num ?>" />
									<? endif ?>
								</td>
								<td>
                                    <? if(isset($row->chk_out_time)): ?>
                                        <?=nl2br($row->chk_note) ?>
                                    <? endif ?>

                                    <? if(!isset($row->chk_out_time)): ?>
                                        <div>
                                            <textarea id="chkNote" name="chk_note" class="form-control" rows="3" placeholder="工作備註"></textarea>
                                        </div>
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
			<div class="col-md-9">上月打卡紀錄
				<table class="table table-striped table-hover table-bordered table-condensed">
					<tr>
						<th>序號</th>
						<th>上班打卡時間</th>
						<th>下班打卡時間</th>
						<th>工作備註</th>
						<th>管理員審核</th>
						<th>管理員審核時間</th>
						<th>審核時數</th>
					</tr>
					<? if(isset($previous_check) and $previous_check!=NULL): ?>
						<? foreach ($previous_check as $key=>$row) : ?>
							<tr>
								<td><?=$key+1 ?></td>
								<td><?=$row->chk_in_time ?></td>
								<td style="font-weight: bold;">
                                    <? if(isset($row->chk_out_time)): ?>
                                        <?=$row->chk_out_time ?>
                                    <? endif ?>

                                    <? if(!isset($row->chk_out_time)): ?>
                                        <input type="button" id="checkoutButton" value="下班打卡" class="btn btn-success"/>
                                        <input type="hidden" id="chkNum" value="<?=$row->chk_num ?>" />
                                    <? endif ?>
                                </td>
                                <td>
                                    <? if(isset($row->chk_out_time)): ?>
                                        <?=nl2br($row->chk_note) ?>
                                    <? endif ?>

                                    <? if(!isset($row->chk_out_time)): ?>
                                        <div>
                                            <textarea id="chkNote" name="chk_note" class="form-control" rows="3" placeholder="工作備註"></textarea>
                                        </div>
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
		</div>
	</body>
</html>

