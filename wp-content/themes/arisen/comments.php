<?php
/**
 * The template for displaying comments
 *
 * @package WordPress
 * @subpackage Arisen
 * @since Arisen 1.0
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) :
	return;
endif;
?>

<div class="comments-section comments-area">

	<?php if ( have_comments() ) : ?>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-below" class="comment-navigation">
			<h1 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'arisen' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( esc_html__( '&larr; Older Comments', 'arisen' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments &rarr;', 'arisen' ) ); ?></div>
		</nav><!-- #comment-nav-below -->
		<?php endif; // check for comment navigation ?>

		 <!-- .comment-list -->
		<div class="comments-content">
		   <h2 class="comments-title">
				<?php
					printf( _nx( '1 Recent Comments', '%1$s Recent Comments', get_comments_number(), 'comments title', 'arisen' ),
						number_format_i18n( get_comments_number() ), get_the_title() );
				?>
			</h2>
		   <ul class="comments-div">			
				<?php
					wp_list_comments( array(
						'style'       => 'ul',
						'short_ping'  => true,
						'avatar_size' => 80,
						'callback' => 'arisen_format_comment'   /* calling custom comments styling function - arisen_format_comment */
					) );
				?>
			</ul>
		</div>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-below" class="comment-navigation">
			<h1 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'arisen' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( esc_html__( '&larr; Older Comments', 'arisen' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments &rarr;', 'arisen' ) ); ?></div>
		</nav><!-- #comment-nav-below -->
		<?php endif; // check for comment navigation ?>

	<?php endif; // have_comments() ?>

	<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'arisen' ); ?></p>
	

<?php else:
$comment_args = array( 'title_reply'=>'Leave a Reply',

'fields' => apply_filters( 'comment_form_default_fields', array(
	'author' => '<div class="row"><fieldset class="col-md-6 form-tag"><label for="author">' . esc_html__( 'Name', 'arisen') .( $req ? '<span>*</span>' : '' ) . '</label> '  .
                '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="20" class="input-data"/></fieldset>',
    'email'  => '<fieldset class="col-md-6 form-tag"><label for="email">' . esc_html__( 'Email', 'arisen') . ( $req ? '<span>*</span>' : '' ) . '</label> ' .
                '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="20" class="input-data" />'.'</fieldset></div>',
    'url'    => '',
	'website'  => ''
	) ),

    'comment_field' => '<div class="row"><fieldset class="col-sm-12 form-tag"><label for="comment">' . esc_html__( 'Comment', 'arisen') . '</label>' .
                       '<textarea class="col-sm-12" rows="5" cols="25" id="comment" name="comment" aria-required="true"></textarea>' .
                       '</fieldset></div>',

                       'comment_notes_after' => '',
);
?>
	<div class="submit_comment">
	     <?php comment_form($comment_args); ?>
	</div>
	<?php endif; ?>
</div><!-- .comments-area -->