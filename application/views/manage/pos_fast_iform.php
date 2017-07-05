<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/main.css" />
		<link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/flick/jquery-ui-1.8.22.custom.css" />
		<link rel="stylesheet" media="screen" href="<?=base_url(); ?>bootstrap/css/bootstrap.min.css">
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery.min.js"></script>
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery-ui-1.8.22.custom.min.js"></script>
		<script type="text/javascript" src="<?=base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				
			});
			
		</script>
		<title>新增快速銷售按鈕</title>
	</head>
	<body>
		<h3>新增快速銷售按鈕</h3>
		<? echo form_open('manage/pos_action/pos_fast_button_save'); ?>
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
			<div>按鈕排序:
				<input type="text" name="pfs_order" maxlength="10" size="10" value="<?=set_value('pfs_order', '999'); ?>" />
				(請輸入數字)
			</div>
			<?=validation_errors('<div class="text-error">','</div>') ?>
			<div>
				<input type="submit" value="新增快速銷售按鈕" class="btn btn-primary" />
				<input type="reset" value="重填" class="btn" />
			</div>
		</form>
	</body>
</html>

