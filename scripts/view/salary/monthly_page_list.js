var defaultBaseHours = 0;

function init() {
	$('input[id^=confirm_]').change(function(e) {
		var chkNum = $(this).attr('chknum');
		var usrNum = $(this).attr('usrnum');
		var stoNum = $(this).attr('stonum');
		var newValue = $(this).val();
		baseHours = (newValue <= defaultBaseHours)? newValue : defaultBaseHours;
		extraHours = (newValue <= defaultBaseHours)? 0 : (newValue - defaultBaseHours);

		$('span#baseHours_'+chkNum).text(baseHours).trigger('change');
		$('span#extraHours_'+chkNum).text(extraHours).trigger('change');

		recalculateSummary(usrNum, stoNum);
	});

	$('input[id^=dsoValue_]').numeric({ negative : false });

	$('input[id^=addExtraOptionBtn_]').click(function(e) {
		var usrNum = $(this).attr('usrnum');
		var dsoType = $('select#dsoType_'+usrNum+' option:selected').val();
		var dsoTypeText = $('select#dsoType_'+usrNum+' option:selected').text();
		var dsoDesc = $('input#dsoDesc_'+usrNum).val();
		var dsoValue = $('input#dsoValue_'+usrNum).val();

		if (_.isEmpty(dsoDesc)) {
			alert('項目說明未填');
			return;
		}

		if (_.isEmpty(dsoValue)) {
			alert('金額未填');
			return;
		}
		addExtraOption(usrNum, dsoType, dsoTypeText, dsoDesc, dsoValue);
		resetExtraOptionInput(usrNum);
	});
	
	$('input[id^=addDefaultExtraOptionBtn_]').click(function(e) {
        var usrNum = $(this).attr('usrnum');
        var dsdoOptionsSelectedOption = $('select#dsdoOptions_'+usrNum+' option:selected');
        var dsoType = $(dsdoOptionsSelectedOption).attr('dsdoType');
        var dsoTypeText = $(dsdoOptionsSelectedOption).attr('dsdoTypeText');
        var dsoDesc = $(dsdoOptionsSelectedOption).attr('dsdoDesc');
        var dsoValue = $(dsdoOptionsSelectedOption).val();

        addExtraOption(usrNum, dsoType, dsoTypeText, dsoDesc, dsoValue);
    });
	
	$('button#submitBtn').click(function(e) {
		$('#mainForm').submit();
	});
}

function addExtraOption(usrNum, dsoType, dsoTypeText, dsoDesc, dsoValue) {

	var dsoTypeInput = $("<input></input>").attr({
		type: 'hidden',
		name: 'dso_type[' + usrNum + '][]',
		value: dsoType
	});
	
	var dsoDescInput = $("<input></input>").attr({
		type: 'hidden',
		name: 'dso_desc[' + usrNum + '][]',
		value: dsoDesc
	});

	var dsoValueInput = $("<input></input>").attr({
		type: 'hidden',
		name: 'dso_value[' + usrNum + '][]',
		value: dsoValue
	});

	var deleteIcon = $("<span></span>").attr({
			'class' : 'glyphicon glyphicon-remove-sign',
			style : 'color: red'
		}).click(function (e){
			$(this).parent().remove();
		});

	var extraDiv = $('<div></div>').attr({
		'class' : 'text-right list-group-item'
	}).append(
		deleteIcon,
		dsoTypeInput, 
		dsoDescInput,
		dsoValueInput
	);
	var plusSignTypes = [0, 1];
	var sign = (_.contains(plusSignTypes, parseInt(dsoType)))? '+' : '-';
	$(extraDiv).append(dsoTypeText + ' ' + sign + '$' + dsoValue + ' ' + dsoDesc);
	
	$('div#extraOptions_'+usrNum).append(extraDiv);
	
}

function resetExtraOptionInput(usrNum) {
	$('select#dsoType_'+usrNum).val(0);
	$('input#dsoDesc_'+usrNum).val('');
	$('input#dsoValue_'+usrNum).val('');
}

function recalculateSummary(usrNum, stoNum) {
	var confirmHourSummary = 0;
	$('input[id^=confirm_][usrnum='+usrNum+'][stonum='+stoNum+']').each(function(){
		if($.isNumeric($(this).val())) {
			confirmHourSummary += parseFloat($(this).val());
		}
	});
	$('span[id^=confirmHourSummary][usrnum='+usrNum+'][stonum='+stoNum+']').text(confirmHourSummary);

	var baseHourSummary = 0;
	$('span[id^=baseHours_][usrnum='+usrNum+'][stonum='+stoNum+']').each(function(){
		if($.isNumeric($(this).text())) {
			baseHourSummary += parseFloat($(this).text());
		}
	});
	$('span[id^=baseHourSummary][usrnum='+usrNum+'][stonum='+stoNum+']').text(baseHourSummary);

	var extraHourSummary = 0;
	$('span[id^=extraHours_][usrnum='+usrNum+'][stonum='+stoNum+']').each(function(){
		if($.isNumeric($(this).text())) {
			extraHourSummary += parseFloat($(this).text());
		}
	});
	$('span[id^=extraHourSummary][usrnum='+usrNum+'][stonum='+stoNum+']').text(extraHourSummary);

	var totalConfirmHours = 0;
	$('span[id^=confirmHourSummary][usrnum='+usrNum+']').each(function(){
		if($.isNumeric($(this).text())) {
			totalConfirmHours += parseFloat($(this).text());
		}
	});
	$('span[id^=totalConfirmHours_][usrnum='+usrNum+']').text(totalConfirmHours);
	
	var usrBaseHours = parseFloat($('span[id^=usrBaseHours_][usrnum='+usrNum+']').text());
	var accumulateLeave = parseFloat($('span[id^=accumulateLeave_][usrnum='+usrNum+']').text());
	
	$('span[id^=leaveBalance_][usrnum='+usrNum+']').text(totalConfirmHours-usrBaseHours+accumulateLeave);
	
	

	var totalBaseHours = 0;
	$('span[id^=baseHourSummary][usrnum='+usrNum+']').each(function(){
		if($.isNumeric($(this).text())) {
			totalBaseHours += parseFloat($(this).text());
		}
	});
	$('span[id^=totalBaseHours_][usrnum='+usrNum+']').text(totalBaseHours);

	var totalExtraHours = 0;
	$('span[id^=extraHourSummary][usrnum='+usrNum+']').each(function(){
		if($.isNumeric($(this).text())) {
			totalExtraHours += parseFloat($(this).text());
		}
	});
	$('span[id^=totalExtraHours_][usrnum='+usrNum+']').text(totalExtraHours);

	var usrHourlySalary = parseInt($('input#usrHourlySalary').val());
	var totalBaseSalary = Math.round(totalBaseHours * usrHourlySalary);
	var totalExtraSalary = Math.round(totalExtraHours * usrHourlySalary * 1.33);

	$('span[id^=totalBaseSalary_][usrnum='+usrNum+']').text(totalBaseSalary);
	$('span[id^=totalExtraSalary_][usrnum='+usrNum+']').text(totalExtraSalary);
	
	
}