(function($) {
	$(function() {
		var centerMap = function() {
			var width = $(window).width();
			if (width <= 593 || (width >= 751 && width <= 991)) {
				$('.map-container').scrollLeft(130);
			} else {
				$('.map-container').scrollLeft(0);
			}
		}
		
		$(window).on('resize', centerMap);
		centerMap();
		
		$('img[data-img-src]').each(function() {
			var $this = $(this);
			$this.attr('src', $this.data('img-src'));
		});
	});
})(jQuery)