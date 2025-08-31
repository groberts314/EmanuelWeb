(function($) {
	$(function() {
		var centerCalendar = function() {
			var width = $(window).width();
			if (width <= 991) {
				$('.calendar-image-container').scrollLeft(130);
			} else {
				$('.calendar-image-container').scrollLeft(0);
			}
		}
		
		$(window).on('resize', centerCalendar);
		centerCalendar();
	});
})(jQuery)