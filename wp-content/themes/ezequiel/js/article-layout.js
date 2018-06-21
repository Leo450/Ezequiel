(function ($, root, undefined) {

	$(function () {

		'use strict';

		var img = $('article .article-thumbnail').get(0);

		if(!img){
			return;
		}

		var imgBounds = img.getBoundingClientRect();
		var imgStyle = window.getComputedStyle(img);

		console.log(imgBounds);

		var imgTop = imgBounds.top;
		var imgBoxBottom = imgBounds.bottom;
		var imgBoxBottomWithMargin = imgBoxBottom + parseFloat(imgStyle.marginBottom);
		var imgBoxWidth = imgBounds.width + parseFloat(imgStyle.marginLeft) + parseFloat(imgStyle.marginRight);

		var afterImg = false;
		$('article > *').each(function(){

			var $this = $(this);

			if($this.hasClass("article-thumbnail")){
				afterImg = true;
				return true;
			}

			if(!afterImg){
				return true;
			}

			var thisBounds = $this.get(0).getBoundingClientRect();

			if(thisBounds.top >= imgTop && thisBounds.top <= imgBoxBottom){
				$this.wrap('<div class="single-thumbnail-offset" style="margin-left:' + imgBoxWidth + 'px;' + '"></div>');
			}else if(thisBounds.top <= imgBoxBottomWithMargin){
				$this.wrap('<div class="single-thumbnail-offset" style="margin-top:' + (parseFloat(imgStyle.marginBottom) + 11) + 'px;"></div>');
			}

		});

	});

})(jQuery, this);
