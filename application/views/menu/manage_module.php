<div id="manage_area">
	<h4>店內管理模組</h4>
	<!-- <div><a target="content" href="<?php echo site_url("manage/manage_action/gid_list_form") ?>">店內遊戲列表</a></div> -->
<!--	<div><a target="content" href="<?php echo site_url("user/user_action/member_save_form") ?>">新增會員資料</a></div>
	<div><a target="content" href="<?php echo site_url("manage/manage_action/daily_page_list") ?>">店內公告列表(個人)</a></div> -->
	<?php foreach ($stores as $key => $store) : ?>
		<?php if( $store->sto_type==0):?>
			<div><a target="content" href="<?php echo site_url("manage/booking_action/save_form/".$store->sto_num."/") ?>">新增訂位資料(<?php echo $store->sto_name?>)</a></div>
		<?php endif;?>
	<?php endforeach ?>
	<div><a target="content" href="<?php echo site_url("manage/booking_action/list_form") ?>">查詢/維護定位資料</a></div>
	<div><a target="content" href="<?php echo site_url("manage/tables_action/save_form") ?>">新增店舖遊戲桌資料</a></div>
	<div><a target="content" href="<?php echo site_url("manage/tables_action/list_form") ?>">查詢/維護店舖遊戲桌資料</a></div>
<!--	<div>
		<h6>===銷售資料===</h6>
		<ul>
			<li><a target="content" href="<?php echo site_url("manage/pos_action/save_form") ?>">新增銷售資料</a></li>
			<li><a target="content" href="<?php echo site_url("manage/pos_action/pos_list_form") ?>">查詢銷售資料</a></li>
			<li><a target="content" href="<?php echo site_url("order/order_action/save_form") ?>">成立遊戲訂購單</a></li>
			<li><a target="content" href="<?php echo site_url("order/order_action/list_form") ?>">查詢遊戲訂購單</a></li>
			<? if($usr_role==0 OR $usr_role==1): ?>
				<li><a target="content" href="<?php echo site_url("manage/pos_tag_action/save_form") ?>">新增銷售類型</a></li>
				<li><a target="content" href="<?php echo site_url("manage/pos_tag_action/pos_list") ?>">銷售類型列表</a></li>
			<? endif ?>
			<li><span class="label label-success">beta</span><a target="content" href="<?php echo site_url("manage/pos_action/pos_fast_panel") ?>">新增銷售快速介面</a></li>
			<? if($usr_role==0 OR $usr_role==1): ?>
			    <li><span class="label label-success">beta</span><a target="content" href="<?php echo site_url("manage/pos_action/pos_fast_button_save_form") ?>">新增快速銷售按鈕</a></li>
			    <li><span class="label label-success">beta</span><a target="content" href="<?php echo site_url("manage/pos_action/pos_fast_button_list") ?>">快速銷售按鈕列表</a></li>
			<? endif ?>
		</ul>
	</div>
-->
</div>

