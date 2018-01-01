<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>每月正職人員薪資總表</title>
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/main.css" />
		<link rel="stylesheet" media="screen" href="<?php echo base_url(); ?>bootstrap/css/bootstrap.min.css">
		<script type="text/javascript" src="<?php echo base_url(); ?>scripts/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>scripts/underscore-min.js"></script>
		
		<script type="text/javascript">
			$(document).ready(function(){
			});

		</script>
	</head>
	<body class="container-fluid">
		<h3>每月正職人員薪資總表</h3>
		<div>
			<? echo form_open('salary/salary_action/employee_monthly_summary_list'); ?>
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
		<?php if(isset($query_result)): ?>
		<div>
			<table class="table table-striped table-hover table-bordered table-condensed">
				<tr>
					<th>名稱</th>
					<th>各店工時</th>
					<th>本月合計工時</th>
					<th>前期累計積假</th>
					<th>本月積假結算</th>
					<th>底薪</th>
					<th>加給與獎金</th>
					<th>預支與扣薪</th>
					<th>合計薪資</th>
				</tr>
				<?php foreach ($query_result as $salary) :?>
				<tr>
					<td><?php echo $salary->usr_name ?></td>
					<td>
						<?php foreach ($stores as $store) :?>
    						<?php if(!empty($salary->stores[$store->sto_num])):?>
    							<div><?php echo $store->sto_name?>:<?php echo $salary->stores[$store->sto_num]->dss_hours?>hr</div>
    						<?php endif; ?>
    					<?php endforeach; ?>
					</td>
					<td><?php echo $salary->total_confirm_hours?></td>
					<td><?php echo $salary->previous_say_leave_balance ?></td>
					<td><?php echo $salary->say_leave_balance ?></td>
					<td><?php echo $salary->usr_monthly_salary ?></td>
					<td>
						<?php foreach ($salary->options->positive as $option) : ?>
							<div><?php echo $option->dso_desc ?>: +$<?php echo $option->dso_value ?></div>
						<?php endforeach;?>
					</td>
					<td>
						<?php foreach ($salary->options->negative as $option) : ?>
							<div><?php echo $option->dso_desc ?>: -$<?php echo $option->dso_value ?></div>
						<?php endforeach;?>
					</td>
					<td>$<?php echo $salary->say_total_salary?></td>
				</tr>
				<?php endforeach;?>
			</table>
		</div>
		<div>
			<table border="0">
				<tr>
					<td>
						<? echo form_open('salary/salary_action/employee_sendmail'); ?>
            				<input type="hidden" value="<?php echo $year_month?>" name="year_month"/>
            				<input type="hidden" value="true" name="is_send"/>
            				<input type="submit" value="寄送所有正職人員薪資單" class="btn btn-primary" />
            			</form>
					</td>
					<td>
						<? echo form_open('salary/salary_action/employee_sendmail'); ?>
            				<input type="hidden" value="<?php echo $year_month?>" name="year_month"/>
            				<input type="hidden" value="false" name="is_send"/>
            				<input type="submit" value="預覽所有正職人員薪資單" class="btn btn-primary" />
            			</form>
					</td>
				</tr>
			</table>
		</div>
		<?php endif; ?>
	</body>
</html>

