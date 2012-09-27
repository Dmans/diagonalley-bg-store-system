<div id="employ_area">
	<h2>員工模組</h2>
	<div><a target="content" href="<?=site_url("user/user_action/change_passwd_form") ?>">維護密碼</a></div>
	<div><a target="content" href="<?=site_url("employ/employ_action/list_form") ?>">上下班打卡</a></div>
	<? if($usr_role==0 OR $usr_role==1): ?>
		<div><a target="content" href="<?=site_url("employ/employ_action/confirm_list_form") ?>">審核打卡資料</a></div>
		<div><a target="content" href="<?=site_url("employ/employ_action/employ_monthly_list_form") ?>">打卡紀錄查詢</a></div>
	<? endif ?>
</div>


