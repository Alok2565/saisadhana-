<?php 
global $arisen_redux_optns;
/*---------------------------------------------------------*/
/*	Blog Read More Button or Link  - for Blog List Layout
/*---------------------------------------------------------*/
	if(isset($arisen_redux_optns['more_option']) && isset($arisen_redux_optns['blog_more_button'])) :		
		if($arisen_redux_optns['blog_more_button'] == true) :
			if($arisen_redux_optns['more_option'] == 'button') :
				$btn_class = 'btn';
				$btn_margin = 'btn-margin';
			else :
				$btn_class = '';
				$btn_margin = '';
			endif;		
		?>
			<div class="readmore">
				<p class="<?php echo esc_attr($btn_margin); ?>"><a class="read-more-link <?php echo esc_attr($btn_class); ?>" href="<?php the_permalink(); ?>"><?php esc_html_e('Read More', 'arisen'); ?></a></p>
			</div>	
		<?php 
		endif;
	else: ?>
		<div class="readmore">
			<p class="btn-margin"><a class="read-more-link btn" href="<?php the_permalink(); ?>"><?php esc_html_e('Read More', 'arisen'); ?></a></p>
		</div>	
	<?php 
	endif;
?>