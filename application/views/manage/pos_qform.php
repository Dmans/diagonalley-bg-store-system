<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>銷售紀錄查詢</title>
		<link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/flick/jquery-ui-1.8.22.custom.css" />
		<link rel="stylesheet" media="screen" href="<?=base_url(); ?>bootstrap/css/bootstrap.min.css">
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery.min.js"></script>
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery-ui-1.8.22.custom.min.js"></script>
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery.ui.datepicker-zh-TW.js"></script>
		<script type="text/javascript" src="<?=base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				$( "#podDate" ).datepicker({
					numberOfMonths: 1,
					dateFormat:'yy-mm-dd',
					showButtonPanel:true
				});
				
				$('#queryButton').click(function(){
					$('#loading').show();
					$('#queryButton').addClass('disabled');
					$.post("<?=site_url("manage/pos_ajax_action/pos_list") ?>",
						{ "pod_date": $('#podDate').val() },
						function(data) {
							$('div#posResultArea').html(data);
							$('#loading').hide();
							$('#queryButton').removeClass('disabled');
						}
					);
				});
			});
			
		</script>
	</head>
	<body>
		<h3>銷售紀錄查詢</h3>
		<div>
			<? echo form_open('manage/pos_action/pos_list'); ?>
				<div>查詢日期:<input type="text" id="podDate" name="pod_date" value="<?=date("Y-m-d") ?>"/>
				</div>
				<?=validation_errors('<div class="text-danger">','</div>') ?>
				<div>
					<input id="queryButton" type="button" value="查詢" class="btn btn-primary" />
					<span id="loading" style="display: none;"><img src="<?=base_url(); ?>images/loading.gif" /></span>
				</div>
			</form>
		</div>
		
		<div id="posResultArea" class="row"></div>
	</body>
</html>

