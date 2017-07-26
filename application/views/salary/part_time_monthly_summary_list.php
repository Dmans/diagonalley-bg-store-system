<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>每月工讀生薪資總表</title>
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/main.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/jquery-ui.min.css" />
		<link rel="stylesheet" media="screen" href="<?php echo base_url(); ?>bootstrap/css/bootstrap.min.css">
		<script type="text/javascript" src="<?php echo base_url(); ?>scripts/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>scripts/jquery-ui.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>scripts/underscore-min.js"></script>
		
		<script type="text/javascript">
			$(document).ready(function(){
			});

		</script>
	</head>
	<body>
		<h3>每月工讀生薪資總表</h3>
		<div>
			<? echo form_open('salary/salary_action/part_time_monthly_summary_list'); ?>
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
				<?php foreach ($stores as $store) :?>
					<th><?php echo $store->sto_name?>工時</th>
					<th><?php echo $store->sto_name?>薪資</th>
				<?php endforeach;?>
					<th>加班工時</th>
					<th>加班薪資</th>
					<th>加給與獎金</th>
					<th>預支與扣薪</th>
					<th>合計薪資</th>
				</tr>
				<?php foreach ($query_result as $salary) :?>
				<tr>
					<td><?php echo $salary->usr_name ?></td>
					<?php foreach ($stores as $store) :?>
						<?php if(empty($salary->stores[$store->sto_num])):?>
							<td>0</td>
							<td>0</td>
						<?php else :?>
							<td><?php echo $salary->stores[$store->sto_num]->dss_hours?></td>
							<td><?php echo $salary->stores[$store->sto_num]->dss_salary?></td>
						<?php endif; ?>
					<?php endforeach; ?>
					<td><?php echo $salary->say_extra_hours?></td>
					<td><?php echo $salary->say_extra_salary?></td>
					<td>
						<?php foreach ($salary->options->positive as $option) : ?>
							<div>+<?php echo $option->dso_value ?><?php echo $option->dso_desc ?></div>
						<?php endforeach;?>
					</td>
					<td>
						<?php foreach ($salary->options->negative as $option) : ?>
							<div>-<?php echo $option->dso_value ?><?php echo $option->dso_desc ?></div>
						<?php endforeach;?>
					</td>
					<td><?php echo $salary->summary?></td>
				</tr>
				<?php endforeach;?>
			</table>
		</div>
		<div>
			<table border="0">
				<tr>
					<td>
						<? echo form_open('salary/salary_action/part_time_sendmail'); ?>
            				<input type="hidden" value="<?php echo $year_month?>" name="year_month"/>
            				<input type="hidden" value="true" name="is_send"/>
            				<input type="submit" value="寄送所有工讀生薪資單" class="btn btn-primary" />
            			</form>
					</td>
					<td>
						<? echo form_open('salary/salary_action/part_time_sendmail'); ?>
            				<input type="hidden" value="<?php echo $year_month?>" name="year_month"/>
            				<input type="hidden" value="false" name="is_send"/>
            				<input type="submit" value="預覽所有工讀生薪資單" class="btn btn-primary" />
            			</form>
					</td>
				</tr>
			</table>
		</div>
		<?php endif; ?>
	</body>
</html>

