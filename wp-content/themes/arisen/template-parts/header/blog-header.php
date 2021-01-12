<?php global $arisen_redux_optns; ?>
	<div class="container bg-overlay">
		<h2 class="blog-header-title">
			<?php if(isset($arisen_redux_optns['ch_blog_header_textarea']) && ($arisen_redux_optns['ch_blog_header_textarea'] !='')) : ?>
				<?php echo wp_kses_post($arisen_redux_optns['ch_blog_header_textarea']);  ?>
			<?php else : esc_html_e( 'Save the Kindness', 'arisen' ); ?>
			<?php endif; ?>
		</h2>
		<div class="center">
			<?php if(isset($arisen_redux_optns['ch_blog_header_btn_id']) && ($arisen_redux_optns['ch_blog_header_btn_id'] !='')) :
				$link_id = $arisen_redux_optns['ch_blog_header_btn_id'];
			else :
				$link_id = '#';
			endif; ?>

			<?php
				if(isset($arisen_redux_optns['blog_banner_button'])) :
					if($arisen_redux_optns['blog_banner_button'] == true) : ?>
						<div class="btn header-btn open-popup-link"><a href="<?php echo esc_attr($link_id); ?>"> <?php esc_html_e('Donate Now', 'arisen'); ?></a></div>
				<?php endif; ?>
				<?php else:	?>
					<div class="btn header-btn open-popup-link"><a href="<?php echo esc_attr($link_id); ?>"> <?php esc_html_e('Donate Now', 'arisen'); ?></a></div>				
				<?php endif; ?>

			<div class="donate-shortcode-div">
			<?php
				/* Blog Donation Form */
				if(isset($arisen_redux_optns['ch_blog_donation_form']) && ($arisen_redux_optns['ch_blog_donation_form'] !='')) :
					echo do_shortcode( $arisen_redux_optns['ch_blog_donation_form']);
				endif;
			?>
			</div>
		</div>
		<!-- BREADCRUMB START -->
		<div>
			<div class="crumb">
				<?php
					if(isset($arisen_redux_optns['blog_breadcrumb'])) :
						if($arisen_redux_optns['blog_breadcrumb'] == true) :
							arisen_breadcrumbs();
						endif;
					else:
						arisen_breadcrumbs();
					endif;
				?>
			</div>
		</div>
		<!-- BREADCRUMB END -->
	</div>