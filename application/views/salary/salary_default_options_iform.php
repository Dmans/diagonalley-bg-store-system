<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/main.css" />
		<link rel="stylesheet" media="screen" href="<?=base_url(); ?>bootstrap/css/bootstrap.min.css">
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery.min.js"></script>
		<script type="text/javascript" src="<?=base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>scripts/jquery.numeric.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>scripts/underscore-min.js"></script>
		
		<script>
            $(document).ready(function(){
                $('input#dsdoValue').numeric({ negative : false });
                $('#dsdoType').change(function(){
                    onDsdoType($(this).val());
                });

                onDsdoType($('#dsdoType option:selected').val());
    		});

    		function onDsdoType(dsdoType) {
    		    if (_.indexOf(["2", "3"], dsdoType) != -1) {
                    $('span#negativeSign').show();
                } else {
                    $('span#negativeSign').hide();
                }
    		}
		</script>
		<title>新增常用薪資附加項目</title>
	</head>
	<body>
		<h1>新增常用薪資附加項目</h1>
		<? echo form_open('salary/salary_default_options_action/save'); ?>
			<div>項目類型:
				<select id="dsdoType" name="dsdo_type">
					<option value="0" <?php echo set_select('dsdo_type', '0'); ?>><?php echo $form_constants->transfer_dso_type(0)?></option>
					<option value="1" <?php echo set_select('dsdo_type', '1'); ?>><?php echo $form_constants->transfer_dso_type(1)?></option>
					<option value="2" <?php echo set_select('dsdo_type', '2'); ?>><?php echo $form_constants->transfer_dso_type(2)?></option>
					<option value="3" <?php echo set_select('dsdo_type', '3'); ?>><?php echo $form_constants->transfer_dso_type(3)?></option>
				</select>
			</div>
			<div>項目金額:<span id="negativeSign"> - </span><input id="dsdoValue" name="dsdo_value" type="text" value="<?php echo set_value('dsdo_value', ''); ?>"></div>
			<div>項目說明:<input id="dsdoDesc" name="dsdo_desc" type="text" value="<?php echo set_value('dsdo_desc', ''); ?>"></div>
			<?=validation_errors('<div class="text-danger">','</div>') ?>
			<div>
				<input type="submit" value="新增常用薪資附加項目" class="btn btn-primary" />
				<input type="reset" value="重填" class="btn btn-default" />
			</div>
		</form>
	</body>

</html>

