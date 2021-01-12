jQuery(document).ready(function($) {
	"use strict"; //Start of Use Strict

	 $('.open-popup-link a').magnificPopup({
		type: 'inline',
		midClick: true // allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source.
	 });
});