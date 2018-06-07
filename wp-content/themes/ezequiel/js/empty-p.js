(function ($, root, undefined) {

	$(function () {

		'use strict';

		$('article p').each(function(){
			var $this = $(this);
			if($this.html() == "&nbsp;"){
				$this.addClass("empty");
			}
		});

	});

})(jQuery, this);
