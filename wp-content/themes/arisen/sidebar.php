<?php
/**
 * The sidebar containing the main widget area
 *
 * @package WordPress
 * @subpackage Arisen
 * @since Arisen 1.0
 */

if ( has_nav_menu( 'primary' ) || has_nav_menu( 'social' ) || is_active_sidebar( 'sidebar-1' )  ) : ?>
	<?php
		get_template_part( 'post-formats/content', 'layout');
		global $arisen_sbar;
	?>
	<div id="secondary" class="col-md-4 <?php echo esc_attr($arisen_sbar); ?>">
		<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
			<div class="widget-area">
				<?php dynamic_sidebar( 'sidebar-1' ); ?>
			</div><!-- .widget-area -->
		<?php endif; ?>

	</div>

<?php endif; ?>