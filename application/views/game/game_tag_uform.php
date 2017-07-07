<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" media="screen" href="<?=base_url(); ?>bootstrap/css/bootstrap.min.css">
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery.min.js"></script>
		<script type="text/javascript" src="<?=base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
		<title>維護遊戲分類</title>
	</head>
	<body>
		<h1>維護遊戲分類</h1>
		<? echo form_open('game/game_action/game_tag_update'); ?>
			<div>遊戲流水號:<?=$game->gam_num ?><input type="hidden" name="gam_num" value="<?=set_value("gam_num",$game->gam_num) ?>" /></div>
			<div>遊戲中文名稱:<?=$game->gam_cname ?></div>
			<div>遊戲英文名稱:<?=$game->gam_ename ?></div>
			<div class="row-fluid">
				<div class="span1">遊戲分類:</div>
				<div class="span4">
					<table class="table table-striped table-hover table-bordered table-condensed">
						<? $index=1; ?>
						<? foreach ($tags as $key => $tag) : ?>
							<? if($index %5==1): ?>
							<tr>	
							<? endif ?>
								<td>
									<input type="checkbox" id="game_tag_<?=$key ?>" 
											name="game_tags[]" value="<?=$tag->tag_num ?>" 
											<?=(isset($game->game_tags[$tag->tag_num]))?"checked='checked'":"";  ?> />
									<label title="<?=$tag->tag_desc ?>" for="game_tag_<?=$key ?>" ><?=$tag->tag_name ?></label>
								</td>
							<? if($index %5==0): ?>
							</tr>	
							<? endif ?>
							<? $index++; ?>
						<? endforeach ?>
					</table>	
				</div>
			</div>
			<div>
				<input type="submit" value="確認維護遊戲類型" class="btn btn-primary" />
				<input type="reset" value="重填" class="btn" />
			</div>
		</form>
		<?=validation_errors('<div class="text-error">','</div>') ?>
	</body>
</html>

