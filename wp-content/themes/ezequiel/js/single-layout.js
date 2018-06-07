(function ($, root, undefined) {

	$(function () {

		'use strict';

		var img = $('article img.attachment-post-thumbnail').get(0);
		var imgBounds = img.getBoundingClientRect();
		var imgStyle = window.getComputedStyle(img);

		var imgTop = imgBounds.top;
		var imgBoxBottom = imgBounds.bottom + parseFloat(imgStyle.marginBottom);
		var imgBoxWidth = imgBounds.width + parseFloat(imgStyle.marginLeft) + parseFloat(imgStyle.marginRight);

		$('article > *').each(function(){

			var $this = $(this);

			if($this.hasClass("attachment-post-thumbnail"))
				return;

			var thisBounds = $this.get(0).getBoundingClientRect();

			if(thisBounds.top >= imgTop && thisBounds.top <= imgBoxBottom){
				$this.wrap('<div class="single-thumbnail-offset" style="margin-left:' + imgBoxWidth + 'px;"></div>');
			}

		});

	});

})(jQuery, this);
