<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package fastest-shop
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( array('fastest-shop-blogwrap') ); ?>>

 	 <?php
    /**
    * Hook - fastest_shop_posts_blog_media.
    *
    * @hooked fastest_shop_posts_formats_thumbnail - 10
    */
    do_action( 'fastest_shop_posts_blog_media' );
    ?>
    <div class="post page-content">
               
		<?php
        /**
        * Hook - diet_shop_site_content_type.
        *
		* @hooked site_loop_heading - 10
        * @hooked render_meta_list	- 20
		* @hooked site_content_type - 30
        */
        do_action( 'fastest_shop_site_content_type');
		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'fastest-shop' ),
			'after'  => '</div>',
		) );
        ?>
      
       
       <?php if ( get_edit_post_link() ) : ?>
		<div class="entry-footer">
			<?php
			edit_post_link(
				sprintf(
					wp_kses(
						/* translators: %s: Name of current post. Only visible to screen readers */
						__( 'Edit <span class="screen-reader-text">%s</span>', 'fastest-shop' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				),
				'<span class="edit-link">',
				'</span>'
			);
			?>
		</div ><!-- .entry-footer -->
	<?php endif; ?>
     <div class="clearfix"></div>
    </div>
   
</article><!-- #post-<?php the_ID(); ?> -->


