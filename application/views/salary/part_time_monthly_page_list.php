<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>每月工讀生薪資審核</title>
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/main.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/jquery-ui.min.css" />
		<link rel="stylesheet" media="screen" href="<?php echo base_url(); ?>bootstrap/css/bootstrap.min.css">
		<script type="text/javascript" src="<?php echo base_url(); ?>scripts/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>scripts/jquery-ui.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>scripts/underscore-min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>scripts/jquery.numeric.js"></script>
		
		<script type="text/javascript">
			var defaultBaseHours = <?php echo BASE_HOURS ?>;
			$(document).ready(function(){
				$('input[id^=confirm_]').change(function(e) {
					var chkNum = $(this).attr('chknum');
					var usrNum = $(this).attr('usrnum');
					var stoNum = $(this).attr('stonum');
					var newValue = $(this).val();
					baseHours = (newValue <= defaultBaseHours)? newValue : defaultBaseHours;
					extraHours = (newValue <= defaultBaseHours)? 0 : (newValue - defaultBaseHours);

					$('span#baseHours_'+chkNum).text(baseHours).trigger('change');
					$('span#extraHours_'+chkNum).text(extraHours).trigger('change');

					recalculateSummary(usrNum, stoNum);
				});

				$('input[id^=dsoValue_]').numeric({ negative : false });

				$('input[id^=addExtraOptionBtn_]').click(function(e) {
					var usrNum = $(this).attr('usrnum');
					var dsoType = $('select#dsoType_'+usrNum+' option:selected').val();
					var dsoTypeText = $('select#dsoType_'+usrNum+' option:selected').text();
					var dsoDesc = $('input#dsoDesc_'+usrNum).val();
					var dsoValue = $('input#dsoValue_'+usrNum).val();

					if (_.isEmpty(dsoDesc)) {
						alert('項目說明未填');
						return;
					}

					if (_.isEmpty(dsoValue)) {
						alert('金額未填');
						return;
					}
					addExtraOption(usrNum, dsoType, dsoTypeText, dsoDesc, dsoValue);
					resetExtraOptionInput(usrNum);
				});
				$('button#submitBtn').click(function(e) {
					$('#mainForm').submit();
				});
			});

			function addExtraOption(usrNum, dsoType, dsoTypeText, dsoDesc, dsoValue) {

				var dsoTypeInput = $("<input></input>").attr({
					type: 'hidden',
					name: 'dso_type[' + usrNum + '][]',
					value: dsoType
				});
				
				var dsoDescInput = $("<input></input>").attr({
					type: 'hidden',
					name: 'dso_desc[' + usrNum + '][]',
					value: dsoDesc
				});

				var dsoValueInput = $("<input></input>").attr({
					type: 'hidden',
					name: 'dso_value[' + usrNum + '][]',
					value: dsoValue
				});

				var deleteIcon = $("<span></span>").attr({
						'class' : 'glyphicon glyphicon-remove-sign',
						style : 'color: red'
					}).click(function (e){
						$(this).parent().remove();
					});

				var extraDiv = $('<div></div>').attr({
					'class' : 'text-right list-group-item'
				}).append(
					deleteIcon,
					dsoTypeInput, 
					dsoDescInput,
					dsoValueInput
				);
				var plusSignTypes = [0, 1];
				var sign = (_.contains(plusSignTypes, parseInt(dsoType)))? '+' : '-';
				$(extraDiv).append(dsoTypeText + ' ' + sign + '$' + dsoValue + ' ' + dsoDesc);
				
				$('div#extraOptions_'+usrNum).append(extraDiv);
				
			}

			function resetExtraOptionInput(usrNum) {
				$('select#dsoType_'+usrNum).val(0);
				$('input#dsoDesc_'+usrNum).val('');
				$('input#dsoValue_'+usrNum).val('');
			}

			function recalculateSummary(usrNum, stoNum) {
				var confirmHourSummary = 0;
				$('input[id^=confirm_][usrnum='+usrNum+'][stonum='+stoNum+']').each(function(){
					if($.isNumeric($(this).val())) {
						confirmHourSummary += parseFloat($(this).val());
					}
				});
				$('span[id^=confirmHourSummary][usrnum='+usrNum+'][stonum='+stoNum+']').text(confirmHourSummary);

				var baseHourSummary = 0;
				$('span[id^=baseHours_][usrnum='+usrNum+'][stonum='+stoNum+']').each(function(){
					if($.isNumeric($(this).text())) {
						baseHourSummary += parseFloat($(this).text());
					}
				});
				$('span[id^=baseHourSummary][usrnum='+usrNum+'][stonum='+stoNum+']').text(baseHourSummary);

				var extraHourSummary = 0;
				$('span[id^=extraHours_][usrnum='+usrNum+'][stonum='+stoNum+']').each(function(){
					if($.isNumeric($(this).text())) {
						extraHourSummary += parseFloat($(this).text());
					}
				});
				$('span[id^=extraHourSummary][usrnum='+usrNum+'][stonum='+stoNum+']').text(extraHourSummary);

				var totalConfirmHours = 0;
				$('span[id^=confirmHourSummary][usrnum='+usrNum+']').each(function(){
					if($.isNumeric($(this).text())) {
						totalConfirmHours += parseFloat($(this).text());
					}
				});
				$('span[id^=totalConfirmHours_][usrnum='+usrNum+']').text(totalConfirmHours);

				var totalBaseHours = 0;
				$('span[id^=baseHourSummary][usrnum='+usrNum+']').each(function(){
					if($.isNumeric($(this).text())) {
						totalBaseHours += parseFloat($(this).text());
					}
				});
				$('span[id^=totalBaseHours_][usrnum='+usrNum+']').text(totalBaseHours);

				var totalExtraHours = 0;
				$('span[id^=extraHourSummary][usrnum='+usrNum+']').each(function(){
					if($.isNumeric($(this).text())) {
						totalExtraHours += parseFloat($(this).text());
					}
				});
				$('span[id^=totalExtraHours_][usrnum='+usrNum+']').text(totalExtraHours);

				var usrHourlySalary = parseInt($('input#usrHourlySalary').val());
				var totalBaseSalary = Math.round(totalBaseHours * usrHourlySalary);
				var totalExtraSalary = Math.round(totalExtraHours * usrHourlySalary * 1.33);

				$('span[id^=totalBaseSalary_][usrnum='+usrNum+']').text(totalBaseSalary);
				$('span[id^=totalExtraSalary_][usrnum='+usrNum+']').text(totalExtraSalary);
			}

		</script>
	</head>
	<body class="container-fluid">
		<h3>每月工讀生薪資審核</h3>
		<div>
			<? echo form_open('salary/salary_action/part_time_monthly_list'); ?>
				<div>審核月份:
					<select name="year_month">
						<?php foreach ($month_options as $option): ?>
							<option value="<?php echo $option?>" <?php echo set_select('year_month', $option)?> ><?php echo $option?></option>
						<?php endforeach; ?>
					</select>
					<input type="submit" value="查詢" class="btn btn-primary" />
				</div>
			</form>
		</div>
		<div>
			<? if(isset($query_result)):  ?>
				<? echo form_open('salary/salary_action/part_time_salary_confirm', 'id="mainForm"'); ?>
				<div>
					<h3><?php echo $year_month?> 工讀生薪資審核</h3>
				<? foreach($query_result as $chk_user): ?>
					<div>
						<table id="table_<?php echo $chk_user->usr_num ?>" class="table table-striped table-hover table-bordered table-condensed">
							<tr>
								<td colspan="8" style="text-align: left">
									<h3>員工:<?php echo $chk_user->usr_name ?> </h3>
								</td>
							</tr>
							<tr>
								<th>上班打卡時間</th>
								<th>下班打卡時間</th>
                                <th>工作備註</th>
                                <th>審核備註</th>
								<th>打卡時數</th>
								<th>審核時數</th>
								<th>基本時數</th>
								<th>加班時數</th>

							</tr>
							<? foreach($chk_user->stores as $store): ?>
							    <tr>
							       <td colspan="8"><?php echo $store->store_data->sto_name ?></td>
							    </tr>
						        <? foreach($store->chks as $chk): ?>

								<tr>
									<td><?php echo date('Y-m-d H:i', strtotime($chk->chk_in_time)); ?></td>
									<td><?php echo date('Y-m-d H:i', strtotime($chk->chk_out_time)); ?></td>
									<td><?php echo nl2br($chk->chk_note) ?></td>
                                    <td><?php echo nl2br($chk->confirm_note) ?></td>
									<td><?php echo $chk->interval ?></td>
									<td>
										<input id="confirm_<?php echo $chk->chk_num ?>" chknum="<?php echo $chk->chk_num ?>" stonum="<?php echo $store->store_data->sto_num ?>" usrnum="<?php echo $chk_user->usr_num ?>" name="confirm_hours[<?php echo $chk->chk_num ?>]" value="<?php echo $chk->confirm_hours ?>"/>
									</td>
									<td><span id="baseHours_<?php echo $chk->chk_num ?>" stonum="<?php echo $store->store_data->sto_num ?>" usrnum="<?php echo $chk_user->usr_num ?>"><?php echo $chk->base_hours ?></span></td>
									<td><span id="extraHours_<?php echo $chk->chk_num ?>" stonum="<?php echo $store->store_data->sto_num ?>" usrnum="<?php echo $chk_user->usr_num ?>"><?php echo $chk->extra_hours ?></span></td>
								</tr>
								<? endforeach ?>
								<tr>
								    <td></td>
								    <td></td>
								    <td></td>
                                    <td align="right">時數小計</td>
                                    <td><?php echo $store->summary->total_hours ?></td>
                                    <td><span id="confirmHourSummary" stonum="<?php echo $store->store_data->sto_num ?>" usrnum="<?php echo $chk_user->usr_num ?>"><?php echo $store->summary->total_confirm_hours?></span></td>
                                    <td><span id="baseHourSummary" stonum="<?php echo $store->store_data->sto_num ?>" usrnum="<?php echo $chk_user->usr_num ?>"><?php echo $store->summary->base_hour_summary?></span></td>
                                    <td><span id="extraHourSummary" stonum="<?php echo $store->store_data->sto_num ?>" usrnum="<?php echo $chk_user->usr_num ?>"><?php echo $store->summary->extra_hour_summary?></span></td>
                                </tr>
							<? endforeach ?>
							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td align="right">時數總計</td>
								<td><?php echo $chk_user->total_hours?></td>
								<td><span id="totalConfirmHours_<?php echo $chk_user->usr_num ?>" usrnum="<?php echo $chk_user->usr_num ?>"><?php echo $chk_user->total_confirm_hours?></span></td>
								<td><span id="totalBaseHours_<?php echo $chk_user->usr_num ?>" usrnum="<?php echo $chk_user->usr_num ?>"><?php echo $chk_user->total_base_hours  ?></span></td>
								<td><span id="totalExtraHours_<?php echo $chk_user->usr_num ?>" usrnum="<?php echo $chk_user->usr_num ?>"><?php echo $chk_user->total_extra_hours  ?></span></td>
							</tr>
							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td>時薪:<?php echo $chk_user->usr_salary ?><input type="hidden" id="usrHourlySalary" value="<?php echo $chk_user->usr_salary ?>"/></td>
								<td align="right">薪資計算</td>
								<td>$<span id="totalBaseSalary_<?php echo $chk_user->usr_num ?>" usrnum="<?php echo $chk_user->usr_num ?>"><?php echo $chk_user->base_salary?></span></td>
								<td>$<span id="totalExtraSalary_<?php echo $chk_user->usr_num ?>" usrnum="<?php echo $chk_user->usr_num ?>"><?php echo $chk_user->extra_salary?></span></td>
							</tr>
						</table>
						<div id="extraOptions_<?php echo $chk_user->usr_num ?>" class="list-group">
							
						</div>
						<div>
							新增項目到<?php echo $chk_user->usr_name ?>:
							<select id="dsoType_<?php echo $chk_user->usr_num ?>">
            					<option value="0"><?php echo $form_constants->transfer_dso_type(0)?></option>
            					<option value="1"><?php echo $form_constants->transfer_dso_type(1)?></option>
            					<option value="2"><?php echo $form_constants->transfer_dso_type(2)?></option>
            					<option value="3"><?php echo $form_constants->transfer_dso_type(3)?></option>
            				</select>
            				金額:<input id="dsoValue_<?php echo $chk_user->usr_num ?>" type="text">
            				說明:<input id="dsoDesc_<?php echo $chk_user->usr_num ?>" type="text">
            				<input id="addExtraOptionBtn_<?php echo $chk_user->usr_num ?>" usrnum="<?php echo $chk_user->usr_num ?>" type="button" value="新增項目" class="btn btn-default btn-primary" style="margin-bottom:10px;"/>
						</div>
					</div>
					<hr />
				<? endforeach ?>
					<div>
						<input type="hidden"  name="year_month" value="<?php echo $year_month?>" />
						<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
							確認全部工讀生薪資審核
						</button>
					</div>
				</div>
				</form>
			<? endif ?>
		</div>
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title" id="myModalLabel"><?php echo $year_month?> 工讀生薪資審核送出確認</h4>
					</div>
    				<div class="modal-body">
    					請確認一切無誤之後再送出
    				</div>
    				<div class="modal-footer">
    					<button type="button" class="btn btn-default" data-dismiss="modal">等等！現在不改就來不及了</button>
    					<button id="submitBtn" type="button" class="btn btn-primary">送！都送</button>
    				</div>
				</div>
			</div>
		</div>
	</body>
</html>

