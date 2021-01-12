<?php
/**
 * The template for displaying all posts selected by tag name
 *
 * @package WordPress
 * @subpackage Arisen
 * @since Arisen 1.0
 */

	get_header();
	get_template_part( 'post-formats/content', 'layout');
?>

	<section class="blog-section" >
		<h2 class="empty-tags">&nbsp;</h2>
		<div class="container">
			<div class="row">

				<div id="primary" class="<?php echo esc_attr($arisen_psbar); ?>">

						<?php if ( have_posts() ) : ?>
							<?php
							// Start the loop.
							while ( have_posts() ) : the_post();

								/*
								 * Include the Post-Format-specific template for the content.
								 * If you want to override this in a child theme, then include a file
								 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
								 */
								$arisen_post_format = get_post_type();
								if($arisen_post_format == 'slider'):
									get_template_part( 'post-formats/content', 'slider' );
								else :
									get_template_part( 'post-formats/content', get_post_format() );
								endif;

							// End the loop.
							endwhile;

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
				<?php get_sidebar('main');?>
			</div>
		</div>
	</section><!-- .content-area -->

<?php get_footer(); ?>