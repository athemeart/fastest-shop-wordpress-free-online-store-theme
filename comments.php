<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Diet_Shop
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>
<div class="clearfix"></div>
<div id="comments" class="comments-area clearfix" >

	<?php
	// You can start editing here -- including this comment!
	if ( have_comments() ) :
		?>
        <div class="comment-wdiget-style comment-meta">
		<h4 class="comments-title widget-title">
			<?php
			$Business_Consultant_Finder_comment_count = get_comments_number();
			if ( '1' === $Business_Consultant_Finder_comment_count ) {
				printf(
					/* translators: 1: title. */
					esc_html__( 'One thought on &ldquo;%1$s&rdquo;', 'fastest-shop' ),
					'<span>' . esc_html(  get_the_title() ) . '</span>'
				);
			} else {
				printf( // WPCS: XSS OK.
					/* translators: 1: comment count number, 2: title. */
					esc_html( _nx( '%1$s thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', $Business_Consultant_Finder_comment_count, 'comments title', 'fastest-shop' ) ),
					number_format_i18n( $Business_Consultant_Finder_comment_count ),
					'<span>' . get_the_title() . '</span>'
				);
			}
			?>
		</h4><!-- .comments-title -->

		<?php the_comments_navigation(); ?>

		<ul class="comments-list">
			<?php
			wp_list_comments( array(
				'style'      => 'ul',
				'short_ping' => true,
				'callback' => 'fastest_shop_walker_comment',
			) );
			?>
		</ul><!-- .comment-list -->

		<?php
		the_comments_navigation();

		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() ) :
			?>
			<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'fastest-shop' ); ?></p>
			<?php
		endif;
	?>
    </div>
    
    
    <?php
	endif; // Check for have_comments().
	?>
     <?php 
		$commenter = wp_get_current_commenter();
		$consent   = empty( $commenter['comment_author_email'] ) ? '' : ' checked="checked"';

	$args = array(
	'fields' => apply_filters(
		'comment_form_default_fields', array(
			'author' =>'<div class="col-xl-4 col-lg-6 col-md-4 col-12">' . '<input id="author" placeholder="' . esc_attr__( 'Your Name', 'fastest-shop'  ) . '" name="author" type="text" value="' .
				esc_attr( $commenter['comment_author'] ) . '" size="30" />'.
				( $req ? '<span class="required">*</span>' : '' )  .
				'</div>'
				,
			'email'  => '<div class="col-xl-4 col-lg-6 col-md-4 col-12">' . '<input id="email" placeholder="' . esc_attr__( 'Your Email', 'fastest-shop'  ) . '" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
				'" size="30" />'  .
				( $req ? '<span class="required">*</span>' : '' ) 
				 .
				'</div>',
			'url'    => '<div class="col-xl-4 col-lg-6 col-md-4 col-12">' .
			 '<input id="url" name="url" placeholder="' . esc_attr__( 'Website', 'fastest-shop' ) . '" type="text" value="' . esc_url( $commenter['comment_author_url'] ) . '" size="30" /> ' .
			
	           '</div>',
			'cookies'    =>  '<p class="comment-form-cookies-consent col-12"><input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" class="fas fa-check" type="checkbox" value="yes"' . $consent . ' />' . '<label for="wp-comment-cookies-consent">'.esc_html__( 'Save my name, email, and website in this browser for the next time I comment.','fastest-shop' ) .'</label></p>',
			   
			   
		)
	),
		'comment_field' =>  '<div class="col-12"><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"  placeholder="' . esc_attr__( 'Comment', 'fastest-shop' ) . '">' .
		'</textarea></div>',
		
		
		'class_form'      => 'row',
		'submit_button' => '<button type="submit" class="btn theme-btn" id="submit-new"><span>'. esc_html__( 'Post Comment', 'fastest-shop' ) .'</span></button>',
		'title_reply_before'   => ' <h4 class="widget-title">',
		'title_reply_after'    => '</h4>',
		'comment_notes_before' => '<p class="comment-notes col-12">' . esc_html__( 'Your email address will not be published. Required fields are marked *.','fastest-shop' ) . '</p>',
		'comment_notes_after'  => '<div class="form-allowed-tags col-12"><div class="text-wrp">' ./* translators: 1: title. */ sprintf( esc_html__( 'You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: %s', 'fastest-shop' ), ' <code>' . allowed_tags() . '</code>' ) . '</div></div>',
		'submit_field' =>'<div class="form-submit col-12">%1$s %2$s</div>'
);
	?>
    <div class="comment-wdiget-style comment-form" >
    
    <?php comment_form( $args );?>
  
    </div>

</div><!-- #comments -->