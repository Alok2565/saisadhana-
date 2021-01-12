<?php
/**
 * The Template for displaying bio about the author
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

					<?php $curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author)); ?>

					<h2><?php esc_html_e('About:', 'arisen'); ?> <?php echo esc_html($curauth->nickname); ?></h2>
					<dl>
						<dt><?php esc_html_e('Website', 'arisen'); ?></dt>
						<dd><a href="<?php echo esc_url($curauth->user_url); ?>"><?php echo esc_url($curauth->user_url); ?></a></dd>
						<dt><?php esc_html_e('Profile', 'arisen'); ?></dt>
						<dd><?php echo esc_html($curauth->user_description); ?></dd>
					</dl>

					<h2><?php esc_html_e('Posts by', 'arisen'); ?> <?php echo esc_html($curauth->nickname); ?></h2>


					<ul>
					<!-- The Loop -->

					<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
						<li>
							<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link: <?php the_title(); ?>">
							<?php the_title(); ?></a>,
							<?php esc_html(get_the_date('M j, Y')); ?> <?php esc_html_e('in', 'arisen'); ?> <?php the_category('&');?>
						</li>

					<?php endwhile; else: ?>
						<p><?php esc_html_e('No posts by this author.', 'arisen'); ?></p>

					<?php endif; ?>

					<!-- End Loop -->

					</ul>

				</div>

				<?php get_sidebar();?>
			</div>
		</div>
	</section><!-- .content-area -->

<?php get_footer(); ?>