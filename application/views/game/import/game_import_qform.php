<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" media="screen" href="<?=base_url(); ?>bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/flick/jquery-ui-1.8.22.custom.css" />
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery-ui-1.8.22.custom.min.js"></script>
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery.ui.datepicker-zh-TW.js"></script>
		<script type="text/javascript" src="<?=base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				$.datepicker.setDefaults( $.datepicker.regional["zh-TW"] );
				$( "#dateFrom" ).datepicker({
					changeMonth: true,
					numberOfMonths: 3,
					dateFormat:'yy/mm/dd',
					onSelect: function( selectedDate ) {
						$( "#dateTo" ).datepicker( "option", "minDate", selectedDate );
					}
				});
				$( "#dateTo" ).datepicker({
					changeMonth: true,
					numberOfMonths: 3,
					dateFormat:'yy/mm/dd',
					onSelect: function( selectedDate ) {
						$( "#dateFrom" ).datepicker( "option", "maxDate", selectedDate );
					}
				});
			});
			
		</script>
		<title>查詢遊戲入庫資料</title>
	</head>
	<body>
		<h1>查詢遊戲入庫資料</h1>
		<? echo form_open('game/game_import_action/game_import_list'); ?>
			<div>查詢區間:
				從<input type="text" id="dateFrom" name="start_gim_date"/>
				到<input type="text" id="dateTo" name="end_gim_date"/>
			</div>
			<?=validation_errors('<div class="text-error">','</div>') ?>
			<div>
				<input type="submit" value="查詢遊戲入庫單"  class="btn btn-primary" />
				<input type="reset" value="重填" class="btn" />
			</div>
		</form>
		<? if(isset($query_result)):  ?>
			<table id="gameListTable" class="table table-striped table-hover table-bordered table-condensed">
				<tr>
					<th>遊戲入庫單流水號</th>
					<th>入庫日期</th>
					<th>新增人員</th>
				</tr>
				<? foreach ($query_result as $row) : ?> 
						<td>
							<a href="<?=site_url("game/game_import_action/game_import_page_detail/".$row->gim_num) ?>"><?=$row->gim_num ?></a>
						</td>
						<td><?=$row->gim_date ?></td>
						<td><?=$row->usr_num ?></td>
					</tr>
				<? endforeach  ?>
			</table>
		<? endif ?>
	</body>
</html>