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
		<title>新增遊戲類型</title>
	</head>
	<body>
		<h1>新增遊戲類型</h1>
		<? echo form_open('game/game_tag_action/tag_save'); ?>
			<div>標籤名稱:<input type="text" name="tag_name" maxlength="32" value="<?=set_value("tag_name","") ?>" /></div>
			<div>標籤說明:<input type="text" name="tag_desc" maxlength="128" value="<?=set_value("gam_ename","") ?>" /></div>
			<?=validation_errors('<div class="text-danger">','</div>') ?>
			<div><input type="submit" value="新增遊戲類型" class="btn btn-primary" /></div>
		</form>
	</body>
	
</html>

