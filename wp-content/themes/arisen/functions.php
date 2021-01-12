<?php
/*---------------------------------------------------------*/
/*	Theme Includes
/*---------------------------------------------------------*/
/* Redux admin settings config */
require_once get_parent_theme_file_path('/inc/functions/function-redux-config.php');

/* Demo data import config */
require_once get_parent_theme_file_path('/inc/functions/function-import-demo.php');

/* Tgm Plugin Activation */
require_once get_parent_theme_file_path('/inc/tgmpa/class-tgm-plugin-activation.php');

/* Required Plugins Function */
require_once get_parent_theme_file_path('/inc/functions/function-plugins.php');

/* Bootstrap Nav Menu walker */
require_once get_parent_theme_file_path('/inc/nav_menu/arisen_navwalker.php');

/* Post - Comments List - Form Format */
require_once get_parent_theme_file_path('/inc/comments/function-post-comment-format.php');

/* Elementor google font link reset */
add_filter( 'elementor/frontend/print_google_fonts', '__return_false' );

/*---------------------------------------------------------*/
/*	Register Theme Menus
/*---------------------------------------------------------*/
if( !function_exists('arisen_register_setup') ) {
	function arisen_register_setup() {

		 load_theme_textdomain( 'arisen', get_template_directory() . '/languages');

		  /* add title tag support */
		  add_theme_support( 'title-tag' );

		  /* Add default posts and comments RSS feed links to head */
		  add_theme_support( 'automatic-feed-links' );

		  /* Add excerpt to pages */
		  add_post_type_support( 'page', 'excerpt' );

		  /* Add support for post thumbnails */
		  add_theme_support( 'post-thumbnails' );

		  /* Add support for Selective Widget refresh */
		  add_theme_support( 'customize-selective-refresh-widgets' );

		 /* Add support for custom header */
		 $defaults = array(
			'default-image'          => '',
			'random-default'         => false,
			'width'                  => 0,
			'height'                 => 0,
			'flex-height'            => false,
			'flex-width'             => false,
			'default-text-color'     => '',
			'header-text'            => true,
			'uploads'                => true,
			'wp-head-callback'       => '',
			'admin-head-callback'    => '',
			'admin-preview-callback' => '',
		);
		add_theme_support( 'custom-header', $defaults );

		/* Add support for custom background */
		$defaults = array(
			'default-color'          => '',
			'default-image'          => '',
			'wp-head-callback'       => '_custom_background_cb',
			'admin-head-callback'    => '',
			'admin-preview-callback' => ''
		);
		add_theme_support( 'custom-background', $defaults );

		/* Add support for HTML5 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'widgets',
		  ) );

		/* Add support for post formats */
		 add_theme_support( 'post-formats', array(
			'aside', 'image', 'audio', 'video', 'slider', 'gallery', 'quote', 'link',
		) );

		register_nav_menus( array(
			'primary' => esc_html__( 'Primary Menu', 'arisen' ),
			'secondary'  => esc_html__( 'Secondary Menu', 'arisen' ),
		) );
	}
	add_action( 'init', 'arisen_register_setup' );
}

/*---------------------------------------------------------*/
/*	Google fonts
/*---------------------------------------------------------*/
if( !function_exists('arisen_fonts_url') ) {

	function arisen_fonts_url() {
		$fonts_url = '';

		/* Translators: If there are characters in your language that are not
		* supported by Raleway and Open Sans, translate this to 'off'. Do not translate
		* into your own language.
		*/
		$raleway = _x( 'on', 'Raleway font: on or off', 'arisen' );
		$open_sans = _x( 'on', 'Open Sans font: on or off', 'arisen' );

		if ( 'off' !== $raleway || 'off' !== $open_sans ) {
			$font_families = array();

			if ( 'off' !== $raleway ) {
				$font_families[] = 'Raleway:300,400,500,600,700,800,300italic,400italic,500italic';
			}

			if ( 'off' !== $open_sans ) {
				$font_families[] = 'Open Sans:300,400,600,700,800,300italic,400italic,600italic,700italic';
			}

			$query_args = array(
				'family' => urlencode( implode( '|', $font_families ) ),
				'subset' => urlencode( 'latin,latin-ext' ),
			);
			$protocol = is_ssl() ? 'https:' : 'http:';
			$fonts_url = add_query_arg( $query_args, $protocol .'//fonts.googleapis.com/css' );
		}
		return esc_url_raw( $fonts_url );
	}
}

if( !function_exists('arisen_font_scripts') ) {
	function arisen_font_scripts() {
		wp_enqueue_style( 'Arisen-fonts', arisen_fonts_url(), array(), null );
	}
	add_action( 'wp_enqueue_scripts', 'arisen_font_scripts' );
}

/*---------------------------------------------------------*/
/*	Register and Load Javascript, CSS and Custom Styles
/*---------------------------------------------------------*/
if( !function_exists('arisen_enqueue_scripts') ) {

	//Includes CSS && JS files
	function arisen_enqueue_scripts() {
		/* ===================================== CSS ================================== */
		/* font-awesome - css */
		wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/assets/css/vendor/font-awesome/font-awesome.min.css' );

		/* bootstrap - css */
		wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/assets/css/vendor/bootstrap/bootstrap.min.css' );

		/* donation form popup - css */
		wp_enqueue_style( 'magnific-popup', get_template_directory_uri() . '/assets/css/vendor/magnific-popup/magnific-popup.css' );

		/* ===================================== JS ================================== */
		/* bootstrap - js */
		wp_enqueue_script('bootstrap', get_template_directory_uri() . '/assets/js/vendor/bootstrap/bootstrap.min.js', array('jquery'), false, true );

		/* donation form popup - js */
		wp_enqueue_script('magnific-popup', get_template_directory_uri() . '/assets/js/vendor/magnific-popup/jquery.magnific-popup.min.js', array('jquery'), false, true );		

		/* custom - js */
		wp_enqueue_script('arisen-donation-popup', get_template_directory_uri() . '/assets/js/custom/donation-popup.js', array('jquery'), false, true );
		wp_enqueue_script('arisen-custom', get_template_directory_uri() . '/assets/js/custom/custom.js', array('jquery'), false, true);

		wp_enqueue_style( 'arisen-theme-style', get_stylesheet_uri() );
		if ( is_singular() && get_option( 'thread_comments' ) ){
			wp_enqueue_script( 'comment-reply' );
		}
		wp_enqueue_style( 'arisen-theme-custom-style', get_template_directory_uri() .'/assets/css/custom/custom.css' );

		/* ===================================== Redux Theme Option - CSS ================================== */
		global $arisen_redux_optns;
		$theme_opt_scheme = '';
		if(isset($arisen_redux_optns['body_background'])) {
			$body_bgcolor = $arisen_redux_optns['body_background'];
			$theme_opt_scheme .= ' html body {background-color: '.$body_bgcolor.';}';
		}

		if(isset($arisen_redux_optns['ch_blog_header_btn_bg'])) {
			$blog_btn_bgcolor = $arisen_redux_optns['ch_blog_header_btn_bg'];
			$theme_opt_scheme .= ' html .btn.header-btn {background-color: '.$blog_btn_bgcolor.';}';
		}

		if(isset($arisen_redux_optns['body_background'])) {
			$body_bg_color = $arisen_redux_optns['body_background'];
			$theme_opt_scheme .= ' html body {background-color: '.$body_bg_color.';}';
		}

		if(isset($arisen_redux_optns['header_menu_background'])) {
			$menu_bg_color = $arisen_redux_optns['header_menu_background'];
			$theme_opt_scheme .= ' html #top_nav {background-color: '.$menu_bg_color.';}';
		}

		if(isset($arisen_redux_optns['copyright_background'])) {
			$copyright_bg_color = $arisen_redux_optns['copyright_background'];
			$theme_opt_scheme .= ' html .site-generator {background-color: '.$copyright_bg_color.';}';
		}

		if(isset($arisen_redux_optns['menu_active_font'])) {
			$menu_active_font_color = $arisen_redux_optns['menu_active_font'];
			$theme_opt_scheme .= ' html .navbar-default .navbar-nav > li.active a, html .navbar-default .navbar-nav > li.active:focus, html .navbar-default .navbar-nav > li.active a:focus, html .navbar-default .navbar-nav > li.active a:hover, html .navbar-default .navbar-nav > li  a:hover, html ul.dropdown-menu li a:hover {color: '.$menu_active_font_color.';}';
		}
		wp_add_inline_style( 'arisen-theme-custom-style', $theme_opt_scheme );
	}
	add_action('wp_enqueue_scripts','arisen_enqueue_scripts');
}

if ( ! isset( $content_width ) ) {
	$content_width = 900;
}

if( !function_exists('arisen_theme_add_editor_styles') ) {
	function arisen_theme_add_editor_styles() {
		add_editor_style( 'assets/css/custom/editor.css' );
	}
	add_action( 'admin_init', 'arisen_theme_add_editor_styles' );
}

/* Function add custom demo import button click js */
if( !function_exists('arisen_load_custom_script') ) {
	function arisen_load_custom_script() {
		wp_enqueue_script('custom_demo_import', get_template_directory_uri() .'/assets/js/custom/custom-demo-import.js', array('jquery'));
	}
	add_action( 'admin_enqueue_scripts', 'arisen_load_custom_script' );
}

/*---------------------------------------------------------------------------------------------*/
/*	Register and Load Admin Script - post meta box display deponds upon post format select
/*---------------------------------------------------------------------------------------------*/
if( !function_exists('arisen_post_metabox_display_enqueue') ) {
	function arisen_post_metabox_display_enqueue($hook) {
		if ( 'post.php' == $hook || 'post-new.php' == $hook ) {
			wp_enqueue_script('post-metabox-display', get_template_directory_uri() . '/assets/js/custom/post_metabox_display.js', array('jquery'));
		}
	}
	add_action('admin_enqueue_scripts', 'arisen_post_metabox_display_enqueue');
}


/*---------------------------------------------------------*/
/*	Initialize Theme Widgets
/*---------------------------------------------------------*/
if( !function_exists('arisen_widgets_init') ) {
	function arisen_widgets_init() {

		add_theme_support( 'post-thumbnails' );
		register_sidebar( array(
			'name'          => esc_html__( 'Sidebar', 'arisen' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'arisen' ),
			'before_widget' => '<div class="colspc Arisen-widget %2$s"><div class="widget-content">',
			'after_widget'  => '</div></div>',
			'before_title'  => '<div class="widget-title"><h3>',
			'after_title'   => '</h3></div><div class="spacer"></div>',			
		) );

		register_sidebar( array(
			'name'          => esc_html__( 'Footer Top', 'arisen' ),
			'id'            => 'footer_top',
			'description'   => esc_html__( 'Footer Top Widgets Area', 'arisen' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<div class="widget_title"><h3>',
			'after_title'   => '</h3></div>',
		) );
	}
	add_action( 'widgets_init', 'arisen_widgets_init' );
}

/*---------------------------------------------------------*/
/*	Theme Header Title
/*---------------------------------------------------------*/
if( !function_exists('arisen_head_title') ) {
	function arisen_head_title( $title, $sep ) {
		global $paged, $page;

		if ( is_feed() ){
			return $title;
		}
		// Add the site name.
		$title .= home_url( 'name' );

		// Add the site description for the home/front page.
		$site_description = home_url( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) ) {
			$title = "$title $sep $site_description";
		}

		// Add a page number if necessary.
		if ( $paged >= 2 || $page >= 2 ){
			$title = "$title $sep " . sprintf( __( 'Page %s', 'arisen' ), max( $paged, $page ) );
		}
		return $title;
	}
	add_filter( 'wp_title', 'arisen_head_title', 10, 2 );
}


/*---------------------------------------------------------*/
/*	Initialize Theme Image Size
/*---------------------------------------------------------*/
if( !function_exists('arisen_image_sizes') ) {
	function arisen_image_sizes() {
		if( has_post_thumbnail() ){
			 return the_post_thumbnail( 'thumbnail' );
		}
		add_image_size( 'arisen-blog-thumb', 945, 540, false ); 		    // Blog thumbnails
		add_image_size( 'arisen-slider-thumb', 945, 450, true); 	        // Slider thumbnails
		add_image_size( 'arisen-2col-grid-thumb', 518, 320, true); 		    // 2column Grid thumbnails
		add_image_size( 'arisen-3col-grid-thumb', 320, 194, true); 		    // 3column Grid thumbnails
		add_image_size( 'arisen-3col-grid-slider-thumb', 320, 194, true); 	// 3column Grid Slider thumbnails
		add_image_size( 'arisen-full-size', 9999, 9999, false ); 		    // Full Size
	}
	add_action( 'init', 'arisen_image_sizes' );
}


/*---------------------------------------------------------*/
/*	Initialize Theme URI Shortcode
/*---------------------------------------------------------*/
if( !function_exists('arisen_theme_uri_shortcode') ) {
	function arisen_theme_uri_shortcode( $attrs = array (), $content = '' )
	{
		$theme_uri = is_child_theme() ? get_stylesheet_directory_uri() : get_template_directory_uri();
		return trailingslashit( $theme_uri );
	}
}


/*---------------------------------------------------------*/
 /* Remove empty paragraphs created by wpautop()
 /* @blog-content - Add custom class with p tag
/*---------------------------------------------------------*/
if( !function_exists('arisen_remove_empty_p') ) {
	function arisen_remove_empty_p( $content ) {
		$content = force_balance_tags( $content );
		$content = preg_replace( '#<p>\s*+(<br\s*/*>)?\s*</p>#i', '', $content );
		$content = preg_replace( '~\s?<p>(\s|&nbsp;)+</p>\s?~', '', $content );
		return $content;
	}
	add_filter('the_content', 'arisen_remove_empty_p', 20, 1);
}

/*---------------------------------------------------------*/
/* Register Custom Tag Cloud widget
/*---------------------------------------------------------*/
if( !function_exists('arisen_custom_tag_cloud_widget') ) {
	function arisen_custom_tag_cloud_widget($args) {
		$args['number'] = 12; //adding a 0 will display all tags
		$args['largest'] = 15; //largest font-size tag
		$args['smallest'] = 14; //smallest font-size tag
		$args['unit'] = 'px'; //tag font unit
		$args['format'] = 'list'; //ul with a class of wp-tag-cloud
		return $args;
	}
	add_filter( 'widget_tag_cloud_args', 'arisen_custom_tag_cloud_widget' );
}


/*---------------------------------------------------------*/
/* Comments Form - fields order re-arrange
/* display comments filed at last
/*---------------------------------------------------------*/
if( !function_exists('arisen_move_comment_field_to_bottom') ) {
	function arisen_move_comment_field_to_bottom( $fields ) {
		$comment_field = $fields['comment'];
		unset( $fields['comment'] );
		$fields['comment'] = $comment_field;
		return $fields;
	}
	add_filter( 'comment_form_fields', 'arisen_move_comment_field_to_bottom' );
}

/*---------------------------------------------------------*/
/* Search Form - search only post
/*---------------------------------------------------------*/
if( !function_exists('arisen_SearchFilter') ) {
	function arisen_SearchFilter($query) {
		if ($query->is_search) {
			$query->set('post_type', 'post');
		}
		return $query;
	}
	add_filter('pre_get_posts','arisen_SearchFilter');
}

/*---------------------------------------------------------*/
/* Post - Numeric Pagination
/*---------------------------------------------------------*/
if( !function_exists('arisen_pagination') ) {
	function arisen_pagination() {
		global $wp_query;
		$big = 12345678;
		$page_format = paginate_links( array(
			'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			'format' => '?paged=%#%',
			'current' => max( 1, get_query_var('paged') ),
			'total' => $wp_query->max_num_pages,
			'type'  => 'array'
		) );
		if( is_array($page_format) ) {
			$paged = ( get_query_var('paged') == 0 ) ? 1 : get_query_var('paged');
			echo '<div class="pagination"><ul>';
			foreach ( $page_format as $page ) {
					echo "<li>$page</li>";
			}
		   echo '</ul></div>';
		}
	}
}

/*---------------------------------------------------------*/
/* Post - Breadcrumb
/*---------------------------------------------------------*/
if( !function_exists('arisen_breadcrumbs') ) {
	function arisen_breadcrumbs() {
	  $showOnHome = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show
	  $delimiter = '&raquo;'; // delimiter between crumbs
	  $home = 'Home'; // text for the 'Home' link
	  $blog = 'Blog'; // text for the 'Blog' link
	  $showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
	  $before = ' ';

	  global $post;
	  $homeLink = home_url();

	  if (is_front_page()) { //static front page

		if ($showOnHome == 1) {
			echo '<div id="crumbs"><a href="' . esc_url($homeLink) . '">' . esc_html($home) . '</a></div>';
		}
	  }
	  elseif (is_home()){ //blog page
			echo '<div id="crumbs"><a href="' . esc_url($homeLink) . '">' . esc_html($home) . '</a> ' . esc_html($delimiter) . ' <span class="current">' . esc_html($blog) . '</span></div>';
	  }
	  else { //other post pages

		echo '<div id="crumbs"><a href="' . esc_url($homeLink) . '">' . esc_html($home) . '</a> ' . esc_html($delimiter) . ' ';

		if ( is_category() ) {
			$thisCat = get_category(get_query_var('cat'), false);
			if ($thisCat->parent != 0) {
				echo get_category_parents($thisCat->parent, TRUE, ' ' . esc_html($delimiter) . ' ');
			}
			echo '<span class="current">' . esc_html__( 'Archive by category "', 'arisen' ). single_cat_title('', false) . '"' . '</span>';

		} elseif ( is_search() ) {
			echo '<span class="current">' . esc_html__( 'Search results for "', 'arisen' ). get_search_query() . '"' . '</span>';

		} elseif ( is_day() ) {
			echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . esc_html($delimiter) . ' ';
			echo '<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . esc_html($delimiter) . ' ';
			echo '<span class="current">' . get_the_time('d') . '</span>';

		} elseif ( is_month() ) {
			echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . esc_html($delimiter) . ' ';
			echo '<span class="current">' . get_the_time('F') . '</span>';

		} elseif ( is_year() ) {
			echo '<span class="current">' . get_the_time('Y') . '</span>';

		} elseif ( is_single() && !is_attachment() ) {
			if ( get_post_type() != 'post' ) {
				$post_type = get_post_type_object(get_post_type());
				$slug = $post_type->rewrite;
				echo '<a href="' . esc_url($homeLink) . '/' . $slug['slug'] . '/">' . esc_html($post_type->labels->singular_name) . '</a>';
				if ($showCurrent == 1) {
					echo esc_html($before) . esc_html($delimiter) . ' <span class="current">' . get_the_title() . '</span>';
				}
			} else {
				$cat = get_the_category(); $cat = $cat[0];
				if ($showCurrent == 0) {
					echo preg_replace("#^(.+)\s$delimiter\s$#", "$1", $cats);
				}
				echo get_category_parents($cat, TRUE, ' ' . esc_html($delimiter) . ' ');

				if ($showCurrent == 1) {
					echo '<span class="current">' . get_the_title() . '</span>';
				}
			}

		} elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
			$post_type = get_post_type_object(get_post_type());
			echo '<span class="current">' . esc_html($post_type->labels->singular_name) . '</span>';

		} elseif ( is_attachment() ) {
			$parent = get_post($post->post_parent);
			$cat = get_the_category($parent->ID); $cat = $cat[0];
			echo get_category_parents($cat, TRUE, ' ' . esc_html($delimiter) . ' ');
			echo '<a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a>';
			if ($showCurrent == 1) {
				echo esc_html($before) . esc_html($delimiter) . ' <span class="current">' . get_the_title() . '</span>';
			}

		} elseif ( is_page() && !$post->post_parent ) {
			if ($showCurrent == 1){
				echo '<span class="current">' . get_the_title() . '</span>';
			}

		} elseif ( is_page() && $post->post_parent ) {
			  $parent_id  = $post->post_parent;
			  $breadcrumbs = array();
			  while ($parent_id) {
				$page = get_page($parent_id);
				$breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
				$parent_id  = $page->post_parent;
			  }
			  $breadcrumbs = array_reverse($breadcrumbs);
			  for ($i = 0; $i < count($breadcrumbs); $i++) {
				echo esc_html($breadcrumbs[$i]);
				if ($i != count($breadcrumbs)-1) {
					$returnString .= ' ' . esc_html($delimiter) . ' ';
				}
			  }
			  if ($showCurrent == 1){
				  echo esc_html($before) . esc_html($delimiter) . ' <span class="current">' . get_the_title() . '</span>';
			  }

		} elseif ( is_tag() ) {
			echo '<span class="current">' . esc_html__( 'Posts tagged "', 'arisen' ) . single_tag_title('', false) . '"' . '</span>';

		} elseif ( is_author() ) {
			global $author;
			$userdata = get_userdata($author);
			echo '<span class="current">' . esc_html__( 'Articles posted by ', 'arisen' ) . esc_html($userdata->display_name) . '</span>';

		} elseif ( is_404() ) {
			echo '<span class="current">' . esc_html__( 'Error 404', 'arisen' ) . '</span>';
		}

		if ( get_query_var('paged') ) {
			if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ){
			  echo esc_html__( ' (', 'arisen' );
			}
			echo esc_html__('Page', 'arisen') . ' ' . get_query_var('paged');
			if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) {
			  echo esc_html__( ')', 'arisen' );
			}
		}
		echo '</div>';
	  }
	}
}
/* -------------------------------------------------------------------------------------------- */
/* Show posts of 'slider' post types on all post page
/* Custom post hook on all post pages
/* -------------------------------------------------------------------------------------------- */
if( !function_exists('arisen_include_post_types_in_search') ) {
	function arisen_include_post_types_in_search($query) {
		if(is_search()) {
			$post_types = get_post_types(array('public' => true, 'exclude_from_search' => false), 'objects');
			$searchable_types = array('post', 'slider');
			$query->set('post_type', $searchable_types);
		}
		return $query;
	}
	add_action('pre_get_posts', 'arisen_include_post_types_in_search');
}

/* -------------------------------------------------------------------------------------------- */
/* Posts content limit
/* -------------------------------------------------------------------------------------------- */
if( !function_exists('arisen_limit_content') ) {
	function arisen_limit_content($limit) {
		  $contents = ''; $lengths = '';
		  $words = wp_trim_words( get_the_content(), 40, '' );
		  $words_lenght = strlen($words);
		  if($words_lenght > 120) {
			  $content = substr($words, 0, $limit);
			  $content .= '...';
			  $length = $limit;
		  }else if($words_lenght == 0){
			 $content = "";
			 $length = 0;
		  }else{
			  $content =  $words;
			  $length = 1;
		  }
		  $result = array($content, $length );
		return  $result;
	}
}

/* -------------------------------------------------------------------------------------------- */
/* Posts excerpt limit
/* -------------------------------------------------------------------------------------------- */
if( !function_exists('arisen_get_excerpt') ) {
	function arisen_get_excerpt($limit, $source = null){
		if($source == "content" ? ($excerpt = get_the_content()) : ($excerpt = get_the_excerpt()));
		return wp_trim_words($excerpt, $limit);
	}
}

/* -------------------------------------------------------------------------------------------- */
/* Posts excerpt word/string count
/* -------------------------------------------------------------------------------------------- */
if( !function_exists('arisen_get_excerpt_lenght') ) {
	function arisen_get_excerpt_lenght($limit, $source = null){
		if($source == "content" ? ($excerpt = get_the_content()) : ($excerpt = get_the_excerpt()));
		$excerpt = preg_replace(" (\[.*?\])",'',$excerpt);
		$excerpt = strip_shortcodes($excerpt);
		$excerpt = strip_tags($excerpt);
		$excerpt = substr($excerpt, 0, $limit);
		$excerpt = substr($excerpt, 0, strripos($excerpt, " "));
		$excerpt = strlen($excerpt);
		return $excerpt;
	}
}

/* -------------------------------------------------------------------------------------------- */
/* Child Theme Support
/* -------------------------------------------------------------------------------------------- */
if( !function_exists('arisen_enqueue_child_styles') ) {
	function arisen_enqueue_child_styles() {
		$parent_style = 'parent-style';

		if (is_child_theme()) {
			wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
			wp_enqueue_style( 'child-style',
				get_stylesheet_directory_uri() . '/style.css',
				array( $parent_style ),
				wp_get_theme()->get('Version')
			);
		}
	}
	add_action( 'wp_enqueue_scripts', 'arisen_enqueue_child_styles' );
}

/* -------------------------------------------------------------------------------------------- */
/* Function remove role attribute
/* -------------------------------------------------------------------------------------------- */
if( !function_exists('arisen_sanitize_pagination') ) {
	function arisen_sanitize_pagination($content) {
		$content = str_replace('role="navigation"', '', $content);
		return $content;
	}
	add_action('navigation_markup_template', 'arisen_sanitize_pagination');
}
?>