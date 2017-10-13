<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/main.css" />
		<link rel="stylesheet" media="screen" href="<?=base_url(); ?>bootstrap/css/bootstrap.min.css">
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery.min.js"></script>
		<script type="text/javascript" src="<?=base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>scripts/jquery.numeric.js"></script>
		
		<script>
    		$(document).ready(function(){
                $("input[name='usr_role']").change(function(e){
//                     if($(this).val() == '1') {

//                         $storePermission.show();
//                     } else {
//                         $storePermission.hide();
//                     }

//                     $('span.salary_wording').hide();
//                     if($(this).val() == '4') {
                        
//                         $('span#salaryPartTime').show();
//                     }

// 					if($(this).val() == '1' || $(this).val() == '2') {
                        
//                         $('span#salaryEmp').show();
//                         $('div#divBaseHours').show();
//                     } else {
//                     	$('div#divBaseHours').hide();
//                     }

					onUsrRoleChange($(this).val());

                });

                var usrRole = $("input[name='usr_role']:checked").val()
            	
                onUsrRoleChange(usrRole);
                
                $('input#usrSalary').numeric({ negative : false });
                $('div#divBaseHours').hide();
    		});

			function onUsrRoleChange(usrRole) {
                
                if(usrRole == "1" || usrRole == "0") {
                    $('div#storePermission').show();
                } else {
                	$('div#storePermission').hide();
                }

                if(usrRole == "3" || usrRole == "0") {
                	$("div#usrSalaryDiv").hide();
                } else {
                	$("div#usrSalaryDiv").show();
                }

                $('span.salary_wording').hide();
                if(usrRole == "4") {
                    
                    $('span#salaryPartTime').show();
                }

				if(usrRole == "1" || usrRole == "2") {
                    
                    $('span#salaryEmp').show();
                    $('div#divBaseHours').show();
                } else {
                	$('div#divBaseHours').hide();
                }
            }

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
			<div>使用者信箱:<input type="text" name="usr_mail" maxlength="32" /></div>
			<div>使用者帳號類型:
				<? if($usr_role==0):  ?>
					<input type="radio" name="usr_role"  value="1" />店長
				<? endif ?>
				<input type="radio" name="usr_role"  value="2" />員工
				<input type="radio" name="usr_role"  value="4"  checked="checked" />工讀生
<!-- 				<input type="radio" name="usr_role"  value="3"/>會員 -->
			</div>
			<div>
				<span class="salary_wording" id="salaryPartTime">使用者時薪<input type="text" id="usrSalary" name="usr_salary" maxlength="8" /></span>
				<span class="salary_wording" id="salaryEmp" style="display: none;">使用者每月底薪<input type="text" id="usrMonthlySalary" name="usr_monthly_salary" maxlength="8" /></span>
			</div>
			<!-- Only Employee need base hours -->
			<div id="divBaseHours">使用者每月基本工時:<input type="text" name="usr_base_hours" maxlength="4" />小時</div>
			
			<? if($usr_role==0):  ?>
			<div id="storePermission">店舖權限:
                <? foreach ($stores as $key=>$store): ?>
                    <input type="checkbox" id="store_<?=$key ?>"
                            name="sto_nums[]" value="<?=$store->sto_num ?>" /><?php echo $store->sto_name ?>
                <? endforeach ?>
            </div>
			<? endif ?>
			<div>使用者啟用狀態:啟用</div>
			<div>使用者備註:<br/>
				<textarea name="usr_memo" cols="50" rows="10"></textarea>
			</div>
			<?=validation_errors('<div class="text-danger">','</div>') ?>
			<div>
				<input type="submit" value="新增使用者" class="btn btn-primary" />
				<input type="reset" value="重填" class="btn btn-default" />
			</div>
		</form>
	</body>

</html>

