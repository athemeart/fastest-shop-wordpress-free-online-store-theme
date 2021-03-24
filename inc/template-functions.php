<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package fastest-shop
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function fastest_shop_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'fastest_shop_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function fastest_shop_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'fastest_shop_pingback_header' );

if ( ! function_exists( 'fastest_shop_alowed_tags' ) ) :
	/**
	 * @see diet_shop_alowed_tags().
	 */
function fastest_shop_alowed_tags() {
	
	
	$wp_post_allow_tag = wp_kses_allowed_html( 'post' );
	
	$allowed_tags = array(
		'a' => array(
			'class' => array(),
			'href'  => array(),
			'rel'   => array(),
			'title' => array(),
			'id'	=> array(),
			'target'=> array(),
		),
		'abbr' => array(
			'title' => array(),
		),
		'b' => array(),
		'blockquote' => array(
			'cite'  => array(),
		),
		'cite' => array(
			'title' => array(),
		),
		'code' => array(),
		'del' => array(
			'datetime' => array(),
			'title' => array(),
		),
		'dd' => array(),
		'div' => array(
			'class' => array(),
			'title' => array(),
			'style' => array(),
			'id' => array(),
		),
		'dl' => array( 
			'class' => array(),
			'style' => array(),
			'id' => array(),
		),
		'dt' => array(
			'class' => array(),
			'style' => array(),
			'id' => array(),
		),
		'em' => array(
			'class' => array(),
			'style' => array(),
			'id' => array(),
		),
		'h1' => array(
			'class' => array(),
			'title' => array(),
			'style' => array(),
			'id' => array(),
		
		),
		'h2' => array(
			'class' => array(),
			'style' => array(),
			'id' => array(),
		
		),
		'h3' => array(
			'class' => array(),
			'style' => array(),
			'id' => array(),
		),
		'h4' => array(
			'class' => array(),
			'style' => array(),
			'id' => array(),
		),
		'h5' => array(
			'class' => array(),
			'style' => array(),
			'id' => array(),
		),
		'h6' => array(
			'class' => array(),
			'style' => array(),
			'id' => array(),
		),
		'i' => array(
			'class' => array(),
			'style' => array(),
			'id' => array(),
		),
		'img' => array(
			'alt'    => array(),
			'class'  => array(),
			'height' => array(),
			'src'    => array(),
			'width'  => array(),
		),
		'li' => array(
			'class' => array(),
			'style' => array(),
			'id' => array(),
		),
		'i' => array(
			'class' => array(),
			'style' => array(),
			'id' => array(),
		),
		'ol' => array(
			'class' => array(),
			'style' => array(),
			'id' => array(),
		),
		'p' => array(
			'class' => array(),
			'style' => array(),
			'id' => array(),
		),
		'q' => array(
			'cite' => array(),
			'title' => array(),
		),
		'span' => array(
			'class' => array(),
			'style' => array(),
			'id' => array(),
		),
		'strike' => array(),
		'strong' => array(),
		'ul' => array(
			'class' => array(),
			'style' => array(),
			'id' => array(),
		),
		'iframe' => array(
			'src'             => array(),
			'height'          => array(),
			'width'           => array(),
			'frameborder'     => array(),
			'allowfullscreen' => array(),
		),
		'time' => array(
			'class' => array(),
			'title' => array(),
			'style' => array(),
			'datetime' => array(),
			'content' => array(),
		),
		'main' => array(
			'class' => array(),
			'id' => array(),
			'style' => array(),
			
		),
	);

	
	$tags = array_merge( $wp_post_allow_tag, $allowed_tags );

	return apply_filters( 'fastest_shop_alowed_tags', $tags );
	
}
endif;



if ( ! function_exists( 'fastest_shop_walker_comment' ) ) : 
	/**
	 * Implement Custom Comment template.
	 *
	 * @since 1.0.0
	 *
	 * @param $comment, $args, $depth
	 * @return $html
	 */
	  
	function fastest_shop_walker_comment($comment, $args, $depth) {
		if ( 'div' === $args['style'] ) {
			$tag       = 'div';
			$add_below = 'comment';
		} else {
			$tag       = 'li';
			$add_below = 'div-comment';
		}
		?>
<li <?php comment_class( empty( $args['has_children'] ) ? 'comment shift' : 'comment' ) ?> id="comment-<?php comment_ID() ?>">
  <div class="single-comment clearfix">
    <?php if ( $args['avatar_size'] != 0 ) echo get_avatar( $comment, 80,'','', array('class' => 'float-left') ); ?>
    <div class="comment-details">
      <div class="comment-heading">
        <h5 class="float-left"><?php echo get_comment_author_link();?></h5>
        <span class="float-left comment-date">
			<?php
			/* translators: 1: date, 2: time */
			printf( esc_html__('%1$s at %2$s', 'fastest-shop' ), esc_html( get_comment_date() ),  esc_html( get_comment_time()) ); 
			?>
        </span>
        <?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
        <div class="clearfix"></div>
      </div>
      <div class="comment-text">
        <?php comment_text(); ?>
      </div>
    </div>
  </div>
  <div class="clearfix"></div>
</li>


       <?php
	}
	
	
endif;



class fastest_shop_navwalker extends Walker_Nav_Menu {
		
		/**
		 * Menu Fallback
		 * =============
		 * If this function is assigned to the wp_nav_menu's fallback_cb variable
		 * and a menu has not been assigned to the theme location in the WordPress
		 * menu manager the function with display nothing to a non-logged in user,
		 * and will add a link to the WordPress menu manager if logged in as an admin.
		 *
		 * @param array $args passed from the wp_nav_menu function.
		 */
		public static function fallback( $args ) {
			
			wp_nav_menu( array(
				'depth'             => 1,
				'menu_class'  		=> 'menu rd-navbar-nav',
				'container'			=>'ul',
				'theme_location'    => 'fallback_menu'
			) );
			
		}
	
}

if( !function_exists('fastest_shop_elementor_editor_simplify') ){
	
	function fastest_shop_elementor_editor_simplify(){
		
		add_action( 'wp_head', function () {
				echo '<style type="text/css">
				#elementor-panel-category-pro-elements,
				#elementor-panel-category-theme-elements,
				#elementor-panel-category-woocommerce-elements,
				#elementor-panel-get-pro-elements{
					display:none!important;	
				}
				</style>';
			}  );
		
	}
	add_action( 'elementor/editor/init', 'fastest_shop_elementor_editor_simplify');

}