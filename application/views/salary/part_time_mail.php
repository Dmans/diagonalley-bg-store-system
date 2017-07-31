<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title><?php echo $year_month ?> <?php echo $user_salary->usr_name ?>薪資單</title>
		<style type="text/css">
		  div.item {
		      line-height : 20px;
		  }
		</style>
	</head>
	<body>
		<h1><?php echo $year_month ?> <?php echo SYSTEM_NAME; ?>薪資單</h1>
		<div>
			<table border="1" cellpadding="0" cellspacing="0" height="100%" width="100%" style="border:2px #000000 solid;">
				<tr>
					<td colspan="6">姓名：<b><?php echo $user_salary->usr_name ?></b></td>
				</tr>
				<tr>
					<td>固定支付項目(A)</td>
					<td>金額</td>
					<td>非固定支付項目(B)</td>
					<td>金額</td>
					<td>應代扣項目(C)</td>
					<td>金額</td>
				<tr>
				<tr>
					<td valign="top">
						<?php foreach ($user_salary->stores as $store): ?>
							<div class="item">
								<?php echo $store->sto_name?>(工時：<?php echo $store->dss_hours?>小時）
							</div>
						<?php endforeach;?>
					</td>
					<td valign="top">
						<?php foreach ($user_salary->stores as $store): ?>
							<div class="item">
								 <?php echo $store->dss_salary?>
							</div>
						<?php endforeach;?>
					</td>
					<td valign="top">
						<?php if ($user_salary->say_extra_hours != 0): ?>
							<div class="item">加班費（工時：<?php echo $user_salary->say_extra_hours?> 小時）</div>
						<?php endif;?>
						<?php foreach ($user_salary->options->positive as $option) : ?>
							<div class="item"><?php echo $option->dso_desc ?></div>
						<?php endforeach;?>
					</td>
					<td valign="top">
						<?php if ($user_salary->say_extra_hours != 0): ?>
							<div class="item"><?php echo $user_salary->say_extra_salary?> </div>
						<?php endif;?>
						<?php foreach ($user_salary->options->positive as $option) : ?>
							<div class="item"><?php echo $option->dso_value ?></div>
						<?php endforeach;?>
					</td>
					<td valign="top">
						<?php foreach ($user_salary->options->negative as $option) : ?>
							<div class="item"><?php echo $option->dso_desc ?></div>
						<?php endforeach;?>
					</td>
					<td valign="top">
						<?php foreach ($user_salary->options->negative as $option) : ?>
							<div class="item"><?php echo $option->dso_value ?></div>
						<?php endforeach;?>
					</td>
				<tr>
				<tr>
					<td align="right">小計(A)</td>
					<td><?php echo $user_salary->type_a_summary?></td>
					<td align="right">小計(B)</td>
					<td><?php echo $user_salary->type_b_summary?></td>
					<td align="right">小計(C)</td>
					<td><?php echo $user_salary->type_c_summary?></td>
				</tr>
				<tr>
					<td align="right" colspan="4">
						<div>實領金額(A)+(B)-(C)</div>
					</td>
					<td align="center" colspan="2">
						
						<h3>
							NTD$ <?php echo $user_salary->type_a_summary + $user_salary->type_b_summary - $user_salary->type_c_summary?>
						</h3>
					</td>
				</tr>
			</table>
		</div>
	</body>
</html>

