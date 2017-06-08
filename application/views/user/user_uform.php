<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

		<link rel="stylesheet" media="screen" href="<?=base_url(); ?>bootstrap/css/bootstrap.min.css">
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="<?=base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
        <script>
            $(document).ready(function(){
                var $storePermission = $('div#storePermission');
                var usrRole = $("input[name='usr_role']:checked").val();
                if(usrRole!='1' && usrRole!='0'){
                    $storePermission.hide();
                }

                if(usrRole=='0') {
                    $("input[name='usr_role']").attr('disabled',true);
                }

                $("input[name='usr_role']").change(function(e){
                    if($(this).val() == '1' || $(this).val() == '0') {
                        $storePermission.show();
                    } else {
                        $storePermission.hide();
                    }

                });
            });

        </script>
		<title>維護使用者</title>
	</head>
	<body>
		<h1>維護使用者</h1>
		<? echo form_open('user/user_action/update'); ?>
			<div>使用者流水號:<?=$update_user->usr_num ?><input type="hidden" name="usr_num" value="<?=$update_user->usr_num ?>" /></div>
			<div>使用者帳號:<?=$update_user->usr_id ?></div>
			<div>使用者名稱:<input type="text" name="usr_name" maxlength="32" value="<?=$update_user->usr_name ?>" /></div>
			<div>使用者信箱:<input type="text" name="usr_mail" maxlength="32" value="<?php $update_user->usr_mail?>" /></div>
			
			<div>帳號類型:
				<?php if($usr_role<=1):  ?>
					<? if($usr_role==0):  ?>
    			        <input type="radio" name="usr_role"  value="0" <?=($update_user->usr_role==0)?'checked="checked"':'' ?> />Root
                        <input type="radio" name="usr_role"  value="1" <?=($update_user->usr_role==1)?'checked="checked"':'' ?> />店長
                    <? endif ?>
                    <input type="radio" name="usr_role"  value="2" <?=($update_user->usr_role==2)?'checked="checked"':'' ?> />員工
                    <input type="radio" name="usr_role"  value="3" <?=($update_user->usr_role==3)?'checked="checked"':'' ?> />會員
				<?php endif; ?>
				<?php if($usr_role>1):  ?>
					<?php echo $form_constants->transfer_usr_role($update_user->usr_role); ?>
				<?php endif; ?>
    			    
			</div>
			<? if($usr_role==0):  ?>
            <div id="storePermission">店舖權限:
                <? foreach ($stores as $key => $store) : ?>
                    <input type="checkbox" id="store_<?=$key ?>"
                            name="sto_nums[]" value="<?=$store->sto_num ?>"
                            <?=(in_array($store->sto_num, $update_user->user_store_permission))?'checked="checked"':'' ?>
                    <label title="<?=$store->sto_name ?>" for="store_<?=$key ?>" ><?=$store->sto_name ?></label>
                <? endforeach ?>
            </div>
            <? endif ?>
            <? if($usr_role!=0):  ?>
            <div id="storePermission">店舖權限:
                <? foreach ($update_user->user_store_permission as $key => $sto_num) : ?>
                    <div><?=$stores[$sto_num]->sto_name ?></div>
                <? endforeach ?>
            </div>
            <? endif ?>
			<div>啟用狀態:
			<?php if($usr_role<=1):  ?>
				<input type="radio" name="usr_status"  value="0" <?=($update_user->usr_status==0)?'checked="checked"':'' ?> />停用
				<input type="radio" name="usr_status"  value="1" <?=($update_user->usr_status==1)?'checked="checked"':'' ?> />啟用
			<?php endif; ?>
			<?php if($usr_role>1):  ?>
				<?php echo $form_constants->transfer_usr_status($update_user->usr_status); ?>
			<?php endif; ?>
			</div>
			<div>使用者備註:<br/>
				<textarea name="usr_memo" cols="50" rows="10"><?=(isset($update_user->usr_memo))?$update_user->usr_memo:"" ?></textarea>
			</div>
			<?=validation_errors('<div class="text-error">','</div>') ?>
			<div>
				<input type="submit" value="維護使用者" class="btn btn-primary" />
				<input type="reset" value="重填" class="btn" />
			</div>
		</form>
	</body>

</html>

