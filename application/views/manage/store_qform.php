<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" media="screen" href="<?=base_url(); ?>bootstrap/css/bootstrap.min.css">
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery.min.js"></script>
		<script type="text/javascript" src="<?=base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>scripts/jquery.numeric.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>scripts/underscore-min.js"></script>
		<script type="text/javascript" src="<?=base_url(); ?>scripts/common/ajaxForm.js"></script>
		<script>
			$(document).ready(function(){

			    $('button.editButton').click(function(){
				    var stoNum = $(this).attr("sto_num");
				    var url = "<?php echo site_url("manage/store_action/update_form")."/" ?>"
				    showDetailContent(stoNum, url);
					
				});
			});
		</script>
		<title>查詢維護店舖</title>
	</head>
	<body  class="container-fluid">
		<h1>查詢維護店舖</h1>
		<? echo form_open('manage/store_action/lists', 'id="listForm"'); ?>
			<div>店舖類型:
				<select id="stoType" name="sto_type">
				<option value="-1" <?php echo set_select('sto_type', -1)?>>全部</option>
					<option value="0" <?php echo set_select('sto_type', '0'); ?>><?php echo $form_constants->transfer_sto_type(0)?></option>
					<option value="1" <?php echo set_select('sto_type', '1'); ?>><?php echo $form_constants->transfer_sto_type(1)?></option>
				</select>
			</div>
			<?=validation_errors('<div class="text-danger">','</div>') ?>
			<div><input type="submit" value="查詢" class="btn btn-primary" /></div>
		</form>
		
		<div>
			<? if(isset($query_result) AND !empty($query_result)):  ?>
				<h3>查詢結果</h3>
				<table class="table table-striped table-hover table-bordered table-condensed">
					<tr>
						<th>維護</th>
						<th>店鋪名稱</th>
						<th>店舖類型</th>
					</tr>
					<? foreach ($query_result as $row) : ?> 
						<tr>
							<td>
								<button class="btn btn-warning btn-xs editButton" sto_num=<?php echo $row->sto_num?>>維護</button>
							</td>
							<td><?php echo $row->sto_name ?></td>
							<td><?php echo $form_constants->transfer_sto_type($row->sto_type)?></td>
						</tr>
					<? endforeach  ?>
				</table>
			<? else : ?>
				<h3>尚未進行查詢或查無資料</h3>
			<? endif ?>
		</div>
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
    				<div class="modal-body">
    				</div>
				</div>
			</div>
		</div>
	</body>
</html>
