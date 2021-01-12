<?php 
global $arisen_redux_optns;
/*---------------------------------------------------------*/
/*	Blog Entry Meta - for Blog List Layout
/*---------------------------------------------------------*/
?>
<div class="entry-meta-main">
	<?php /* BLOG COMMENTS COUNT */
		if(isset($arisen_redux_optns['blog_comments'])) :
			 if($arisen_redux_optns['blog_comments'] == true) :
			?>
				<div class="entry-meta main-comments">					
					<span><i class="fa fa-comments"></i><?php comments_number(); ?></span>
				</div>
	  <?php endif;
		else:
		?>
			<div class="entry-meta main-comments">
				<div class="entry-meta main-comments">					
					<span><i class="fa fa-comments"></i><?php comments_number(); ?></span>
				</div>
			</div>
	  <?php
		endif;
	?>

	<?php /* BLOG AUTHOR NAME */
		if(isset($arisen_redux_optns['blog_author'])) :
			 if($arisen_redux_optns['blog_author'] == true) :
			?>
				<div class="entry-meta main-author">
					<span><i class="fa fa-user"></i><?php the_author(); ?></span>
				</div>
	  <?php endif;
		else: ?>
			<div class="entry-meta main-author">
				<div class="entry-meta main-author">
					<span><i class="fa fa-user"></i><?php the_author(); ?></span>
				</div>
			</div>
		<?php endif;
	?>

	<?php /* BLOG MODIFIED DATE */
		if(isset($arisen_redux_optns['blog_date'])) :
			 if($arisen_redux_optns['blog_date'] == true) :
			?>
				<div class="entry-meta main-date">					
					<span><i class="fa fa-calendar"></i><?php echo esc_html( get_the_date() ); ?></span>
				</div>
	  <?php endif;
		else: ?>
			<div class="entry-meta main-date">
				<div class="entry-meta main-date">					
					<span><i class="fa fa-calendar"></i><?php echo esc_html( get_the_date() ); ?></span>
				</div>
			</div>
		<?php endif;
	?>

<!-- TAGS &  CATEGORIES LIST IN PAGE SINGLE -->
<?php if(is_single()):  ?>
		
	<!-- CATEGORIES LIST -->
	<?php if(isset($arisen_redux_optns['categories_list'])):
				if( $arisen_redux_optns['categories_list'] == true) : ?>
				<div class="entry-meta entry-categories">
				<?php
					$wp_categories_list = get_the_category_list( __( ', ', 'arisen' ) );
					if ( $wp_categories_list ) {
						echo '<i class="fa fa-folder-open"></i><span class="categories-links">' . $wp_categories_list . '</span>';
					}
				?>
				</div>
				<?php endif; ?>
		<?php else: ?>
			<div class="entry-meta entry-categories">
				<?php
				$wp_categories_list = get_the_category_list( __( ', ', 'arisen' ) );
				if ( $wp_categories_list ) {
					echo '<i class="fa fa-folder-open"></i><span class="categories-links">' . $wp_categories_list . '</span>';
				}
			?>
			</div>
	<?php endif; ?>

	<!-- TAGS LIST -->	
	<?php if(isset($arisen_redux_optns['tags_list'])):
				if( $arisen_redux_optns['tags_list'] == true) : ?>	
					<div class="entry-meta entry-tags">		
					<?php 
						$wp_tag_list = get_the_tag_list( '', __( ', ', 'arisen' ) );  
						if ( $wp_tag_list ) {
							echo '<i class="fa fa-tags"></i><span class="tags-links">' . $wp_tag_list . '</span>';
						}
					?>
					</div>
			<?php endif; ?>
		<?php else: ?>
				<div class="entry-meta entry-tags">		
					<?php 
					$wp_tag_list = get_the_tag_list( '', __( ', ', 'arisen' ) );  
					if ( $wp_tag_list ) {
						echo '<i class="fa fa-tags"></i><span class="tags-links">' . $wp_tag_list . '</span>';
					}
					?>
				</div>		
	<?php endif; ?>		
	
<?php endif; ?>
</div>