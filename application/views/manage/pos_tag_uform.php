<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/main.css" />
		<link rel="stylesheet" media="screen" href="<?=base_url(); ?>bootstrap/css/bootstrap.min.css">
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery.min.js"></script>
		<script type="text/javascript" src="<?=base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
			});
		</script>
		<title>維護銷售類型</title>
	</head>
	<body>
		<h2>維護銷售類型</h2>
		<? echo form_open('manage/pos_tag_action/update'); ?>
			<input type="hidden" name="tag_num" value="<?=$tag_num ?>" />
			<div>銷售類型名稱:<input type="text" name="tag_name" maxlength="32" value="<?=set_value("tag_name",$tag_name) ?>" /></div>
			<div>銷售類型說明:<input type="text" name="tag_desc" maxlength="128" value="<?=set_value("tag_desc",$tag_desc) ?>" /></div>
			</div>
			<?=validation_errors('<div class="text-error">','</div>') ?>
			<div><input type="submit" value="維護銷售類型" class="btn btn-primary" /></div>
		</form>
	</body>
	
</html>

