<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package fastest-shop
 */

get_header();

$layout = fastest_shop_get_option('single_post_layout');

/**
* Hook - container_wrap_start 		- 5
*
* @hooked fastest_shop_container_wrap_start
*/
 do_action( 'fastest_shop_container_wrap_start', esc_attr( $layout ));
?>
	

		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', get_post_type() );

			/**
			* Hook - fastest_shop_site_footer
			*
			* @hooked fastest_shop_container_wrap_start
			*/
			do_action( 'fastest_shop_single_post_navigation');
			

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>

<?php
/**
* Hook - container_wrap_end 		- 999
*
* @hooked fastest_shop_container_wrap_end
*/
do_action( 'fastest_shop_container_wrap_end', esc_attr( $layout ));
get_footer();