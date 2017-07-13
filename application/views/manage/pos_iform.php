<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/main.css" />
		<link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/flick/jquery-ui-1.8.22.custom.css" />
		<link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/jquery-ui-timepicker.css" />
		<link rel="stylesheet" media="screen" href="<?=base_url(); ?>bootstrap/css/bootstrap.min.css">
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery.min.js"></script>
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery-ui-1.8.22.custom.min.js"></script>
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery.ui.datepicker-zh-TW.js"></script>
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery-ui-timepicker.js"></script>
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery-ui-timepicker-zh-TW.js"></script>
		<script type="text/javascript" src="<?=base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
		
		
		<script type="text/javascript">
			$(document).ready(function(){
				$( "input[id^='podDate']" ).each(function(){
					$(this).datetimepicker({
						dateFormat:'yy-mm-dd',
						timeFormat: "hh:mm:ss",
						//showSecond: true,
						hourGrid: 4,
						secondMax:0,
						secondMin:0
					});
				});
				
			});
			
		</script>
		<title>新增銷售資料</title>
	</head>
	<body>
		<div class="well">
		<h3>新增銷售資料</h3>
		<? echo form_open('manage/pos_action/save'); ?>
			<div>銷售時間:<input type="text" id="podDate" name="pod_date" value="<?=set_value('pod_date', $pod_date); ?>" /></div>
			<div>銷售類型:
				<select name="tag_num">
					<? foreach ($tags as $tag): ?>
						<option value="<?=$tag->tag_num ?>" title="<?=$tag->tag_desc ?>" <?=set_select('tag_num', $tag->tag_num); ?>><?=$tag->tag_name ?></option>
					<? endforeach ?>
				</select>
			</div>
			<div>銷售說明:<input type="text" name="pod_desc" maxlength="256" size="30" value="<?=set_value('pod_desc', ''); ?>" /></div>
			<div>銷售金額:<input type="text" name="pod_svalue" maxlength="12" size="10" value="<?=set_value('pod_svalue', ''); ?>" /></div>
			<div>銷售狀態:
				<!-- <input type="radio" name="pod_status"  value="0" <?=set_radio("pod_status","0") ?> />暫存 -->
				<input type="radio" name="pod_status" value="1" <?=set_radio("pod_status","1",TRUE) ?> />成立
			</div>
			<?=validation_errors('<div class="text-danger">','</div>') ?>
			<div>
				<input type="submit" value="新增銷售資料" class="btn btn-primary"/>
				<input type="reset" value="重填" class="btn btn-default"/>
			</div>
		</form>
		</div>
		<h3>新增多筆銷售資料</h3>
		<? echo form_open('manage/pos_action/multiple_save'); ?>
			<table class="table table-striped table-hover table-bordered table-condensed">
				<tr>
					<th>序號</th>
					<th>銷售時間</th>
					<th>銷售類型</th>
					<th>銷售說明</th>
					<th>銷售金額</th>
					<th>銷售狀態</th>
				</tr>
			<? for ($i=0; $i < 20; $i++) : ?>
				<tr>
					<td><?=$i+1 ?>
						<input type="checkbox" name="pos_enabled[]" value="<?=$i ?>" />
					</td>
					<td><input type="text" id="podDate_<?=$i ?>" name="pod_date[]" value="<?=set_value('pod_date', $pod_date); ?>" /></td>
					<td>
						<select name="tag_num[]">
							<? foreach ($tags as $tag): ?>
								<option value="<?=$tag->tag_num ?>" title="<?=$tag->tag_desc ?>" ><?=$tag->tag_name ?></option>
							<? endforeach ?>
						</select>
					</td>
					<td><input type="text" name="pod_desc[]" maxlength="256" size="30"  /></td>
					<td><input type="text" name="pod_svalue[]" maxlength="12" size="10"  /></td>
					<td>
						<!-- <input type="radio" name="pod_status"  value="0" <?=set_radio("pod_status","0") ?> />暫存 -->
						<!-- <input type="radio" name="pod_status[]" value="1" <?=set_radio("pod_status","1",TRUE) ?> />成立 -->
						<input type="hidden" name="pod_status[]" value="1" />成立 
					</td>
				</tr>
			<? endfor ?>
			</table>
			<?=validation_errors('<div class="text-danger">','</div>') ?>
			<div>
				<input type="submit" value="新增多筆銷售資料" class="btn btn-primary"/>
				<input type="reset" value="重填" class="btn btn-default"/>
			</div>
		</form>
		
	</body>
</html>

