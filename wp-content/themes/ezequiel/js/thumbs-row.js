(function ($, root, undefined) {

	$(function () {

		$('.thumbs-row').each(function(){

			/* Get max height before thumbnail */

			var $row = $(this);

			var beforeThumbnailHeights = [];

			$('.thumb', $row).each(function(thumb_index){

				var $thumb = $(this);

				beforeThumbnailHeights[thumb_index] = 0;

				$('> *', $thumb).each(function(){

					var $thumb_child = $(this);

					if($thumb_child.is('img') || $thumb_child.hasClass('.thumbnail')){
						return false;
					}

					beforeThumbnailHeights[thumb_index] += $thumb_child.get(0).getBoundingClientRect().height;

				});

			});

			var maxBeforeThumbnailHeight = Math.max.apply(null, beforeThumbnailHeights);



			/* Apply correction */

			$('.thumb', $row).each(function(thumb_index){

				var $thumb = $(this);

				var thisBeforeThumbnailHeight = beforeThumbnailHeights[thumb_index];

				if(thisBeforeThumbnailHeight < maxBeforeThumbnailHeight){

					$('img, .thumbnail', $thumb).css('margin-top', (maxBeforeThumbnailHeight - thisBeforeThumbnailHeight) + "px");

				}

			});

		});

	});

})(jQuery, this);
