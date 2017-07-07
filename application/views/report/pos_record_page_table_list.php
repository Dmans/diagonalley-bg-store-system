<!DOCTYPE html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>銷售資料月報表(表單)</title>
		<!-- <link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/main.css" /> -->
		<link rel="stylesheet" media="screen" href="<?=base_url(); ?>bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/fullcalendar.css" />
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery.min.js"></script>
		<script type="text/javascript" src="<?=base_url(); ?>highcharts/highcharts.js"></script>
		<script type="text/javascript" src="<?=base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
		<!-- <script type="text/javascript" src="<?=base_url(); ?>scripts/knockout-2.2.1.js"></script> -->
		<script type="text/javascript">
			$(document).ready(function(){
				$.get('<?=site_url("report/report_json_action/pos_record_graph") ?>',
					{current_select_date : $('#current_select_date').val()},
					function(data){
						console.log("success");
						console.log(data);
						load_graph(data, $('#current_select_date').val());
					},
					'json');
				
				
			});
			
			function load_graph(jsonData, selectDate){
				$('#tableGraph').highcharts({
					chart: {
	                type: 'line',
	                marginRight: 130,
	                marginBottom: 25
		            },
		            title: {
		                text: '銷售資料' + selectDate + '月報表線圖',
		                x: -20 //center
		            },
		            /*subtitle: {
		                text: 'Source: WorldClimate.com',
		                x: -20
		            },*/
		            xAxis: {
		                categories : jsonData.categories
		            },
		            yAxis: {
		                title: {
		                    text: '金額'
		                },
		                plotLines: [{
		                    value: 0,
		                    width: 1,
		                    color: '#808080'
		                }]
		            },
		            tooltip: {
		                valueSuffix: '元'
		            },
		            legend: {
		                layout: 'vertical',
		                align: 'right',
		                verticalAlign: 'top',
		                x: -10,
		                y: 100,
		                borderWidth: 0
		            },
		            series: jsonData.series
	        	});
			}
			
		</script>
	</head>
	<body>
		<h3>銷售資料月報表(表單)</h3>
		
		
		<div>
			
			<? echo form_open('report/report_action/pos_record_page_table_list'); ?>
			<div>查詢月份：
				<select id="current_select_date" name="current_select_date">
					<? $prev_year_count=2 ?>
					<? for ($i=0; $i<=$prev_year_count ; $i++) : ?> 
						<? for ($j=1; $j <=12 ; $j++) : ?>
							<? $option=sprintf("%d-%02d", ($now_year-$prev_year_count+$i), $j) ?> 
							<option value="<?=$option ?>" <?=($option==$current_select)?"selected='selected'":""; ?>>
								<?=$option ?>
							</option>
						<? endfor ?>
					<? endfor ?>	
				</select>
			</div>
			<?=validation_errors('<div class="text-error">','</div>') ?>
			<div><input type="submit" value="查詢" class="btn btn-primary" /></div>
		</form>
		</div>
		<table class="table table-striped table-hover table-bordered table-condensed">
			<tr>
				<th>日期</th>
				<? foreach ($tags as $tag) : ?>
					<th><?=$tag->tag_name ?></th>
				<? endforeach ?>
			</tr>
			<? foreach ($pos_list as $pos_data) : ?>
			
				<tr>
					<td><?=$pos_data['pos_date'] ?>
					</td>
					<? foreach ($tags as $tag) : ?>
						<td><?=$pos_data[$tag->tag_num]->total_svalue ?></td>
					<? endforeach ?>
				</tr>
			<? endforeach  ?>
		</table>
		<div id="tableGraph"></div>
	</body>
</html>

