<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>New Web Project</title>
	</head>
	<body>
		<h1>處理結果</h1>
		<div><?=$message  ?></div>
		<? if(isset($extend_url)): ?>
		<div>
			<? foreach ($extend_url as $key => $url_data) : ?>
				<div><a href="<?=$url_data->url ?>"><?=$url_data->title ?></a></div>
			<? endforeach ?>
		</div>
		<? endif ?>
	</body>
</html>

