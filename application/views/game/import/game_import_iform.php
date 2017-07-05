<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" media="screen" href="<?=base_url(); ?>bootstrap/css/bootstrap.min.css">
		<script type="text/javascript" src="<?=base_url(); ?>scripts/jquery.min.js"></script>
		<script type="text/javascript" src="<?=base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript">
			
			var submitData = new Array();
			$(document).ready(function(){
				$('#barCode').keypress(function(event){
					if(event.which == 13){
						event.preventDefault();
						if(!isDataExists($(this).val())){
							getBarcodeData($(this).val());	
						}else{
							alert("此條碼已重複");
							$(this).val('');
							$(this).focus();
						}
						
					}
				});
				
				$('#submitButton').click(function(){
					
					var errorMsg = validateAddData();
					
					if(errorMsg.length != 0){
						alert(errorMsg.join('\r\n'));
						$('#barCode').focus();
						return;
					}
					
					
					var newData = addToSubmitData();
					addNewDataRow(newData);
					resetForm();
					$('#barCode').focus();
					
				});
				
				$('#submitImportData').click(function(){
					$.ajax({
						type: 'POST',
						url: "<?=site_url("game/game_import_ajax_action/game_import_save") ?>",
						dataType: "json",
						data: {dataArray : submitData},
						success: function( data ) {
							alert(data.message);
							window.location="<?=site_url("game/game_import_action/game_import_page_detail") ?>/"+data.gim_num;
						}
					});
					
				});
				
			});
			
			function isDataExists(code){
				for(var i=0 ; i<submitData.length ; i++) {
					if(submitData[i].bar_code == code ){
						return true;
					}
				}
				return false;
			}
			
			function getBarcodeData(code){
				
				$.ajax({
					url: "<?=site_url("game/game_import_ajax_action/get_game_info") ?>",
					dataType: "json",
					data: {
						'bar_code': code
					},
					success: function( data ) {
						
						if(data.redirect!=null && data.redirect==true){
							alert("登入逾時 請重新登入");
							parent.location.reload();
							return;
						}
						
						var game=data.game;
						
						if(game == null){
							alert('此條碼資料不存在');
							resetForm();
							$('#barCode').focus();
							return;
						}
						
						
						$('#gamNameSpan').text(game.gam_cname + '(' + game.gam_ename + ')');
						$('#gamName').val(game.gam_cname + '(' + game.gam_ename + ')');
						$('#gamNum').val(game.gam_num);
						$('#gamStorage').text(game.gam_storage);
						$('#gamCvalue').text(game.gam_cvalue);
						$('#giiImportValue').val(game.gam_cvalue);
					}
				});
				
				// $("#target_code").append(code+"<br>");
			}
			
			function addToSubmitData(){
				
				var data = new Object();
				data.bar_code = $('#barCode').val();
				data.gam_name = $('#gamName').val();
				data.gam_num = $('#gamNum').val();
				data.gii_ivalue = $('#giiIvalue').val();
				data.gii_import_value = $('#giiImportValue').val();
				data.gii_source = $('#giiSource').val();
				
				submitData.push(data);
				return data;
			}
			
			function addNewDataRow(data){
				var temp = $('#tempTr').clone();
				$(temp).find('.tdBarCode').text(data.bar_code);
				$(temp).find('.tdGamName').text(data.gam_name);
				$(temp).find('.tdGamNum').text(data.gam_num);
				$(temp).find('.tdGiiIvalue').text(data.gii_ivalue);
				$(temp).find('.tdGiiImportValue').text(data.gii_import_value);
				$(temp).find('.tdGiiSource').text(data.gii_source);
				$(temp).find('.deleteButton').attr('funcValue',data.bar_code).click(function(){
					
					removeRowData($(this).attr('funcValue'));
				});
				
				
				
				$(temp).attr('id', 'dataTr' + data.bar_code);
				$(temp).show();
				
				$('#displayTable').append(temp);
			}
			
			function validateAddData(){
				var validateFields = [{
					name : 'barCode',
					msg : '尚未感應條碼'
				}, {
					name : 'giiIvalue',
					msg : '尚未輸入入庫數量'
				}, {
					name : 'giiSource',
					msg : '尚未輸入來源'
				}];
				
				var message = new Array();
				for (var i=0; i < validateFields.length; i++) {
					
					var value = $('#'+validateFields[i].name).val();
					if(value == '' || value == 0){
						message.push(validateFields[i].msg);
					}
				}
				
				return message;
				
			}
			
			function resetForm(){
				$('#barCode').val('');
				$('#gamNameSpan').text('尚未輸入');
				$('#gamName').val('');
				$('#gamNum').val('');
				$('#gamStorage').text(0);
				$('#gamCvalue').text(0);
				$('#giiImportValue').val(0);
				$('#giiIvalue').val(0);
			}
			
			function removeRowData(targetId){
				$('#dataTr'+targetId).remove();
				for(var i=0 ; i<submitData.length ; i++) {
					if(submitData[i].bar_code == targetId ){
						submitData.splice(i,1); 
						break;
					}
				}
			}
		</script>
		<title>新增遊戲入庫單</title>
	</head>
	<body>
		<h1>新增遊戲入庫單(試用barcode)</h1>
		
		<div>條碼編號:<input name="bar_code" id="barCode" type="text" /></div>
		<div>入庫遊戲:<span id="gamNameSpan">尚未輸入</span>
			<input name="gam_num" id="gamNum" type="hidden" />
			<input name="gam_name" id="gamName" type="hidden" />
		</div>
		<div>入庫數量:<input name="gii_ivalue" id="giiIvalue" type="text" value="0" />(目前庫存<span id="gamStorage">0</span>)</div>
		<div>遊戲成本:<input name="gii_import_value" id="giiImportValue" type="text" value="0" />(目前成本<span id="gamCvalue">0</span>)</div>
		<div>進貨來源:<input name="gii_source" id="giiSource" type="text" /></div>
		<div><input id="submitButton" type="button" value="加入入庫單" class="btn btn-primary" /></div>
		<div id="target_code"></div>
		
		<div>
			<table id="displayTable" class="table table-striped table-hover table-bordered table-condensed">
				<tr>
					<th>條碼編號</th>
					<th>遊戲名稱</th>
					<th>入庫遊戲流水號</th>
					<th>入庫數量</th>
					<th>遊戲成本</th>
					<th>進貨來源</th>
					<th>刪除</th>
				</tr>
				<tr id="tempTr" style="display: none;">
					<td class="tdBarCode"></td>
					<td class="tdGamName"></td>
					<td class="tdGamNum"></td>
					<td class="tdGiiIvalue"></td>
					<td class="tdGiiImportValue"></td>
					<td class="tdGiiSource"></td>
					<td class="tdDelete"><input class="deleteButton" type="button" value="刪除" class="btn btn-danger btn-mini" /></td>
				</tr>
			</table>
			<button id="submitImportData" class="btn btn-primary" >送出入庫單</button>
		</div>
		
		
	</body>
	
</html>

