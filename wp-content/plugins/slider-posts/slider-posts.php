<?php
/** 
 * This file includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://themeforest.net/user/pennyblack
 * @since             1.0.0
 * @package           Slider_Posts
 *
 * @wordpress-plugin
 * Plugin Name:       Slider Posts
 * Plugin URI:        https://themeforest.net/user/pennyblack
 * Description:       This is a custom post format allow you to create multiple image slider post.
 * Version:           1.0.0
 * Author:            PennyBlack
 * Author URI:        https://themeforest.net/user/pennyblack
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       slider-posts
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-slider-posts-activator.php
 */
function activate_slider_posts() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-slider-posts-activator.php';
	Slider_Posts_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-slider-posts-deactivator.php
 */
function deactivate_slider_posts() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-slider-posts-deactivator.php';
	Slider_Posts_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_slider_posts' );
register_deactivation_hook( __FILE__, 'deactivate_slider_posts' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-slider-posts.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_slider_posts() {

	$plugin = new Slider_Posts();
	$plugin->run();

}
run_slider_posts();
