<?php
	/* All blog list layout selection in redux option
	*  Layout types:
	   * Single with sidebar, Single without sidebar, 2 Column, 3 Column, 4 Column, Full width
	*/

	global $arisen_redux_optns, $arisen_sbar;
	if(is_home()){ // if blog list page
		global $arisen_blogsbar, $arisen_num_column, $arisen_blog_type, $arisen_grid_col, $arisen_width, $arisen_height, $arisen_awidth, $arisen_aheight, $arisen_vwidth, $arisen_vheight, $arisen_slider_img_sizes, $arisen_gallery_img_sizes, $arisen_featured_img_sizes, $arisen_col;

		if(isset($arisen_redux_optns['blog_list_layout'])) {
			if($arisen_redux_optns['blog_list_layout'] == '2-col-grid'){ //2 Column
				$arisen_blog_type = '2-col';
				$arisen_num_column = 2;
				$arisen_blogsbar = '';
				$arisen_sbar = 'no-sidebar';

				$arisen_grid_col = 'col-md-6 col-sm-6 column-2-grid '; //2-column grid layout
				$arisen_width = 518; $arisen_height = 320;
				$arisen_vwidth = '518px'; $arisen_vheight = '320px';
				$arisen_awidth = '518px'; $arisen_aheight = '320px';
				$arisen_slider_img_sizes = 'arisen-2col-grid-thumb';
				$arisen_gallery_img_sizes = 'arisen-blog-2col-grid-gallery';
				$arisen_featured_img_sizes = 'arisen-2col-grid-thumb';
				$arisen_col = '2col';
			}
			else if($arisen_redux_optns['blog_list_layout'] == '3-col-grid'){ //3 Column
				$arisen_blog_type = '3-col';
				$arisen_num_column = 3;
				$arisen_blogsbar = '';
				$arisen_sbar = 'no-sidebar';

				$arisen_grid_col = 'col-md-4 col-sm-4 column-3-grid '; //3-column grid layout				
				$arisen_width = 320; $arisen_height = 194;
				$arisen_vwidth = '320px'; $arisen_vheight = '194px';
				$arisen_awidth = '320px'; $arisen_aheight = '194px';
				$arisen_slider_img_sizes = 'arisen-3col-grid-slider-thumb';
				$arisen_gallery_img_sizes = 'arisen-blog-3col-grid-gallery';
				$arisen_featured_img_sizes = 'arisen-3col-grid-thumb';
				$arisen_col = '3col';
			}
			else if($arisen_redux_optns['blog_list_layout'] == '3-col-masonry'){ //3 Column	masonry
				$arisen_blog_type = '3-col-masonry';
				$arisen_num_column = 3;
				$arisen_blogsbar = '';
				$arisen_sbar = 'no-sidebar';

				$arisen_grid_col = 'column-3-grid items ';   //3-column masonry layout
				$arisen_width = 320; $arisen_height = 194;
				$arisen_vwidth = '320px'; $arisen_vheight = '194px';
				$arisen_awidth = '320px'; $arisen_aheight = '194px';
				$arisen_slider_img_sizes = 'arisen-3col-grid-slider-thumb';
				$arisen_gallery_img_sizes = 'arisen-blog-3col-grid-gallery';
				$arisen_featured_img_sizes = 'arisen-3col-grid-thumb';
				$arisen_col = '3col';
			}
			else if($arisen_redux_optns['blog_list_layout'] == 'sidebar-left'){
				$arisen_blog_type = '1-col';
				$arisen_num_column = 1;
				$arisen_blogsbar = 'col-md-8 sidebar-left'; //left sidebar
				$arisen_sbar = '';
			}
			else if($arisen_redux_optns['blog_list_layout'] == 'sidebar-right'){
				$arisen_blog_type = '1-col';
				$arisen_num_column = 1;
				$arisen_blogsbar = 'col-md-8 sidebar-right'; //right sidebar
				$arisen_sbar = '';
			}
			else if($arisen_redux_optns['blog_list_layout'] == 'no-sidebar'){ //without sidebar, full-width
				$arisen_blog_type = '1-col';
				$arisen_num_column = 1;
				$arisen_blogsbar = 'col-md-offset-1 col-md-10 no-sidebar';
				$arisen_sbar = 'no-sidebar';
				$arisen_grid_col=''; $arisen_width=''; $arisen_height=''; $arisen_slider_img_sizes=''; $arisen_gallery_img_sizes=''; $arisen_featured_img_sizes=''; $arisen_col='';
			}else{}
		}else{ //default right sidebar
			$arisen_blog_type = '1-col';
			$arisen_num_column = 1;
			$arisen_blogsbar = 'col-md-8 sidebar-right';
			$arisen_sbar = '';
			$arisen_grid_col=''; $arisen_width=''; $arisen_height=''; $arisen_slider_img_sizes=''; $arisen_gallery_img_sizes=''; $arisen_featured_img_sizes=''; $arisen_col='';
		}
	}else{
		/* Single blog layout selection in redux option
		*  Layout types:
		   * Left Sidebar, Right Sidebar, No Sidebar
		*/

		global $arisen_psbar;

		if(isset($arisen_redux_optns['blog_sidebar'])) {
			if($arisen_redux_optns['blog_sidebar'] == 'sidebar-left') {
				$arisen_psbar = 'col-md-8 sidebar-left'; //left sidebar
				$arisen_sbar = '';
			}
			else if($arisen_redux_optns['blog_sidebar'] == 'sidebar-right'){
				$arisen_psbar = 'col-md-8 sidebar-right'; //default right sidebar
				$arisen_sbar = '';
			}
			else if($arisen_redux_optns['blog_sidebar'] == 'no-sidebar'){
				$arisen_psbar = 'col-md-offset-1 col-md-10 no-sidebar'; //without sidebar, full-width
				$arisen_sbar = 'no-sidebar';
			}
		}else{
			$arisen_psbar = 'col-md-8 sidebar-right'; //default right sidebar
			$arisen_sbar = '';
		}
	}
?>