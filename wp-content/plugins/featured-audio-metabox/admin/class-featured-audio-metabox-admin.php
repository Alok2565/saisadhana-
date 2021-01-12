<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://themeforest.net/user/pennyblack
 * @since      1.0.0
 *
 * @package    Featured_Audio_Metabox
 * @subpackage Featured_Audio_Metabox/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Featured_Audio_Metabox
 * @subpackage Featured_Audio_Metabox/admin
 * @author     PennyBlack <PennyBlack>
 */
class Featured_Audio_Metabox_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;
	
	private $screens = array(
		'post',
	);	
	
	private $fields = array(
		array(
			'id' => 'select-audio-type',
			'label' => 'Select Audio Type:',
			'type' => 'select',
			'options' => array(
				'upload' => 'Upload Audio',
				'url' => 'Insert Url',
			),
		),
		array(
			'id' => 'upload-audio',
			'label' => 'Upload Audio:',
			'type' => 'media',
		),
		array(
			'id' => 'insert-url',
			'label' => 'Insert Url:',
			'type' => 'url',
		),		
	);

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
		add_action( 'admin_footer', array( $this, 'admin_footer' ) );
		add_action( 'save_post', array( $this, 'save_post' ) );
		
		add_shortcode('url', array( $this, 'wp_url_audio_short_code' ) );  //for frontend page display
	}
	
	/**
	 * Hooks into WordPress' add_meta_boxes function.
	 * Goes through screens (post types) and adds the meta box.
	 */
	public function add_meta_boxes() {
		foreach ( $this->screens as $screen ) {
			add_meta_box(
				'featured-audio',
				esc_html__( 'Featured Audio Metabox', 'featured-audio-metabox' ),
				array( $this, 'add_meta_box_callback' ),
				$screen,
				'side',
				'core'
			);
		}
	}

	/**
	 * Generates the HTML for the meta box
	 * 
	 * @param object $post WordPress post object
	 */
	public function add_meta_box_callback( $post ) {
		wp_nonce_field( 'featured_audio_data', 'featured_audio_nonce' );
		$this->generate_fields( $post );
		$this->generate_audio_reset_button(); 
		
		$audio_type = get_post_meta( $post->ID, 'featured_audio_select-audio-type', true );
		
	?>	
		<script type="text/javascript">			
			jQuery(document).ready(function($){
				function getSelectedAudioText(elementId) {
					var elt = document.getElementById(elementId);
					if (elt.selectedIndex == -1)
						return null;
					return elt.options[elt.selectedIndex].value;
				}
				var sel_text = getSelectedAudioText('select-audio-type');				
				
				if(sel_text == 'url'){					
					$("label[for='insert-url']").parent().show();	
					$('#reset_audio_fields').show();			
					$("label[for='upload-audio']").parent().hide();					
					
				}else{				
					$("label[for='upload-audio']").parent().show();	
					$('#reset_audio_fields').show();
					$("label[for='insert-url']").parent().hide();
				}

				$('#select-audio-type').on('change', function() {
					var selected = $(this).val();
					if(selected == 'url'){					
						$("label[for='insert-url']").parent().show();	
						$('#reset_audio_fields').show();			
						$("label[for='upload-audio']").parent().hide();					
						
					}else{				
						$("label[for='upload-audio']").parent().show();	
						$('#reset_audio_fields').show();
						$("label[for='insert-url']").parent().hide();
					}
				});					
			});			
		</script>
	<?php	
		
	}

	/**
	 * Hooks into WordPress' admin_footer function.
	 * Adds scripts for media uploader.
	 */
	public function admin_footer() {
		?><script>			
			jQuery(document).ready(function($){
				if ( typeof wp.media !== 'undefined' ) {
					var _custom_media = true,
					_orig_send_attachment = wp.media.editor.send.attachment;
					$('.rational-metabox-media').click(function(e) {
						var send_attachment_bkp = wp.media.editor.send.attachment;
						var button = $(this);
						var id = button.attr('id').replace('_button', '');
						_custom_media = true;
							wp.media.editor.send.attachment = function(props, attachment){
							if ( _custom_media ) {
								$("#"+id).val(attachment.url);
							} else {
								return _orig_send_attachment.apply( this, [props, attachment] );
							};
						}
						wp.media.editor.open(button);
						return false;
					});
					$('.add_media').on('click', function(){
						_custom_media = false;
					});
					
					$('.removeAudioBtn').click(function() {
					   $('#insert-url, #upload-audio').val('');					  
					  
					   if($('.up-audio-player').length){
						   $('.up-audio-player').remove();
					   }

					  if($('.url-audio-player').length){
						   $('.url-audio-player').remove();
					   }	
					  
					   return false;
					});
				}
			});
		</script><?php
	}

	public function generate_audio_reset_button() {
		$removeV = '<input class="removeAudioBtn" type="button" value="Remove Audio" />';
		echo '<div id="reset_audio_fields">' . $removeV . '</div>'; 
	}
		
	/**
	 * Generates the field's HTML for the meta box.
	 */
	public function generate_fields( $post ) {
		$output = '';
		foreach ( $this->fields as $field ) {
			$label = '<label for="' . $field['id'] . '">' . $field['label'] . '</label>';
			$db_value = get_post_meta( $post->ID, 'featured_audio_' . $field['id'], true );
			switch ( $field['type'] ) {
				case 'media':
					$input = sprintf(
						'<input id="%s" name="%s" type="text" value="%s"> <input class="button rational-metabox-media" id="%s_button" name="%s_button" type="button" value="Upload" />',
						$field['id'],
						$field['id'],
						$db_value,
						$field['id'],
						$field['id']
					);
					break;
				case 'select':
					$input = sprintf(
						'<select id="%s" name="%s">',
						$field['id'],
						$field['id']
					);
					foreach ( $field['options'] as $key => $value ) {
						$field_value = !is_numeric( $key ) ? $key : $value;
						$input .= sprintf(
							'<option %s value="%s">%s</option>',
							$db_value === $field_value ? 'selected' : '',
							$field_value,
							$value
						);
					}
					$input .= '</select>';
					break;
				default:
					$input = sprintf(
						'<input id="%s" name="%s" type="%s" value="%s">',
						$field['id'],
						$field['id'],
						$field['type'],
						$db_value
					);
			}
			$output .= '<p>' . $label . '<br>' . $input . '</p>';
		}
		echo $output;
		
		$audio_type = get_post_meta( $post->ID, 'featured_audio_select-audio-type', true );
		$audio_url = get_post_meta( $post->ID, 'featured_audio_insert-url', true );
		$audio_upload = get_post_meta($post->ID,'featured_audio_upload-audio',true);		
			
		if(!empty($audio_url) || !empty($audio_upload)){	
			if($audio_type == 'url'){
				echo $this->wp_url_audio($audio_url, '250px', '120px');
			}else{
				echo $this->wp_ply_audio($audio_upload);
			}		
		}	
	}

	/**
	 * Hooks into WordPress' save_post function
	 */
	public function save_post( $post_id ) {
		if ( ! isset( $_POST['featured_audio_nonce'] ) )
			return $post_id;

		$nonce = $_POST['featured_audio_nonce'];
		if ( !wp_verify_nonce( $nonce, 'featured_audio_data' ) )
			return $post_id;

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return $post_id;

		foreach ( $this->fields as $field ) {
			if ( isset( $_POST[ $field['id'] ] ) ) {
				switch ( $field['type'] ) {
					case 'email':
						$_POST[ $field['id'] ] = sanitize_email( $_POST[ $field['id'] ] );
						break;
					case 'text':
						$_POST[ $field['id'] ] = sanitize_text_field( $_POST[ $field['id'] ] );
						break;
				}
				update_post_meta( $post_id, 'featured_audio_' . $field['id'], $_POST[ $field['id'] ] );				
								
			} else if ( $field['type'] === 'checkbox' ) {
				update_post_meta( $post_id, 'featured_audio_' . $field['id'], '0' );
			}
		}
	}
	
	public function wp_ply_audio($audio_id) {		
		return '<audio controls class="up-audio-player">
					<source src="'.esc_url($audio_id).'" type="audio/ogg">
					<source src="'.esc_url($audio_id).'" type="audio/mpeg">
					Your browser does not support the audio element.
				</audio>';
	}
	
	public function wp_url_audio($video_id, $width, $height) {			
		return '<iframe title="audio player" class="url-audio-player" type="text/html" src="'.esc_url($video_id).'" style="border:0; overflow:hidden; width:'.esc_attr($width).'; height:'.esc_attr($height).';" ></iframe>';
	}
	
	public function wp_url_audio_short_code($atts) {
		extract(shortcode_atts(array('id' => '', 'width' => '', 'height' => ''), $atts));		
		 return '<div class="sound sound-div entry-attachment"><iframe title="audio player" class="audio-player" src="'.esc_attr($id).'" style="border:0; overflow:hidden; width:'.esc_attr($width).'; height:'.esc_attr($height).';"></iframe></div>';
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Featured_Audio_Metabox_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Featured_Audio_Metabox_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/featured-audio-metabox-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Featured_Audio_Metabox_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Featured_Audio_Metabox_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/featured-audio-metabox-admin.js', array( 'jquery' ), $this->version, false );

	}

}
