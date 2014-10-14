$(document).ready(function(){
	$.fn.exists = function(){return this.length > 0;}
	if ($('form').exists()) {
		customForm.customForms.replaceAll();
	}
	if (window.PIE) {
		$('.ie-fix, .btn, .form select, .popup, .popup .input, .users .ico-online').each(function() {
			PIE.attach(this);
		});
	}
	if ($('.fancybox').exists()) {
		$('.fancybox').fancybox({
			padding: 0
		});
	}
	if ($('#banner, #users').exists()) {
		$('img').load(function(){
			$(".masonry").masonry();
		});
		$("#banner").masonry({
			columnWidth: '.grid-sizer',
			"itemSelector": ".item"
		});
		$("#users").masonry({
			"itemSelector": ".item"
		});
	}
});