<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://themeforest.net/user/pennyblack
 * @since      1.0.0
 *
 * @package    Featured_Audio_Metabox
 * @subpackage Featured_Audio_Metabox/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Featured_Audio_Metabox
 * @subpackage Featured_Audio_Metabox/includes
 * @author     PennyBlack <PennyBlack>
 */
class Featured_Audio_Metabox_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'featured-audio-metabox',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
