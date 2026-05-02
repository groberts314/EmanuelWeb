(function($) {
	$(function() {
		/**
		 * BEGIN: Center the map on load and on window resize for mobile and tablet breakpoints
		 */
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
		/**
		 * END: Center the map on load and on window resize for mobile and tablet breakpoints
		 */

		/**
		 * BEGIN: Check for live stream every 5 minutes and update the YouTube embed URL if it has changed
				- We check for the live stream by making a GET request to the youtube-video-data.php endpoint which checks the YouTube API for the latest video and whether it's a live stream or not. If it is a live stream, it returns the embed URL for the live stream. If it's not a live stream, it returns the embed URL for the latest video.
				- We then compare the current embed URL with the new embed URL and update the iframe src if they are different.
				- This allows us to automatically update the YouTube embed on our website without having to manually change the URL in our code whenever we have a new live stream or new video.
		 */
		var currentVideoUrl = $('#youtube-iframe').attr('src');

		var checkForLiveStream = function() {
			console.log('Checking YouTube Streaming Video Data ...');
			$.getJSON('https://www.elclh.org/youtube-video-data', function(data) {
				console.log('YouTube Video Data:', data);
				
				var newEmebedUrl = data.iframeUrl;
				console.log('Current Embed URL:', currentVideoUrl);
				console.log('New Embed URL:', newEmebedUrl);

				if (currentVideoUrl !== newEmebedUrl) {
					console.log('Updating YouTube Embed URL to:', newEmebedUrl);
					$('#youtube-iframe').attr('src', newEmebedUrl);
					currentVideoUrl = newEmebedUrl;
				} else {
					console.log('YouTube Embed URL is up to date. No update needed.');
				}
			}).fail(function() {
				console.error('Error fetching YouTube video data');
			});
		};

		setInterval(checkForLiveStream, 300000); // Check every 5 minutes
		checkForLiveStream(); // Initial check on page load
		/**
		 * END: Check for live stream every 5 minutes and update the YouTube embed URL if it has changed
		 */
		
		// Depracated -- lazy load images for the photo careousel we used to have before we switched to the video embed
		// $('img[data-img-src]').each(function() {
		// 	var $this = $(this);
		// 	$this.attr('src', $this.data('img-src'));
		// });
	});
})(jQuery)