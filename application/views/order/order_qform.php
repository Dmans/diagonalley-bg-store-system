<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/flick/jquery-ui-1.8.22.custom.css" />
		<link rel="stylesheet" media="screen" href="<?=base_url(); ?>bootstrap/css/bootstrap.min.css">
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery.min.js"></script>
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery-ui-1.8.22.custom.min.js"></script>
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery.ui.datepicker-zh-TW.js"></script>
		<script type="text/javascript" src="<?=base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				$.datepicker.setDefaults( $.datepicker.regional["zh-TW"] );
				$( "#dateFrom" ).datepicker({
					changeMonth: true,
					numberOfMonths: 3,
					dateFormat:'yy-mm-dd',
					onSelect: function( selectedDate ) {
						$( "#dateTo" ).datepicker( "option", "minDate", selectedDate );
					}
				});
				$( "#dateTo" ).datepicker({
					changeMonth: true,
					numberOfMonths: 3,
					dateFormat:'yy-mm-dd',
					onSelect: function( selectedDate ) {
						$( "#dateFrom" ).datepicker( "option", "maxDate", selectedDate );
					}
				});
			});
			
		</script>
		<title>查詢訂單資料</title>
	</head>
	<body>
		<h1>查詢訂單資料</h1>
		<? echo form_open('order/order_action/order_list'); ?>
			<div>訂單流水號:<input type="text" name="ord_num" maxlength="32" size="24" /></div>
<!-- 			<div>遊戲流水號:<input type="text" name="gam_num" maxlength="32" size="24" /></div> -->
			<div>訂單成立時間:
					從<input type="text" id="dateFrom" name="start_order_date"/>
					到<input type="text" id="dateTo" name="end_order_date"/>
				</div>
			<div>訂單狀態:
				<input type="radio" name="ord_status"  value="0" checked="checked" />一般
				<input type="radio" name="ord_status" value="1" />預購
				<input type="radio" name="ord_status" value="2" />取消
				<input type="radio" name="ord_status" value="-1" />全部
			</div>
			<?=validation_errors('<div class="text-error">','</div>') ?>
			<div><input type="submit" value="查詢" class="btn btn-primary" /></div>
		</form>
		
		<div>
			<? if(isset($query_result)):  ?>
				<h3>查詢結果</h3>
				<table class="table table-striped table-hover table-bordered table-condensed">
					<tr>
						<th>查詢/維護</th>
						<th>訂單流水號</th>
						<th>訂購者帳號</th>
						<th>遊戲名稱</th>
						<th>訂單類型</th>
						<th>訂單金額</th>
						<th>訂單狀態</th>
						<th>訂單成立日期</th>
						<th>訂單成立者</th>
						<th>取消訂單</th>
					</tr>
					<? foreach ($query_result as $row) : ?> 
						<tr>
							<td>
								<a href="<?=site_url("order/order_action/page_detail/".$row->ord_num) ?>" class="btn btn-info btn-mini">查詢</a>
							<? if($usr_role==0 OR $usr_role==1): ?>
<!-- 								<a href="<?=site_url("order/order_action/update_form/".$row->ord_num) ?>">維護</a> -->
							<? endif ?>
							</td>
							<td><?=$row->ord_num ?></td>
							<td><?=$row->usr_id ?></td>
							<td><?=$row->gam_cname ?>(<?=$row->gam_ename ?>)</td>
							<td><?=$row->ord_type_desc ?></td>
							<td><?=$row->ord_svalue ?></td>
							<td><?=$row->ord_status_desc ?></td>
							<td><?=$row->ord_date ?></td>
							<td><?=$row->ord_usr_name ?></td>
							<td><a href="<?=site_url("order/order_action/cancel/".$row->ord_num) ?>" class="btn btn-danger btn-mini" >取消</a></td>
						</tr>
					<? endforeach  ?>
				</table>
			<? else : ?>
				<h3>尚未進行查詢或查無資料</h3>
			<? endif ?>
		</div>
	</body>
</html>
