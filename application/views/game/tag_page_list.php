<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" media="screen" href="<?=base_url(); ?>bootstrap/css/bootstrap.min.css">
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="<?=base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
			});
		</script>
		<title>遊戲類型列表</title>
	</head>
	<body>
		<h2>遊戲類型列表</h2>
		<div class="row">
			<? if(isset($tags)):  ?>
				<div class="span9">
					<table class="table table-striped table-hover table-bordered table-condensed">
						<tr>
							<th>維護</th>
							<th>遊戲類型名稱</th>
							<th>遊戲類型說明</th>
							<th>刪除</th>
						</tr>
						<? foreach($tags as $tag): ?>
							<tr>
								<td>
									<a target="content" href="<?=site_url("game/game_tag_action/tag_update_form/".$tag->tag_num) ?>" class="btn btn-warning btn-mini">
										維護
									</a>
								</td>
								<td><?=$tag->tag_name ?></td>
								<td><?=$tag->tag_desc ?></td>
								<td>
									<a target="content" href="<?=site_url("game/game_tag_action/remove/".$tag->tag_num) ?>" class="btn btn-danger btn-mini">
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

