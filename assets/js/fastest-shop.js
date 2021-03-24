;(function($) {
'use strict'
// Dom Ready

	var back_to_top_scroll = function() {
			
			$('#backToTop').on('click', function() {
				$("html, body").animate({ scrollTop: 0 }, 500);
				return false;
			});
			
			$(window).scroll(function() {
				if ( $(this).scrollTop() > 500 ) {
					
					$('#backToTop').addClass('active');
				} else {
				  
					$('#backToTop').removeClass('active');
				}
				
			});
			
		}; // back_to_top_scroll   
	
	
		//Trap focus inside mobile menu modal
		//Based on https://codepen.io/eskjondal/pen/zKZyyg	
		var trapFocusInsiders = function(elem) {
			
				
			var tabbable = elem.find('select, input, textarea, button, a,#navbar i').filter(':visible');
			
			var firstTabbable = tabbable.first();
			var lastTabbable = tabbable.last();
			/*set focus on first input*/
			firstTabbable.focus();
			
			/*redirect last tab to first input*/
			lastTabbable.on('keydown', function (e) {
			   if ((e.which === 9 && !e.shiftKey)) {
				   e.preventDefault();
				   
				   firstTabbable.focus();
				  
			   }
			});
			
			/*redirect first shift+tab to last input*/
			firstTabbable.on('keydown', function (e) {
				if ((e.which === 9 && e.shiftKey)) {
					e.preventDefault();
					lastTabbable.focus();
				}
			});
			
			/* allow escape key to close insiders div */
			elem.on('keyup', function(e){
			  if (e.keyCode === 27 ) {
				elem.hide();
			  };
			});
			
		};

		var focus_to = function(action,element) {

			$(action).keyup(function (e) {
			    e.preventDefault();
				var code = e.keyCode || e.which;
				if(code == 13) { 
					$(element).focus();
				}
			});		
			
		}
	
	$(function() {
		
		back_to_top_scroll();
		
		
		if( $('.owlGallery .blocks-gallery-grid').length ){
			$(".owlGallery .blocks-gallery-grid").owlCarousel({
				stagePadding: 0,
				loop: true,
				autoplay: true,
				autoplayTimeout: 3000,
				margin: 0,
				nav: false,
				dots: false,
				smartSpeed: 2000,
				rtl: ( $("body.rtl").length ) ? true : false, 
				responsive: {
					0: {
						items: 1
					},
					600: {
						items: 1
					},
					1000: {
						items: 1
					}
				}
			});
		}
	 
	 	if( $('#secondary').length ){
			$('#secondary').stickySidebar({
				topSpacing: 60,
				bottomSpacing: 60,
			});
		}
		
		if( $('.fastest-shop-post-carousel-widgets').length ){
			
			$(".fastest-shop-post-carousel-widgets").owlCarousel({
				stagePadding: 0,
				loop: true,
				autoplay: true,
				autoplayTimeout: 2000,
				margin: 0,
				nav: false,
				dots: false,
				rtl: ( $("body.rtl").length ) ? true : false, 
				smartSpeed: 1000,
				responsive: {
					0: {
						items: ( $(".fastest-shop-post-carousel-widgets").data('xs') != "" ) ? $(".fastest-shop-post-carousel-widgets").data('xs') : 1
					},
					600: {
						items: ( $(".fastest-shop-post-carousel-widgets").data('sm') != "" ) ? $(".fastest-shop-post-carousel-widgets").data('sm') : 1
					},
					1000: {
						items: ( $(".fastest-shop-post-carousel-widgets").data('md') != "" ) ? $(".fastest-shop-post-carousel-widgets").data('md') : 1
					}
				}
			});
		}
		
	
		/*=============================================
	    =            Main Menu         =
	    =============================================*/
	   
		$('#navbar .navigation-menu li > a').keyup(function (e) {
			if ( matchMedia( 'only screen and (min-width: 992px)' ).matches ) {
				
				$("#navbar .navigation-menu li").removeClass('focus');
				$(this).parents('li.menu-item-has-children').addClass('focus');
				$(this).parents('li.page_item_has_children').addClass('focus');
			} 
			
		});	
	
		
		$('#navbar .navigation-menu li').hover(function(){	
			$('#navbar .navigation-menu li').removeClass('focus');
		});	
		
		
		$('#navbar li.menu-item-has-children,#navbar li.page_item_has_children').each(function( index ) {
			$(this).find('a').eq(0).after('<i class="icofont-rounded-down responsive-submenu-toggle" tabindex="0" autofocus="autofocus"></i>');
		});

		$('#secondary .widget li a').keyup(function (e) {
			if ( matchMedia( 'only screen and (min-width: 992px)' ).matches ) {
				$("#navbar .navigation-menu li").removeClass('focus');
				$(this).parents('li.menu-item-has-children').addClass('focus');
				$(this).parents('li.page_item_has_children').addClass('focus');
			}
		});	
		 

		$(".responsive-submenu-toggle").on('click', function(e){
			$(this).next('ul').toggleClass('focus-active');
			$(this).toggleClass('icofont-rounded-up');
	    });
		$(".responsive-submenu-toggle").keyup(function (e) {
		    e.preventDefault();
			var code = e.keyCode || e.which;
			if(code == 13) { 
				$(this).next('ul').toggleClass('focus-active');
				$(this).toggleClass('icofont-rounded-up');
			}
		});


  		$(".fastest-shop-rd-navbar-toggle").on('click', function(e){
			$('#navbar').toggleClass('active');
			$(this).find('i').toggleClass('icofont-arrow-left').toggleClass('icofont-navigation-menu');
			trapFocusInsiders( $('#navbar') );
	    });
	    $(".fastest-shop-navbar-close").on('click', function(e){
			$('#navbar').removeClass('active');
			$(".fastest-shop-rd-navbar-toggle").find('i').removeClass('icofont-arrow-left').addClass('icofont-navigation-menu');
	    });	
	  	
	  	
	  	$(window).on('load resize', function() {
			if ( matchMedia( 'only screen and (max-width: 992px)' ).matches && $('.ss-wrapper').length  == 0 ) {
				
				var el = document.querySelector('#navbar');
  				SimpleScrollbar.initEl(el);
			}
		});
		
		$('#masthead .header-icon li > a').keyup(function (e) {
			if ( matchMedia( 'only screen and (min-width: 992px)' ).matches ) {
				$("#masthead .header-icon li").removeClass('focus');
				$("#navbar .navigation-menu li").removeClass('focus');
				$(this).parents('li').addClass('focus');

			}
		});	
		/*=============================================
	    =            search overlay active            =
	    =============================================*/
	    
	    $(".search-overlay-trigger").on('click', function(e){
			e.preventDefault();
			$("#fly-search-bar").addClass("active");
			
	    });
	    
	    $(".search-close-trigger").on('click', function(e){
	    	 e.preventDefault();
	        $("#fly-search-bar").removeClass("active");
	    });
	    trapFocusInsiders( $("#fly-search-bar") );

		focus_to('.search-overlay-trigger',$("#fly-search-bar").find('input.search-field'));
		focus_to('.search-overlay-trigger',$("#fly-search-bar").find('input.apsw-search-input'));
		focus_to('.search-close-trigger',".search-overlay-trigger");

		$('#secondary .widget li a').keyup(function (e) {
			if ( matchMedia( 'only screen and (min-width: 992px)' ).matches ) {
				$("#secondary .widget li").removeClass('focus');
				$(this).parents('li').addClass('focus');

			}
		});	
		
		if( $('.image-popup').length ){
			$('.image-popup').magnificPopup({type:'image'});
		}
	});
})(jQuery);