<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/main.css" />
		<title>遊戲資料</title>
	</head>
	<body>
		<h1>遊戲資料</h1>
			<div>遊戲流水號:<?=$game->gam_num ?></div>
			<div>遊戲中文名稱:<?=$game->gam_cname ?></div>
			<div>遊戲英文名稱:<?=$game->gam_ename ?></div>
			<div>遊戲庫存:<?=$game->gam_storage ?></div>
			<div>遊戲庫位:<?=$game->gam_locate ?></div>
			<div>遊戲牌套尺寸:<?=$game->gam_cardsize ?></div>
			<div>遊戲牌數量:<?=$game->gam_cardcount ?></div>
			<div>遊戲售價:<?=$game->gam_svalue ?></div>
			<div>遊戲成本價:<?=$game->gam_cvalue ?></div>
			<div>遊戲是否可出售:<?=$game->gam_sale_desc ?></div>
			<div>遊戲分類:
				<? foreach ($game->game_tags as $key => $game_tag) : ?>
					<span title="<?=$game_tag->tag_desc ?>" style="text-decoration: underline "><?=$game_tag->tag_name ?></span>
					&nbsp;
				<? endforeach ?>
			</div>
			<div>遊戲備註:<br/>
				<?=(isset($game->gam_memo))?nl2br($game->gam_memo):"" ?>
			</div>
	</body>
	
</html>

