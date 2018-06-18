(function ($, root, undefined) {

	$(function () {

		'use strict';

		$(window).resize(function(){



		});

		$('.mobile-menu-button').click(function(){
			var $nav = $('.l-header .nav');

			if($nav.is(":visible")){
				$nav.addClass("d-none");
			}else{
				$nav.removeClass("d-none");
			}

		});

	});

})(jQuery, this);
