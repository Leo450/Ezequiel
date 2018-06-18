(function ($, root, undefined) {

	$(function () {

		'use strict';

		var $rating = $('.comment-form .rating');
		var $submit = $('.comment-form .form-submit');

		if(!$rating.length || !$submit.length){
			return;
		}

		$rating.detach().insertBefore($submit);

	});

})(jQuery, this);
