<?php
/**
 * The Template for displaying single page content. Including index/archive/search.
 *
 * @package WordPress
 * @subpackage Arisen
 * @since Arisen 1.0
 */

global $post, $arisen_redux_optns;
$arisen_post_format = get_post_type(); //get post format either post or slider
$arisen_classes = join( '  ', get_post_class() );
?>
<!-- Single Post -->
<article id="<?php echo esc_attr($post->ID); ?>" class="<?php echo esc_attr($arisen_classes); ?>">
	<div class="single-post">

		<div class="article-content article-bgcolor article-space">

			<!-- BLOG TITLE START -->
			<?php
				if(isset($arisen_redux_optns['blog_title'])) :
					if($arisen_redux_optns['blog_title'] == true) :
						if (get_the_title()) :
					?>
							<div class="entry-header">
								<h2 class="entry-title blog-title"><a href="<?php the_permalink() ?>" class="permalink"><?php the_title(); ?></a></h2>
							</div>
			  <?php 	endif; 
					endif;
				else: 
					if (get_the_title()) :
				?>
					<div class="entry-header">
						<h2 class="entry-title blog-title"><a href="<?php the_permalink() ?>" class="permalink"><?php the_title(); ?></a></h2>
					</div>
				<?php endif;
				endif;
			?>
			<!-- BLOG TITLE END -->

			<!-- BLOG ATTACHMENT START -->
			<?php
			if ( $arisen_post_format == 'post' && has_post_format( 'video' )) : //Video Format

				$arisen_featured_video = get_post_meta(get_the_ID(), 'featured_video_upload-featured-video', true); //featured video by upload - video format
				$arisen_yt_vimo = get_post_meta($post->ID, 'my_meta_box_text', true);	//featured video youtube/vimeo text field value

				if (!empty($arisen_featured_video))  :
					echo '<div id="video-div" class="entry-attachment"><video controls="controls" preload="auto" style="width:100%; height:100%;">
							<source src="'. esc_url($arisen_featured_video). '" type="video/mp4" /></video></div>';						
				endif;

				if(!empty($arisen_yt_vimo)) :
					if (get_post_meta($post->ID, 'my_video_type', true) == "youtube") :
						echo do_shortcode('[youtube id="'.get_post_meta($post->ID, 'my_meta_box_text', true).'" width="100%" height="400px"]');
					endif;
					if (get_post_meta($post->ID, 'my_video_type', true) == "vimeo") :
						echo do_shortcode('[vimeo id="'.get_post_meta($post->ID, 'my_meta_box_text', true).'" width="100%" height="400px"]');
					endif;
				endif;

				if(empty($arisen_featured_video) && empty($arisen_yt_vimo)) :
			?>
				<!-- BLOG FEATURED IMAGE START -->
				<?php
					if ( has_post_thumbnail() ) :

						$arisen_attch_img_id = get_post_thumbnail_id($post->ID);
						$arisen_attch_img_alt = get_post_meta($arisen_attch_img_id, '_wp_attachment_image_alt', true);
						$arisen_attch_img_url = wp_get_attachment_url($arisen_attch_img_id);
						$arisen_attch_img_attr = wp_get_attachment_image_src($arisen_attch_img_id, 'arisen-blog-thumb');
					?>
						<div class="entry-attachment blog-image">
							<img class="entry-img img-responsive" src="<?php echo esc_url($arisen_attch_img_url); ?>" width="<?php echo esc_attr($arisen_attch_img_attr[1]);?>"  alt="<?php echo esc_attr($arisen_attch_img_alt); ?>" />
						</div>
						<!-- BLOG FEATURED IMAGE END -->
				<?php
					endif;
				endif;
			endif;
			?>
			<!-- BLOG ATTACHMENT END -->

			<!-- BLOG ENTRY META -->
			<?php get_template_part( 'template-parts/entry-meta' ); ?>

			<!-- BLOG ENTRY CONTENT -->
			<?php get_template_part( 'template-parts/entry-content' ); ?>			
			
		</div><!-- BLOG END -->
	</div>
</article>