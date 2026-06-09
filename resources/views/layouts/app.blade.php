<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1"/>

    <title>
        {{ trim(View::yieldContent('title') . ' | ' . config('app.name')) }}
    </title>

<script>
    window.cartTranslations = {
        cartAdded: '{{ __("cart.translations.cart_added") }}',
        cartRemoved: '{{ __("cart.translations.cart_removed") }}',
        cartEmpty: '{{ __("cart.translations.cart_empty") }}',
        cartUpdated: '{{ __("cart.translations.cart_updated") }}',
        
        loading: '{{ __("cart.translations.loading") }}',
        loadError: '{{ __("cart.translations.load_error") }}',
        
        viewDetails: '{{ __("cart.translations.view_details") }}',
        addToCart: '{{ __("cart.translations.add_to_cart") }}',
        addedToCart: '{{ __("cart.translations.added_to_cart") }}',
        removeFromCart: '{{ __("cart.translations.remove_from_cart") }}',
        updateCart: '{{ __("cart.translations.update_cart") }}',
        checkout: '{{ __("cart.translations.checkout") }}',
        continueShopping: '{{ __("cart.translations.continue_shopping") }}',
        
        soldRecently: '{{ __("cart.translations.sold_recently") }}',
        noProducts: '{{ __("cart.translations.no_products") }}',
        seeAllProducts: '{{ __("cart.translations.see_all_products") }}',
        
        qty: '{{ __("cart.translations.qty") }}',
        price: '{{ __("cart.translations.price") }}',
        unitPrice: '{{ __("cart.translations.unit_price") }}',
        subtotal: '{{ __("cart.translations.subtotal") }}',
        total: '{{ __("cart.translations.total") }}',
        
        sortDefault: '{{ __("cart.translations.sort_default") }}',
        sortNewest: '{{ __("cart.translations.sort_newest") }}',
        sortPriceAsc: '{{ __("cart.translations.sort_price_asc") }}',
        sortPriceDesc: '{{ __("cart.translations.sort_price_desc") }}',
        sortNameAsc: '{{ __("cart.translations.sort_name_asc") }}',
        sortNameDesc: '{{ __("cart.translations.sort_name_desc") }}',
        showing: '{{ __("cart.translations.showing") }}',
        of: '{{ __("cart.translations.of") }}',
        results: '{{ __("cart.translations.results") }}',
        page: '{{ __("cart.translations.page") }}',
        next: '{{ __("cart.translations.next") }}',
        previous: '{{ __("cart.translations.previous") }}',
        
        promo: '{{ __("cart.translations.promo") }}',
        sku: '{{ __("cart.translations.sku") }}',
        categories: '{{ __("cart.translations.categories") }}',
        inStock: '{{ __("cart.translations.in_stock") }}',
        outOfStock: '{{ __("cart.translations.out_of_stock") }}',
        close: '{{ __("cart.translations.close") }}',
        
        wishlist: '{{ __("cart.translations.wishlist") }}',
        addToWishlist: '{{ __("cart.translations.add_to_wishlist") }}',
        removeFromWishlist: '{{ __("cart.translations.remove_from_wishlist") }}',
        compare: '{{ __("cart.translations.compare") }}',
        addToCompare: '{{ __("cart.translations.add_to_compare") }}',
        removeFromCompare: '{{ __("cart.translations.remove_from_compare") }}',
        
        quantityError: '{{ __("cart.translations.quantity_error") }}',
        stockError: '{{ __("cart.translations.stock_error") }}',
        maxQuantity: '{{ __("cart.translations.max_quantity") }}',
        
        freeShipping: '{{ __("cart.translations.free_shipping") }}',
        shipping: '{{ __("cart.translations.shipping") }}',
        tax: '{{ __("cart.translations.tax") }}',
        
        emptyCartTitle: '{{ __("cart.translations.empty_cart_title") }}',
        emptyCartText: '{{ __("cart.translations.empty_cart_text") }}',
        cartSummary: '{{ __("cart.translations.cart_summary") }}',
        item: '{{ __("cart.translations.item") }}',
        items: '{{ __("cart.translations.items") }}'
    };
</script>
    <meta name='robots' content='max-image-preview:large'/>
    <link rel='dns-prefetch' href='http://fonts.googleapis.com/'/>
    <link rel='preconnect' href='https://fonts.gstatic.com/' crossorigin/>


    <link rel='stylesheet' id='contact-form-7-css'
          href='{{ asset("assets/plugins/contact-form-7/includes/css/styles1b46.css") }}' type='text/css'
          media='all'/>
    <link rel='stylesheet' id='sr7css-css'
          href='{{ asset("assets/plugins/revslider/public/css/sr7659f.css") }}' type='text/css'
          media='all'/>
    <link rel='stylesheet' id='ts-style-css'
          href='{{ asset("assets/plugins/themesky/css/themeskyc358.css") }}' type='text/css' media='all'/>
    <link rel='stylesheet' id='swiper-css'
          href='{{ asset("assets/plugins/themesky/css/swiper-bundle.minc358.css") }}' type='text/css'
          media='all'/>
    <link rel='stylesheet' id='woocommerce-layout-css'
          href='{{ asset("assets/plugins/woocommerce/assets/css/woocommerce-layoutf607.css") }}'
          type='text/css' media='all'/>
    <link rel='stylesheet' id='woocommerce-smallscreen-css'
          href='{{ asset("assets/plugins/woocommerce/assets/css/woocommerce-smallscreenf607.css") }}'
          type='text/css' media='only screen and (max-width: 768px)'/>
    <link rel='stylesheet' id='woocommerce-general-css'
          href='{{ asset("assets/plugins/woocommerce/assets/css/woocommercef607.css") }}' type='text/css'
          media='all'/>

    <link rel='stylesheet' id='elementor-frontend-css'
          href='{{ asset("assets/uploads/elementor/css/custom-frontend.minaec1.css") }}'
          type='text/css' media='all'/>
    <link rel='stylesheet' id='elementor-post-10348-css'
          href='{{ asset("assets/uploads/elementor/css/post-10348aec1.css") }}' type='text/css'
          media='all'/>
    <link rel='stylesheet' id='widget-heading-css'
          href='{{ asset("assets/plugins/elementor/assets/css/widget-heading.min1504.css") }}'
          type='text/css' media='all'/>
    <link rel='stylesheet' id='elementor-post-8171-css'
          href='{{ asset("assets/uploads/elementor/css/post-8171840d.css") }}' type='text/css'
          media='all'/>
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <link href="http://fonts.googleapis.com/css2?family=Poppins:wght@600;700&amp;display=swap" rel="stylesheet"
          property="stylesheet" media="all" type="text/css">
    <noscript>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap">
    </noscript>
    <link rel='stylesheet' id='font-awesome-5-css'
          href='{{ asset("assets/themes/merto/css/fontawesome.min.css") }}' type='text/css'
          media='all'/>
    <link rel='stylesheet' id='font-icomoon-css' href='{{ asset("assets/themes/merto/css/icomoon-icon.css") }}'
          type='text/css' media='all'/>
    <link rel='stylesheet' id='merto-reset-css' href='{{ asset("assets/themes/merto/css/reset6f3e.css") }}'
          type='text/css' media='all'/>
    <link rel='stylesheet' id='merto-style-css' href='{{ asset("assets/themes/merto/style6f3e.css") }}'
          type='text/css' media='all'/>
    <link rel='stylesheet' id='merto-responsive-css'
          href='{{ asset("assets/themes/merto/css/responsive6f3e.css") }}' type='text/css' media='all'/>
  


    <script type="text/javascript" src="{{ asset('assets/js/jquery/jquery.minf43b.js') }}"
            id="jquery-core-js"></script>
    <script type="text/javascript" src="{{ asset('assets/js/jquery/jquery-migrate.min5589.js') }}"
            id="jquery-migrate-js"></script>
    <script type="text/javascript"
            src="{{ asset('assets/plugins/revslider/public/js/libs/tptools659f.js') }}" id="tp-tools-js"
            async="async" data-wp-strategy="async"></script>
    <script type="text/javascript"
            src="{{ asset('assets/plugins/woocommerce/assets/js/jquery-blockui/jquery.blockUI.minae83.js') }}"
            id="wc-jquery-blockui-js" defer="defer" data-wp-strategy="defer"></script>
    <script type="text/javascript"
            src="{{ asset('assets/plugins/woocommerce/assets/js/js-cookie/js.cookie.minf503.js') }}"
            id="wc-js-cookie-js" defer="defer" data-wp-strategy="defer"></script>
    <script type="text/javascript"
            src="{{ asset('assets/plugins/woocommerce/assets/js/frontend/woocommerce.minf607.js') }}"
            id="woocommerce-js" defer="defer" data-wp-strategy="defer"></script>
    <script type="text/javascript"
            src="{{ asset('assets/plugins/woocommerce/assets/js/frontend/cart-fragments.minf607.js') }}"
            id="wc-cart-fragments-js" defer="defer" data-wp-strategy="defer"></script>
    <script type="text/javascript"
            src="{{ asset('assets/plugins/woocommerce/assets/js/flexslider/jquery.flexslider.minb871.js') }}"
            id="wc-flexslider-js" defer="defer" data-wp-strategy="defer"></script>
    <script type="text/javascript" src="{{ asset('assets/js/underscore.min3ab8.js') }}"
            id="underscore-js"></script>
    <script type="text/javascript" src="{{ asset('assets/js/wp-util.min4d80.js') }}"
            id="wp-util-js"></script>
    <script type="text/javascript"
            src="{{ asset('assets/plugins/woocommerce/assets/js/frontend/add-to-cart-variation.minf607.js') }}"
            id="wc-add-to-cart-variation-js" defer="defer" data-wp-strategy="defer"></script>
    <script type="text/javascript"
            src="{{ asset('assets/plugins/woocommerce/assets/js/zoom/jquery.zoom.minc932.js') }}"
            id="wc-zoom-js" defer="defer" data-wp-strategy="defer"></script>
 <link rel='stylesheet' id='elementor-icons-fa-solid-css'
          href="{{ asset('assets/cleverfont/style.css') }}" type='text/css'
          media='all' />

    <meta name="generator"
          content="Powered by Slider Revolution 6.7.38 - responsive, Mobile-Friendly Slider Plugin for WordPress with comfortable drag and drop interface."/>
    <link rel="icon" class="logo" href="{{ asset('assets/images/logo-dark.png') }}"
          sizes="32x32"/>
    <link rel="icon" class="logo" href="{{ asset('assets/images/logo-dark.png') }}"
          sizes="192x192"/>
    <link rel="apple-touch-icon"
          class="logo" href="{{ asset('assets/images/logo-dark.png') }}"/>
    <meta name="msapplication-TileImage"
          content="{{ asset('assets/images/logo-dark.png') }}"/>
<script src="{{ asset('assets/js/sweetalert2@11.js') }}"></script>

    <link rel='stylesheet' 
          href="{{ asset('assets/css/app.css') }}" type='text/css'
          media='all' />
        @stack('styles')
<!-- Slick Slider CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>

<!-- Slick Slider JS -->
<script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

<style>
      .star-rating {
    font-family: 'star';
    overflow: hidden;
    position: relative;
    height: 1.618em;
    line-height: 1.618;
    font-size: 0.8em;
    width: 5.3em;
    color: #f4c542;
}

.star-rating::before {
    content: '\53\53\53\53\53';
    opacity: 0.25;
    float: left;
    top: 0;
    left: 0;
    position: absolute;
}

.star-rating span {
    overflow: hidden;
    float: left;
    top: 0;
    left: 0;
    position: absolute;
    padding-top: 1.5em;
    color: #f4c542;
}

.star-rating span::before {
    content: '\53\53\53\53\53';
    top: 0;
    position: absolute;
    left: 0;
}

.star-rating .rating-text {
    position: absolute;
    right: -60px;
    top: 0;
    font-size: 12px;
    color: #666;
    font-family: Arial, sans-serif;
}
</style>
<meta name="google-site-verification" content="xGoMJps76w9XZGPCw-Ejf8oi_-UXqyAfKkxgwJwQmRM" />
</head>

<body class="@yield('body_class', 'home wp-singular page-template-default page page-id-8171 wp-theme-merto theme-merto woocommerce-no-js wide header-v1 product-label-rectangle product-hover-style-v2 product-border-radius vertical-menu-fixed ts_desktop elementor-default elementor-kit-10348 elementor-page elementor-page-8171')">
<div id="page" class="hfeed site">
    @include('layouts.partials.navbar.public')

    <div id="main" class="wrapper">
        @yield('content')
    </div>

    @include('layouts.partials.footer.public')
</div>

@stack('scripts')
<link href="{{ asset('assets/plugins/revslider/public/css/fonts/revicons/css/revicons.css') }}" rel="stylesheet"
      property="stylesheet" media="all" type="text/css"/>


<link rel='stylesheet' id='wc-blocks-style-css'
      href='{{ asset("assets/plugins/woocommerce/assets/client/blocks/wc-blocks5210.css") }}'
      type='text/css' media='all'/>
<link rel='stylesheet' id='elementor-post-9597-css'
      href='{{ asset("assets/uploads/elementor/css/post-9597c8c9.css") }}' type='text/css'
      media='all'/>
<link rel='stylesheet' id='widget-spacer-css'
      href='{{ asset("assets/plugins/elementor/assets/css/widget-spacer.min1504.css") }}' type='text/css'
      media='all'/>
<link rel='stylesheet' id='widget-icon-box-css'
      href='{{ asset("assets/uploads/elementor/css/custom-widget-icon-box.minaec1.css") }}'
      type='text/css' media='all'/>
<link rel='stylesheet' id='widget-image-css'
      href='{{ asset("assets/plugins/elementor/assets/css/widget-image.min1504.css") }}' type='text/css'
      media='all'/>
<link rel='stylesheet' id='e-swiper-css'
      href='{{ asset("assets/plugins/elementor/assets/css/conditionals/e-swiper.min1504.css") }}'
      type='text/css' media='all'/>

<script type="text/javascript" src="{{ asset('assets/js/dist/hooks.minaf5f.js') }}"
        id="wp-hooks-js"></script>
<script type="text/javascript" src="{{ asset('assets/js/dist/i18n.min1cde.js') }}"
        id="wp-i18n-js"></script>



<script type="text/javascript" src="{{ asset('assets/themes/merto/js/main6f3e.js') }}"
        id="merto-script-js"></script>
<script type="text/javascript" src="{{ asset('assets/themes/merto/js/jquery.sticky6f3e.js') }}"
        id="jquery-sticky-js"></script>


  <script src="{{ asset('assets/js/product/cart-manager.js') }}"></script>
  <script src="{{ asset('assets/js/product/langue.js') }}"></script>

{{-- Dans votre layout principal (layouts/app.blade.php) --}}

@stack('scripts')

<div id="ts-quickshop-modal" class="ts-popup-modal">
    <div class="overlay"></div>
    <div class="quickshop-container popup-container">
        <span class="close"></span>
        <div class="quickshop-content"></div>
    </div>
</div>
</body>


</html>
