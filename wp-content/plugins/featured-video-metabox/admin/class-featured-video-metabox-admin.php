<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://themeforest.net/user/pennyblack
 * @since      1.0.0
 *
 * @package    Featured_Video_Metabox
 * @subpackage Featured_Video_Metabox/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Featured_Video_Metabox
 * @subpackage Featured_Video_Metabox/admin
 * @author     PennyBlack
 */
class Featured_Video_Metabox_Admin {

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
			'id' => 'upload-featured-video',
			'label' => '',
			'desc' => 'Upload video from media library',
			'type' => 'media',
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

		add_shortcode('youtube', array( $this, 'wp_youtube_video_short_code' ) ); //for frontend page display
		add_shortcode('vimeo', array( $this, 'wp_vimeo_video_short_code' ) );	//for frontend page display
	}
	
	/**
	 * Hooks into WordPress' add_meta_boxes function.
	 * Goes through screens (post types) and adds the meta box.
	 */
	public function add_meta_boxes() {
		foreach ( $this->screens as $screen ) {
			add_meta_box(
				'featured-video',
				esc_html__( 'Featured Video Metabox', 'featured-video-metabox' ),
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
		wp_nonce_field( 'featured_video_data', 'featured_video_nonce' );		
		
		$video_type = get_post_meta($post->ID,'my_video_type',true);
		$video_id = get_post_meta($post->ID,'my_meta_box_text',true);
		wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' );
	?>	
		<p>
        <label class="my_meta_box_text_label" for="my_meta_box_text"><?php esc_html_e('Select Video By:', 'charity'); ?></label>
         <!-- added select for selecting vedio type -->
        <select name="my_video_type" id="my_video_type" onchange="getval(this);"> 
			<option value="0" style="display:none;"><?php esc_html_e('Select', 'charity'); ?></option>
            <option <?php echo ($video_type == 'youtube') ? "selected='selected'" : "" ;?> value="youtube"><?php esc_html_e('Youtube', 'charity'); ?></option>
            <option <?php echo ($video_type == 'vimeo') ? "selected='selected'" : "" ;?> value="vimeo"><?php esc_html_e('Vimeo', 'charity'); ?></option>
			<option <?php echo ($video_type == 'custom') ? "selected='selected'" : "" ;?> value="custom"><?php esc_html_e('Media', 'charity'); ?></option>
        </select>
		
		<script type="text/javascript">			
			jQuery(document).ready(function($){
				function getSelectedText(elementId) {
					var elt = document.getElementById(elementId);
					if (elt.selectedIndex == -1)
						return null;
					return elt.options[elt.selectedIndex].value;
				}
				var sel_text = getSelectedText('my_video_type');
				
				if(sel_text == '0'){					
					document.getElementById("option_type").style.display = "none";
					document.getElementById("option_upload").style.display = "none";
					document.getElementById("reset_fields").style.display = "none";
				}
				else if(sel_text == 'youtube' || sel_text == 'vimeo'){
					mode = '<p><label for="my_meta_box_text">Youtube/Vimeo ID:</label><input type="text" name="my_meta_box_text" id="my_meta_box_text" value="<?php echo esc_js($video_id); ?>" /></p>';					
					
					document.getElementById("option_type").innerHTML = mode;
					document.getElementById("option_type").style.display = "block";
					document.getElementById("reset_fields").style.display = "block";
					document.getElementById("option_upload").style.display = "none";
					
				}else{	
					
					document.getElementById("option_type").style.display = "none";
					document.getElementById("option_upload").style.display = "block";
					document.getElementById("reset_fields").style.display = "block";					
				}			
				
			});
			var mode;
			function getval(sel)
			{   
				if(sel.value == '0'){
					document.getElementById("option_type").style.display = "none";
					document.getElementById("option_upload").style.display = "none";
					document.getElementById("reset_fields").style.display = "none";
				}				
				else if(sel.value == 'youtube' || sel.value == 'vimeo'){
					mode = '<p><label for="my_meta_box_text">Youtube/Vimeo ID:</label><input type="text" name="my_meta_box_text" id="my_meta_box_text" value="<?php echo esc_js($video_id); ?>" /></p>';
					document.getElementById("option_type").innerHTML = mode;
					document.getElementById("option_type").style.display = "block";
					document.getElementById("reset_fields").style.display = "block";
					document.getElementById("option_upload").style.display = "none";
					
				}else{
					document.getElementById("option_type").style.display = "none";
					document.getElementById("option_upload").style.display = "block";
					document.getElementById("reset_fields").style.display = "block";					
				}			
				
			}
		</script>
        <!-- added select for selecting vedio type -->
    </p>

    <p id="option_type" style="display:none;"></p>
	
	<?php $this->generate_fields( $post ); ?>
	<?php $this->generate_reset_button(); ?>
	
		
	<?php	
		
	}
	
	public function generate_reset_button() {
		$removeV = '<input class="removeVideoBtn" type="button" value="Remove Video" />';
		echo '<div id="reset_fields">' . $removeV . '</div>'; 
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
				}
				
				function displaySelectOption() {
					
					$('#my_video_type, .my_meta_box_text_label').show();
					if($('#my_meta_box_text').val() != "" || $('#upload-featured-video').val() != ""){
						$('#my_video_type, .my_meta_box_text_label').hide();
					}else{
						$('#my_video_type, .my_meta_box_text_label').show();
					}
				}
				//displaySelectOption();
				
				$('.removeVideoBtn').click(function() {
					
				   $('#upload-featured-video, #my_meta_box_text').val('');  
				   if($('.youtube-player').length){
					   $('.youtube-player').remove();
				   }
				   if($('.vimeo-player').length){
					   $('.vimeo-player').remove();
				   }
				   if($('.upload_player').length){
					   $('.upload_player').remove();
				   }			   
				  //displaySelectOption();		  
				  
				   return false;
				});
				
				$('#upload-featured-video').live("change", function (e) { 					
					//displaySelectOption();
				 });
			});
		</script><?php
	}

	/**
	 * Generates the field's HTML for the meta box.
	 */
	public function generate_fields( $post ) {
		$output = '';
		foreach ( $this->fields as $field ) {
			$label = '<label for="' . $field['id'] . '">' . $field['label'] . '</label>';
			$desc  = '<p>'. $field['desc']. '</p>';
			
			$db_value = get_post_meta( $post->ID, 'featured_video_' . $field['id'], true );
			switch ( $field['type'] ) {
				case 'media':
					$input = sprintf(
						'<input class="" id="%s" name="%s" type="text" value="%s" width="250"> <input class="button rational-metabox-media" id="%s_button" name="%s_button" type="button" value="Upload" />',
						$field['id'],
						$field['id'],
						$db_value,
						$field['id'],
						$field['id']
					);
					break;
				default:
					$input = sprintf(
						'<input %s id="%s" name="%s" type="%s" value="%s" width="250">',
						$field['type'] !== 'color' ? 'class="regular-text"' : '',
						$field['id'],
						$field['id'],
						$field['type'],
						$db_value
					);
			}
			$output .= $this->row_format($desc, $input);			
		}		
		
		echo '<table id="option_upload" class="" style="display:none;"><tbody>' . $output . '</tbody></table>';
		
		$video_type = get_post_meta($post->ID,'my_video_type',true);
		$video_id = get_post_meta($post->ID,'my_meta_box_text',true);
		
		if(isset($video_id) && isset($video_type)){
			if($video_type == 'youtube'){
				echo $this->wp_youtube_video($video_id, '250px', '120px');
			}else if($video_type == 'vimeo'){
				echo $this->wp_vimeo_video($video_id, '250px', '120px');
			}
		}
		if(isset($db_value) && !empty($db_value)){			
			echo $this->wp_upload_video($db_value, '250px', '135px');
		}
	}

	/**
	 * Generates the HTML for table rows.
	 */
	public function row_format( $desc, $input ) {
		return sprintf(
			'<tr><td scope="row">%s</td></tr> <tr><td>%s</td></tr>',
			$desc,
			$input
		);
	}
	/**
	 * Hooks into WordPress' save_post function
	 */
	public function save_post( $post_id ) {
		if ( ! isset( $_POST['featured_video_nonce'] ) )
			return $post_id;

		$nonce = $_POST['featured_video_nonce'];
		if ( !wp_verify_nonce( $nonce, 'featured_video_data' ) )
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
				update_post_meta( $post_id, 'featured_video_' . $field['id'], $_POST[ $field['id'] ] );
				
				// now we can actually save the data
				$allowed = array( 
					'a' => array( // on allow a tags
						'href' => array() // and those anchords can only have href attribute
					)
				);
				
				if( isset( $_POST['my_meta_box_text'] ) && isset( $_POST['my_video_type'] ) ) {
					update_post_meta( $post_id, 'my_meta_box_text', wp_kses( $_POST['my_meta_box_text'], $allowed ) );
					update_post_meta( $post_id, 'my_video_type', strip_tags($_POST['my_video_type']) );
				}
				
			} else if ( $field['type'] === 'checkbox' ) {
				update_post_meta( $post_id, 'featured_video_' . $field['id'], '0' );
			}
		}		

		// if our nonce isn't there, or we can't verify it, bail
		if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'my_meta_box_nonce' ) ) return;

		
		/** Check the user allowed to edit the post or page */
		if ( ! current_user_can( 'edit_post', $post_id ) )
			return;

		// Probably a good idea to make sure your data is set
	}
	
	public function wp_upload_video($featuredVideoURL, $width, $height) {
		return '<video class="upload_player" controls="controls" preload="auto" style="width:'.esc_attr($width).'; height:'.esc_attr($height).';">
				<source src="'. esc_url($featuredVideoURL). '" type="video/mp4" />
				</video>';
	}
		
	
	public function wp_youtube_video($video_id, $width, $height) {			
		return '<iframe title="YouTube video player" class="youtube-player" src="https://www.youtube.com/embed/'.esc_attr($video_id).'" style="border:0; width:'.esc_attr($width).'; height:'.esc_attr($height).';"></iframe>';
	}
	
	public function wp_youtube_video_short_code($atts) {			
		//$width = ''; $height='';
		extract(shortcode_atts(array('id' => '', 'width' => '', 'height' => ''), $atts));		
		 return '<div class="player-div entry-attachment"><iframe title="YouTube video player" class="youtube-player" src="https://www.youtube.com/embed/'.esc_attr($id).'" allowFullScreen style="border:0; width:'.esc_attr($width).'; height:'.esc_attr($height).';"></iframe></div>';
	}
	
	public function wp_vimeo_video($video_id, $width, $height) {		
		return '<iframe src="https://player.vimeo.com/video/'.esc_attr($video_id).'" class="vimeo-player" style="border:0; width:'.esc_attr($width).'; height:'.esc_attr($height).';"></iframe>';
	}
	
	public function wp_vimeo_video_short_code($atts) {
		$width = '100%'; $height='100%';
        extract(shortcode_atts(array('id' => ''), $atts));
        return '<div class="player-div entry-attachment"><iframe src="https://player.vimeo.com/video/'.esc_attr($id).'" webkitAllowFullScreen mozallowfullscreen allowFullScreen style="border:0; width:'.esc_attr($width).'; height:'.esc_attr($height).';"></iframe></div>';
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
		 * defined in Featured_Video_Metabox_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Featured_Video_Metabox_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/featured-video-metabox-admin.css', array(), $this->version, 'all' );

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
		 * defined in Featured_Video_Metabox_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Featured_Video_Metabox_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/featured-video-metabox-admin.js', array( 'jquery' ), $this->version, false );

	}
}