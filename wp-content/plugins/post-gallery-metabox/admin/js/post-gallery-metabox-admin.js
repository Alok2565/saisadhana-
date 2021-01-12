(function( $ ) {
	'use strict';

	var file_frame;
	var index;
	var attachment;
	$(document).on('click', '#post-gallery-metabox a.gallery-add', function(e) {

		e.preventDefault();

		if (file_frame) file_frame.close();

		file_frame = wp.media.frames.file_frame = wp.media({
			title: $(this).data('uploader-title'),
			button: {
				text: $(this).data('uploader-button-text'),
			},
			multiple: true
		});

		file_frame.on('select', function() {
			var listIndex = $('#post-gallery-metabox-list li').index($('#post-gallery-metabox-list li:last')),
			selection = file_frame.state().get('selection');
			
			selection.map(function(attachment, i) {
				attachment = attachment.toJSON(),
				index = listIndex + (i + 1);
				$('#post-gallery-metabox-list').append('<li><input type="hidden" name="post_gallery[' + index + ']" value="' + attachment.id + '"><img class="image-preview" src="' + attachment.sizes.full.url + '"><a class="change-image button button-small" href="#" data-uploader-title="Change image" data-uploader-button-text="Change image">Change image</a><br><small><a class="remove-image" href="#">Remove image</a></small></li>');
			});
		});

		gm_makeSortable();		
		file_frame.open();

	});

	$(document).on('click', '#post-gallery-metabox a.change-image', function(e) {

		e.preventDefault();

		var that = $(this);

		if (file_frame) file_frame.close();

		file_frame = wp.media.frames.file_frame = wp.media({
			title: $(this).data('uploader-title'),
			button: {
				text: $(this).data('uploader-button-text'),
			},
			multiple: false
		});

		file_frame.on( 'select', function() {
			attachment = file_frame.state().get('selection').first().toJSON();

			that.parent().find('input:hidden').attr('value', attachment.id);
			that.parent().find('img.image-preview').attr('src', attachment.sizes.full.url);
		});

		file_frame.open();

	});

	function gm_add_attribute() {
		if($('#post-gallery-metabox-list li').length){
			$('#post-gallery-metabox-list li').each(function(i) {
				$(this).find('input:hidden').attr('name', 'post_gallery[' + i + ']');
			});
		}
	}

	function gm_makeSortable() {
		if($('#post-gallery-metabox-list').length){
			$('#post-gallery-metabox-list').sortable({
				opacity: 0.6,
				stop: function() {
					gm_add_attribute();
				}
			});
		}		
	}

	$(document).on('click', '#post-gallery-metabox a.remove-image', function(e) {
		e.preventDefault();

		$(this).parents('li').animate({ opacity: 0 }, 200, function() {
			$(this).remove();
			gm_add_attribute();
		});
	});

  gm_makeSortable();

})( jQuery );