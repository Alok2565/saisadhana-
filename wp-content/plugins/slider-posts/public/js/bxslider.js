(function( $ ) {	  
	'use strict'; 
	if($('.slider_default').length){
		$('.slider_default').bxSlider({
			auto: true,
			mode: 'horizontal',
			pager: false
		});
	}

	if($('.slider_grid').length){
		$('.slider_grid').bxSlider({
			auto: true,
			mode: 'horizontal',
			pager: false
		});
	}
})( jQuery );