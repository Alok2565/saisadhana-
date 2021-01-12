<?php
/**
 * Template home page to display your latest blog posts
 *
 * @package WordPress
 * @subpackage Arisen
 * @since Arisen 1.0
 */

	get_header();
	//posts lists display depends upon layout selected in theme option
	get_template_part( 'template-parts/content', 'layout');
?>

	<section class="blog-section" >
		<h2 class="empty-tags">&nbsp;</h2>
		<div class="container">
			<div class="row">

				<div id="primary" class="<?php echo esc_attr($arisen_blogsbar) .' '. esc_attr($arisen_blog_type); ?>">

					<?php if ( have_posts() ) : ?>
					<?php

						$arisen_columns_num = $arisen_num_column; // The number of columns we want to display our posts
						$i = 0; //Counter for .row divs

						if($arisen_blog_type == '2-col' || $arisen_blog_type == '3-col') :
						?>
							<div class="row grid-row">
						<?php	
							while(have_posts()) :  the_post();

								get_template_part( 'post-formats/content', 'grid' );

								if($i % $arisen_columns_num == $arisen_columns_num - 1 ) :
								?>
									</div> <div class="row grid-row">
								<?php 
								endif;
								$i++;

							endwhile;
							?>
							</div>
						<?php
						elseif($arisen_blog_type == '3-col-masonry') : ?>
							<div class="row grid-row masonry">
						<?php	while(have_posts()) :  the_post();
							$row_num++;
								get_template_part( 'post-formats/content', 'grid' );
							endwhile; ?>
							</div>
						<?php
						else :

							while(have_posts()) :  the_post();
								$arisen_post_format = get_post_type();
								if($arisen_post_format == 'slider') :
									get_template_part( 'post-formats/content', 'slider' );
								else :
									get_template_part( 'post-formats/content', get_post_format() );
								endif;
							endwhile;

						endif;

						// Previous/next page navigation.
						if(isset($arisen_redux_optns['blog_pagination'])) :
							if($arisen_redux_optns['blog_pagination'] == true) :
								 arisen_pagination();
							endif;
						else:
							arisen_pagination();
						endif;

					// If no content, include the "No posts found" template.
					else :
						get_template_part( 'post-formats/content', 'none' );
					endif;
				?>
				</div>

			</div>
		</div>
	</section><!-- .content-area -->

<?php get_footer(); ?>