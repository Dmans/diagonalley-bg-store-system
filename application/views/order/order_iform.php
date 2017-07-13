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
				$('#buyUsrId').autocomplete({
					source: function( request, response ) {
						
						
						$.ajax({
							url: "<?=site_url("order/order_ajax_action/users_autocomplete") ?>",
							dataType: "jsonp",
							data: {
								'usr_id': request.term
							},
							success: function( data ) {
								
								if(data.redirect!=null && data.redirect==true){
									alert("登入逾時 請重新登入");
									parent.location.reload();
									return;
								}
								
								response(data.users);
							}
						});
					},
					minLength: 2,
					select: function( event, ui ) {
						$('#usrNum').val(ui.item.usr_num);
					}
					
				});
				
				$('#buyGameName').autocomplete({
					source: function( request, response ) {
						$('#gameDetail').fadeOut();
						$('#gamNum').val('');
						$.ajax({
							url: "<?=site_url("order/order_ajax_action/games_autocomplete") ?>",
							dataType: "jsonp",
							data: {
								'gam_name': request.term
							},
							success: function( data ) {
								if(data.redirect!=null && data.redirect==true){
									alert("登入逾時 請重新登入");
									parent.location.reload();
									return;
								}
								response(data.games);
							}
						});
					},
					minLength: 2,
					select: function( event, ui ) {
						$('#submitButton').removeAttr("disabled");
						
						$('#gamNum').val(ui.item.gam_num);
						$('#storage').text(ui.item.gam_storage);
						$('#locate').text(ui.item.gam_locate);
						$('#cardsize').text(ui.item.gam_cardsize);
						
						$('#gameSvalue').text(ui.item.gam_svalue);
						$('input#gamSvalue').val(ui.item.gam_svalue);
						
						$('#gameDetail').fadeIn();
						
						if(parseInt(ui.item.gam_storage,10)<=0){
							alert("此遊戲目前無庫存");
							$('#submitButton').attr("disabled","disabled");
						}
					}
					
				});
				
				$( "input[id^='ordDate']" ).each(function(){
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
			
			function formSubmit(){
				// alert("submit");
				var errorMessage="";
				
				if($('#usrNum').val()==""){
					errorMessage += "訂購會員帳號 欄位必填\n";
				}
				
				if($('#gamNum').val()==""){
					errorMessage += "訂購遊戲 欄位必填\n";
				}
				
				if($('input[name="ord_type"]:checked').val()=="1" 
					&&	$('#gamSvalueRebate').val()==""){
					errorMessage += "選擇特價則 特價欄位必填\n";
				}
				
				if(errorMessage!=""){
					alert(errorMessage);
					return false;		
				}
				
				$('#saveForm').submit();
			}
		</script>
		<title>新增訂單</title>
	</head>
	<body>
		<h1>新增訂單</h1>
		<? echo form_open('order/order_action/save', array("id"=>"saveForm")); ?>
			<div>
				訂購會員帳號:<input type="text" id="buyUsrId" name="usr_id" value="<?=set_value("usr_id","") ?>" maxlength="64" size="50" />
				<input type="hidden" name="usr_num" id="usrNum" value="<?=set_value("usr_num",$default_usr_num) ?>" />
				未輸入將使用預設散客帳號
			</div>
			<div>
				<div>
					訂購遊戲:<input type="text" id="buyGameName" name="gam_name" value="<?=set_value("gam_name","") ?>" maxlength="64" size="50" />
					<input type="hidden" name="gam_num" id="gamNum" value="<?=set_value("gam_num","") ?>" />
				</div>
				<div id="gameDetail" style="display: none">
					<div>遊戲庫存:<span id="storage"></span></div>
					<div>遊戲庫位:<span id="locate"></span></div>
					<div>遊戲牌套尺寸:<span id="cardsize"></span></div>
				</div>
			</div>
			<div>
				遊戲售價:
				<input type="radio" name="ord_type" value="0" checked="checked" />原價
				<span id="gameSvalue"></span>元
				<input type="hidden" id="gamSvalue" name="gam_svalue" maxlength="5" />
				<input type="radio" name="ord_type" value="1" />特價
				<input type="text" name="gam_svalue_rebate" id="gamSvalueRebate" maxlength="5" size="5" />
			</div>
			<div>訂單狀態:
				<input type="radio" name="ord_status"  value="0" <?=set_radio("ord_status", "0", TRUE) ?> />一般訂單
				<input type="radio" name="ord_status"  value="1" <?=set_radio("ord_status", "1") ?> />預購訂單
			</div>
			<div>訂購時間:
				<input type="text" id="ordDate" name="ord_date" value="<?=set_value('ord_date', $ord_date); ?>" />
			</div>
			<?=validation_errors('<div class="text-danger">','</div>') ?>
			<div>
				<input type="button" id="submitButton" value="送出訂單" onclick="formSubmit();" class="btn btn-primary" />
				<input type="reset" value="重填" class="btn btn-default" />
			</div>
		</form>
	</body>
	
</html>

