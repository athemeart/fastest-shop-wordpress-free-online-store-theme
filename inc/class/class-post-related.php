<?php
/**
 * All POST Related Function 
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Diet_Shop
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
class fastest_shop_Post_Related {
	/**
	 * Function that is run after instantiation.
	 *
	 * @return void
	 */
	public function __construct() {
		
		if( !is_admin()  )
		{
			add_action( 'fastest_shop_site_content_type', array( $this,'site_loop_heading' ), 21 ); 
			add_action( 'fastest_shop_site_content_type', array( $this,'site_content_type' ), 30 ); 
		}
		
		add_action( 'fastest_shop_posts_blog_media', array( $this, 'render_thumbnail' ) ); 
		
		
		add_action( 'fastest_shop_loop_navigation', array( $this,'site_loop_navigation' ) );
		
		
		add_filter( 'the_content_more_link', array( $this,'content_read_more_link' ));
		add_filter( 'excerpt_more', array( $this,'excerpt_read_more_link' ) );
		
		add_filter( 'comment_form_fields', array( $this,'move_comment_field_to_bottom' ) );
	}
	
	/**
	 * Web Site heading
	 *
	 * @since 1.0.0
	 */
	public function site_loop_heading() {
		if( is_page() ) return;
		if ( is_singular() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark" >', '</a></h2>' );
		endif;
		
		
	}
	
	

    /**
     * @since  Blog Expert 1.0.0
     *
     * @param null
     */
    function site_content_type( ){
		
		$type = apply_filters( 'fastest_shop_content_type_filter', fastest_shop_get_option( 'blog_loop_content_type' ) );
		
		echo '<div class="content-wrap">';
		
			if( ! is_single() && !is_page()):
			
				if ( $type == 'content' ) 
				{
					the_content();
					
				}else
				{
					echo wp_kses_post( get_the_excerpt() );
				}
				
			else:
			
				the_content();
				
			endif;
			
		echo '</div>';

    }
	
	
	
	/**
	* Adds custom Read More link the_content().
	* add_filter( 'the_content_more_link', array( $this,'content_read_more_link' ));
	* @param string $more "Read more" excerpt string.
	* @return string (Maybe) modified "read more" excerpt string.
	*/
	public function content_read_more_link( $more  ) {
		if ( is_admin() ) return $more;
		return sprintf( '<div class="more-link">
             <a href="%1$s" class="btn  theme-btn"><span>%2$s </span><i class="icofont-thin-double-right"></i></a>
        </div>',
            esc_url( get_permalink( get_the_ID() ) ),
		    esc_html( fastest_shop_get_option( 'read_more_text' ) )
        );
		
	}
	
	/**
	* Filter the "read more" excerpt string link to the post.
	* //add_filter( 'excerpt_more', array( $this,'excerpt_read_more_link' ) );
	* @param string $more "Read more" excerpt string.
	* @return string (Maybe) modified "read more" excerpt string.
	*/
	public function excerpt_read_more_link( $more ) {
		if ( is_admin() ) return $more;
		if ( ! is_single() ) {
			$more = sprintf( '<div class="more-link">
				 <a href="%1$s" class="btn theme-btn"><span>%2$s </span><i class="icofont-thin-double-right"></i></a>
			</div>',
				esc_url( get_permalink( get_the_ID() ) ),
				esc_html( fastest_shop_get_option( 'read_more_text' ) )
			);
			
		}
		return $more;
	}

	/**
	 * Post Posts Loop Navigation
	 * add_action( 'fastest_shop_loop_navigation', $array( $this,'site_loop_navigation' ) ); 
	 * @since 1.0.0
	 */
	function site_loop_navigation( $type = '' ) {
		
		if( $type == '' ){
			$type = apply_filters( 'fastest_shop_loop_navigation_filter', get_theme_mod( 'fastest_shop_loop_navigation', 'default' ) );
		}
		
		if( $type == 'default' ):
		
			the_posts_navigation(
				array(
					'prev_text' => '<span class="btn-wrap">'.esc_html__('Previous Posts', 'fastest-shop').'</span><span class="icon"><i class="icofont-rounded-double-left"></i></span>',
					'next_text' => '<span class="btn-wrap">'.esc_html__('Next Posts', 'fastest-shop').'</span><span class="icon"><i class="icofont-rounded-double-right"></i></span>',
					'screen_reader_text' => __('Posts navigation', 'fastest-shop')
				)
			);
			echo '<div class="clearfix"></div>';
		
		else:
		
			echo '<div class="pagination-custom">';
			the_posts_pagination( array(
				'format' => '/page/%#%',
				'type' => 'list',
				'mid_size' => 2,
				'prev_text' => esc_html__( 'Previous', 'fastest-shop' ),
				'next_text' => esc_html__( 'Next', 'fastest-shop' ),
				'screen_reader_text' => esc_html__( '&nbsp;', 'fastest-shop' ),
			) );
		echo '</div>';
		endif;
		
		
	}
	
	
	/**
	 * Change Comment fields location
	 * @since 1.0.0
	 * @ add_filter( 'comment_form_fields', array( $this,'move_comment_field_to_bottom' ) );
	 */
	function move_comment_field_to_bottom( $fields ) {
		
		$comment_field = $fields['comment'];
		$cookies_field = $fields['cookies'];
		
		unset( $fields['comment'] );
		unset( $fields['cookies'] );
		
		$fields['comment'] = $comment_field;
		$fields['cookies'] = $cookies_field;
		
		return $fields;
	}
	
	
	
	/**
	 * Render post type thumbnail.
	 *
	 * @param $formats = string.
	 */
	public function render_thumbnail( $formats = '') {
		
		if( empty( $formats ) ) { $formats = get_post_format( get_the_ID() ); }
		
		
		switch ( $formats ) {
			default:
				$this->get_image_thumbnail();
			break;
			case 'gallery':
				$this->get_gallery_thumbnail();
			break;
			case 'audio':
				$this->get_audio_thumbnail();
			break;
			case 'video':
				$this->get_video_thumbnail();
			break;
		} 
	
	}
	
	
	/**
	 * Post formats audio.
	 *
	 * @since 1.0.0
	 */
	public function get_gallery_thumbnail(){
		
		global $post;
		$html = '';
		if( has_block('gallery', $post->post_content) ): 
			$html = '<div class="img-box">';
			$post_blocks = parse_blocks( $post->post_content );
			
			if( !empty( $post_blocks ) ):
				
				$html .= '<div class="gallery-media wp-block-gallery owlGallery">';
				foreach ( $post_blocks as $row  ):
					if( $row['blockName']=='core/gallery' )
					$html .= $row['innerHTML'];
				endforeach;
				$html .= '</div>';
			endif;
			$html .= '</div>';
		elseif ( get_post_gallery() ) :
			$html = '<div class="img-box">';
			
			$html .= '<figure class="gallery-media owlGallery">';
			
				$gallery = get_post_gallery( $post, false );
				$ids     = explode( ",", $gallery['ids'] );
				
				if( !empty( $ids  ) ) :
				foreach( $ids as $id ) {
				
				   $link   = wp_get_attachment_url( $id );
				
				   $html  .= '<div class="item"><img src="' . esc_url( $link ) . '"  class="img-responsive" alt="' .esc_attr( get_the_title() ). '" title="' .esc_attr( get_the_title() ). '"  /></div>';
				
				} 
				endif;
			$html .= '</figure>';
			$html .= '</div>';
		else: 
			
			$html .= $this->get_image_thumbnail();
			
		endif;	
		
		
		
		$html =  apply_filters( 'diet_shop_gallery_thumbnail', $html );
		
		echo wp_kses( $html, $this->alowed_tags() );
	}
	/**
	 * Post formats audio.
	 *
	 * @since 1.0.0
	 */
	public function get_audio_thumbnail(){
		
		$content 		= apply_filters( 'the_content', get_the_content() );
		$audio			= false;
		
		$post_thumbnail_url 	= '';
	
		// Only get audio from the content if a playlist isn't present.
		if ( false === strpos( $content, 'wp-playlist-script' ) ) {
			$audio 		= get_media_embedded_in_content( $content, array( 'audio' ) );
		}
		
		if ( has_post_thumbnail() ) :
		
			$post_thumbnail_id 		= get_post_thumbnail_id( get_the_ID() );
			$post_thumbnail_url 	= wp_get_attachment_url( $post_thumbnail_id );
		
		endif;
			
			
		// If not a single post, highlight the audio file.
		if ( ! empty( $audio ) )
		{	 $i = 0;
			
			$html  = '<div class="img-box">';
			
			foreach ( $audio as $audio_html ) : $i++;
			
				if( $post_thumbnail_url != "" )
				{
					$html .= '<figure style="background: url(\''.esc_url( $post_thumbnail_url ).'\') no-repeat center center; background-size:cover;" class="entry-audio embed-responsive embed-responsive-16by9"><div class="audio-center">';
					
					$html .= wp_kses( $audio_html, $this->alowed_tags() );
					
					$html .= '</div></figure>';
					
				}else{
					
					$html .= wp_kses( $audio_html, $this->alowed_tags() );
					
				}
			
				if( $i == 1 ){ break; }
					
			endforeach;
			$html .= '</div>';
		}else {
			$html .= $this->get_image_thumbnail();
		}
		
		
		
		
		$html =  apply_filters( 'diet_shop_audio_thumbnail', $html );
		
		echo wp_kses( $html, $this->alowed_tags() );
	}
	
	
	/**
	 * Post formats video.
	 *
	 * @since 1.0.0
	 */
	public function get_video_thumbnail(){
		
		$content	 = apply_filters( 'the_content', get_the_content(get_the_ID()) );
		$video 	  	 = false;
		
		
		// Only get video from the content if a playlist isn't present.
		if ( false === strpos( $content, 'wp-playlist-script' ) ) {
			$video = get_media_embedded_in_content( $content, array( 'video', 'object', 'embed', 'iframe' ) );
		}
        
		if ( ! empty( $video ) ) 
		{	
			$html = '<div class="img-box">';
			$i = 0;
			
			foreach ( $video as $video_html ) {  $i++;
			
				$html  .=  '<div class="entry-video embed-responsive embed-responsive-16by9">';
				$html .= wp_kses( $video_html, $this->alowed_tags() );
				$html  .=  '</div>';
				
				if( $i == 1 ){ break; }
			}
			$html .= '</div>';
		}else
		{ 
			$html .= $this->get_image_thumbnail();
		}
		
		
		
		$html =  apply_filters( 'diet_shop_video_thumbnail', $html );
		
		echo wp_kses( $html, $this->alowed_tags() );
	}
	
	
	/**
	 * Post formats thumbnail.
	 *
	 * @since 1.0.0
	 */
	public function get_image_thumbnail(){
		$html = '';
		
		if ( has_post_thumbnail() ) :

			$html = '<div class="img-box">';
			$post_thumbnail_id  = get_post_thumbnail_id( get_the_ID() );
			$post_thumbnail_url = wp_get_attachment_url( $post_thumbnail_id );
			
			
			
			if ( is_singular() )
			{
				$html  .=  '<a href="'.esc_url( $post_thumbnail_url ).'" class="image-popup">';
			} else
			{
				$html  .= '<a href="'.esc_url( get_permalink(get_the_ID()) ).'" class="image-link">';
			}
			
        	$html .= get_the_post_thumbnail( get_the_ID(), 'full' );
			$html .='</a>';
			$html .= '</div>';
        endif;
		

		
		
	
		$html =  apply_filters( 'diet_shop_image_thumbnail', $html );
		
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

$fastest_shop_post_related = new fastest_shop_Post_Related();