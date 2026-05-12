<section class="ts-header has-hotline has-search-category header-fullwidth" style="background: #f6f8fa;">
    <div class="container" style="display: flex; justify-content:space-between; align-items: center; ">
        <span class=""><a href="tel:+34657942736">{{ __('header.service.hotline') }}: <b>+34 657 94 2736</b></a></span>

          <div class="header-left">
        <!-- Sélecteur de langues CORRIGÉ -->                                                               
        <div class="language-selector-wrapper">
            <div class="language-selector" id="languageSelector">
                <button class="language-dropdown-toggle" id="languageDropdownToggle" type="button" aria-expanded="false">
                    @if (app()->getLocale() === 'fr')
                    <img class="flag-icon" width="25" src="{{ asset('assets/images/flags/fr.svg') }}" alt="Français">
                    <span>{{ __('header.language.french') }}</span>

                    @elseif (app()->getLocale() === 'pt')
                    <img class="flag-icon" width="25" src="{{ asset('assets/images/flags/pt.svg') }}" alt="Português">
                    <span>{{ __('header.language.portuguese') }}</span>
                    @elseif (app()->getLocale() === 'es')
                    <img class="flag-icon" width="25" src="{{ asset('assets/images/flags/es.svg') }}" alt="Español">
                    <span>{{ __('header.language.spanish') }}</span>
                    @endif
                    <svg class="dropdown-arrow" width="12" height="12" viewBox="0 0 12 12" fill="none">
                        <path d="M2 4L6 8L10 4" stroke="currentColor" stroke-width="1.5"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
                <ul class="language-dropdown-menu" id="languageDropdownMenu" style="display:none;">
                    <li>
                        <a class="language-dropdown-item {{ app()->getLocale() == 'fr' ? 'active' : '' }}"
                            href="{{ route('lang.switch', 'fr') }}">
                            <div class="language-item-content">
                                <img class="flag-icon" width="25" src="{{ asset('assets/images/flags/fr.svg') }}" alt="Français">
                                <span>{{ __('header.language.french') }}</span>
                            </div>
                            @if (app()->getLocale() == 'fr')
                            <svg class="check-icon" width="14" height="14" viewBox="0 0 14 14" fill="none">
                                <path d="M11.6667 3.5L5.25 9.91667L2.33333 7" stroke="#2c3e50"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            @endif
                        </a>
                    </li>


                    <li>
                        <a class="language-dropdown-item {{ app()->getLocale() == 'pt' ? 'active' : '' }}"
                            href="{{ route('lang.switch', 'pt') }}">
                            <div class="language-item-content">
                                <img class="flag-icon" width="25" src="{{ asset('assets/images/flags/pt.svg') }}" alt="Português">
                                <span>{{ __('header.language.portuguese') }}</span>
                            </div>
                            @if (app()->getLocale() == 'pt')
                            <svg class="check-icon" width="14" height="14" viewBox="0 0 14 14" fill="none">
                                <path d="M11.6667 3.5L5.25 9.91667L2.33333 7" stroke="#2c3e50"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            @endif
                        </a>
                    </li>
                    <li>
                        <a class="language-dropdown-item {{ app()->getLocale() == 'es' ? 'active' : '' }}"
                            href="{{ route('lang.switch', 'es') }}">
                            <div class="language-item-content">
                                <img class="flag-icon" width="25" src="{{ asset('assets/images/flags/es.svg') }}" alt="Español">
                                <span>{{ __('header.language.spanish') }}</span>
                            </div>
                            @if (app()->getLocale() == 'es')
                            <svg class="check-icon" width="14" height="14" viewBox="0 0 14 14" fill="none">
                                <path d="M11.6667 3.5L5.25 9.91667L2.33333 7" stroke="#2c3e50"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            @endif
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    </div>
  
</section>
<header class="ts-header has-hotline has-search-category header-fullwidth">
    <div class="overlay"></div>

    <div class="header-template header-sticky">
        <div class="header-middle">
            <div class="container">

                <div style="display:flex; gap:10px ">
                    
                <div class="ts-mobile-icon-toggle visible-xs">
                    <span class="icon"></span>
                </div>

                <div class="logo-wrapper">
                    <div class="logo">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('assets/images/logo.png') }}"
                                alt="Nova  Remolques" title="Nova  Remolques" class="logo normal-logo" />
                            <img src="{{ asset('assets/images/logo.png') }}"
                                alt="Nova  Remolques" title="Nova  Remolques" class=" logo mobile-logo" />
                            <img src="{{ asset('assets/images/logo.png') }}"
                                alt="Nova  Remolques" title="Nova  Remolques" class=" logo sticky-logo" />
                        </a>
                    </div>
                </div>
                </div>

                <div class="header-center">
                    <div class="ts-search-by-category">
                        <form action="{{ route('shop') }}" method="get">
                            <div class="search-table">
                                <div class="search-field search-content">
                                    <input type="text" value="{{ $search2 ?? '' }}" name="search_Prin"
                                        placeholder="{{ __('header.search.placeholder') }}" autocomplete="off" />
                                    <div class="search-button">
                                        <input type="submit" title="{{ __('header.search.button') }}"
                                            value="{{ __('header.search.button') }}" />
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="search-dropdown">
                            <div class="ts-search-result-container woocommerce"></div>
                        </div>
                    </div>
                </div>



                <!-- PANIER (CANVAS CART) - CHECKBOX BIEN CACHÉE -->
                <div class="elementor-element elementor-element-9531d9a elementor-widget__width-auto 
            elementor-widget elementor-widget-clever-canvas-cart"
                    data-id="9531d9a" data-element_type="widget" data-widget_type="clever-canvas-cart.default">
                    <div class="elementor-widget-container" style="position: relative;">
                        <!-- Checkbox cachée pour contrôler l'ouverture/fermeture -->
                        <input type="checkbox" id="cafe-canvas-cart-toggle" class="cafe-toggle-input" style="display: none !important; position: absolute; opacity: 0; width: 0; height: 0; pointer-events: none;">

                        <!-- Icône du panier -->
                        <label for="cafe-canvas-cart-toggle" class="cafe-canvas-cart count-custom subtotal-after cart-empty" style="cursor: pointer;">
                            <span class="cafe-wrap-icon-cart">
                                <i class="fa-solid fa-cart-shopping"></i>
                                <span class="cafe-cart-count" id="cart-count">0</span>
                            </span>
                            <span class="cafe-wrap-right-cart">
                                <span class="cafe-cart-subtotal" id="cart-subtotal">
                                    <span class="woocommerce-Price-amount amount">
                                        0,00<span class="woocommerce-Price-currencySymbol">€</span>
                                    </span>
                                </span>
                            </span>
                        </label>

                        <!-- Overlay -->
                        <label class="cafe-canvas-cart-mask cafe-mask-close" for="cafe-canvas-cart-toggle"></label>

                        <!-- Panier latéral -->
                        <div class="cafe-canvas-cart-content widget_shopping_cart woocommerce">
                            <div class="cafe-heading-cart-content">
                                {{ __('header.cart.title') }} (<span class="cafe-cart-count" id="cart-count-sidebar">0</span>)
                                <span class="cafe-close-cart">
                                    <label for="cafe-canvas-cart-toggle" style="cursor: pointer;">
                                        <i class="fa-solid fa-xmark"></i> {{ __('header.cart.close') }}
                                    </label>
                                </span>
                            </div>

                            <div class="widget_shopping_cart_content" id="cart-items-container">
                                <p class="woocommerce-mini-cart__empty-message">{{ __('header.cart.empty') }}</p>
                            </div>

                            <div id="cart-total-container" style="display:none;">
                                <div class="woocommerce-mini-cart__total total" style="color: black; padding-inline: 25px;">
                                    <strong>{{ __('header.cart.subtotal') }}:</strong>
                                    <span class="woocommerce-Price-amount amount" id="cart-total-price">0,00€</span>
                                </div>
                                <div class="woocommerce-mini-cart__buttons buttons" style="display: block;">
                                    <a href="{{ route('cart') }}" class="button wc-forward">
                                        <i class="fa-solid fa-bag-shopping"></i> {{ __('header.cart.view_cart') }}
                                    </a>
                                    <a href="{{ route('checkout') }}" class="button checkout wc-forward">
                                        <i class="fa-solid fa-credit-card"></i> {{ __('header.cart.checkout') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="header-bottom hidden-xs">
            <div class="container">
                <div class="menu-wrapper">
                    <div class="vertical-menu-wrapper">
                        <div class="vertical-menu-heading">
                            <span>{{ __('header.menu.buy_by_category') }}</span>
                        </div>
                    </div>

                    <div class="ts-menu">
                        <nav class="main-menu pc-menu ts-mega-menu-wrapper">
                            <ul id="menu-cosmetic" class="menu">
                                <li class="menu-item {{ request()->routeIs('home') ? 'active-menu' : '' }}">
                                    <a href="{{ route('home') }}">
                                        <span class="menu-label">{{ __('header.menu.welcome') }}</span>
                                    </a>
                                </li>
                                @php
                                $currentCategory = request()->route('category');
                                @endphp

                                <li class="menu-item {{ $currentCategory == 'volquete hidráulico' ? 'active-menu' : '' }}">
                                    <a href="{{ route('category.show', ['category' => 'volquete hidráulico']) }}">
                                        <span class="menu-label">{{ __('header.menu.hydraulic_dump') }}</span>
                                    </a>
                                </li>
                                <li class="menu-item {{ $currentCategory == 'Porta-bicicletas' ? 'active-menu' : '' }}">
                                    <a href="{{ route('category.show', ['category' => 'Porta-bicicletas']) }}">
                                        <span class="menu-label">{{ __('header.menu.bike_rack') }}</span>
                                    </a>
                                </li>
                                <li class="menu-item {{ $currentCategory == 'Remolque portacoches' ? 'active-menu' : '' }}">
                                    <a href="{{ route('category.show', ['category' => 'Remolque portacoches']) }}">
                                        <span class="menu-label">{{ __('header.menu.car_trailer') }}</span>
                                    </a>
                                </li>
                                <li class="menu-item {{ $currentCategory == 'Remolque de barco' ? 'active-menu' : '' }}">
                                    <a href="{{ route('category.show', ['category' => 'Remolque de barco']) }}">
                                        <span class="menu-label">{{ __('header.menu.boat_trailer') }}</span>
                                    </a>
                                </li>

                                <li class="menu-item {{ request()->routeIs('contact') ? 'active-menu' : '' }}">
                                    <a href="{{ route('contact') }}">
                                        <span class="menu-label">{{ __('header.menu.contact_us') }}</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>