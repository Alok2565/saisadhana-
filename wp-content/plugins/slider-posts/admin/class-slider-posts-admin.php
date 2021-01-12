<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://themeforest.net/user/pennyblack
 * @since      1.0.0
 *
 * @package    Slider_Posts
 * @subpackage Slider_Posts/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Slider_Posts
 * @subpackage Slider_Posts/admin
 * @author     PennyBlack
 */
class Slider_Posts_Admin {

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
		
		add_action('init', array( $this, 'register_cpt_slider') );
		add_action('add_meta_boxes', array( $this, 'add_slider_gallery_metabox') );
		add_action('save_post', array( $this, 'sliedr_gallery_meta_save') );
		add_action( 'pre_get_posts', array( $this, 'add_my_post_types_to_query' ) );		
	}
	
	/**
	 * Register the plugin for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function register_cpt_slider() {

		$labels = array(
			'name' => esc_html__( 'Slider Posts', 'slider' ),
			'singular_name' => esc_html__( 'Slider Posts', 'slider' ),
			'add_new' => esc_html__( 'Add Slider Post', 'slider' ),
			'add_new_item' => esc_html__( 'Add Slider Post', 'slider' ),
			'edit_item' => esc_html__( 'Edit Slider Post', 'slider' ),
			'new_item' => esc_html__( 'Edit Slider Post', 'slider' ),
			'view_item' => esc_html__( 'View Slider Post', 'slider' ),
			'search_items' => esc_html__( 'Search Slider Post', 'slider' ),
			'not_found' => esc_html__( 'No Slider Found', 'slider' ),
			'not_found_in_trash' => esc_html__( 'No Slider Found in Trash', 'slider' ),
			'parent_item_colon'  => '',
			'menu_name'          => esc_html__( 'Slider Posts', 'slider' ),
		);

		$args = array(
			'labels' => $labels,
			'hierarchical' => false,
			'supports' => array( 'title', 'editor', 'excerpt', 'author', 'trackbacks', 'comments', 'revisions', 'slider-gallery-metabox' ),
			'taxonomies' => array( 'category', 'post_tag', 'page-category' ),
			'public' => true,
			'show_ui' => true,
			'show_in_menu' => true,
			'menu_position' => 5,
			'show_in_nav_menus' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'has_archive' => true,
			'query_var' => true,
			'can_export' => true,
			'rewrite' => true,
			'capability_type' => 'post',
			'menu_icon' => 'dashicons-images-alt2'
		);

		register_post_type( 'slider', $args );
	}
	
	/**
	 * Add the metabox for the admin area.
	 *
	 * @since    1.0.0
	 */
	public  function add_slider_gallery_metabox($post_type) {
		$types = array('slider');
		if (in_array($post_type, $types)) {
				add_meta_box(
					'slider-gallery-metabox',
					'Slider Gallery',
					array($this, 'slider_gallery_meta_display'),				
					$post_type,
					'normal',
					'high'
				);
		}
	}
	
	/**
	 * Add this custom post type into query.
	 *
	 * @since    1.0.0
	 */
	public function add_my_post_types_to_query( $query ) {
		
		if ( is_search() && $query->is_main_query() && $query->get( 's' ) ) {			
			$query->set(			
				'post_type', array('post', 'slider'),
				'meta_query', array(
					array(
					'key' => 'wysiwyg',
					'value' => '%s',
					'compare' => 'LIKE',
					),
				)
			);			
			return $query;
		}
		
		if ( is_single() || is_home() || is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() || is_attachment() || is_paged() && $query->is_main_query() ){
			$query->set( 'post_type', array( 'post', 'slider' ) );
			return $query;
		}		
	}	
  
	/**
	 * Add the fields for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function slider_gallery_meta_display($post) {
		wp_nonce_field( basename(__FILE__), 'sliedr_gallery_meta_nonce' );
		$ids = get_post_meta($post->ID, 'post_slider_gallery', true);
    ?>
		<table class="form-table">
			<tr>
				<td>
					<a class="gallery-add-slider button" href="#" data-uploader-title="Add image(s) to slider gallery" data-uploader-button-text="Add image(s)"><?php esc_html_e('Add image(s)', 'slider-posts'); ?></a>

					<ul id="slider-gallery-metabox-list">
					<?php if ($ids) : foreach ($ids as $key => $value) : $image = wp_get_attachment_image_src($value); ?>

						<li>
							<input type="hidden" name="post_slider_gallery[<?php echo esc_attr($key); ?>]" value="<?php echo esc_attr($value); ?>">
							<img class="image-preview" src="<?php echo esc_url($image[0]); ?>">
							<a class="change-slider-image button button-small" href="#" data-uploader-title="Change image" data-uploader-button-text="Change image"><?php esc_html_e('Change image', 'slider-posts'); ?></a><br>
							<small><a class="remove-slider-image" href="#"><?php esc_html_e('Remove image', 'slider-posts'); ?></a></small>
						</li>

					<?php endforeach; endif; ?>
					</ul>

				</td>
			</tr>
		</table>
  <?php }
  
	/**
	 * save/update function.
	 *
	 * @since    1.0.0
	 */
	public function sliedr_gallery_meta_save($post_id) {
		if (!isset($_POST['sliedr_gallery_meta_nonce']) || !wp_verify_nonce($_POST['sliedr_gallery_meta_nonce'], basename(__FILE__))) return;

		if (!current_user_can('edit_post', $post_id)) return;

		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

		if(isset($_POST['post_slider_gallery'])) {
		  update_post_meta($post_id, 'post_slider_gallery', $_POST['post_slider_gallery']);
		} else {
		  delete_post_meta($post_id, 'post_slider_gallery');
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
		 * defined in Slider_Posts_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Slider_Posts_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */		
		
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/slider-posts-admin.css', array(), $this->version, 'all' );
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
		 * defined in Slider_Posts_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Slider_Posts_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/slider-posts-admin.js', array( 'jquery' ), $this->version, false );		
	}

}
