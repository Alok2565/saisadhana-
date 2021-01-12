jQuery(function($) {

  var file_frame;

  $(document).on('click', '#slider-gallery-metabox a.gallery-add-slider', function(e) {

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
      var listIndex = $('#slider-gallery-metabox-list li').index($('#slider-gallery-metabox-list li:last')),
          selection = file_frame.state().get('selection');

      selection.map(function(attachment, i) {
        attachment = attachment.toJSON(),
        index      = listIndex + (i + 1);
		//console.log(attachment.sizes.full.url);
        $('#slider-gallery-metabox-list').append('<li><input type="hidden" name="post_slider_gallery[' + index + ']" value="' + attachment.id + '"><img class="image-preview" src="' + attachment.sizes.full.url + '"><a class="change-slider-image button button-small" href="#" data-uploader-title="Change image" data-uploader-button-text="Change image">Change image</a><br><small><a class="remove-slider-image" href="#">Remove image</a></small></li>');
      });
    });

    makeSortable();
    
    file_frame.open();

  });

  $(document).on('click', '#slider-gallery-metabox a.change-slider-image', function(e) {

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

  function resetIndex() {
    $('#slider-gallery-metabox-list li').each(function(i) {
      $(this).find('input:hidden').attr('name', 'post_slider_gallery[' + i + ']');
    });
  }

  function makeSortable() {
    if($('#slider-gallery-metabox-list').length){
		$('#slider-gallery-metabox-list').sortable({
			opacity: 0.6,
			stop: function() {
				resetIndex();
			}
		});
	}
  }

  $(document).on('click', '#slider-gallery-metabox a.remove-slider-image', function(e) {
    e.preventDefault();

    $(this).parents('li').animate({ opacity: 0 }, 200, function() {
      $(this).remove();
      resetIndex();
    });
  });

  makeSortable();

});