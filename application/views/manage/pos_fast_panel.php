<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/flick/jquery-ui-1.8.22.custom.css" />
		<link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/jquery-ui-timepicker.css" />
		<link rel="stylesheet" media="screen" href="<?=base_url(); ?>bootstrap/css/bootstrap.min.css">
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery.min.js"></script>
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery-ui-1.8.22.custom.min.js"></script>
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery.ui.datepicker-zh-TW.js"></script>
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery-ui-timepicker.js"></script>
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery-ui-timepicker-zh-TW.js"></script>
		<script type="text/javascript" src="<?=base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript">
			var counter=0;
			$(document).ready(function(){
				
				$('.fastButton').each(function(index,element){
					
					$(element).click(function(){
						
						var pfsNum = $(element).val();
						var pfsNum = $(element).val();
						var podSvalue = $(element).attr("podsvalue");
						var podDesc = $(element).attr("poddesc");
						var tagName = $(element).attr("tagname");
						
						populateNewPosLine(pfsNum,podSvalue,podDesc,tagName);
						counter++;
						populateTotalSelectedCount(counter);
					});
					
					
				});
				
				populateTodayPos();
				
				$('#cleanUpButton').click(function(){
					cleanUpPos();
				});
				
				$('#submitPosButton').click(function(){
					submitCurrentPos();
				});				
				
			});
			
			function populateNewPosLine(pfsNum,podSvalue,podDesc,tagName){
				var insertTag="<div>"+tagName+" "+pfsNum+" "+podDesc+" "+podSvalue+"</div>";
				
				$("div#displayArea").append(insertTag);
				$("<input>").attr({name:'pfsNums[]',type:'hidden',value:pfsNum}).appendTo("div#insertPfsNums");
				increaseTotalSvalue(podSvalue);
				
				console.log($('input[name=pfsNums]').length);
			}
			
			function populateTodayPos(){
				$.post("<?=site_url("manage/pos_ajax_action/pos_list") ?>",
					{ "pod_date": "<?=date("Y-m-d") ?>" },
					function(data) {
						$('div#todayPosArea').html(data);
					}
				);
				
			}
			
			function populateTotalSelectedCount(count){
				$('#totalSelectedCount').html(count);
			}
			
			function increaseTotalSvalue(newSvalue){
				var nowTotalValue = parseInt($("#totalSvalueArea").text(),10);
				nowTotalValue = nowTotalValue + parseInt(newSvalue,10);
				
				$("#totalSvalueArea").text(nowTotalValue);
			}
			
			function cleanUpPos(){
				$('#insertPfsNums').text("");
				$('#displayArea').text("");
				$('#totalSvalueArea').text("0");
				counter=0;
				populateTotalSelectedCount(counter);
			}
			
			function submitCurrentPos(){
				$('#loading').show();
				var postSubmit = $.post("<?=site_url("manage/pos_ajax_action/pos_fast_save") ?>",
					  				$("#currentPosForm").serialize()
			 		 			);
			 	postSubmit.done(function(){
			 		cleanUpPos();
			 		populateTodayPos();
			 		$('#loading').hide();
			 		});
			}
			
		</script>
		<title>新增銷售快速介面</title>
	</head>
	<body>
		<h3>新增銷售快速介面</h3>
		<div id="fastButtonArea">
			<? foreach ($query_result as $fastpos ) : ?>
				<button id="fastButton_<?=$fastpos->pfs_num ?>" 
						class="fastButton btn btn-default btn-lg" 
					    type="button" 
					    value="<?=$fastpos->pfs_num ?>" 
					    podSvalue="<?=$fastpos->pod_svalue ?>" 
					    podDesc="<?=$fastpos->pod_desc ?>"
					    tagName="<?=$fastpos->tag->tag_name ?>">
					<?=$fastpos->tag->tag_name ?><?=$fastpos->pod_desc ?> $<?=$fastpos->pod_svalue ?>
				</button>
			<? endforeach ?>
		</div>
		<div id="fastCartArea">
			<form id="currentPosForm">
				<div id="insertPfsNums"></div>
				<div id="displayArea" class="well"></div>
				<div>目前總金額:<span id="totalSvalueArea">0</span>元</div>
				<div>目前共選擇:<span id="totalSelectedCount">0</span>項</div>
				<button id="submitPosButton" type="button" class="btn btn-primary btn-lg">送出</button>
				<button id="cleanUpButton" type="button" class="btn btn-default btn-lg">清空</button>
			</form>
		</div>
		<span id="loading" style="display: none;"><img src="<?=base_url(); ?>images/loading.gif" /></span>
		<div id="todayPosArea">
			
		</div>
		
		
		
		
	</body>
</html>

