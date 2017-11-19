<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/main.css" />
        <link rel="stylesheet" media="screen" href="<?=base_url(); ?>bootstrap/css/bootstrap.min.css">
        <script type="text/javascript" src="<?=base_url(); ?>scripts/jquery.min.js"></script>
        <script type="text/javascript" src="<?=base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?=base_url(); ?>scripts/common/ajaxForm.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                initAjaxForm();
            });
        </script>
        <title>維護店舖資料</title>
    </head>
    <body class="container-fluid">
        <h3>維護店舖資料</h3>
        <? echo form_open('manage/store_ajax_action/update', 'id="updateForm"'); ?>
        	<div><input type="hidden" name="sto_num" value="<?php echo $store->sto_num ?>" /></div>
            <div>店舖名稱:<input type="text" name="sto_name"  value="<?php echo set_value('sto_name', $store->sto_name); ?>"/></div>
            <div>店舖類型:
                <input type="radio" name="sto_type" value="0" <?php echo ($store->sto_type==0)?'checked="checked"':'' ?>/><?php echo $form_constants->transfer_sto_type(0)?>
                <input type="radio" name="sto_type" value="1" <?php echo ($store->sto_type==1)?'checked="checked"':'' ?>/><?php echo $form_constants->transfer_sto_type(1)?>
            </div>
            <?=validation_errors('<div class="text-danger">','</div>') ?>
            <div>
                <input type="submit" value="維護店舖資料"  class="btn btn-primary" />
                <input type="reset" value="重填"  class="btn btn-default" />
            </div>
        </form>
    </body>

</html>

