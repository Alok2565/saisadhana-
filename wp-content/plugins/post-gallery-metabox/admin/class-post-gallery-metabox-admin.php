<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://themeforest.net/user/pennyblack
 * @since      1.0.0
 *
 * @package    Post_Gallery_Metabox
 * @subpackage Post_Gallery_Metabox/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Post_Gallery_Metabox
 * @subpackage Post_Gallery_Metabox/admin
 * @author     PennyBlack <saravanakumar@keenicon.com>
 */
class Post_Gallery_Metabox_Admin {

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
		
		add_action('add_meta_boxes', array( $this, 'add_Post_Gallery_Metabox') );
		add_action('save_post', array( $this, 'post_gallery_meta_save') );
	}
	
	public function add_Post_Gallery_Metabox($post_type) {   
		$types = array('post');
		if (in_array($post_type, $types)) {
		  add_meta_box(
			    'post-gallery-metabox',				
				esc_html__( 'Gallery', 'post-gallery-metabox' ),
				array( $this, 'gallery_meta_callback'),
				$post_type,
				'normal',
				'high'
			);
		}
	}
	
	
	public function gallery_meta_callback($post) {
		wp_nonce_field( basename(__FILE__), 'post_gallery_meta_nonce' );
		$ids = get_post_meta($post->ID, 'post_gallery', true);		
    ?>
		<table class="form-table">
			<tr>
				<td>
					<a class="gallery-add button" href="#" data-uploader-title="Add image(s) to gallery" data-uploader-button-text="Add image(s)"><?php esc_html_e('Add image(s)', 'post-gallery-metabox'); ?></a>

					<ul id="post-gallery-metabox-list">
					<?php if ($ids) : foreach ($ids as $key => $value) : $image = wp_get_attachment_image_src($value); ?>

						<li>
							<input type="hidden" name="post_gallery[<?php echo esc_attr($key); ?>]" value="<?php echo esc_attr($value); ?>">
							<img class="image-preview" src="<?php echo esc_url($image[0]); ?>">
							<a class="change-image button button-small" href="#" data-uploader-title="Change image" data-uploader-button-text="Change image"><?php esc_html_e('Change image', 'post-gallery-metabox'); ?></a><br>
							<small><a class="remove-image" href="#"><?php esc_html_e('Remove image', 'post-gallery-metabox'); ?></a></small>
						</li>

					<?php endforeach; endif; ?>
					</ul>

				</td>
			</tr>
		</table>
  <?php }
  
  
	public function post_gallery_meta_save($post_id) {
		if (!isset($_POST['post_gallery_meta_nonce']) || !wp_verify_nonce($_POST['post_gallery_meta_nonce'], basename(__FILE__))) return;

		if (!current_user_can('edit_post', $post_id)) return;

		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

		if(isset($_POST['post_gallery'])) {
			update_post_meta($post_id, 'post_gallery', $_POST['post_gallery']);
		} else {
			delete_post_meta($post_id, 'post_gallery');
		}
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
		 * defined in Post_Gallery_Metabox_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Post_Gallery_Metabox_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/post-gallery-metabox-admin.css', array(), $this->version, 'all' );

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
		 * defined in Post_Gallery_Metabox_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Post_Gallery_Metabox_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/post-gallery-metabox-admin.js', array( 'jquery' ), $this->version, false );

	}

}
