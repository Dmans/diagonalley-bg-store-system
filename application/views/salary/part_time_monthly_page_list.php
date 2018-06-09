<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>每月工讀生薪資審核</title>
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/main.css" />
		<link rel="stylesheet" media="screen" href="<?php echo base_url(); ?>bootstrap/css/bootstrap.min.css">
		<script type="text/javascript" src="<?php echo base_url(); ?>scripts/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>scripts/jquery-ui.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>scripts/underscore-min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>scripts/jquery.numeric.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>scripts/view/salary/monthly_page_list.js"></script>
		
		<script type="text/javascript">
			$(document).ready(function(){
				defaultBaseHours = <?php echo BASE_HOURS ?>;
				init();
			});

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
								<td><span id="totalBaseSalary_<?php echo $chk_user->usr_num ?>" usrnum="<?php echo $chk_user->usr_num ?>"><?php echo $chk_user->base_salary?></span></td>
								<td><span id="totalExtraSalary_<?php echo $chk_user->usr_num ?>" usrnum="<?php echo $chk_user->usr_num ?>"><?php echo $chk_user->extra_salary?></span></td>
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
						<div>
							常用附加項目到<?php echo $chk_user->usr_name ?>:
							<select id="dsdoOptions_<?php echo $chk_user->usr_num ?>">
							<?php foreach ($salary_default_options as $option):?>
								<option value="<?php echo $option->dsdo_value?>" 
										dsdoTypeText="<?php echo $form_constants->transfer_dso_type($option->dsdo_type)?>" 
										dsdoType="<?php echo $option->dsdo_type?>" 
										dsdoDesc="<?php echo $option->dsdo_desc?>" >
									<?php echo $form_constants->transfer_dso_type($option->dsdo_type)?>|<?php echo $option->dsdo_desc?>(金額:<?php echo $option->dsdo_value?>)
								</option>
							<?php endforeach;?>
							</select>
							<input id="addDefaultExtraOptionBtn_<?php echo $chk_user->usr_num ?>" usrnum="<?php echo $chk_user->usr_num ?>" type="button" value="新增此常用項目" class="btn btn-default btn-primary" style="margin-bottom:10px;"/>
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

