<?php
/**
 * The template for displaying the footer
 *
 * @package WordPress
 * @subpackage Arisen
 * @since Arisen 1.0
 */
?>

	</div><!-- #main -->
		<?php global $arisen_redux_optns; ?>
		<footer class="colophon copyright-foo">
			<div id="footer_widgets_wrapper">
				<?php get_template_part('template-parts/footer/footer-top'); ?>
			</div>
			<div class="site-generator">
				<div class="container">
					<span class="copyright-text">
						<?php if(isset($arisen_redux_optns['copyright_textarea']) && ($arisen_redux_optns['copyright_textarea'] !='')) : ?>
						<?php echo wp_kses_post($arisen_redux_optns['copyright_textarea']);  ?>
						<?php else : esc_html_e( 'Copyright &copy; 2017, All rights reserved', 'arisen' ); ?>
						<?php endif; ?>
					</span>
				</div>
			</div>
		</footer>

	<?php wp_footer(); ?>
</body>
</html>