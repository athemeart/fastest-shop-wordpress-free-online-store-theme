<?php
/**
 * WooCommerce Compatibility File
 *
 * @link https://woocommerce.com/
 *
 * @package fastest-shop
 */
/**
 *  Hook remove from WooCommerce archive
 */
remove_action( 'woocommerce_before_main_content','woocommerce_breadcrumb',20 );
add_filter( 'woocommerce_show_page_title', '__return_false' );
remove_action( 'woocommerce_sidebar','woocommerce_get_sidebar',10 );

remove_action( 'woocommerce_before_shop_loop_item','woocommerce_template_loop_product_link_open',10 );
remove_action( 'woocommerce_after_shop_loop_item','woocommerce_template_loop_product_link_close',5 );

remove_action( 'woocommerce_before_shop_loop_item_title','woocommerce_template_loop_product_thumbnail',10 );
remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );

remove_action( 'woocommerce_after_shop_loop_item_title','woocommerce_template_loop_rating',5 );

remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
add_action( 'woocommerce_after_cart', 'woocommerce_cross_sell_display',5 );

remove_action( 'woocommerce_after_shop_loop_item','woocommerce_template_loop_add_to_cart',10 );

add_action( 'fastest_shop_add_to_cart_icon','woocommerce_template_loop_add_to_cart',10 );

remove_action( 'woocommerce_archive_description','woocommerce_taxonomy_archive_description',10 );
remove_action( 'woocommerce_archive_description','woocommerce_product_archive_description',10 );
/**
 * WooCommerce setup function.
 *
 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
 * @link https://github.com/woocommerce/woocommerce/wiki/Enabling-product-gallery-features-(zoom,-swipe,-lightbox)
 * @link https://github.com/woocommerce/woocommerce/wiki/Declaring-WooCommerce-support-in-themes
 *
 * @return void
 */
function fastest_shop_woocommerce_setup() {
	add_theme_support(
		'woocommerce',
		array(
			'thumbnail_image_width' => 300,
			'single_image_width'    => 600,
			'product_grid'          => array(
				'default_rows'    => 3,
				'min_rows'        => 1,
				'default_columns' => 4,
				'min_columns'     => 1,
				'max_columns'     => 6,
			),
		)
	);
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
	
	register_sidebar( array(
		'name'          => esc_html__( 'Woocommerce Sidebar', 'fastest-shop' ),
		'id'            => 'woocommerce-sidebar',
		'description'   => esc_html__( 'Add widgets here.', 'fastest-shop' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title"><span>',
		'after_title'   => '</span></h3>',
	) );
}
add_action( 'after_setup_theme', 'fastest_shop_woocommerce_setup' );

/**
 * WooCommerce specific scripts & stylesheets.
 *
 * @return void
 */

function fastest_shop_woocommerce_scripts() {
	
	wp_enqueue_style( 'fastest-shop-woocommerce-core', get_template_directory_uri() . '/assets/css/woocommerce-core.css', array(), _FATEST_SHOP_VERSION );
	wp_enqueue_style( 'fastest-shop-woocommerce-style', get_template_directory_uri() . '/woocommerce.css', array(), _FATEST_SHOP_VERSION );

	$font_path   = esc_url( WC()->plugin_url() . '/assets/fonts/' );
	$inline_font = '@font-face {
			font-family: "star";
			src: url("' . esc_url( $font_path ) . 'star.eot");
			src: url("' . esc_url( $font_path ) . 'star.eot?#iefix") format("embedded-opentype"),
				url("' . esc_url( $font_path ) . 'star.woff") format("woff"),
				url("' . esc_url( $font_path ) . 'star.ttf") format("truetype"),
				url("' . esc_url( $font_path ) . 'star.svg#star") format("svg");
			font-weight: normal;
			font-style: normal;
		}';

	wp_add_inline_style( 'fastest-shop-woocommerce-style', $inline_font );

	wp_enqueue_script( 'fastest-shop-woocommerce', get_theme_file_uri( '/assets/js/fastest-shop-woocommerce.js' ) , 0, '1.1', true );
}
add_action( 'wp_enqueue_scripts', 'fastest_shop_woocommerce_scripts' );

/**
 * Disable the default WooCommerce stylesheet.
 *
 * Removing the default WooCommerce stylesheet and enqueing your own will
 * protect you during WooCommerce core updates.
 *
 * @link https://docs.woocommerce.com/document/disable-the-default-stylesheet/
 */
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

/**
 * Add 'woocommerce-active' class to the body tag.
 *
 * @param  array $classes CSS classes applied to the body tag.
 * @return array $classes modified to include 'woocommerce-active' class.
 */
function fastest_shop_woocommerce_active_body_class( $classes ) {
	$classes[] = 'woocommerce-active';

	return $classes;
}
add_filter( 'body_class', 'fastest_shop_woocommerce_active_body_class' );

/**
 * Related Products Args.
 *
 * @param array $args related products args.
 * @return array $args related products args.
 */
function fastest_shop_woocommerce_related_products_args( $args ) {
	$defaults = array(
		'posts_per_page' => 3,
		'columns'        => 3,
	);

	$args = wp_parse_args( $defaults, $args );

	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'fastest_shop_woocommerce_related_products_args' );
add_filter( 'woocommerce_upsell_display_args', 'fastest_shop_woocommerce_related_products_args' );

add_filter( 'woocommerce_cross_sells_columns', 'fastest_shop_change_cross_sells_columns' );
 
function fastest_shop_change_cross_sells_columns( $columns ) {
	return 3;
}
/**
 * Remove default WooCommerce wrapper.
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

if ( ! function_exists( 'fastest_shop_woocommerce_wrapper_before' ) ) {
	/**
	 * Before Content.
	 *
	 * Wraps all WooCommerce content in wrappers which match the theme markup.
	 *
	 * @return void
	 */
	function fastest_shop_woocommerce_wrapper_before() {
		/**
		* Hook - fastest_shop_container_wrap_start 	
		*
		* @hooked fastest_shop_container_wrap_start	- 5
		*/
		 $layout = ( is_shop() || is_product_category() ) ? 'sidebar-content': 'no-sidebar';
		 
		 do_action( 'fastest_shop_container_wrap_start', esc_attr( $layout ) );
	}
}
add_action( 'woocommerce_before_main_content', 'fastest_shop_woocommerce_wrapper_before' );

if ( ! function_exists( 'fastest_shop_woocommerce_wrapper_after' ) ) {
	/**
	 * After Content.
	 *
	 * Closes the wrapping divs.
	 *
	 * @return void
	 */
	function fastest_shop_woocommerce_wrapper_after() {
		/**
		* Hook - fastest_shop_container_wrap_end	
		*
		* @hooked container_wrap_end - 999
		*/
		 $layout = ( is_shop() || is_product_category() ) ? 'sidebar-content': 'no-sidebar';
		 
		do_action( 'fastest_shop_container_wrap_end', esc_attr( $layout ) );
	}
}
add_action( 'woocommerce_after_main_content', 'fastest_shop_woocommerce_wrapper_after' );

/**
 * Sample implementation of the WooCommerce Mini Cart.
 *
 * You can add the WooCommerce Mini Cart to header.php like so ...
 *
	<?php
		if ( function_exists( 'fastest_shop_woocommerce_header_cart' ) ) {
			fastest_shop_woocommerce_header_cart();
		}
	?>
 */

if ( ! function_exists( 'fastest_shop_woocommerce_cart_link_fragment' ) ) {
	/**
	 * Cart Fragments.
	 *
	 * Ensure cart contents update when products are added to the cart via AJAX.
	 *
	 * @param array $fragments Fragments to refresh via AJAX.
	 * @return array Fragments to refresh via AJAX.
	 */
	function fastest_shop_woocommerce_cart_link_fragment( $fragments ) {
		ob_start();
		fastest_shop_woocommerce_cart_link();
		$fragments['a.cart-contents'] = ob_get_clean();

		return $fragments;
	}
}
add_filter( 'woocommerce_add_to_cart_fragments', 'fastest_shop_woocommerce_cart_link_fragment' );

if ( ! function_exists( 'fastest_shop_woocommerce_cart_link' ) ) {
	/**
	 * Cart Link.
	 *
	 * Displayed a link to the cart including the number of items present and the cart total.
	 *
	 * @return void
	 */
	function fastest_shop_woocommerce_cart_link() {
		?>
        <?php if( class_exists('ATA_WC_Smart_Popup_Cart') || class_exists('ATA_WC_Smart_Popup_Cart_PRO') ) :?>
        <a class="cart-contents single_add_to_cart_flyer" href="javascript:void(0)" title="<?php esc_attr_e( 'View your shopping cart', 'fastest-shop' ); ?>">
        <?php else : ?>
		<a class="cart-contents single_add_to_cart_flyer" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'fastest-shop' ); ?>">
			<?php
		endif;
			$item_count_text = sprintf(
				/* translators: number of items in the mini cart. */
				_n( '%d', '%d', WC()->cart->get_cart_contents_count(), 'fastest-shop' ),
				WC()->cart->get_cart_contents_count()
			);
			?>
			<i class="icofont-grocery"></i>

		
			<span class="quantity"><?php echo esc_html( $item_count_text ); ?></span>
		</a>

		<?php
	}
}

if ( ! function_exists( 'fastest_shop_woocommerce_header_cart' ) ) {
	/**
	 * Display Header Cart.
	 *
	 * @return void
	 */
	function fastest_shop_woocommerce_header_cart() {
		if ( is_cart() ) {
			$class = 'current-menu-item';
		} else {
			$class = '';
		}
		?>
		<ul id="site-header-cart" class="site-header-cart">
			<li class="<?php echo esc_attr( $class ); ?>">
				<?php fastest_shop_woocommerce_cart_link(); ?>
			</li>
			<li>
				<?php
				$instance = array(
					'title' => '',
				);

				the_widget( 'WC_Widget_Cart', $instance );
				?>
			</li>
		</ul>
		<?php
	}
}

/*------------------------------------*/
	//TOOL BAR
/*------------------------------------*/
remove_action('woocommerce_before_shop_loop','woocommerce_result_count',20);

if ( ! function_exists( 'fastest_shop_toolbar_start' ) ) {
	/**
	 * Insert the opening anchor tag for products in the loop.
	 */
	function fastest_shop_toolbar_start() {
		echo '<div class="fastest-shop-toolbar clearfix">';
	}
	
	add_action('woocommerce_before_shop_loop','fastest_shop_toolbar_start',20);
}

/**
* Add Custom Result Counter.
*/
function fastest_shop_result_count() {
	get_template_part( 'woocommerce/result-count' );
}
add_action('woocommerce_before_shop_loop','fastest_shop_result_count',30);


if ( ! function_exists( 'fastest_shop_header_toolbar_end' ) ) {
	/**
	 * Insert the opening anchor tag for products in the loop.
	 */
	function fastest_shop_header_toolbar_end() {
		echo '<div class="clearfix"></div></div>';
	}
	
	add_action('woocommerce_before_shop_loop','fastest_shop_header_toolbar_end',30);
}


if ( ! function_exists( 'fastest_shop_loop_shop_per_page' ) ) :
	/**
	 * Returns correct posts per page for the shop
	 *
	 * @since 1.0.0
	 */
	function fastest_shop_loop_shop_per_page() {
		
		$posts_per_page = ( isset( $_GET['products-per-page'] ) ) ? sanitize_text_field( wp_unslash( $_GET['products-per-page'] ) ) : get_theme_mod( 'shopstore_woo_shop_posts_per_page',12 );

		if ( $posts_per_page == 'all' ) {
			$posts_per_page = wp_count_posts( 'product' )->publish;
		}
		
		return $posts_per_page;
	}
	add_filter( 'loop_shop_per_page', 'fastest_shop_loop_shop_per_page', 20 );
endif;

/*------------------------------------*/
	//PRODUCT LOOP
/*------------------------------------*/


/**
 * Default loop columns on product archives.
 *
 * @return integer products per row.
 */
function fastest_shop_woocommerce_loop_columns() {
	return 3;
}
add_filter( 'loop_shop_columns', 'fastest_shop_woocommerce_loop_columns' );



if ( ! function_exists( 'fastest_shop_loop_product_thumbnail' ) ) {
	
	/**
	 * Get the product thumbnail for the loop.
	 */
	function fastest_shop_loop_product_thumbnail() {
		global $product;
		$attachment_ids   = $product->get_gallery_image_ids();
		
		
		echo '<div class="product-image">';

		
			if( isset( $attachment_ids[0] ) && $attachment_ids[0] != "" ) {
			
				$img_tag = array(
				'class'         => 'woo-entry-image-secondary',
				'alt'           => get_the_title(),
				);
				
				echo '<figure class="hover_hide">'. wp_kses_post(woocommerce_get_product_thumbnail()) . wp_get_attachment_image( $attachment_ids[0], 'shop_catalog', '', $img_tag ) .'</figure>';

			}else{
				echo '<figure>'.wp_kses_post(woocommerce_get_product_thumbnail()).'</figure>';	
			}
		echo '</div>';	
	}
	add_action( 'woocommerce_before_shop_loop_item_title','woocommerce_template_loop_rating',5 );

	add_action( 'woocommerce_before_shop_loop_item_title','woocommerce_template_loop_product_link_open',10 );

	add_action( 'woocommerce_before_shop_loop_item_title','woocommerce_show_product_loop_sale_flash',20 );

	add_action( 'woocommerce_before_shop_loop_item_title','fastest_shop_loop_product_thumbnail',30 );

	add_action( 'woocommerce_before_shop_loop_item_title','woocommerce_template_loop_product_link_close',99 );
	
	

	
}


if ( ! function_exists( 'fastest_shop_loop_content_before' ) ) {

	/**
	 * end the product content wrap
	 */
	function fastest_shop_loop_content_before() {
		echo '<div class="product_wrap">';
	}
	add_action( 'woocommerce_shop_loop_item_title', 'fastest_shop_loop_content_before', 5 );
}


if ( ! function_exists( 'fastest_shop_product_loop_actions' ) ) {

	/**
	 * end the product content wrap
	 */
	function fastest_shop_product_loop_actions() {
		echo '<ul class="product_actions_btn_wrap">';
		do_action('fastest_shop_add_to_cart_icon');
		echo '<li><a href="'.esc_url( get_permalink( get_the_ID() ) ).'" title="'.get_the_title( get_the_ID() ).'"><i class="icofont-external-link"></i><span></span></a></li>';
		echo '<li><a href="'.esc_url( get_permalink( get_the_ID() ) ).'" title="'.get_the_title( get_the_ID() ).'"><i class="icofont-ui-love-add"></i></a></li>';
			
	    echo '</ul>';
	}
	add_action( 'woocommerce_shop_loop_item_title', 'fastest_shop_product_loop_actions', 10 );
}


if ( ! function_exists( 'fastest_shop_loop_item_title' ) ) {

	/**
	 * Show the product title in the product loop. By default this is an h4.
	 */
	function fastest_shop_loop_item_title() {
		echo '<h5 class="' . esc_attr( apply_filters( 'woocommerce_product_loop_title_classes', 'woocommerce-loop-product__title' ) ) . '">' . esc_html( get_the_title() ) . '</h5>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
	add_action( 'woocommerce_shop_loop_item_title', 'fastest_shop_loop_item_title', 40 );
}


if ( ! function_exists( 'fastest_shop_loop_content_after' ) ) {

	/**
	 * end the product content wrap
	 */
	function fastest_shop_loop_content_after() {
		echo '</div>';
	}
	add_action( 'woocommerce_after_shop_loop_item', 'fastest_shop_loop_content_after', 999);
}



if ( ! function_exists( 'fastest_shop_before_quantity_input_field' ) ) {
	/**
	 * before quantity.
	 *
	 *
	 * @return $html
	 */
	function fastest_shop_before_quantity_input_field() {
		echo '<button type="button" class="plus"><i class="icofont-plus"></i></button>';
	}
	add_action( 'woocommerce_before_quantity_input_field','fastest_shop_before_quantity_input_field',10);
	
	
}

if ( ! function_exists( 'fastest_shop_after_quantity_input_field' ) ) {
	/**
	 * after quantity.
	 *
	 *
	 * @return $html
	 */
	function fastest_shop_after_quantity_input_field() {
		echo '<button type="button" class="minus"><i class="icofont-minus"></i></button>';
	}
	add_action( 'woocommerce_after_quantity_input_field','fastest_shop_after_quantity_input_field',10);
	
	
}


function fastest_shop_product_loop_swatches(){
if( !class_exists('ATA_WC_Variation_Swatches') ) return;
global $product;

if( $product->is_type( 'variable' )) {

	$attributes = $product->get_variation_attributes();	
	$variations_json = wp_json_encode( $product->get_available_variations() );
	$variations_attr = function_exists( 'wc_esc_json' ) ? wc_esc_json( $variations_json ) : _wp_specialchars( $variations_json, ENT_QUOTES, 'UTF-8', true );
?>
<div class="fastest_shop_variations_wrap" data-product_variations="<?php echo esc_attr( $variations_attr ); // WPCS: XSS ok. ?>">
<?php

if( !empty($attributes) ):
foreach ( $attributes as $attribute_name => $options ) : 

	if( $attribute_name == 'pa_color' ){
		wc_dropdown_variation_attribute_options(
			array(
				'options'   => $options,
				'attribute' => $attribute_name,
				'product'   => $product,
			)
		);
	}
endforeach;
endif;
?>

</div>

<?php
}

}
add_action( 'woocommerce_after_shop_loop_item','fastest_shop_product_loop_swatches',100 );


function fastest_shop_wcspc_get_default_options( $value ) {
    
    $value['_wcspc_count'] 			= 'no';
    $defaults['_wcspc_manual_show']	= '.cart-contents';
    return $value;
}
add_filter( 'wcspc_get_default_options', 'fastest_shop_wcspc_get_default_options' );