<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/main.css" />
		<link rel="stylesheet" media="screen" href="<?=base_url(); ?>bootstrap/css/bootstrap.min.css">
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="<?=base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
			});
		</script>
		<title>新增銷售類型</title>
	</head>
	<body>
		<h2>新增銷售類型</h2>
		<? echo form_open('manage/pos_tag_action/save'); ?>
			<div>銷售類型名稱:
				<input type="text" name="tag_name" maxlength="32" value="<?=set_value("tag_name","") ?>" />
				(顯示於銷售資料的銷售類型下拉選單)
			</div>
			<div>銷售類型說明:
				<input type="text" name="tag_desc" maxlength="128" value="<?=set_value("gam_ename","") ?>" />
				(顯示於銷售類型下拉選單滑鼠移到選項時出現說明)
			</div>
			</div>
			<?=validation_errors('<div class="error">','</div>') ?>
			<div><input type="submit" value="新增銷售類型" /></div>
		</form>
	</body>
	
</html>

