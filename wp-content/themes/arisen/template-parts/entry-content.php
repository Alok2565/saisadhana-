<?php 
global $arisen_redux_optns;
/*---------------------------------------------------------*/
/*	Blog Entry Content - for Blog List Layout
/*---------------------------------------------------------*/

if(is_single()) :
	$thecontent = get_the_content();
	if(!empty($thecontent)) : ?>
		<div class="entry-content">
			<?php the_content(); ?>
			
			<!-- SINGLE PAGE LINKS  -->
			<?php
				wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'arisen' ) . '</span>', 'after' => '</div>', 'link_before' => '<span class="current-page">', 'link_after' => '</span>' ) );
			?>
		</div>
	<?php endif;
else:	
	?>
	
	<!-- POST EXCERPT -->
	<?php if(has_excerpt()): ?>
		<div class="entry-content">
			<?php the_excerpt(); ?>		
		</div>
	<?php		
	elseif(get_the_content() != ''): ?>
		<!-- POST CONTENT -->
		<div class="entry-content">
			<?php the_content(); ?>		
		</div>
	<?php
	endif; ?>	

	<?php get_template_part( 'template-parts/excerpt-read-more' ); ?>
	<!-- BLOG CONTENT END -->
<?php
endif;
?>