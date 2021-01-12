<?php
/* 
 *	Custom styling for Comments Section
 *  Comments list format 
 */
function arisen_format_comment($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>	  
			
		<li class="commentlist list-comments">								
		   <div class="list-comments-main">
				<div <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
					<div class="row">
						<div class="col-author-img">
							<div class="author-image">
								<figure>
									<div class="comments_img"><?php echo get_avatar( $comment, $size='80' ); ?></div>
								</figure>									
							</div>
						</div>
						<div class="col-author-meta">
							<div class="comment-meta comments-date">
								<div>
									 <!-- without link -->	
									<div class="author"><?php printf(esc_html__('%s', 'arisen'), get_comment_author_link()); ?> <span><?php esc_html_e('Says?', 'arisen'); ?></span></div>
									<div class="author_date time"> 
										 <!-- without link -->
										<p>	
										<?php comment_date('d M, Y \a\t g:i A'); ?>										
										<span class="reply reply-heading"><?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth'], 'after' => '', 'before' => '| '))); ?></span>
										</p>										
									</div>										
								</div>	
							</div>
						</div>
					</div>
					<div class="comment-content comment-para author_para">						
						<?php if ($comment->comment_approved == '0') : ?>
							 <em><?php esc_html_e('Your comment is awaiting moderation.', 'arisen') ?></em><br />
						 <?php endif; ?>
						 <?php comment_text(); ?>
					</div>
					
				</div>
			</div> 				 	  
 <?php 
      
    }
?>