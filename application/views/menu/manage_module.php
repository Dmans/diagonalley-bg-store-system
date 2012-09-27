<div id="manage_area">
	<h2>店內管理模組</h2>
	<div><a target="content" href="<?=site_url("manage/manage_action/gid_list_form") ?>">店內遊戲列表</a></div>
	<div><a target="content" href="<?=site_url("user/user_action/member_save_form") ?>">新增會員資料</a></div>
	<div><a target="content" href="<?=site_url("game/game_action/game_list_form") ?>">遊戲資料列表</a></div>
	<div><a target="content" href="<?=site_url("manage/manage_action/daily_page_list") ?>">店內公告列表(個人)</a></div>
	<div><a target="content" href="<?=site_url("order/order_action/save_form") ?>">成立遊戲訂購單</a></div>
	<div><a target="content" href="<?=site_url("order/order_action/list_form") ?>">查詢遊戲訂購單</a></div>
	<div>
		<h4>===銷售資料===</h4>
		<ul>
			<li><a target="content" href="<?=site_url("manage/pos_action/save_form") ?>">新增銷售資料</a></li>
			<li><a target="content" href="<?=site_url("manage/pos_action/pos_list_form") ?>">查詢銷售資料</a></li>
			<? if($usr_role==0 OR $usr_role==1): ?>
				<li><a target="content" href="<?=site_url("manage/pos_tag_action/save_form") ?>">新增銷售類型</a></li>
				<li><a target="content" href="<?=site_url("manage/pos_tag_action/pos_list") ?>">銷售類型列表</a></li>
			<? endif ?>
		</ul>
	</div>
	
</div>

