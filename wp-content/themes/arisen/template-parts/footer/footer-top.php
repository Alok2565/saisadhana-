<?php
	global $arisen_redux_optns;
	if ( is_active_sidebar( 'footer_top' ) ) : ?>
		<?php
		if(isset($arisen_redux_optns['footer_top'])) :
			if($arisen_redux_optns['footer_top'] == true) :
				$widget_areas = 'cols_'.$arisen_redux_optns['footer_top_columns'];

				if( ! $widget_areas ) :
					$widget_areas = 'cols_4';
				endif;
			?>
				<div id="footer_top" class="clearfix">
					<div class="container">
						<div class="widgets foo-widgets-wrap <?php echo esc_attr( $widget_areas ); ?>">
							<?php dynamic_sidebar( 'footer_top' ); ?>
						</div>
					</div>
				</div>
			<?php
			endif;
		else:	
		?>			
		<div id="footer_top" class="clearfix">
			<div class="container">
				<div class="widgets foo-widgets-wrap cols_4">
					<?php dynamic_sidebar( 'footer_top' ); ?>		
				</div>
			</div>
		</div>
		
		<?php	
		endif;
	else: ?>
		<!-- Default Widgets -->
		<div id="footer_top" class="clearfix">
			<div class="container">
				<div class="widgets foo-widgets-wrap cols_4">
					<div class="col-sm-3">
						<?php the_widget( 'WP_Widget_Recent_Posts' ); ?>
					</div>
					
					<div class="col-sm-3">
						<?php the_widget( 'WP_Widget_Recent_Comments' ); ?>
					</div>
					
					<div class="col-sm-3">
						<?php the_widget( 'WP_Widget_Tag_Cloud' ); ?>
					</div>
					
					<div class="col-sm-3">
						<?php the_widget( 'WP_Widget_Archives' ); ?>
					</div>					
				</div>
			</div>
		</div>		
	<?php	
	endif;
?>