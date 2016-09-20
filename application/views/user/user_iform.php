<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/main.css" />
		<link rel="stylesheet" media="screen" href="<?=base_url(); ?>bootstrap/css/bootstrap.min.css">
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="<?=base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
		<script>
    		$(document).ready(function(){
    		    var $storePermission = $('div#storePermission');
    		    $storePermission.hide();
                $("input[name='usr_role']").change(function(e){
                    if($(this).val() == '1') {

                        $storePermission.show();
                    } else {
                        $storePermission.hide();
                    }

                });
    		});

		</script>
		<title>新增使用者</title>
	</head>
	<body>
		<h1>新增使用者</h1>
		<? echo form_open('user/user_action/save'); ?>
			<div>使用者帳號:<input type="text" name="usr_id" maxlength="32" /></div>
			<div>使用者名稱:<input type="text" name="usr_name" maxlength="32" /></div>
			<div>使用者密碼:<input type="password" name="usr_passwd" maxlength="32" /></div>
			<div>確認使用者密碼:<input type="password" name="confirm_usr_passwd" maxlength="32" /></div>
			<div>使用者帳號類型:
				<? if($usr_role==0):  ?><input type="radio" name="usr_role"  value="1" />店長<? endif ?>
				<input type="radio" name="usr_role"  value="2" />員工
				<input type="radio" name="usr_role"  value="3" checked="checked" />會員
			</div>
			<? if($usr_role==0):  ?>
			<div id="storePermission">店舖權限:
                <? foreach ($stores as $key => $store) : ?>
                    <input type="checkbox" id="store_<?=$key ?>"
                            name="sto_nums[]" value="<?=$store->sto_num ?>"
                    <label title="<?=$store->sto_name ?>" for="store_<?=$key ?>" ><?=$store->sto_name ?></label>
                <? endforeach ?>
            </div>
			<? endif ?>
			<div>使用者啟用狀態:啟用</div>
			<div>使用者備註:<br/>
				<textarea name="usr_memo" cols="50" rows="10"></textarea>
			</div>
			<?=validation_errors('<div class="text-error">','</div>') ?>
			<div>
				<input type="submit" value="新增使用者" class="btn btn-primary" />
				<input type="reset" value="重填" class="btn" />
			</div>
		</form>
	</body>

</html>

