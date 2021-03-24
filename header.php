<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package fastest-shop
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> >
 <?php wp_body_open(); ?>
<div id="page" class="site">

    <?php
	/**
	* Hook - fastest_shop_site_header
	*
	* @hooked site_header_layout
	*/
	do_action( 'fastest_shop_site_header');
	
	?>


	<div id="content" class="site-content"  >
