<div id="salary_area" role="tablist">
	<div class="card">
		<div class="card-header panel" role="tab" id="salary1" data-toggle="collapse" data-target="#salary1_sub1">
			<h4 class="mb-0">薪資模組</h4>
		</div>
	</div>
	<div id="salary1_sub1" class="collapse" role="tabpanel">
		<div class="card-body">
        	<div>
        		<h5>審核</h5>
        		<div><a target="content" href="<?php echo site_url("salary/salary_action/part_time_monthly_list_form") ?>">每月工讀生薪資審核</a></div>
        		<div><a target="content" href="<?php echo site_url("salary/salary_action/employee_monthly_list_form") ?>">每月正職人員薪資審核</a></div>
        	</div>
        	<div>
        		<h5>總表</h5>
        		<div><a target="content" href="<?php echo site_url("salary/salary_action/part_time_monthly_summary_list_form") ?>">每月工讀生薪資總表</a></div>
        		<div><a target="content" href="<?php echo site_url("salary/salary_action/employee_monthly_summary_list_form") ?>">每月正職人員薪資總表</a></div>
        	</div>
        	<div>
        		<h5>常用薪資附加項目</h5>
        		<div><a target="content" href="<?php echo site_url("salary/salary_default_options_action/save_form") ?>">新增常用薪資附加項目</a></div>
        		<div><a target="content" href="<?php echo site_url("salary/salary_default_options_action/list_form") ?>">查詢維護常用薪資附加項目</a></div>
        	</div>
		</div>
	</div>
</div>


<hr/>
