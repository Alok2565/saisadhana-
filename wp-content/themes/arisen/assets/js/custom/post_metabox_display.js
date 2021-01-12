jQuery(document).ready(function($) {
	"use strict"; //Start of Use Strict	
				
	function arisen_displayMetaboxes() {					
		var selectedElt = $("#post-formats-select input:radio[name='post_format']:checked").val();		
		
		if (selectedElt == 'video') {
			$('#featured-video').show();
			$('#featured-audio').hide();
			$('#post-gallery-metabox').hide();
		}
		else if (selectedElt == 'audio') {
			$('#featured-audio').show();
			$('#featured-video').hide();
			$('#post-gallery-metabox').hide();
		}
		else if (selectedElt == 'gallery') {
			$('#post-gallery-metabox').show();
			$('#featured-video').hide();
			$('#featured-audio').hide();
		}
		else{
			$('#featured-video').hide();
			$('#featured-audio').hide();
			$('#post-gallery-metabox').hide();
		}
	}
	
	arisen_displayMetaboxes();	
	
	/* show/hide video upload metabox depends upon post format option selected */
	$("#post-formats-select input:radio[name='post_format']").change(function(){		
		arisen_displayMetaboxes();	
	} );	
	
	return false; 	
// End of use strict
});