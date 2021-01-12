<?php
/**
 * The Template for displaying content. Including index/archive/search.
 *
 * @package WordPress
 * @subpackage Arisen
 * @since Arisen 1.0
 */

global $post, $arisen_redux_optns;
?>
<!-- All Standard Posts lists -->
<article id="<?php echo esc_attr($post->ID); ?>" <?php post_class(); ?>>

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
			<?php endif; ?>

			<!-- BLOG ENTRY META -->
			<?php get_template_part( 'template-parts/entry-meta' ); ?>

			<!-- BLOG ENTRY CONTENT -->
			<?php get_template_part( 'template-parts/entry-content' ); ?>				
			
		</div><!-- BLOG END -->
	</div>
</article>