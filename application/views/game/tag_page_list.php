<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/main.css" />
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery-1.7.2.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
			});
		</script>
		<title>遊戲類型列表</title>
	</head>
	<body>
		<h2>遊戲類型列表</h2>
		<div>
			<? if(isset($tags)):  ?>
				<div>
					<table class="list_table">
						<tr>
							<th>維護</th>
							<th>遊戲類型名稱</th>
							<th>遊戲類型說明</th>
							<th>刪除</th>
						</tr>
						<? foreach($tags as $tag): ?>
							<tr>
								<td>
									<a target="content" href="<?=site_url("game/game_tag_action/tag_update_form/".$tag->tag_num) ?>">
										維護
									</a>
								</td>
								<td><?=$tag->tag_name ?></td>
								<td><?=$tag->tag_desc ?></td>
								<td>
									<a target="content" href="<?=site_url("game/game_tag_action/remove/".$tag->tag_num) ?>">
										刪除
									</a>
								</td>
							</tr>
						<? endforeach ?>
					</table>
				</div>
			<? endif ?>
		</div>
	</body>
	
</html>

