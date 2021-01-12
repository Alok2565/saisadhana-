<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://themeforest.net/user/pennyblack
 * @since             1.0.0
 * @package           Post_Gallery_Metabox
 *
 * @wordpress-plugin
 * Plugin Name:       Post Gallery MetaBox
 * Plugin URI:        https://themeforest.net/user/pennyblack
 * Description:       This is a image gallery metabox used to attach and manage multiple images.
 * Version:           1.0.0
 * Author:            PennyBlack
 * Author URI:        https://themeforest.net/user/pennyblack
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       post-gallery-metabox
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-post-gallery-metabox-activator.php
 */
function activate_Post_Gallery_Metabox() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-post-gallery-metabox-activator.php';
	Post_Gallery_Metabox_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-post-gallery-metabox-deactivator.php
 */
function deactivate_Post_Gallery_Metabox() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-post-gallery-metabox-deactivator.php';
	Post_Gallery_Metabox_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_Post_Gallery_Metabox' );
register_deactivation_hook( __FILE__, 'deactivate_Post_Gallery_Metabox' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-post-gallery-metabox.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_Post_Gallery_Metabox() {

	$plugin = new Post_Gallery_Metabox();
	$plugin->run();

}
run_Post_Gallery_Metabox();
