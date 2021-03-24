<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package fastest-shop
 */


get_header();
/**
* Hook - fastest_shop_container_wrap_start 	
*
* @hooked fastest_shop_container_wrap_start	- 5
*/
 do_action( 'fastest_shop_container_wrap_start');
 
 
		if ( have_posts() ) : 
			/* Start the Loop */
			while ( have_posts() ) :
				the_post();

				/**
				 * Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called content-search.php and that will be used instead.
				 */
				get_template_part( 'template-parts/content', 'search' );

			endwhile;

			the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
		
/**
* Hook - fastest_shop_container_wrap_end	
*
* @hooked container_wrap_end - 999
*/
do_action( 'fastest_shop_container_wrap_end');
get_footer();
?>
