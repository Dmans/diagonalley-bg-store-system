<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>銷售資料月報表(表單)</title>
		<link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/main.css" />
		<link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/fullcalendar.css" />
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery-1.7.2.min.js"></script>
		<!-- <script type="text/javascript" src="<?=base_url(); ?>scripts/knockout-2.2.1.js"></script> -->
		<script type="text/javascript">
			$(document).ready(function(){
				
			});
			
		</script>
	</head>
	<body>
		<h3>銷售資料月報表(表單)</h3>
		
		
		<div>
			
			<? echo form_open('report/report_action/pos_record_page_table_list'); ?>
			<div>查詢月份：
				<select name="current_select_date">
					<? $prev_year_count=2 ?>
					<? for ($i=0; $i<=$prev_year_count ; $i++) : ?> 
						<? for ($j=1; $j <=12 ; $j++) : ?>
							<? $option=sprintf("%d-%02d", ($now_year-$prev_year_count+$i), $j) ?> 
							<option value="<?=$option ?>" <?=($option==$current_select)?"selected='selected'":""; ?>>
								<?=$option ?>
							</option>
						<? endfor ?>
					<? endfor ?>	
				</select>
			</div>
			<?=validation_errors('<div class="error">','</div>') ?>
			<div><input type="submit" value="查詢" /></div>
		</form>
		</div>
		<table class="list_table">
			<tr>
				<th>日期</th>
				<? foreach ($tags as $tag) : ?>
					<th><?=$tag->tag_name ?></th>
				<? endforeach ?>
			</tr>
			<? foreach ($pos_list as $pos_data) : ?>
			
				<tr>
					<td><?=$pos_data['pos_date'] ?>
					</td>
					<? foreach ($tags as $tag) : ?>
						<td><?=$pos_data[$tag->tag_num]->total_svalue ?></td>
					<? endforeach ?>
				</tr>
			<? endforeach  ?>
		</table>
	</body>
</html>

