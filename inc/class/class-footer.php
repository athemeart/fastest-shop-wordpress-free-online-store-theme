<?php
/**
 * The Site Theme Header Class 
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package fastest-shop
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
class fastest_shop_Footer_Layout{
	/**
	 * Function that is run after instantiation.
	 *
	 * @return void
	 */
	public function __construct() {
		
		add_action('fastest_shop_site_footer', array( $this, 'site_footer_container_before' ), 5);
		add_action('fastest_shop_site_footer', array( $this, 'site_footer_widgets' ), 10);
		add_action('fastest_shop_site_footer', array( $this, 'site_footer_info' ), 80);
		add_action('fastest_shop_site_footer', array( $this, 'site_footer_container_after' ), 998);
		
	}
	
	/**
	* diet_shop foter conteinr before
	*
	* @return $html
	*/
	public function site_footer_container_before (){
		
		$html = ' <footer id="colophon" class="site-footer">';
						
		$html = apply_filters( 'fastest_shop_footer_container_before_filter',$html);		
				
		echo wp_kses( $html, $this->alowed_tags() );
		
						
	}
	
	/**
	* Footer Container before
	*
	* @return $html
	*/
	function site_footer_widgets(){
		if ( is_active_sidebar( 'footer-1' ) ) { ?>
         <div class="footer_widget_wrap">
         <div class="container">
            <div class="row fastest-shop-flex">
                <?php dynamic_sidebar( 'footer-1' ); ?>
            </div>
         </div>  
         </div>
        <?php }
	}
	
	
	/**
	* diet_shop foter conteinr after
	*
	* @return $html
	*/
	public function site_footer_info (){
		$text ='';
		$html = '<div class="container site_info"><span class="back-to-top" id="backToTop"><i class="icofont-rounded-up parallax"></i></span>
					<div class="row">';
		

			$html .= '<div class="col-12 col-md-12">';
			
			if( get_theme_mod('copyright_text') != '' ) 
			{
				$text .= esc_html(  get_theme_mod('copyright_text') );
			}else
			{
				/* translators: 1: Current Year, 2: Blog Name  */
				$text .= sprintf( esc_html__( 'Copyright &copy; %1$s %2$s. All Right Reserved.', 'fastest-shop' ), date_i18n( _x( 'Y', 'copyright date format', 'fastest-shop' ) ), esc_html( get_bloginfo( 'name' ) ) );

			
				
			}

			
			$html  .= apply_filters( 'fastest_shop_footer_copywrite_filter', $text );
				
			/* translators: 1: developer website, 2: WordPress url  */
			$html  .= '<span class="dev_info">'.sprintf( esc_html__( 'Theme : %1$s By aThemeArt - Proudly Powered by WordPress .', 'fastest-shop' ), '<a href="'. esc_url( 'https://athemeart.com/downloads/fastest-shop/' ) .'" target="_blank" rel="nofollow">'.esc_html_x( 'Fastest Shop', 'credit - theme', 'fastest-shop' ).'</a>' ).'</span>';
			
			$html .= '</div>';
			
			


		$html .= '<div class="col-12 col-md-12">';
			
			$html .='<ul class="social-list ">';
			
			if( fastest_shop_get_option('__fb_pro_link') != "" ): 
			$html .='<li class="social-item-facebook"><a href="'.esc_url( fastest_shop_get_option('__fb_pro_link') ).'" target="_blank" rel="nofollow"><i class="icofont-facebook"></i></a></li>';				
			endif;
			
			 if( fastest_shop_get_option('__tw_pro_link') != "" ): 
			$html .='<li class="social-item-twitter"><a href="'.esc_url( fastest_shop_get_option('__tw_pro_link') ).'" target="_blank" rel="nofollow"><i class="icofont-twitter"></i></a></li>';
			endif;
			if( fastest_shop_get_option('__you_pro_link') != "" ): 
			$html .='<li class="social-item-youtube"><a href="'.esc_url( fastest_shop_get_option('__you_pro_link') ).'" target="_blank" rel="nofollow"><i class="icofont-youtube"></i></a></li>';
			 endif;
					
				$html .='	</ul>';
			
			$html .= '</div>';	
			
		$html .= '	</div>
		  		</div>';
		
		
				
		echo wp_kses( $html, $this->alowed_tags() );
	
	}
	
	/**
	* diet_shop foter conteinr after
	*
	* @return $html
	*/
	public function site_footer_container_after (){
		
		$html = '</footer>';
						
		$html = apply_filters( 'fastest_shop_footer_container_after_filter',$html);		
				
		echo wp_kses( $html, $this->alowed_tags() );
	
	}
	
	
	private function alowed_tags(){
		
		if( function_exists('fastest_shop_alowed_tags') ){ 
			return fastest_shop_alowed_tags(); 
		}else{
			return array();	
		}
		
	}
}

$fastest_shop_footer_layout = new fastest_shop_Footer_Layout();