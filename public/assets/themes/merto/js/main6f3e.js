jQuery(function($){
	"use strict";
	var on_touch = !$('body').hasClass('ts_desktop');

	setTimeout(function(){
		$('.footer-container.loading').removeClass('loading');
		$('.ts-custom-block-content').removeClass('hidden');
	}, 10);
	
	/** CSS Global scrollbarWidth Variable **/
	if( typeof $.position != 'undefined' && typeof $.position.scrollbarWidth != 'undefined' ){
		document.documentElement.style.setProperty('--scrollbarWidth',$.position.scrollbarWidth() + 'px');
	}
	
	/** Middle Navigation **/
	$(window).on('ts_slider_middle_navigation_position', function(e, swiper){
		if( swiper.parents('.ts-slider:not(.ts-product).middle-thumbnail.rows-1').length || swiper.parents('.ts-slider.ts-product-category-wrapper').length ){
			var thumbnail = swiper.find('.swiper-slide-active').first().find('.product-wrapper .thumbnail-wrapper, .product-wrapper > a, .article-content .thumbnail-content > a.thumbnail, .team-content > .image-thumbnail');
			var top = thumbnail.length ? thumbnail.height() / 2 : 0;
			if( top ){
				swiper.find('.swiper-button-prev, .swiper-button-next').css('top', top);
			}
		}
	});
	
	/* [wrapper selector, slider selector, slider options, extra settings] */
	var carousel_data = [
		['.single-product .related .products, .single-product .upsells .products, .woocommerce .cross-sells .products', null, null]
		,['.single-post .related-posts .blogs', '.content-wrapper .blogs', {breakpoints:{0: { slidesPerView: 1 }, 600: { slidesPerView: 2 }, 900: { slidesPerView: 3 }, 1200: { slidesPerView: 4 }}}]
		,['.single-post figure.gallery, .list-posts .post-item .gallery figure, .ts-blogs-widget .thumbnail.gallery figure', null, {simulateTouch: false, effect: 'fade', fadeEffect: {crossFade: true}, breakpoints:{0:{slidesPerView:1}}}, {show_dots: true, auto_play: true}]
	];
	
	$.each(carousel_data, function( i, data ){
		$(data[0]).each(function( index ){
			var element = $(this);
			if( typeof data[1] != 'undefined' && data[1] != null ){
				var swiper = element.find(data[1]);
			}
			else{
				var swiper = element;
			}
			
			if( swiper.find('> *').length <= 1 ){
				element.removeClass('loading');
				swiper.parent().removeClass('loading');
				return;
			}
			
			var unique_class = 'swiper-theme-' + Math.floor(Math.random() * 10000) + '-' + index;
		
			swiper.addClass('swiper ' + unique_class);
			swiper.find('> *').addClass('swiper-slide');
			swiper.wrapInner('<div class="swiper-wrapper"></div>');
			
			if( $('body').hasClass('rtl') ){
				swiper.attr('dir', 'rtl');
			}
			
			var slider_options = {
				loop: true
				,spaceBetween: 0
				,breakpointsBase: 'container'
				,breakpoints:{0:{slidesPerView:1},260:{slidesPerView:2},540:{slidesPerView:3},760:{slidesPerView:4},1000:{slidesPerView:5}}
				,on: {
					init: function(){
						element.removeClass('loading');
						swiper.parent().removeClass('loading');
						$(window).trigger('ts_slider_middle_navigation_position', [swiper]);
					}
					,resize: function(){
						$(window).trigger('ts_slider_middle_navigation_position', [swiper]);
					}
				}
			};
			
			if( typeof data[2] != 'undefined' && data[2] != null ){
				$.extend( slider_options, data[2] );
			}
			
			if( typeof data[3] != 'undefined' && data[3] != null ){
				var extra_settings = data[3];
				
				if( typeof extra_settings.loop != 'undefined' ){
					slider_options.loop = extra_settings.loop;
				}
				
				if( typeof extra_settings.show_nav != 'undefined' && extra_settings.show_nav ){
					swiper.append('<div class="swiper-button-prev"></div><div class="swiper-button-next"></div>');
					
					slider_options.navigation = {
						prevEl: '.swiper-button-prev'
						,nextEl: '.swiper-button-next'
					};
				}
				
				if( typeof extra_settings.show_dots != 'undefined' && extra_settings.show_dots ){
					swiper.append('<div class="swiper-pagination"></div>');
					
					slider_options.pagination = {
						el: '.swiper-pagination'
						, clickable: true
					};
				}
				
				if( typeof extra_settings.auto_play != 'undefined' && extra_settings.auto_play ){
					slider_options.autoplay = {
						delay: 5000
						,disableOnInteraction: false
						,pauseOnMouseEnter: true
					};
				}
			}
			
			new Swiper( '.' + unique_class, slider_options );
		});
	});

	/** Mega menu **/
	ts_mega_menu_change_state();
	$('.elementor-widget-wp-widget-nav_menu .menu-item-has-children .sub-menu').before('<span class="ts-menu-drop-icon"></span>');

	/** Menu on IPAD **/
	ts_mobile_ipad_menu_handle();


	
	/** Login Popup **/
	$('.ts-tiny-account-wrapper .login').on('click', function(e){
		if( $('#ts-login-popup-modal').length && $(window).width() > 768 ){
			$('#ts-login-popup-modal').addClass('show');
			setTimeout(function(){
				$('#ts-login-popup-modal form input:first').trigger('focus');
			}, 100);
			e.preventDefault();
		}
	});
	
	/** Store Notice **/
	$('.ts-store-notice .close').on('click', function(){
		$('.ts-store-notice').slideUp();
		if( typeof Cookies != 'undefined' ){
			Cookies.set('ts_store_notice', 'hidden', { expires: 1 });
		}
	});
	
	/** Vertical Menu **/
	$('.vertical-menu-fixed .vertical-menu-heading').on('click', function(){
		$('.menu-sticky-wrapper').addClass('active disabled-pointer-event');
		setTimeout(function(){
			$('.menu-sticky-wrapper').removeClass('disabled-pointer-event');
		}, 600);
	});
	$('.menu-sticky-wrapper .overlay').on('click', function(){
		$('.menu-sticky-wrapper').removeClass('active');
	});


	$('.icon-menu-sticky-header .icon').on('click', function(){
		if( $(this).hasClass('active') ){
			$('header .header-bottom').css('display', '');
		}else{
			$('header .header-bottom').fadeIn('fast');
		}
		$(this).toggleClass('active');
		ts_mega_menu_change_state();
	});

	/** Device - Resize action **/
	$(window).on('resize orientationchange', function(){
		ts_mega_menu_change_state();
	});

	/* Tab Mobile Menu */
	$('.tab-mobile-menu li:not(.close)').on('click', function(){
		$('#group-icon-header li.parent, #group-icon-header .ts-menu-drop-icon').removeClass('active');
		$('#group-icon-header ul.sub-menu, #group-icon-header .mobile-menu-wrapper').css('overflow', '');
		$('#group-icon-header ul.sub-menu').css('z-index', '');
		if( $(this).attr('id') == 'main-menu' ){
			$('.tab-vertical-menu').css('display', 'none');
			$('.tab-menu-mobile').css('display', 'block');
			$('#main-menu').addClass('active');
			$('#vertical-menu').removeClass('active');
		}
		else if( $(this).attr('id') == 'vertical-menu' ){
			$('.tab-menu-mobile').css('display', 'none');
			$('.tab-vertical-menu').css('display', 'block');
			$('#vertical-menu').addClass('active');
			$('#main-menu').removeClass('active');
		}
		$('#group-icon-header .menu-title span').text($(this).text());
	});

	/** To Top button **/
	$(window).on('scroll', function(){
		if( $(this).scrollTop() > 100 ){
			$('#to-top').addClass('on');
		}else{
			$('#to-top').removeClass('on');
		}
	});

	$('#to-top .scroll-button').on('click', function(){
		$('body,html').animate({
			scrollTop: '0px'
		}, 1000);
		return false;
	});



	function quickshop_init_zoom( zoomTarget, $target ){
		if( typeof $.fn.zoom != 'function' ){
			return;
		}

		var galleryWidth = $target.width(), zoomEnabled = false;

		$(zoomTarget).each(function(index, target){
			var image = $(target).find('img');

			if( image.attr('data-large_image_width') > galleryWidth ){
				zoomEnabled = true;
				return false;
			}
		});

	
	}

	$(document).on('click', '.ts-popup-modal .close, .ts-popup-modal .overlay', function(){
		$('.ts-popup-modal').removeClass('show');
		$('.ts-popup-modal .quickshop-content').html(''); /* prevent conflict with lightbox on single product */
		$('body').removeClass('opening-quickshop');
	});

	/*** Color Swatch ***/
	$(document).on('click', '.products .product .color-swatch > div', function(){
		$(this).siblings().removeClass('active');
		$(this).addClass('active');
		/* Change thumbnail */
		var image_src = $(this).data('thumb');
		$(this).closest('.product').find('figure img:first').attr('src', image_src).removeAttr('srcset sizes');
		/* Change price */
		var term_id = $(this).data('term_id');
		var variable_prices = $(this).parent().siblings('.variable-prices');
		var price_html = variable_prices.find('[data-term_id="' + term_id + '"]').html();
		$(this).closest('.product').find('.meta-wrapper .price').html(price_html).addClass('variation-price');
	});

	/*** Product Stock - Variable Product ***/
	function single_variable_product_reset_stock(wrapper){
		var stock_html = wrapper.find('.availability').data('original');
		var classes = wrapper.find('.availability').data('class');
		if( classes == '' ){
			classes = 'in-stock';
		}
		wrapper.find('.availability .availability-text').html(stock_html);
		wrapper.find('.availability').removeClass('in-stock out-of-stock').addClass(classes);
	}

	$(document).on('found_variation', 'form.variations_form', function(e, variation){
		var wrapper = $(this).parents('.summary');
		
		setTimeout(function(){
			if( wrapper.find('.single_variation .stock').length ){
				var stock_html = wrapper.find('.single_variation .stock').html();
				var classes = wrapper.find('.single_variation .stock').hasClass('out-of-stock') ? 'out-of-stock' : 'in-stock';
				wrapper.find('.availability .availability-text').html(stock_html);
				wrapper.find('.availability').removeClass('in-stock out-of-stock').addClass(classes);
			}
			else{
				single_variable_product_reset_stock(wrapper);
			}
		}, 310);
		
		if( typeof variation.discount_number != 'undefined' && variation.discount_number ){
			wrapper.find('.ts-discount-number').removeClass('hidden');
			wrapper.find('.ts-discount-number .number').html(variation.discount_number);
		}
		else{
			wrapper.find('.ts-discount-number').addClass('hidden');
		}
	});

	$(document).on('reset_image', 'form.variations_form', function(){
		var wrapper = $(this).parents('.summary');
		single_variable_product_reset_stock(wrapper);
		
		wrapper.find('.ts-discount-number').addClass('hidden');
	});

	/*** Variation attribute ***/
	$(document).on('change', '.product form.variations_form .variations select', function(){
		var data = $(this).val();
		var dataAttr = data.length ? $(this).find('option[value="' + data + '"]').text() : '';
		var attributes = $(this).parents('tr');
		var html = $('<span class="ts-value"></span>').text(dataAttr);

		attributes.find('> .label .ts-value').remove();
		attributes.find('> .label').append(html);
	});

	$('.product form.variations_form .variations select').trigger('change');

	/*** Variation price ***/
	$(document).on('found_variation', 'form.variations_form', function(e, variation){
		var summary = $(this).parents('.summary');
		if( variation.price_html ){
			summary.find('.ts-variation-price').html(variation.price_html).removeClass('hidden');
			summary.find('p.price').addClass('hidden');
		}
	});

	$(document).on('reset_image', 'form.variations_form', function(){
		var summary = $(this).parents('.summary');
		summary.find('p.price').removeClass('hidden');
		summary.find('.ts-variation-price').addClass('hidden');
	});

	/*** Hide product attribute if not available ***/
	$(document).on('update_variation_values', 'form.variations_form', function(){
		if( $(this).find('.ts-product-attribute').length > 0 ){
			$(this).find('.ts-product-attribute').each(function(){
				var attr = $(this);
				var values = [];
				attr.siblings('select').find('option').each(function(){
					if( $(this).attr('value') ){
						values.push($(this).attr('value'));
					}
				});
				attr.find('.option').removeClass('hidden');
				attr.find('.option').each(function(){
					if( $.inArray( $(this).attr('data-value'), values ) == -1 ){
						$(this).addClass('hidden');
					}
				});
			});
		}
	});



	/*** Buy Now ***/
	$(document).on('click', '.ts-buy-now-button', function(e){
		e.preventDefault();
		var cart_form = $(this).parents('.summary').find('form.cart');
		if( cart_form.length ){
			if( !$(this).hasClass('disabled') ){
				$(document).off('submit', '.product:not(.product-type-external) .summary form.cart'); /* disable ajax add to cart */
				cart_form.append('<input type="hidden" name="ts_buy_now" value="1" />');
			}
			cart_form.find('.single_add_to_cart_button').trigger('click');
		}
	});
	
	$(document).on('found_variation', 'form.variations_form', function(){
		$(this).parents('.summary').find('.ts-buy-now-button').removeClass('disabled');
	});
	
	$(document).on('reset_image', 'form.variations_form', function(){
		$(this).parents('.summary').find('.ts-buy-now-button').addClass('disabled');
	});

	/*** Custom Orderby on Product Page ***/
	$('form.woocommerce-ordering ul.orderby ul a').on('click', function(e){
		e.preventDefault();
		if( $(this).hasClass('current') ){
			return;
		}
		var form = $('form.woocommerce-ordering');
		var data = $(this).attr('data-orderby');
		form.find('select.orderby').val(data).trigger('change');
	});

	/*** Per page on Product page ***/
	$('form.product-per-page-form ul.perpage ul a').on('click', function(e){
		e.preventDefault();

		if( $(this).hasClass('current') ){
			return;
		}
		var form = $(this).parents('form.product-per-page-form');
		var data = $(this).attr('data-perpage');

		form.find('select.perpage').val(data);
		form.submit();
	});
	
	/* Grid/List Toggle */
	$('.gridlist-toggle span').on('click', function(){
		var style = $(this).data('style');
		$(this).addClass('active').siblings().removeClass('active');
		$('.woocommerce.main-products').removeClass('grid list').addClass( style );
	});

	/*** Quantity on shop page ***/
	$(document).on('change', '.products .product input[name="quantity"]', function(){
		var add_to_cart_button = $(this).parents('.product').find('.add_to_cart_button');
		var quantity = parseInt($(this).val());
		add_to_cart_button.attr('data-quantity', quantity);
		/* For non ajax */
		var href = '?add-to-cart=' + add_to_cart_button.eq(0).attr('data-product_id') + '&quantity=' + quantity;
		add_to_cart_button.attr('href', href);
	});

	/*** Widget toggle ***/
	$('.ts-sidebar .widget-title-wrapper .block-control').on('click', function(e){
		e.preventDefault();
		$(this).toggleClass('active');
		$(this).parent().siblings(':not(script)').toggleClass('active');
	});
	
	/*** Set Top Shop Elements ***/
	$(window).on('resize ts_set_top_shop_elements', function(){
		var top = 0;
		top += $('.header-sticky.is-sticky').length ? $('.header-sticky.is-sticky').height() : 0;
		top += $('#wpadminbar').length ? $('#wpadminbar').height() : 0;
		
		if( $('.before-loop-wrapper').length ){
			$('.before-loop-wrapper').css( 'top', $(window).width() < 768 ? top : '' );
		}
		
		if( $('.collapse-scroll-sidebar .ts-sidebar > aside').length ){
			top += 30;
			$('.ts-sidebar > aside').css( 'top', top );
		}
		
		/* Product Detail - Summary Scrolling */
		if( $('div.product.summary-scrolling div.summary, div.product.gallery-layout-grid div.summary').length ){
			top += 30;
			$('div.product div.summary').css( 'top', top );
		}
	});
	
	$(window).trigger('ts_set_top_shop_elements');

	/* Image Lazy Load */
	function lazyload_slider_middle_navigation_position( img ){
		if( img.parents('.swiper').length && !img.parents('.swiper.lazy-recalc-nav-pos').length && img.parents('.swiper-slide-active').length ){
			img.parents('.swiper').addClass('lazy-recalc-nav-pos');
			$(window).trigger('ts_slider_middle_navigation_position', [img.parents('.swiper')]);
			img.on('load', function(){ /* recalc if image is not loaded */
				$(window).trigger('ts_slider_middle_navigation_position', [img.parents('.swiper')]);
			});
		}
	}
	
	if( $('img.ts-lazy-load').length ){
		$(window).on('scroll ts_lazy_load', function(){
			var scroll_top = $(this).scrollTop();
			var window_height = $(this).height();
			$('img.ts-lazy-load:not(.loaded)').each(function(){
				if( $(this).data('src') && $(this).offset().top < scroll_top + window_height + 900 ){
					$(this).attr('src', $(this).data('src')).addClass('loaded');
					lazyload_slider_middle_navigation_position( $(this) );
				}
			});
		});

		setTimeout(function(){
			if( $('img.ts-lazy-load:first').offset().top < $(window).scrollTop() + $(window).height() + 200 ){
				$(window).trigger('ts_lazy_load');
			}
		}, 50);
	}

	/* WooCommerce Quantity Increment */
	$(document).on('click', '.plus, .minus', function(){
		var $qty = $(this).closest('.quantity').find('.qty'),
			currentVal = parseFloat($qty.val()),
			max = parseFloat($qty.attr('max')),
			min = parseFloat($qty.attr('min')),
			step = $qty.attr('step');

		if( !currentVal || currentVal === '' || currentVal === 'NaN' ) currentVal = 0;
		if( max === '' || max === 'NaN' ) max = '';
		if( min === '' || min === 'NaN' ) min = 0;
		if( step === 'any' || step === '' || step === undefined || parseFloat(step) === 'NaN' ) step = 1;

		if( $(this).is('.plus') ){
			if( max && ( max == currentVal || currentVal > max ) ){
				$qty.val(max);
			}else{
				$qty.val(currentVal + parseFloat(step));
			}
		}else{
			if( min && ( min == currentVal || currentVal < min ) ){
				$qty.val(min);
			}else if( currentVal > 0 ){
				$qty.val(currentVal - parseFloat(step));
			}
		}

		$qty.trigger('change');
	});


	
	/* Shopping Cart Sidebar */
	$(document).on('click', '.search-button .icon, .shopping-cart-wrapper .cart-control', function(e){
		$('.ts-floating-sidebar .close').trigger('click');
		var is_cart = $(this).is('.cart-control');
		if( is_cart ){
			if( $('#ts-shopping-cart-sidebar').length ){
				e.preventDefault();
				$('#ts-shopping-cart-sidebar').addClass('active');
				$('body').addClass('floating-sidebar-active');
			}
		}
		else if( $('#ts-search-sidebar').length ){
			$('#ts-search-sidebar').addClass('active');
			$('body').addClass('floating-sidebar-active');
			setTimeout(function(){
				$('#ts-search-sidebar input[name="s"]').trigger('focus');
			}, 100);
		}
	});

	$('.ts-floating-sidebar .overlay, .ts-floating-sidebar .close').on('click', function(){
		$('.ts-floating-sidebar').removeClass('active');
		$('body').removeClass('floating-sidebar-active');

		$('body').removeClass('menu-mobile-active');
		$('.ts-mobile-icon-toggle .icon').removeClass('active');

		$('.filter-widget-area-button').removeClass('active');
		
		$('#main-content').removeClass('show-filter-sidebar');
		
		update_filter_area_main_content_height();
	});



	/* Show cart after removing item */
	$(document.body).on('click', '.shopping-cart-wrapper .remove_from_cart_button', function(){
		$(this).parents('.shopping-cart-wrapper').addClass('updating');
	});
	$(document.body).on('removed_from_cart', function(){
		if( $('.shopping-cart-wrapper.updating').length && !$('.shopping-cart-wrapper.updating').is(':hover') ){
			$('.shopping-cart-wrapper').removeClass('updating');
		}
	});



	$(document).on('mouseleave', '.shopping-cart-wrapper.updating', function(){
		$(this).removeClass('updating');
	});

	/* Filter Widget Area */
	var filter_sidebar_interval = 0;
	function update_filter_area_main_content_height(){
		if( !$('#ts-filter-widget-area').length || $('#main-content').hasClass('style-top') ){
			return;
		}

		if( $('#ts-filter-widget-area').hasClass('active') ){
			filter_sidebar_interval = setInterval(function(){
				$('#main-content').css('min-height', $('#ts-filter-widget-area .filter-widget-area').height() + ( $('.before-loop-wrapper').length ? $('.before-loop-wrapper').outerHeight(true) : 0 ) + 20);
			}, 1000);
		}
		else{
			clearInterval(filter_sidebar_interval);
			$('#main-content').css('min-height', '');
		}
	}

	update_filter_area_main_content_height();

	$('.filter-widget-area-button a, .filter-widget-area-button + .overlay, .ts-sidebar > .close').on('click', function(){
		
		$('#ts-filter-widget-area, .ts-sidebar').toggleClass('active');
		$('#main-content').toggleClass('show-filter-sidebar');
		$('.filter-widget-area-button').toggleClass('active');
		update_filter_area_main_content_height();

		return false;
	});

	/* Product On Sale Checkbox */
	$('.product-on-sale-form input[type="checkbox"]').on('change', function(){
		$(this).parents('form').submit();
	});

	/* Single Product - Variable Product options */
	$(document).on('click', '.variations_form .ts-product-attribute .option a', function(){
		var _this = $(this);
		var val = _this.closest('.option').data('value');
		var selector = _this.closest('.ts-product-attribute').siblings('select');
		if( selector.length ){
			if( selector.find('option[value="' + val + '"]').length ){
				selector.val(val).change();
				_this.closest('.ts-product-attribute').find('.option').removeClass('selected');
				_this.closest('.option').addClass('selected');
			}
		}
		return false;
	});

	$('.variations_form').on('click', '.reset_variations', function(){
		$(this).closest('.variations').find('.ts-product-attribute .option').removeClass('selected');
	});

	/** Widget woocommerce nav link */
	$(document).on('click', '.woocommerce-widget-layered-nav-list .woocommerce-widget-layered-nav-list__item span.count', function(){
		$(this).prev('a')[0].click();
	});
	

});

/*** Mega menu ***/
var ts_mega_menu_timeout = 0;
function ts_mega_menu_change_state(){
	if( Math.max(window.outerWidth, jQuery(window).width()) > 767 ){

		var padding_left = 0, container_width = 0;
		var container = jQuery('.header-sticky .container:first');
		var container_stretch = jQuery('.header-sticky');
		if( !container.length ){
			container = jQuery('.header-sticky');
			if( !container.length ){
				return;
			}
			container_width = container.outerWidth();
		}
		else{
			container_width = container.width();
			padding_left = parseInt(container.css('padding-left'));
		}
		var container_offset = container.offset();

		var container_stretch_width = container_stretch.outerWidth();
		var container_stretch_offset = container_stretch.offset();

		clearTimeout(ts_mega_menu_timeout);

		ts_mega_menu_timeout = setTimeout(function(){
			jQuery('.ts-menu nav.main-menu > ul.menu > .ts-megamenu-fullwidth').each(function(index, element){
				var current_offset = jQuery(element).offset();
				if( jQuery(element).hasClass('ts-megamenu-fullwidth-stretch') ){
					var left = current_offset.left - container_stretch_offset.left;
					jQuery(element).children('ul.sub-menu').css({ 'width': container_stretch_width + 'px', 'left': -left + 'px', 'right': 'auto' });
				}
				else{
					var left = current_offset.left - container_offset.left - padding_left;
					jQuery(element).children('ul.sub-menu').css({ 'width': container_width + 'px', 'left': -left + 'px', 'right': 'auto' });
				}
			});

			jQuery('.ts-menu nav.main-menu > ul.menu').children('.ts-megamenu-columns-1, .ts-megamenu-columns-2, .ts-megamenu-columns-3, .ts-megamenu-columns-4').each(function(index, element){
				jQuery(element).children('ul.sub-menu').css({ 'max-width': container_width + 'px' });
				var sub_menu_width = jQuery(element).children('ul.sub-menu').outerWidth();
				var item_width = jQuery(element).outerWidth();
				jQuery(element).children('ul.sub-menu').css({ 'left': '-' + (sub_menu_width / 2 - item_width / 2) + 'px', 'right': 'auto' });

				var container_left = container_offset.left;
				var container_right = container_left + container_width;
				var item_left = jQuery(element).offset().left;

				var overflow_left = (sub_menu_width / 2 > (item_left + item_width / 2 - container_left));
				var overflow_right = ((sub_menu_width / 2 + item_left + item_width / 2) > container_right);
				if( overflow_left ){
					var left = item_left - container_left - padding_left;
					jQuery(element).children('ul.sub-menu').css({ 'left': -left + 'px', 'right': 'auto' });
				}
				if( overflow_right && !overflow_left ){
					var left = item_left - container_left - padding_left;
					left = left - (container_width - sub_menu_width);
					jQuery(element).children('ul.sub-menu').css({ 'left': -left + 'px', 'right': 'auto' });
				}
			});

			/* Remove hide class after loading */
			jQuery('ul.menu li.menu-item').removeClass('hide');

		}, 100);
	}
	else { /* Mobile menu action */
		jQuery('#wpadminbar').css('position', 'fixed');

		/* Remove hide class after loading */
		jQuery('ul.menu li.menu-item').removeClass('hide');
	}
}

function ts_mobile_ipad_menu_handle(){
	/* Mobile Menu One Page */
	jQuery('.ts-mobile-icon-toggle .icon').on('click', function(){
		jQuery(this).toggleClass('active');
		jQuery('#group-icon-header').toggleClass('active');
		jQuery('body').toggleClass('menu-mobile-active');
	});

	/* Main Menu Drop Icon */
	jQuery('.ts-menu nav.main-menu .ts-menu-drop-icon').on('click', function(){

		var is_active = jQuery(this).hasClass('active');
		var sub_menu = jQuery(this).siblings('.sub-menu');

		jQuery('.ts-menu nav.main-menu .ts-menu-drop-icon').removeClass('active');
		jQuery('.ts-menu nav.main-menu .sub-menu').hide();

		jQuery(this).parents('.sub-menu').show();
		jQuery(this).parents('.sub-menu').siblings('.ts-menu-drop-icon').addClass('active');

		/* Reset Dropdown Cart */
		jQuery('header .shopping-cart-wrapper').removeClass('active');

		if( sub_menu.length ){
			if( is_active ){
				sub_menu.fadeOut(250);
				jQuery(this).removeClass('active');
			}
			else{
				sub_menu.fadeIn(250);
				jQuery(this).addClass('active');
			}
		}
	});

	/* Mobile Menu Drop Icon */
	if( jQuery('.ts-menu nav.mobile-menu .ts-menu-drop-icon').length ){
		jQuery('.ts-menu nav.mobile-menu .sub-menu').hide();
	}

	jQuery('.ts-menu.mobile-menu-wrapper .ts-menu-drop-icon').on('click', function(){
		var is_active = jQuery(this).hasClass('active');
		var sub_menu = jQuery(this).siblings('.sub-menu');
		var li_parent = jQuery(this).parent();
		var ul_submenu = jQuery(this).closest('.sub-menu');
		jQuery('#group-icon-header').addClass('not-first-level');

		if( is_active ){
			if( ul_submenu.length ){
				var z_index = ul_submenu.css('z-index');
				z_index = parseInt(z_index) - 1;
				ul_submenu.css('z-index', z_index);
				ul_submenu.css('overflow', 'scroll');
				ul_submenu.css('bottom', '0');
			}
			else{
				jQuery('#group-icon-header .mobile-menu-wrapper').css('overflow', 'auto');
			}

			sub_menu.find('.ts-menu-drop-icon').removeClass('active');
			li_parent.removeClass('active');
			jQuery(this).removeClass('active');

			if( !ul_submenu.length ){ /* First level */
				var menu_title_back = jQuery('.tab-mobile-menu li.active span').text();
				jQuery('#group-icon-header').removeClass('not-first-level');
			}
			else{
				if( ul_submenu.siblings('a').find('.menu-label').length ){
					var menu_title_back = ul_submenu.siblings('a').find('.menu-label').text();
				}
				else{
					var menu_title_back = ul_submenu.siblings('a').text();
				}
			}
			jQuery('#group-icon-header .menu-title span').text(menu_title_back);
		}
		else{
			if( ul_submenu.length ){
				var z_index = ul_submenu.css('z-index');
				z_index = parseInt(z_index) + 1;
				ul_submenu.css('z-index', z_index);
				ul_submenu.css('overflow', 'hidden');
				ul_submenu.css('bottom', 'auto');
			}
			else{
				jQuery('#group-icon-header .mobile-menu-wrapper').scrollTop(0);
				jQuery('#group-icon-header .mobile-menu-wrapper').css('overflow', 'hidden');
			}
			li_parent.addClass('active');
			jQuery(this).addClass('active');

			if( li_parent.find('> a .menu-label').length ){
				var menu_title = li_parent.find('> a .menu-label').text();
			}
			else{
				var menu_title = li_parent.find('> a').text();
			}

			jQuery('#group-icon-header .menu-title span').text(menu_title);
		}
	});

}

/*** Sticky Menu ***/
function ts_sticky_menu(){
	var top_begin = jQuery('header.ts-header').height() + 300;
	var sub_menu = jQuery('header .main-menu > ul > li > ul.sub-menu');
	
	if( jQuery('body').hasClass('display-vertical-menu') && jQuery('.ts-header nav.vertical-menu').length ){
		top_begin += jQuery('.ts-header nav.vertical-menu').height();
	}

	setTimeout(function(){
		jQuery('.header-sticky').mysticky({
			topBegin: top_begin
			, scrollOnTop: function(){
				ts_mega_menu_change_state();

				/* RESET MENU STICKY */
				jQuery('header .header-bottom').css('display', '');
				jQuery('.icon-menu-sticky-header .icon').removeClass('active');

				sub_menu.css('display', 'none');
				setTimeout(function(){
					sub_menu.css('display', '');
				}, 200);
				
				jQuery(window).trigger('ts_set_top_shop_elements');
			}
			, scrollOnBottom: function(){
				ts_mega_menu_change_state();

				sub_menu.css('display', 'none');
				setTimeout(function(){
					sub_menu.css('display', '');
				}, 200);
				
				jQuery(window).trigger('ts_set_top_shop_elements');
			}
		});
	}, 100);
}

/*** Ajax search ***/
function ts_ajax_search(){
	var search_string = '';
	var search_previous_string = '';
	var search_timeout;
	var search_delay = 700;
	var search_input;
	var search_result_container;
	var search_cache_data = {};
	
	jQuery('.ts-search-by-category input[name="s"]').on('focusin', function(){
		jQuery(this).parents('.ts-search-by-category').addClass('focusing');
	}).on('focusout', function(){
		var wrapper = jQuery(this).parents('.ts-search-by-category');
		setTimeout(function(){
			if( !wrapper.hasClass('clicking') ){
				wrapper.removeClass('focusing');
			}
		}, 100);
	});
	
	jQuery(document).on('click', '.ts-search-by-category .search-dropdown a', function(){
		jQuery(this).parents('.ts-search-by-category').addClass('clicking');
	});



	jQuery(document).on('click', '.search-content .view-all-wrapper a', function(e){
		e.preventDefault();
		jQuery(this).parents('.ts-search-by-category').find('form').trigger('submit');
	});

	jQuery('.ts-search-by-category select.select-category').on('change', function(){
		search_previous_string = '';
		search_cache_data = {};
		var wrapper = jQuery(this).parents('.ts-search-by-category');
		if( wrapper.find('input[name="s"]').val() ){
			wrapper.find('.ts-search-result-container').html('');
			wrapper.find('input[name="s"]').trigger('focus').trigger('keyup');
		}
	});
}