<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package fastest-shop
 */

?>

	</div><!-- #content -->

	<?php
	/**
	* Hook - fastest_shop_site_footer
	*
	* @hooked fastest_shop_container_wrap_start
	*/
	do_action( 'fastest_shop_site_footer');
	?>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
