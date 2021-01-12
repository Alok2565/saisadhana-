<?php
/* Demo data import function */
function ocdi_import_files() {
  return array(
    array(
      'import_file_name'           => 'Demo 1',
      'local_import_file'            => trailingslashit( get_template_directory() ) .'inc/demo-data/demo1/content.xml',
      'local_import_widget_file'     => trailingslashit( get_template_directory() ) .'inc/demo-data/demo1/widgets.txt',
      'local_import_redux'               => array(
        array(
          'file_path'    => trailingslashit( get_template_directory() ) .'inc/demo-data/demo1/redux.json',
          'option_name' => 'arisen_redux_optns',
        ),
      ),
      'import_preview_image_url'   => get_template_directory_uri().'/inc/demo-data/demo1/screen-image.jpg',
      'import_notice'              => esc_html__( 'Please waiting for a few minutes, do not close the window or refresh the page until the data is imported.', 'arisen' ),
    ),
  );
}
add_filter( 'pt-ocdi/import_files', 'ocdi_import_files' );

/* Automatically set menu, front page & blog page */
function ocdi_after_import_setup() {
	// Assign menus to their locations.
	$main_menu = get_term_by( 'name', 'top-menu', 'nav_menu' );

	set_theme_mod( 'nav_menu_locations', array(
			'primary' => $main_menu->term_id,
		)
	);

	// Assign front page and posts page (blog page).
	$front_page_id = get_page_by_title( 'demo-1' );
	$blog_page_id  = get_page_by_title( 'blog' );

	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', $front_page_id->ID );
	update_option( 'page_for_posts', $blog_page_id->ID );
}
add_action( 'pt-ocdi/after_import', 'ocdi_after_import_setup' );

/* Remove plugin add message */
add_filter( 'pt-ocdi/disable_pt_branding', '__return_true' );
?>