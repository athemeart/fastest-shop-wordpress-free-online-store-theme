<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package fastest-shop
 */

get_header();

$layout = fastest_shop_get_option('blog_layout');
/**
* Hook - fastest_shop_container_wrap_start 	
*
* @hooked fastest_shop_container_wrap_start	- 5
*/
 do_action( 'fastest_shop_container_wrap_start',  esc_attr( $layout ) );

	if ( have_posts() ) :

		if ( is_home() && ! is_front_page() ) :
			?>
			<header>
				<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
			</header>
			<?php
		endif;

		/* Start the Loop */
		while ( have_posts() ) :
			the_post();

			/*
			 * Include the Post-Type-specific template for the content.
			 * If you want to override this in a child theme, then include a file
			 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
			 */
			get_template_part( 'template-parts/content', get_post_type() );

		endwhile;

		/**
		* Hook - fastest_shop_loop_navigation 	
		*
		* @hooked site_loop_navigation	- 10
		*/
		 do_action( 'fastest_shop_loop_navigation');

	else :

		get_template_part( 'template-parts/content', 'none' );

	endif;
		
/**
* Hook - fastest_shop_container_wrap_end	
*
* @hooked container_wrap_end - 999
*/
 do_action( 'fastest_shop_container_wrap_end',  esc_attr( $layout ) );
get_footer();
