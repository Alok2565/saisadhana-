<?php 
/*
Template Name: Full Width
*/
get_header(); ?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<div class="centered-wrapper">
			<section class="percent-page">
				<h2 class="empty-tags">&nbsp;</h2>
				<article id="page-<?php esc_attr(the_ID()); ?>" <?php post_class('begin-content'); ?>>
					<div class="page-entry-content">
						<h2 class="empty-tags">&nbsp;</h2>					
						<?php the_content(); ?>
					</div>
				</article>
			</section>
		</div><!--end centered-wrapper-->

	<?php endwhile; ?>
	<?php endif; ?>
<?php get_footer(); ?>