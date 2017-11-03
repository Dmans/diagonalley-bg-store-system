<div id="user_area">
	<h4>使用者模組</h4>
	<?php if($usr_role==0 or $usr_role==1): ?>
		<div><a target="content" href="<?php echo site_url("user/user_action/save_form") ?>">新增使用者</a></div>
		<div><a target="content" href="<?php echo site_url("user/user_action/list_form") ?>">查詢/維護使用者</a></div>
	<?php endif; ?>
</div>
<hr/>
