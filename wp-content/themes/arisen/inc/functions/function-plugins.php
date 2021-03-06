<?php
/*** Required Plugins ***/
add_action( 'tgmpa_register', 'arisen_register_required_plugins' );
function arisen_register_required_plugins() {
	
	$plugins = array(		
		
		array(
			'name'     				=> 'Elementor', // The plugin name
			'slug'     				=> 'elementor', // The plugin slug (typically the folder name)		
			'source'                => 'https://wordpress.org/plugins/elementor', //plugin from WordPress repository
			'required'              => true,
		),
		array(
			'name'     				=> 'Regenerate Thumbnails', // The plugin name
			'slug'     				=> 'regenerate-thumbnails', // The plugin slug (typically the folder name)	
			'source'                => 'https://wordpress.org/plugins/regenerate-thumbnails',	 //plugin from WordPress repository	
			'required'              => true,
		),
		array(
			'name'     				=> 'Contact Form 7', // The plugin name
			'slug'     				=> 'contact-form-7', // The plugin slug (typically the folder name)		
			'source'                => 'https://wordpress.org/plugins/contact-form-7',  //plugin from WordPress repository	
			'required'              => false,
		),
		array(
			'name'     				=> 'Give - Donation Plugin', // The plugin name
			'slug'     				=> 'give', // The plugin slug (typically the folder name)			
			'source'                => 'https://wordpress.org/plugins/give', //plugin from WordPress repository	
			'required'              => true, 
		),	
		array(
			'name'     				=> 'One Click Demo Import', // The plugin name
			'slug'     				=> 'one-click-demo-import', // The plugin slug (typically the folder name)			
			'source'             	=> 'https://wordpress.org/plugins/one-click-demo-import', //plugin from WordPress repository		
			'required'              => true,		
		),
		array(
			'name'     				=> 'Redux Framework', // The plugin name
			'slug'     				=> 'redux-framework', // The plugin slug (typically the folder name)
			'source'             	=> 'http://wordpress.org/plugins/redux-framework', //plugin from WordPress repository		
			'required'              =>  true,			
		),
		array(
			'name'     				=> 'Recent Posts Widget With Thumbnails', // The plugin name
			'slug'     				=> 'recent-posts-widget-with-thumbnails', // The plugin slug (typically the folder name)
			'source'             	=> 'http://wordpress.org/plugins/recent-posts-widget-with-thumbnails/', //plugin from WordPress repository		
			'required'              =>  false,			
		),			
		array(
			'name'     				=> 'Slider Posts', // The plugin name
			'slug'     				=> 'slider-posts', // The plugin slug (typically the folder name)
			'source'                => get_template_directory_uri() . '/plugins/my-plugins/slider-posts.zip', //plugin from theme	
			'required'              => true,
		),
		array(
			'name'     				=> 'Featured Video Metabox', // The plugin name
			'slug'     				=> 'featured-video-metabox', // The plugin slug (typically the folder name)	
			'source'                => get_template_directory_uri() . '/plugins/my-plugins/featured-video-metabox.zip', //plugin from theme
			'required'              => true,
		),
		array(
			'name'     				=> 'Featured Audio Metabox', // The plugin name
			'slug'     				=> 'featured-audio-metabox', // The plugin slug (typically the folder name)	
			'source'                => get_template_directory_uri() . '/plugins/my-plugins/featured-audio-metabox.zip', //plugin from theme
			'required'              => true,
		),	
		array(
			'name'     				=> 'Post Gallery MetaBox', // The plugin name
			'slug'     				=> 'post-gallery-metabox', // The plugin slug (typically the folder name)	
			'source'                => get_template_directory_uri() . '/plugins/my-plugins/post-gallery-metabox.zip', //plugin from theme
			'required'              => true,
		),		
	);

	/**
	 * Array of configuration settings. Amend each line as needed.
	 * If you want the default strings to be available under your own theme domain,
	 * leave the strings uncommented.
	 * Some of the strings are added into a sprintf, so see the comments at the
	 * end of each line for what each argument will be.
	 */
    $config = array(
        'default_path' => '',                      // Default absolute path to pre-packaged plugins.
        'menu'         => 'tgmpa-install-plugins', // Menu slug.
        'has_notices'  => true,                    // Show admin notices or not.
        'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
        'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => false,                   // Automatically activate plugins after installation or not.
        'message'      => '',                      // Message to output right before the plugins table.
        'strings'      => array(
            'page_title'                      => __( 'Install Required Plugins', 'arisen' ),
            'menu_title'                      => __( 'Install Plugins', 'arisen' ),
            'installing'                      => __( 'Installing Plugin: %s', 'arisen' ), // %s = plugin name.
            'oops'                            => __( 'Something went wrong with the plugin API.', 'arisen' ),
            'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'arisen' ), // %1$s = plugin name(s).
            'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'arisen' ), // %1$s = plugin name(s).
            'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'arisen' ), // %1$s = plugin name(s).
            'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'arisen' ), // %1$s = plugin name(s).
            'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'arisen' ), // %1$s = plugin name(s).
            'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'arisen' ), // %1$s = plugin name(s).
            'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'arisen' ), // %1$s = plugin name(s).
            'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'arisen' ), // %1$s = plugin name(s).
            'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'arisen' ),
            'activate_link'                   => _n_noop( 'Begin activating plugin', 'Begin activating plugins', 'arisen' ),
            'return'                          => __( 'Return to Required Plugins Installer', 'arisen' ),
            'plugin_activated'                => __( 'Plugin activated successfully.', 'arisen' ),
            'complete'                        => __( 'All plugins installed and activated successfully. %s', 'arisen' ), // %s = dashboard link.
            'nag_type'                        => 'updated' // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
        )
    );
    tgmpa( $plugins, $config );
}