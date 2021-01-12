<?php
/**
 * The Template for displaying 404 error
 *
 * @package WordPress
 * @subpackage Arisen
 * @since Arisen 1.0
 */

get_header(); ?>

	<section class="blog-section" >
		<h2 class="empty-tags">&nbsp;</h2>
		<div class="container">
			<div class="row">
				<div id="primary" class="col-md-offset-1 col-md-10 no-sidebar">

					<div class="error-404 not-found">
						<header class="entry-header">
							<h1 class="entry-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'arisen' ); ?></h1>
						</header><!-- .page-header -->

						<div class="entry-content">
							<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try a search?', 'arisen' ); ?></p>

							<?php get_search_form(); ?>
						</div><!-- .page-content -->
					</div><!-- .error-404 -->

				</div>
			</div>
		</div>
	</section><!-- .content-area -->

<?php get_footer(); ?>