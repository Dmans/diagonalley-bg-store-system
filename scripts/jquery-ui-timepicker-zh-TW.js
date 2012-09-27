
	
jQuery(function($){
	$.timepicker.regional['zh-TW'] = {
		timeOnlyTitle: '選擇時間',
		timeText: '時間',
		hourText: '時',
		minuteText: '分',
		secondText: '秒',
		millisecText: '毫秒',
		timezoneText: '時區',
		currentText: '現在',
		closeText: '關閉',
		timeFormat: 'hh:mm:ss',
		amNames: ['AM', 'A'],
		pmNames: ['PM', 'P'],
		ampm: false};
	$.timepicker.setDefaults($.timepicker.regional['zh-TW']);
});