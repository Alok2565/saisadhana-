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

		<div class="article-content article-bgcolor article-gallery">

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
			 if ( $arisen_post_format == 'post' && has_post_format( 'gallery' )) : //Gallery Format
				$arisen_images = get_post_meta($post->ID, 'post_gallery', true);					
				if(!empty($arisen_images)) : 
				?>
					<div id="gallery-table" class="blog-gallery">
						<div class="row">
							<?php foreach (array_chunk($arisen_images, 3) as $row_set) :
								$i = 1;
								foreach ($row_set as $image): ?>
									<div class="col-xs-6 col-sm-4 blog-gal-col gal-col-<?php echo esc_attr($i);?>">
										<?php 
											$arisen_image_attributes = wp_get_attachment_image_src( $image, 'arisen-full-size' ); 
											$arisen_image_alt = $arisen_image_attributes[1].'x'.$arisen_image_attributes[2];	
										?>
										<img src="<?php echo esc_url($arisen_image_attributes[0]); ?>" width="<?php echo esc_attr($arisen_image_attributes[1]); ?>" height="<?php echo esc_attr($arisen_image_attributes[2]); ?>" alt="<?php echo esc_attr($arisen_image_alt); ?>" />
									</div>
								<?php $i++;
								endforeach;
							endforeach; ?>
						</div>
					</div>
					<?php
				else :
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