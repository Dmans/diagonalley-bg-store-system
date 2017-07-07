<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/main.css" />
        <link rel="stylesheet" media="screen" href="<?php echo base_url(); ?>bootstrap/css/bootstrap.min.css">
        <script type="text/javascript" src="<?php echo base_url(); ?>scripts/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
            });

        </script>
        <title>維護遊戲桌資料</title>
    </head>
    <body>
        <h3>維護遊戲桌資料</h3>
        <? echo form_open('manage/tables_action/update'); ?>
            <input type="hidden" name="dtb_num" value="<?php echo $dtb_num ?>" />
            <div>所屬店舖: <?php echo $store->sto_name ?></div>
            <div>遊戲桌名稱:<input type="text" name="dtb_name" value="<?php echo $dtb_name ?>" /></div>
            <div>最大可容納人數:
                <select name="dtb_max_cap">
                    <? for ($i=1; $i <= 10; $i++): ?>
                        <option value="<?php echo $i ?>" title="<?php echo $i ?>" <?php echo set_select('dtb_max_cap', $i , ($dtb_max_cap==$i)); ?>><?php echo $i ?></option>
                    <? endfor ?>
                </select>
            </div>
            <div>遊戲桌狀態:
                <input type="radio" name="dtb_status" value="0" <?php echo set_radio("dtb_status","0") ?> />隱藏
                <input type="radio" name="dtb_status" value="1" <?php echo set_radio("dtb_status","1",TRUE) ?> />公開
            </div>
            <?php echo validation_errors('<div class="text-error">','</div>') ?>
            <div>
                <input type="submit" value="維護遊戲桌資料"  class="btn btn-primary" />
                <input type="reset" value="重填"  class="btn" />
            </div>
        </form>
    </body>

</html>

