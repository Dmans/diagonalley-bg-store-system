<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		
		<link rel="stylesheet" media="screen" href="<?=base_url(); ?>bootstrap/css/bootstrap.min.css">
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="<?=base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
		<title>處理結果</title>
	</head>
	<body>
		<h1>處理結果</h1>
		<div class="text-success"><h3><?=$message  ?></h3></div>
		<? if(isset($extend_url)): ?>
		<div>
			<? foreach ($extend_url as $key => $url_data) : ?>
				<div><a href="<?=$url_data->url ?>" class="btn" ><?=$url_data->title ?></a></div>
			<? endforeach ?>
		</div>
		<? endif ?>
	</body>
</html>

