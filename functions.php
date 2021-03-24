<?php
/**
 * Fastest Shop functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package fastest-shop
 */
/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/theme-core.php';

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/class/class-header.php';

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/class/class-body.php';

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/class/class-footer.php';

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/class/class-template-tags.php';
require get_template_directory() . '/inc/class/class-post-related.php';

/**
* Functions which enhance the theme by hooking into WordPress.
*/
require get_template_directory() . '/inc/template-functions.php';

/**
* Load Jetpack compatibility file.
*/
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
* TGM Plugins
*/
require get_template_directory() . '/inc/tgm/recommended-plugins.php';

require get_template_directory() . '/inc/customizer/customizer.php';


/**
* Implement pro features.
*/
require get_template_directory() . '/inc/admin/admin-page.php';

if ( class_exists( 'WooCommerce' ) ) {
require get_template_directory() . '/inc/woocommerce.php';
}
