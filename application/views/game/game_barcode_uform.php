<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/main.css" />
		<link rel="stylesheet" media="screen" href="<?=base_url(); ?>bootstrap/css/bootstrap.min.css">
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery.min.js"></script>
		<script type="text/javascript" src="<?=base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
		<script>
			$(document).ready(function(){
				$('#barCode').keypress(function(event){
					if(event.which == 13){
						event.preventDefault();
						checkIsBarCodeUsed($(this).val(), $('#gamNum').val());
					}
				});
				
				$('#barCode').click(function(event){
					//select all
					$(this).select();
				});
			});
			
			function checkIsBarCodeUsed(barCode, gamNum){

				$.ajax({
					url: "<?=site_url("game/game_ajax_action/check_bar_code") ?>",
					dataType: "json",
					data: {
						'bar_code': barCode,
						'gam_num': gamNum
					},
					success: function( data ) {
						
						if(data.redirect!=null && data.redirect==true){
							alert("登入逾時 請重新登入");
							parent.location.reload();
							return;
						}
						
						if(data.checkResult.isDuplicate){
							alert('此條碼已被使用, 遊戲流水號:'+ data.checkResult.barcode.bar_value);
							$('#barCode').val('').focus();
							return;
						}
						
					}
				});
			}
		</script>
		<title>遊戲對應條碼</title>
	</head>
	<body>
		<h1>遊戲對應條碼</h1>
		<div>遊戲中文名稱:<?=$game->gam_cname?></div>
		<? echo form_open('game/game_action/game_barcode_update'); ?>
			<input type="hidden" id="gamNum" name="bar_value" value="<?=$game->gam_num ?>" />
			<div>條碼值:<input type="text" id="barCode" name="bar_code" value="<?=set_value("bar_code", $bar_code) ?>" /></div>
			<?=validation_errors('<div class="text-danger">','</div>') ?>
			<div><input type="submit" value="更新遊戲對應條碼" class="btn btn-primary" /><input type="reset" value="重填" class="btn btn-default" /></div>
		</form>
	</body>
	
</html>

