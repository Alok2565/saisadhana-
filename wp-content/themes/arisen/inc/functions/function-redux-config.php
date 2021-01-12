<?php

/**
  ReduxFramework Sample Config File
  For full documentation, please visit: https://docs.reduxframework.com
 * */

if (!class_exists('Redux_Framework_sample_config')) {

    class Redux_Framework_sample_config {

        public $args        = array();
        public $sections    = array();
        public $theme;
        public $ReduxFramework;

        public function __construct() {

            if (!class_exists('ReduxFramework')) {
                return;
            }             

            $this->initSettings();

        }

        public function initSettings() {       

            // Just for demo purposes. Not needed per say.
            $this->theme = wp_get_theme();

            // Set the default arguments
            $this->setArguments();


            // Create the sections and fields
            $this->setSections();

            if (!isset($this->args['opt_name'])) { // No errors please
                return;
            }

            // If Redux is running as a plugin, this will remove the demo notice and links
            //add_action( 'redux/loaded', array( $this, 'remove_demo' ) );
            
            // Function to test the compiler hook and demo CSS output.
            // Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
            //add_filter('redux/options/'.$this->args['opt_name'].'/compiler', array( $this, 'compiler_action' ), 10, 2);
            
            // Change the arguments after they've been declared, but before the panel is created
            //add_filter('redux/options/'.$this->args['opt_name'].'/args', array( $this, 'change_arguments' ) );
            
            // Change the default value of a field after it's been set, but before it's been useds
            //add_filter('redux/options/'.$this->args['opt_name'].'/defaults', array( $this,'change_defaults' ) );
            
            // Dynamically add a section. Can be also used to modify sections/fields
            // add_filter('redux/options/' . $this->args['opt_name'] . '/sections', array($this, 'dynamic_section'));

            $this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
        }

        /**

          This is a test function that will let you see when the compiler hook occurs.
          It only runs if a field	set with compiler=>true is changed.

         * */
        function compiler_action($options, $css) {
            //echo '<h1>The compiler hook has run!';
            //print_r($options); //Option values
            //print_r($css); // Compiler selector CSS values  compiler => array( CSS SELECTORS )           
        }

        /**

          Custom function for filtering the sections array. Good for child themes to override or add to the sections.
          Simply include this function in the child themes functions.php file.

          NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
          so you must use get_template_directory_uri() if you want to use any of the built in icons

         * */
        function dynamic_section($sections) {           
            $sections[] = array(
                'title' => esc_html__('Section via hook', 'arisen'),
                'desc' => esc_html__('<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'arisen'),
                'icon' => 'el-icon-paper-clip',
                // Leave this as a blank section, no options just some intro text set above.
                'fields' => array()
            );

            return $sections;
        }

        /**

          Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.

         * */
        function change_arguments($args) {
            //$args['dev_mode'] = true;

            return $args;
        }

        /**

          Filter hook for filtering the default value of any given field. Very useful in development mode.

         * */
        function change_defaults($defaults) {
            $defaults['str_replace'] = 'Testing filter hook!';

            return $defaults;
        }

        public function setSections() {  

            $this->sections[] = array(
					'title' => esc_html__( 'Home', 'arisen' ),
					'id'    => 'home',
					'desc'  => esc_html__( 'Body Styling.', 'arisen' ),
					'icon'  => 'el-icon-home',    
					'fields'     => array(
					   array(
							'id'        => 'body_background',
							'type'      => 'color',	
							//'output'    => array('html body'),				
							'title'     => esc_html__('Body Background Color', 'arisen'),
							'subtitle'  => esc_html__('Change the body background color (default: #ffffff).', 'arisen'),
							'default'   => '#ffffff',
							'transparent' => false,
							'validate'  => 'color',
						),
					)				
            );
            
           // -> START Header Fields
			$this->sections[] = array(
				'title' => esc_html__( 'Header', 'arisen' ),
				'id'    => 'header',
				'icon'  => 'el-icon-th-list'
			 );

			$this->sections[] = array(
				'title'      => esc_html__( 'Menu', 'arisen' ),
				'id'         => 'menu_style',
				'desc'       => esc_html__( 'Change Site Logo, Favicon, Menu Font & Menu Background Style:', 'arisen' ),
				'subsection' => true,
				'fields'     => array(						
					array(
						'id'        => 'theme_favicon',
						'type'      => 'media',
						'url'       => true,
						'title'     => esc_html__('Site Favicon', 'arisen'),
						'subtitle'  => esc_html__('Change site favicon(Icon should be max-16x16 pixel png/gif).', 'arisen'),
						'default'   => array('url' => '') 	
					),                    

					array(
						'id'        => 'theme_logo',
						'type'      => 'media',
						'url'       => true,
						'title'     => esc_html__('Site Logo', 'arisen'),
						//'mode'      => false, // Can be set to false to allow any media type, or can also be set to any mime type.
						'subtitle'  => esc_html__('Change site logo(image should be max-150x50 pixel png/gif).', 'arisen'),
						'default'   => array('url' => get_template_directory_uri() .'/assets/images/logo.png')                
					),
					array(
						'id'          => 'menu_font',
						'type'        => 'typography',
						'title'    => esc_html__( 'Menu Font Style', 'arisen' ),                
						'font-backup' => true,               
						'all_styles'  => true,
						'output'      => array( 'html .navbar-default .navbar-nav > li > a' ), 
						'units'       => 'px',
						'subtitle' => esc_html__( 'Change the header menu font properties (default: #666666):', 'arisen' ),
						'default'     => array(
							'google'      => true,
							'color'       => '#666666',                   
							'font-family' => 'Open Sans',                    
							'font-size'   => '13px',
							'line-height' => '20px',
							'font-weight' => '600'
						),
					),			
					array(
						'id'        => 'menu_active_font',
						'type'      => 'color',	
					   // 'output'    => array('html #top_nav'),				
						 'title'    => esc_html__( 'Menu Active Font Style', 'arisen' ), 
						'subtitle' => esc_html__( 'Change the header menu active, focus, hover font properties (default: #fea501):', 'arisen' ),
						'default'   => '#fea501',
						'transparent' => false,
						'validate'  => 'color',
					),						
					array(
						'id'        => 'header_menu_background',
						'type'      => 'color',	
					   // 'output'    => array('html #top_nav'),				
						'title'     => esc_html__('Menu Background Color', 'arisen'),
						'subtitle'  => esc_html__('Change the header menu background color (default: #f7f7f7).', 'arisen'),
						'default'   => '#f7f7f7',
						'transparent' => false,
						'validate'  => 'color',
					),			
				)
			);

			// -> START BLOG/POST
			$this->sections[] = array(
				'title' => esc_html__( 'Blog', 'arisen' ),
				'id'    => 'blog',
				'icon'  => 'el-icon-screen'        
			);
			
			$this->sections[] = array(
				'title'      => esc_html__( 'Blog Layout', 'arisen' ),
				'id'         => 'blog_layout_opt',
				'desc'       => esc_html__( 'Choose your blog layouts', 'arisen' ),
				'subsection' => true,
				'fields'     => array(			
					array(
						'id'        => 'blog_sidebar',
						'type'      => 'image_select',
						'title'     => esc_html__('Sidebar Position for Single Blog Pages', 'arisen'),
						'subtitle'  => esc_html__('Choose a sidebar position for blog pages. This will be applied to single post, index page, category, archive and search page.', 'arisen'),
						'options'   => array(
							'sidebar-left' => array('alt' => 'Sidebar Left',  'img' => get_template_directory_uri() .'/assets/images/redux/2cl.png'),
							'sidebar-right' => array('alt' => 'Sidebar Right',  'img' => get_template_directory_uri() .'/assets/images/redux/2cr.png'),
							'no-sidebar' => array('alt' => 'No Sidebar',  'img' => get_template_directory_uri() .'/assets/images/redux/1col.png')
						),
						'default'   => 'sidebar-right'
					),
					array(
						'id'        => 'blog_list_layout',
						'type'      => 'image_select',
						'title'     => esc_html__('Blog List Page Layout', 'arisen'),
						'subtitle'  => esc_html__('Choose a layout for blog lists. This will be applied to all type of posts in list format page.', 'arisen'),
						'options'   => array(				
							'sidebar-left' => array('alt' => 'Sidebar Left',  'img' => get_template_directory_uri() .'/assets/images/redux/2cl.png'),
							'sidebar-right' => array('alt' => 'Sidebar Right',  'img' => get_template_directory_uri() .'/assets/images/redux/2cr.png'),
							'2-col-grid' => array('alt' => '2-col-grid',  'img' => get_template_directory_uri() .'/assets/images/redux/2-col-portfolio.png'),
							'3-col-grid' => array('alt' => '3-col-grid',  'img' => get_template_directory_uri() .'/assets/images/redux/3-col-portfolio.png'),					
							'3-col-masonry' => array('alt' => '3-col-masonry',  'img' => get_template_directory_uri() .'/assets/images/redux/3-col-masonry.png'),
							'no-sidebar' => array('alt' => 'No Sidebar',  'img' => get_template_directory_uri() .'/assets/images/redux/1col.png')
						),
						'default'   => 'sidebar-right'
					),			
				)
			);
			
			$this->sections[] = array(
				'title'      => esc_html__( 'Blog Header Banner', 'arisen' ),
				'id'         => 'blog_header_banner',
				'desc'       => esc_html__( 'Enable or Disable blog header banner title, button, breadcrumb', 'arisen' ),
				'subsection' => true,
				'fields'     => array(			
					array(
						'id'      => 'blog_banner',
						'type'    => 'switch',
						'title'   => esc_html__( 'Blog Header Banner', 'arisen' ),
						'desc'    => esc_html__( 'Enable/Disable Blog header banner shown in all block pages', 'arisen' ),
						'default' => false,
					),
					array(
						'id'      => 'blog_banner_button',
						'type'    => 'switch',
						'title'   => esc_html__( 'Blog Banner Button', 'arisen' ),
						'default' => true,
					),
					array(
						'id'      => 'blog_breadcrumb',
						'type'    => 'switch',
						'title'   => esc_html__( 'Blog Banner Breadcrumb', 'arisen' ),
						'default' => true,
					),
					array(
						'id'        => 'ch_blog_header_background',
						'type'      => 'background',						
						'title'     => esc_html__('Blog Banner Background Image', 'arisen'),
						'output'    => array('html #header-featured-image.header-img'),
						//'mode'      => false, // Can be set to false to allow any media type, or can also be set to any mime type.
						'subtitle'  => esc_html__('Change blog banner background(image should be max-1500x780 pixel).', 'arisen'),
						'transparent' => true,
						'preview_media' => true,
						'preview' => false,
						'default'   => array(
							'background-position' => 'center center',
							'background-size' => 'cover',
							'background-repeat' => 'no-repeat',
							'background-image' => get_template_directory_uri() .'/assets/images/1500x780x1.jpg',
						),                
					),					
					array(
						'id'        => 'ch_blog_header_textarea',
						'type'      => 'editor',
						'title'     => esc_html__('Blog Banner Title Text', 'arisen'),
						'subtitle'  => esc_html__('Change blog banner title text in editor.', 'arisen'),				 
						'default'   => 'Save the Kindness',
					),		
					array(
						'id'          => 'ch_blog_header_font',
						'type'        => 'typography',
						'title'    => esc_html__( 'Blog Banner Title Font Style', 'arisen' ),                
						'font-backup' => true,               
						'all_styles'  => true,
						'output'      => array( 'html .header-section h2.blog-header-title' ), 
						'units'       => 'px',
						'subtitle' => esc_html__( 'Change blog banner title text font properties (default: #ffffff):', 'arisen' ),
						'text-align'=> false,
						'subsets'   => true,
						'font-weight' => false,
						'default'     => array(
						   'google'      => true,
							'color'       => '#ffffff',                  
							'font-family' => 'Ubuntu',                    
							'font-size'   => '36px',
							'line-height' => '40px',					
							'font-weight' => '500'
						),
					),
					
					array(
						'id'        => 'ch_blog_header_btn_bg',
						'type'      => 'color',	
					   // 'output'    => array('html .btn.header-btn'),				
						 'title'    => esc_html__( 'Blog Banner Button Background Color', 'arisen' ), 
						'subtitle' => esc_html__( 'Change the blog banner button background-color (default: #fea501):', 'arisen' ),
						'default'   => '#fea501',
						'transparent' => false,
						'validate'  => 'color',
					),
					array(
						'id'          => 'ch_blog_header_btn_font',
						'type'        => 'typography',
						'title'    => esc_html__( 'Blog Banner Button Font Style', 'arisen' ),                
						'font-backup' => true,               
						'all_styles'  => true,
						'output'      => array( 'html .btn.header-btn a' ), 
						'units'       => 'px',
						'subtitle' => esc_html__( 'Change blog banner button text font properties (default: #ffffff):', 'arisen' ),
						'text-align'=> false,
						'subsets'   => true,
						'font-weight' => false,
						'default'     => array(
						   'google'      => true,
							'color'       => '#ffffff',                  
							'font-family' => 'Open Sans',   
							'font-size'   => '13px',										
							'font-weight' => '600'
						),
					),
					
					array(
						'id'       => 'ch_blog_donation_form',
						'type'     => 'text',
						'title'    => esc_html__('Donation Form Shortcode', 'arisen'),
						'subtitle' => esc_html__('Enter Blog page donation form short code generated in donation plugin, this form display in blog header', 'arisen'),	
						'default'  => '[give_form id="355"]',
					),
					
					array(
						'id'       => 'ch_blog_header_btn_id',
						'type'     => 'text',
						'title'    => esc_html__('Donation Form Button Href', 'arisen'),
						'subtitle' => esc_html__('Enter donation form href with # (Ex: #give-form-355-wrap):', 'arisen'),
						'desc'     => esc_html__('This is form parent div id, this div open in lightbox pop-up', 'arisen'),
						'default'  => '#give-form-355-wrap',
					),
					
					array(
						'id'          => 'blog_breadcrumb_font',
						'type'        => 'typography',
						'title'    => esc_html__( 'Blog Header Breadcrumb Menu Font Style', 'arisen' ),                
						'font-backup' => true,               
						'all_styles'  => true,
						'output'      => array( 'html #crumbs, #crumbs a, #crumbs span' ), 
						'units'       => 'px',
						'subtitle' => esc_html__( 'Change blog breadcrumb menu title text font properties (default: #ffffff):', 'arisen' ),
						'default'     => array(
							'google'     => true,
							'color'      => '#ffffff',
						   'font-style'  => '500',
							'font-family' => 'Lato',                    
							'font-size'   => '15px',				
						),
					),	
				)
			);
			
			$this->sections[] = array(
				'title'      => esc_html__( 'Blog Single & List', 'arisen' ),
				'id'         => 'blog_single',
				'desc'       => esc_html__( 'Enable or Disable single and list blog settings :', 'arisen' ),
				'subsection' => true,
				'fields'     => array( 
					array(
						'id'      => 'blog_title',
						'type'    => 'switch',
						'title'   => esc_html__( 'Blog Title', 'arisen' ),
						'default' => true,
					),
					array(
						'id'      => 'blog_author',
						'type'    => 'switch',
						'title'   => esc_html__( 'Blog Author Name', 'arisen' ),
						'default' => true,
					),
					array(
						'id'      => 'blog_comments',
						'type'    => 'switch',
						'title'   => esc_html__( 'Blog Comments Count', 'arisen' ),
						'default' => true,
					),
					array(
						'id'      => 'blog_date',
						'type'    => 'switch',
						'title'   => esc_html__( 'Blog Modified Date', 'arisen' ),
						'default' => true,
					),
					array(
						'id'      => 'categories_list',
						'type'    => 'switch',
						'title'   => esc_html__( 'Blog Categories List', 'arisen' ),
						'default' => true,
					),
					array(
						'id'      => 'tags_list',
						'type'    => 'switch',
						'title'   => esc_html__( 'Blog Tags List', 'arisen' ),
						'default' => true,
					),
					array(
						'id'      => 'more_option',
						'type'    => 'button_set',
						'title'   => esc_html__( 'Blog Excerpt Read More Type Button/Link', 'arisen' ),
						'options' => array(					
							'button'     => esc_html__( 'Button', 'arisen' ),
							'link'       => esc_html__( 'Link', 'arisen' ),					
						),
						'default' => 'button'
					),
					array(
						'id'      => 'blog_more_button',
						'type'    => 'switch',
						'title'   => esc_html__( 'Blog Excerpt Button/Link', 'arisen' ),
						'default' => true,
					),				
					array(
						'id'      => 'blog_single_pagination',
						'type'    => 'switch',
						'title'   => esc_html__( 'Single Blog Pagination', 'arisen' ),
						'default' => true,
					),
					array(
						'id'      => 'blog_pagination',
						'type'    => 'switch',
						'title'   => esc_html__( 'List Blog Pagination', 'arisen' ),
						'default' => true,
					)	
				)
			);
				
			$this->sections[] = array(
				'title'      => esc_html__( 'Blog Grid', 'arisen' ),
				'id'         => 'blog_grid',
				'desc'       => esc_html__( 'Enable or Disable blog grid page settings :', 'arisen' ),
				'subsection' => true,
				'fields'     => array( 
					array(
						'id'      => 'grid_blog_title',
						'type'    => 'switch',
						'title'   => esc_html__( 'Grid Blog Title', 'arisen' ),
						'default' => true,
					),
					array(
						'id'      => 'grid_blog_author',
						'type'    => 'switch',
						'title'   => esc_html__( 'Grid Blog Author Name', 'arisen' ),
						'default' => true,
					),		
					array(
						'id'      => 'grid_blog_date',
						'type'    => 'switch',
						'title'   => esc_html__( 'Grid Blog Modified Date', 'arisen' ),
						'default' => true,
					),
					array(
						'id'      => 'grid_more_option',
						'type'    => 'button_set',
						'title'   => esc_html__( 'Grid Blog Excerpt Read More Type Button/Link', 'arisen' ),
						'options' => array(					
							'button'     => esc_html__( 'Button', 'arisen' ),
							'link'       => esc_html__( 'Link', 'arisen' ),					
						),
						'default' => 'button'
					),
					array(
						'id'      => 'grid_blog_more_button',
						'type'    => 'switch',
						'title'   => esc_html__( 'Grid Blog Excerpt Button/Link', 'arisen' ),
						'default' => true,
					),
					array(
						'id'      => 'grid_blog_excerpt_length',
						'type'    => 'spinner',
						'title'   => esc_html__( 'Blog List Excerpt Length', 'arisen' ),
						'default'  => '200',
						'min'      => '100',
						'step'     => '10',
						'max'      => '700',
					),	
				)
			);
			
			$this->sections[] = array(
				'title'      => esc_html__( 'Blog Audio BG', 'arisen' ),
				'id'         => 'blog_audio_bg_optn',				
				'subsection' => true,
				'fields'     => array( 
					array(
						'id'        => 'audio_background',
						'type'      => 'background',						
						'title'     => esc_html__('Audio post Background Image', 'arisen'),						
						'subtitle'  => esc_html__('Change uploaded audio background(image should be max-1000x600 pixel).', 'arisen'),
						'output'    => array('.post_format-post-format-audio #audio-div audio, .post_format-post-format-audio #audio-div-2col audio, .post_format-post-format-audio #audio-div-3col audio, .post_format-post-format-audio #audio-div-4col audio'),
						'transparent' => true,
						'preview_media' => true,
						'preview' => false,						
						'default'   => array(						
							'background-position' => 'center center',
							'background-size' => 'cover',
							'background-repeat' => 'no-repeat',
							'background-image' => get_template_directory_uri() .'/assets/images/audio_bg.jpg',
						),	
					),			
				)
			);	
			
			// -> START Footer Fields
			$this->sections[] = array(
				'title' => esc_html__( 'Footer', 'arisen' ),
				'id'    => 'footer',
				'icon'  => 'el-icon-map-marker-alt'
			);
	
			$this->sections[] = array(
				'title'   => esc_html__( 'Footer Widget Top', 'arisen' ),
				'desc'    => '',		
				'subsection' => true,
				'fields'  => array(
					array(
						'id'      => 'footer_top',
						'type'    => 'switch',
						'title'   => esc_html__( 'Enable footer top widgets area', 'arisen' ),
						'default' => true,
					),
					array(
						'id'      => 'footer_top_bg',
						'type'    => 'color',
						'title'   => esc_html__( 'Footer Top Widget Background Color', 'arisen' ),
						'output'    => array('background-color' => '#footer_top'),
						'default'   => '#333333',
					),
					array(
						'id'       => 'footer_top_columns',
						'type'     => 'button_set',
						'title'    => esc_html__( 'Footer Top Widget Columns', 'arisen' ),
						'desc'     => esc_html__( 'Select the number of columns to display in the footer.', 'arisen' ),
						'type'     => 'button_set',
						'default'  => '4',
						'required' => array( 'footer_top', '=', true, ),
						'options'  => array(
							'1' => esc_html__( '1 Column', 'arisen' ),
							'2' => esc_html__( '2 Columns', 'arisen' ),
							'3' => esc_html__( '3 Columns', 'arisen' ),
							'4' => esc_html__( '4 Columns', 'arisen' ),
						),
					),
				)
			);
			
			$this->sections[] = array(
				'title'      => esc_html__( 'Footer Copyright', 'arisen' ),
				'id'         => 'opt_copyright',
				'desc'       => esc_html__( 'Change Copyright Text, Font Styles:', 'arisen' ),
				'subsection' => true,
				'fields'     => array( 
					array(
						'id'        => 'copyright_background',
						'type'      => 'color',	
						//'output'    => array('html .site-generator'),				
						'title'     => esc_html__('Copyright Background Color', 'arisen'),
						'subtitle'  => esc_html__('Change the copyright section background color (default: #333333).', 'arisen'),
						'default'   => '#333333',
						'transparent' => false,
						'validate'  => 'color',
					),
					array(
						'id'        => 'copyright_textarea',
						'type'      => 'editor',
						'title'     => esc_html__('Footer Copyright Text', 'arisen'),
						'subtitle'  => esc_html__('Change copyright text in editor. For ex: Copyright 2016 | My website.', 'arisen'),
						'default'   => 'Copyright &copy; 2017, All rights reserved',
					), 
					array(
						'id'          => 'foo_copyright_font',
						'type'        => 'typography',
						'title'    => esc_html__( 'Footer Copyright Font Style', 'arisen' ),                
						'font-backup' => true,               
						'all_styles'  => true,
						'output'      => array( 'html .site-generator .copyright-text' ), 
						'units'       => 'px',
						'subtitle' => esc_html__( 'Change the copyright text font properties (default: #ffffff):', 'arisen' ),
						'text-align'=> false,
						'subsets'   => true,
						'font-weight' => false,
						'default'     => array(
						   'google'      => true,
							'color'       => '#ffffff',                   
							'font-family' => 'Open Sans',                    
							'font-size'   => '14px',
							'line-height' => '24px',
						),
					),
				)
			);  
		}
        

        /**

          All the possible arguments for Redux.
          For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments

         * */
        public function setArguments() {

            $theme = wp_get_theme(); // For use with some settings. Not necessary.

            $this->args = array(
                // TYPICAL -> Change these values as you need/desire
                'opt_name'          => 'arisen_redux_optns',            // This is where your data is stored in the database and also becomes your global variable name.
                'display_name'      => $theme->get('Name'),     // Name that appears at the top of your panel
                'display_version'   => $theme->get('Version'),  // Version that appears at the top of your panel
                'menu_type'         => 'menu',                  //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                'allow_sub_menu'    => true,                    // Show the sections below the admin menu item or not
                'menu_title'        => esc_html__('Theme Options', 'arisen'),
                'page_title'        => esc_html__('Theme Options', 'arisen'),
                
                // You will need to generate a Google API key to use this feature.
                // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                'google_api_key' => '', // Must be defined to add google fonts to the typography module
                
                'async_typography'  => false,                    // Use a asynchronous font on the front end or font string
                'admin_bar'         => true,                    // Show the panel pages on the admin bar
                'global_variable'   => '',                      // Set a different name for your global variable other than the opt_name
                'dev_mode'          => false,                    // Show the time the page took to load, etc
                'customizer'        => true,                    // Enable basic customizer support 
                
                // CAREFUL -> These options are for advanced use only
                'transient_time'    => 60 * MINUTE_IN_SECONDS,
                'output'            => true,                    // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
                'output_tag'        => true,                    // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
                // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.
                
                // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
                'database'              => '', // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
                'show_import_export'    => true, // REMOVE
                'system_info'           => false, // REMOVE

                // HINTS
                'hints' => array(
                    'icon'          => 'icon-question-sign',
                    'icon_position' => 'right',
                    'icon_color'    => 'lightgray',
                    'icon_size'     => 'normal',
                    'tip_style'     => array(
                        'color'         => 'light',
                        'shadow'        => true,
                        'rounded'       => false,
                        'style'         => '',
                    ),
                    'tip_position'  => array(
                        'my' => 'top left',
                        'at' => 'bottom right',
                    ),
                    'tip_effect'    => array(
                        'show'          => array(
                            'effect'        => 'slide',
                            'duration'      => '500',
                            'event'         => 'mouseover',
                        ),
                        'hide'      => array(
                            'effect'    => 'slide',
                            'duration'  => '500',
                            'event'     => 'click mouseleave',
                        ),
                    ),
                )
            );


            // SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
            $this->args['share_icons'][] = array(
                'url'   => '',
                'title' => '',
                'icon'  => 'el-icon-envelope'
                //'img'   => '', // You can use icon OR img. IMG needs to be a full URL.
            );
            $this->args['share_icons'][] = array(
                'url'   => 'http://themeforest.net',
                'title' => 'Theme Official Page',
                'icon'  => 'el-icon-link'
            );
            $this->args['share_icons'][] = array(
                'url'   => 'http://twitter.com/',
                'title' => 'Follow on Twitter',
                'icon'  => 'el-icon-twitter'
            );

        }

    }
    
    global $reduxConfig;
    $reduxConfig = new Redux_Framework_sample_config();
}

/**
  Custom function for the callback referenced above
 */
if (!function_exists('redux_my_custom_field')):
    function redux_my_custom_field($field, $value) {
        print_r($field);
        echo '<br/>';
        print_r($value);
    }
endif;


/**
  Custom function for the callback validation referenced above
 * */
if (!function_exists('redux_validate_callback_function')):
    function redux_validate_callback_function($field, $value, $existing_value) {
        $error = false;
        $value = 'just testing';

        /*
          do your validation

          if(something) {
            $value = $value;
          } elseif(something else) {
            $error = true;
            $value = $existing_value;
            $field['msg'] = 'your custom error message';
          }
         */

        $return['value'] = $value;
        if ($error == true) {
            $return['error'] = $field;
        }
        return $return;
    }
endif;