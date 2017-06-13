<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" media="screen" href="<?php echo base_url(); ?>bootstrap/css/bootstrap.min.css">
		<script type="text/javascript" src="<?php echo base_url(); ?>scripts/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
		<title>查詢遊戲桌</title>
	</head>
	<body>
		<h1>查詢遊戲桌</h1>
		<? echo form_open('manage/tables_action/lists'); ?>
			<div>店鋪名稱:
				<select name="sto_num">
                    <? foreach ($stores as $store): ?>
                        <option value="<?php echo $store->sto_num ?>" title="<?php echo $store->sto_name ?>" ><?php echo $store->sto_name ?></option>
                    <? endforeach ?>
                </select>
            </div>
			<div>桌子名稱:<input type="text" name="dtb_name" maxlength="32" /></div>
			<div>桌子可容納人數:
				<select name="dtb_max_cap">
						<option value="-1" title="全部" >全部</option>
                    <?for ($i=1; $i <= 10; $i++): ?>
                        <option value="<?php echo $i ?>" title="<?php echo $i ?>" ><?php echo $i ?></option>
                    <? endfor ?>
               </select>
            </div>
			<?php echo validation_errors('<div class="text-error">','</div>') ?>
			<div><input type="submit" value="查詢" class="btn btn-primary" /></div>
		</form>

		<div>
			<? if(isset($query_result)):  ?>
				<h3>查詢結果</h3>
				<table class="table table-striped table-hover table-bordered table-condensed">
					<tr>
						<th>維護</th>
						<th>店鋪名稱</th>
						<th>桌子名稱</th>
						<th>桌子可容納人數</th>
					</tr>
					<? foreach ($query_result as $row) : ?>
						<tr>
						
							<td>
							<?php if($row->dtb_status==1):?>
								<a href="<?=site_url("manage/tables_action/tables_update_form/".$row->dtb_num) ?>" class="btn btn-warning btn-mini">維護</a>
							<?php else : ?>
								<a class="btn btn-warning btn-mini">已預約</a>
							<?php endif; ?>
							</td>
							<td><?php echo $row->sto_name ?></td>
							<td><?php echo $row->dtb_name ?></td>
							<td><?php echo $row->dtb_max_cap ?></td>
						</tr>
					<? endforeach  ?>
				</table>
			<? else : ?>
				<h3>尚未進行查詢或查無資料</h3>
			<? endif ?>
		</div>
	</body>
</html>
