<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/main.css" />
		<link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/jquery.simplecolorpicker.css" />
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery.simplecolorpicker.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				// $('select[name="tag_color"]').simplecolorpicker({
				  // picker: true
				// }).change(function() {
					// $('span#tagSample').css('color',$(this).val());
				// });
// 				
				// $('select[name="tag_bgcolor"]').simplecolorpicker({
				  // picker: true
				// }).change(function() {
					// $('span#tagSample').css('background-color',$(this).val());
				// });
			});
		</script>
		<title>新增遊戲類型</title>
	</head>
	<body>
		<h1>新增遊戲類型</h1>
		<? echo form_open('game/game_tag_action/tag_save'); ?>
			<div>標籤名稱:<input type="text" name="tag_name" maxlength="32" value="<?=set_value("tag_name","") ?>" /></div>
			<div>標籤說明:<input type="text" name="tag_desc" maxlength="128" value="<?=set_value("gam_ename","") ?>" /></div>
<!-- 			<div>標籤顏色: 
				文字<select name="tag_color">
					  <option value="#000000">Black</option>
					  <option value="#ffffff">White</option>
					  <option value="#7bd148">Green</option>
					  <option value="#5484ed">Bold blue</option>
					  <option value="#a4bdfc">Blue</option>
					  <option value="#46d6db">Turquoise</option>
					  <option value="#7ae7bf">Light green</option>
					  <option value="#51b749">Bold green</option>
					  <option value="#fbd75b">Yellow</option>
					  <option value="#ffb878">Orange</option>
					  <option value="#ff887c">Red</option>
					  <option value="#dc2127">Bold red</option>
					  <option value="#dbadff">Purple</option>
					  <option value="#e1e1e1">Gray</option>
					</select>
				背景<select name="tag_bgcolor">
					  <option value="#ffffff">White</option>
					  <option value="#000000">Black</option>
					  <option value="#7bd148">Green</option>
					  <option value="#5484ed">Bold blue</option>
					  <option value="#a4bdfc">Blue</option>
					  <option value="#46d6db">Turquoise</option>
					  <option value="#7ae7bf">Light green</option>
					  <option value="#51b749">Bold green</option>
					  <option value="#fbd75b">Yellow</option>
					  <option value="#ffb878">Orange</option>
					  <option value="#ff887c">Red</option>
					  <option value="#dc2127">Bold red</option>
					  <option value="#dbadff">Purple</option>
					  <option value="#e1e1e1">Gray</option>
					</select>
				<span id="tagSample" style="background-color: white; color: black;">標籤樣式</span> 
		</div> -->
			<?=validation_errors('<div class="error">','</div>') ?>
			<div><input type="submit" value="新增遊戲類型" /></div>
		</form>
	</body>
	
</html>

