<?php
/**
 * The Template for displaying pages
 *
 * @package WordPress
 * @subpackage Arisen
 * @since Arisen 1.0
 */

get_header();
get_template_part( 'post-formats/content', 'layout');
/* This page used to show single post(blog) */
?>

	<div class="blog-section">
		<h2 class="empty-tags">&nbsp;</h2>
		<div class="container">
			<div class="row">
				<div id="primary" class="<?php echo esc_attr($arisen_psbar); ?>">
					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
						
						<!--  -->
						<article id="<?php echo esc_attr($post->ID); ?>" <?php post_class(); ?>>
							<div class="single-post">
								<div class="article-content article-bgcolor article-space">
									<div class="entry-header page-title">
										<h2 class="entry-title blog-title"><?php the_title(); ?></h2>
									</div>
									<div class="page-entry-content">
										<h2 class="empty-tags">&nbsp;</h2>					
										<?php the_content(); ?>
									</div>
								</div><!--  -->
							</div>
						</article>
						
						<?php
							if ( comments_open() || get_comments_number() ) :
								comments_template();
							endif;						
						?>
						
					<?php endwhile; ?>
					<?php endif; ?>

				</div>
				<?php get_sidebar();?>
			</div>
		</div>
	</div><!-- .content-area -->

<?php get_footer(); ?>