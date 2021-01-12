<?php
/**
 * The Template for displaying content in grid layout.
 *
 * @package WordPress
 * @subpackage Arisen
 * @since Arisen 1.0
 */

//featured video by upload - video format
$arisen_featured_video = get_post_meta(get_the_ID(), 'featured_video_upload-featured-video', true);

global $post, $arisen_redux_optns, $row_num, $arisen_blogsbar, $arisen_grid_col, $arisen_width, $arisen_height, $arisen_awidth, $arisen_aheight, $arisen_vwidth, $arisen_vheight, $arisen_slider_img_sizes, $arisen_gallery_img_sizes, $arisen_featured_img_sizes, $arisen_col, $arisen_blog_type;

//featured video youtube/vimeo text field value
$arisen_yt_vimo = get_post_meta($post->ID, 'my_meta_box_text', true);

//featured audio - audio format
$arisen_audio_type = get_post_meta( $post->ID, 'featured_audio_select-audio-type', true );
$arisen_audio_url = get_post_meta( $post->ID, 'featured_audio_insert-url', true );
$arisen_audio_upload = get_post_meta($post->ID,'featured_audio_upload-audio',true);

//Custom Post - Slider Post-Format
$arisen_slider_gal = array( 'post_type'=> 'slider', 'order' => 'ASC' );

//get post format either post or slider
$arisen_post_format = get_post_type();

get_template_part( 'post-formats/content', 'layout');
$arisen_classes = join( '  ', get_post_class() );

if ( $arisen_post_format == 'post' && has_post_format( 'gallery' )) :
	$entry_header_gallery = 'entry-header-gallery';
	$article_grid_gallery = 'article-grid-gallery';
else :
	$entry_header_gallery = '';
	$article_grid_gallery = '';
endif;
?>

<!-- All Posts lists in grid layout -->

<article id="<?php echo esc_attr($post->ID); ?>" class="<?php echo esc_attr($arisen_grid_col). esc_attr($arisen_classes); ?>">
	<div class="article-content article-bgcolor article-grid <?php echo esc_attr($article_grid_gallery); ?>">
		<div class="col3-grid">
	<?php if( !is_page() ):
				$title = get_the_title();
			?>

			<!-- BLOG TITLE START -->
			<?php
				if(isset($arisen_redux_optns['grid_blog_title'])) :
					 if($arisen_redux_optns['grid_blog_title'] == true) : 
						if (get_the_title()) :
						?>
						<div class="entry-header <?php echo esc_attr($entry_header_gallery); ?>">
							<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="permalink"><?php echo mb_strimwidth( $title, 0, 20, '...'); ?></a></h2>
						</div>
				<?php 	endif;
					endif;
				endif;
			?>
			<!-- BLOG TITLE END -->

			<?php
			/* ===== Slider Format ===== */
			 if( $arisen_post_format == 'slider' && !empty($arisen_slider_gal) ) :
				$images = get_post_meta($post->ID, 'post_slider_gallery', true);
				if(!empty($images)) :
				?>
				<div class="entry-attachment">
					<ul class="slider_grid">
					<?php
						foreach ($images as $image) :
							$image_attributes = wp_get_attachment_image_src( $image, $arisen_slider_img_sizes );
							$alt = $image_attributes[1].'x'.$image_attributes[2];
						?>
							<li><img src="<?php echo esc_url($image_attributes[0]); ?>" width="<?php echo esc_attr($image_attributes[1]); ?>" height="<?php echo esc_attr($image_attributes[2]); ?>" alt="<?php echo esc_attr($alt); ?>" /></li>
						<?php
						endforeach;
					?>
					</ul>
				</div>
			<?php
				endif;

			/* ===== Video Format ===== */
			elseif ( $arisen_post_format == 'post' && has_post_format( 'video' )) :

				if (!empty($arisen_featured_video)) :
					echo '<div id="video-div" class="entry-attachment"><video controls="controls" preload="auto"  style="width:'.esc_attr($arisen_vwidth).'; height:'.esc_attr($arisen_vheight).';">
							<source src="'. esc_url($arisen_featured_video). '" type="video/mp4" /></video></div>';
				elseif (empty($arisen_featured_video)) :
					echo the_post_thumbnail('full');
				endif;

				if(!empty($arisen_yt_vimo)) :
					if (get_post_meta($post->ID, 'my_video_type', true) == "youtube") :
						echo do_shortcode('[youtube id="'.get_post_meta($post->ID, 'my_meta_box_text', true).'" width="'. esc_attr($arisen_vwidth) .'" height="'. esc_attr($arisen_vheight) .'"]');
					endif;
					if (get_post_meta($post->ID, 'my_video_type', true) == "vimeo") :
						echo do_shortcode('[vimeo id="'.get_post_meta($post->ID, 'my_meta_box_text', true).'" width="'. esc_attr($arisen_vwidth) .'" height="'. esc_attr($arisen_vheight) .'"]');
					endif;
				endif;

			/* ===== Audio Format ===== */
			elseif ( $arisen_post_format == 'post' && has_post_format( 'audio' )) :
				if (!empty($arisen_audio_upload)) :
					echo '<div id="audio-div-'.$arisen_col.'" class="entry-attachment"><audio controls>
							<source src="'. esc_url($arisen_audio_upload). '" type="audio/ogg" /></audio></div>';
				endif;

				if(!empty($arisen_audio_url)) :
					if ($arisen_audio_type == "url") :
						echo do_shortcode('[url id="'.get_post_meta($post->ID, 'featured_audio_insert-url', true).'" width="'. esc_attr($arisen_awidth) .'" height="'. esc_attr($arisen_aheight) .'"] ');
					endif;
				endif;

			/* ===== Gallery Format ===== */
			elseif ( $arisen_post_format == 'post' && has_post_format( 'gallery' )) :
				$images = get_post_meta($post->ID, 'post_gallery', true);
				if(!empty($images)) :
				?>
				<div id="gallery-table" class="blog-gallery">
					<div class="row">
						<?php foreach (array_chunk($images, 3) as $row_set) : ?>

							<?php $i = 1;
							foreach ($row_set as $image) : ?>
								<div class="col-xs-6 col-sm-4 blog-gal-col gal-col-<?php echo esc_attr($i);?>">
									<?php $image_attributes = wp_get_attachment_image_src( $image, $arisen_gallery_img_sizes ); ?>
									<?php $alt = $image_attributes[1].'x'.$image_attributes[2]; ?>
									<img src="<?php echo esc_url($image_attributes[0]); ?>" width="<?php echo esc_attr($image_attributes[1]); ?>" height="<?php echo esc_attr($image_attributes[2]); ?>" alt="<?php echo esc_attr($alt); ?>" />
								</div>
								<?php $i++;
							endforeach; ?>

						<?php endforeach; ?>
					</div>
				</div>
				<?php
				endif;
			else :
			?>
				<!-- BLOG FEATURED IMAGE START -->
				<?php
					if ( has_post_thumbnail() ) :  ?>
						<div class="entry-attachment">
							<?php 
								$thumb_id = get_post_thumbnail_id($post->ID);
								$image_attributes = wp_get_attachment_image_src( $thumb_id, $arisen_featured_img_sizes ); 
								$alt = get_post_meta($thumb_id, '_wp_attachment_image_alt', true); 
							?>
							<img class="entry-img img-responsive" src="<?php echo esc_url($image_attributes[0]); ?>" width="<?php echo esc_attr($image_attributes[1]); ?>" height="<?php echo esc_attr($image_attributes[2]); ?>" alt="<?php echo esc_attr($alt); ?>" />
						</div>
						<!-- BLOG FEATURED IMAGE END -->
				<?php
					endif;
			endif;
			?>

			<?php
				if ( $arisen_post_format == 'post' && has_post_format( 'gallery' )) :
					$cls = 'gallery';
				else :
					$cls = '';
				endif;
			?>

			<div class="entry-meta-main <?php echo esc_attr($cls); ?>">
				<div class="entry-meta">
					<ul>
						<?php /* BLOG DATE */
							if(isset($arisen_redux_optns['grid_blog_date'])) :
								 if($arisen_redux_optns['grid_blog_date'] == true) : ?>
									<li><p><?php echo esc_html( get_the_date() ); ?></p></li>
						  <?php endif;
							endif;

							/* BLOG AUTHOR */
							if(isset($arisen_redux_optns['grid_blog_author'])) :
								if($arisen_redux_optns['grid_blog_author'] == true) : ?>
									<li><p><?php esc_html_e('- by', 'arisen'); ?> <span><?php the_author(); ?></span></p></li>
						  <?php endif;
							endif;
						?>
					</ul>
				</div>
			</div>

			<?php
				if(isset($arisen_redux_optns['grid_blog_excerpt_length']) && $arisen_redux_optns['grid_blog_excerpt_length'] != '') :
					$limit = $arisen_redux_optns['grid_blog_excerpt_length'];
				else:
					$limit = 200;
				endif;

				if($arisen_blog_type == '3-col-masonry') :
					if($row_num%2) : //odd;
					  $limit = 80;
					else : // even;
					  $limit = $limit;
					endif;
				endif;
			?>
			
			<?php if(!empty(get_the_content())) : ?>
				<div class="entry-content three-col-content">
					<p> <?php echo arisen_get_excerpt($limit);	?> </p>
				</div>
			<?php endif; ?>

			<?php
				if(isset($arisen_redux_optns['grid_more_option']) && isset($arisen_redux_optns['grid_blog_more_button'])) :
					if($arisen_redux_optns['grid_blog_more_button'] == true ) :
						if($arisen_redux_optns['grid_more_option'] == 'button') :
							$btn_class = 'btn';
							$btn_margin = 'btn-margin';
						else :
							$btn_class = '';
							$btn_margin = '';
						endif;
					?>
					<div class="readmore">
						<p class="<?php echo esc_attr($btn_margin); ?>"><a class="read-more-link <?php echo esc_attr($btn_class); ?>" href="<?php the_permalink(); ?>"><?php esc_html_e('Read More', 'arisen'); ?></a></p>
					</div>
					<?php
					endif;
				endif;
			endif;			
		 ?>
		</div>
	</div>
</article>