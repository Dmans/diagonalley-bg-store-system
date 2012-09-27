<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>上架遊戲使用情形</title>
		<link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/main.css" />
		<link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/fullcalendar.css" />
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="<?=base_url(); ?>scripts/fullcalendar.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				$('#calendar').fullCalendar({
					header:{
						left:'prev,next  today',
						center: 'title',
						right: 'month,agendaWeek,agendaDay'
					},
					events: '<?=site_url("report/report_json_action/gid_record_list") ?>'
			   });
			});
			
		</script>
	</head>
	<body>
		<h3>上架遊戲使用情形</h3>
		<div id="calendar"></div>
	</body>
</html>

