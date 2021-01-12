jQuery( function ( $ ) {
	"use strict"; //Start of Use Strict

	var mymodel = '<div id="mymodal-content"></div>';  // Dialogue box div
	var mybtn =  '<button class="ocdi__button  button  button-hero  button-primary  js-my-import-data">Import Demo Data</button>';  // Custom Import Button
	$( 'p.ocdi__button-container' ).append(mybtn + mymodel);
	$('.js-ocdi-import-data, #mymodal-content').hide();

	$( '.js-my-import-data' ).unbind('click').on('click', function(e) {
		e.preventDefault();

		var $info = $("#mymodal-content");
		var dialogOptions = $.extend(
		{
			'dialogClass': 'wp-dialog',
			'resizable':   false,
			'height':      'auto',
			'modal':       true
		},
		ocdi.dialog_options,
		{
			'buttons':
			[
				{
					text: 'No',  // IF NO - text: ocdi.texts.dialog_no
					click: function() {
						$(this).dialog('close');
					}
				},
				{
					text: ocdi.texts.dialog_yes,   // IF YES
					class: 'button  button-primary',
					click: function() {
						$(this).dialog('close');
						$( '.js-ocdi-import-data' ).trigger('click'); //Initiate demo import
					}
				}
			]
		});

		$info.prop( 'title', ocdi.texts.dialog_title );
		$info.html(
				'<p class="ocdi__modal-item-title">Import Demo Content</p>'
			);
		$info.dialog( dialogOptions ); //Open dialogue

	});
});