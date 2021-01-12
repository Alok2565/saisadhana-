<?php
/** 
 * Plugin Name:       Featured Video Metabox
 * Plugin URI:        https://themeforest.net/user/pennyblack
 * Description:       This plugin used to create featured video format post type. It support youtube & vimeo formats. 
 * Version:           1.0.0
 * Author:            PennyBlack
 * Author URI:        https://themeforest.net/user/pennyblack
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       featured-video-metabox
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-featured-video-metabox-activator.php
 */
function activate_featured_video_metabox() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-featured-video-metabox-activator.php';
	Featured_Video_Metabox_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-featured-video-metabox-deactivator.php
 */
function deactivate_featured_video_metabox() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-featured-video-metabox-deactivator.php';
	Featured_Video_Metabox_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_featured_video_metabox' );
register_deactivation_hook( __FILE__, 'deactivate_featured_video_metabox' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-featured-video-metabox.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_featured_video_metabox() {

	$plugin = new Featured_Video_Metabox();
	$plugin->run();

}
run_featured_video_metabox();
