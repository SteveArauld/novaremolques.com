@extends('layouts.app')

@push('styles')
<link rel='stylesheet' id='elementor-icons-fa-solid-css'
    href="{{ 'assets/css/home.css' }}" type='text/css'
    media='all' />
@endpush

@section('title', 'Nova Remolques')


@section('content')
<div id="main" class="wrapper">
    <div class="page-container no-sidebar">
        <div id="main-content">
            <div id="primary" class="site-content">
                <article id="post-8171" class="post-8171 page type-page status-publish hentry">
                    <div data-elementor-type="wp-page" data-elementor-id="8171" class="elementor elementor-8171">

                        @include('layouts.partials.hero-slider')

                        <!-- Section Container Refrigerati -->
                        <div class="elementor-element elementor-element-7fe59cb1 e-flex e-con-boxed e-con e-parent"
                            data-id="7fe59cb1" data-element_type="container">
                            <div class="e-con-inner">
                                <div class="elementor-element elementor-element-6488a7da elementor-widget elementor-widget-ts-products"
                                    data-id="6488a7da" data-element_type="widget"
                                    data-widget_type="ts-products.default">
                                    <div class="elementor-widget-container">
                                        <div class="ts-product-wrapper ts-shortcode ts-product woocommerce columns-5 recent grid has-shop-more-button"
                                            style="--ts-columns: 5">

                                            <header class="shortcode-heading-wrapper">
                                                <h3 class="shortcode-title">{{ __('home.products.news') }}</h3>

                                            </header>
                                            <div class="products">
                                                @forelse($dernieresTondeuses as $article)
                                                @php
                                                $allImages = $article->images;
                                                $primaryImage = $allImages->first();
                                                $secondaryImage = $allImages->count() > 1 ? $allImages[1] : null;

                                                $discount = null;
                                                $prixOriginal = $article->prix_original;
                                                $prixActuel = $article->prix_actuel;

                                                if($prixOriginal && $prixOriginal > $prixActuel) {
                                                $discount = round((($prixOriginal - $prixActuel) / $prixOriginal) * 100);
                                                }
                                                $categorySlug = $article->categories->first()?->slug ?? '';
                                                @endphp

                                                <section class="product type-product status-publish first instock {{ $categorySlug ? 'product_cat-' . $categorySlug : '' }} has-post-thumbnail {{ $discount ? 'sale' : '' }} taxable shipping-taxable purchasable product-type-simple"
                                                    data-product_id="{{ $article->id }}">
                                                    <div class="product-wrapper">

                                                        {{-- Zone image avec ratio fixe --}}
                                                        <div class="thumbnail-wrapper">
                                                            <a href="{{ route('product.show', $article->slug) }}">
                                                                <figure class="no-back-image">
                                                                    @if($primaryImage)
                                                                    <img width="300" height="300"
                                                                        src="{{ $primaryImage->fichier }}"
                                                                        class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail primary-image"
                                                                        alt="{{ $article->name }}"
                                                                        loading="lazy"
                                                                        onerror="this.src='https://via.placeholder.com/300x300?text=No+Image'">
                                                                    @else
                                                                    <img width="300" height="300"
                                                                        src="https://via.placeholder.com/300x300?text=No+Image"
                                                                        class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail primary-image"
                                                                        alt="{{ $article->name }}">
                                                                    @endif

                                                                    @if($secondaryImage)
                                                                    <img width="300" height="300"
                                                                        src="{{ $secondaryImage->fichier }}"
                                                                        class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail secondary-image"
                                                                        alt="{{ $article->name }} - Vue 2"
                                                                        loading="lazy"
                                                                        onerror="this.style.display='none'">
                                                                    @endif
                                                                </figure>
                                                            </a>

                                                            @if($discount)
                                                            <div class="product-label">
                                                                <span class="onsale percent">
                                                                    <span>{{ __('home.products.offer') }}</span>
                                                                </span>
                                                            </div>
                                                            @endif
                                                        </div>

                                                        {{-- Zone texte avec hauteur fixe --}}
                                                        <div class="meta-wrapper">
                                                            <h3 class="heading-title product-name">
                                                                <a href="{{ route('product.show', $article->slug) }}">
                                                                    {{ $article->name }}
                                                                </a>
                                                            </h3>

                                                          <div class="star-rating-wrapper">
                                                            <div class="star-rating">
                                                                @php
                                                                    $rating = $article->average_rating ?? 0;
                                                                    $ratingPercentage = ($rating / 5) * 100;
                                                                @endphp
                                                                <span style="width:{{ $ratingPercentage }}%;"></span>
                                                            </div>
                                                            <span class="rating-number">({{ number_format($rating, 1) }})</span>
                                                        </div>

                                                            <span class="price">
                                                                @if($prixOriginal && $prixOriginal > $prixActuel)
                                                                <del aria-hidden="true">
                                                                    <span class="woocommerce-Price-amount amount">
                                                                        <bdi>{{ number_format($prixOriginal, 2, '.', ',') }}&nbsp;<span class="woocommerce-Price-currencySymbol">€</span></bdi>
                                                                    </span>
                                                                </del>
                                                                <ins aria-hidden="true">
                                                                    <span class="woocommerce-Price-amount amount">
                                                                        <bdi>{{ number_format($prixActuel, 2, '.', ',') }}&nbsp;<span class="woocommerce-Price-currencySymbol">€</span></bdi>
                                                                    </span>
                                                                </ins>
                                                                @else
                                                                <span class="woocommerce-Price-amount amount">
                                                                    <bdi>{{ number_format($prixActuel, 2, '.', ',') }}&nbsp;<span class="woocommerce-Price-currencySymbol">€</span></bdi>
                                                                </span>
                                                                @endif
                                                            </span>
                                                        </div>

                                                        {{-- Zone boutons - toujours en bas --}}
                                                        <div class="meta-wrapper meta-wrapper-2">
                                                            <div class="product-group-button-meta">
                                                                <div class="button-in quickshop">
                                                                    <a class="quickshop" href="#" data-product_id="{{ $article->id }}">

                                                                    </a>
                                                                </div>
                                                                <div class="button-in add-to-cart">
                                                                    <a class="add_to_cart_button" href="#"
                                                                        data-product-id="{{ $article->id }}"
                                                                        data-product-name="{{ $article->name }}"
                                                                        data-product-price="{{ $prixActuel }}"
                                                                        data-product-image="{{ $primaryImage ? $primaryImage->fichier : 'https://via.placeholder.com/300x300?text=No+Image' }}"
                                                                        data-product-slug="{{ $article->slug }}">

                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </section>
                                                @empty
                                                <div class="no-products-found" style="grid-column: 1/-1; text-align: center; padding: 50px;">
                                                    <h3>{{ __('home.products.no_products.title') }}</h3>
                                                    <p>{{ __('home.products.no_products.text') }}</p>
                                                    <a href="{{ route('shop') }}" class="button" style="display: inline-block; padding: 12px 30px; background: #495057; color: #fff; text-decoration: none; border-radius: 8px; margin-top: 20px;">
                                                        {{ __('home.products.no_products.clear_filters') }}
                                                    </a>
                                                </div>
                                                @endforelse
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Section Container Modulari -->
                        <div class="elementor-element elementor-element-3880d06 e-flex e-con-boxed e-con e-parent"
                            data-id="3880d06" data-element_type="container">
                            <div class="e-con-inner">
                                <div class="elementor-element elementor-element-824866c elementor-widget elementor-widget-ts-products"
                                    data-id="824866c" data-element_type="widget"
                                    data-widget_type="ts-products.default">
                                    <div class="elementor-widget-container">
                                        <div class="ts-product-wrapper ts-shortcode ts-product woocommerce columns-5 recent grid has-shop-more-button"
                                            style="--ts-columns: 5">

                                            <header class="shortcode-heading-wrapper">
                                                <h3 class="shortcode-title">{{ __('home.products.quality_trailers') }}</h3>

                                            </header>

                                            <div class="content-wrapper">
                                                <div class="products">
                                                    @forelse($dernieresRemorques as $article)
                                                    @php
                                                    $primaryImage = $article->images->first();
                                                    $allImages = $article->images;
                                                    $secondaryImage = $allImages->count() > 1 ? $allImages[1] : null;

                                                    $discount = null;
                                                    $prixOriginal = $article->prix_original;
                                                    $prixActuel = $article->prix_actuel;

                                                    if($prixOriginal && $prixOriginal > $prixActuel) {
                                                    $discount = round((($prixOriginal - $prixActuel) / $prixOriginal) * 100);
                                                    }
                                                    $categorySlug = $article->categories->first()?->slug ?? '';
                                                    @endphp

                                                    <section class="product type-product status-publish first instock {{ $categorySlug ? 'product_cat-' . $categorySlug : '' }} has-post-thumbnail {{ $discount ? 'sale' : '' }} taxable shipping-taxable purchasable product-type-simple"
                                                        data-product_id="{{ $article->id }}">
                                                        <div class="product-wrapper">
                                                            <div class="thumbnail-wrapper">
                                                                <a href="{{ route('product.show', $article->slug) }}">
                                                                    <figure class="no-back-image">
                                                                        {{-- Image principale --}}
                                                                        @if($primaryImage)
                                                                        <img width="300" height="300"
                                                                            src="{{ $primaryImage->fichier }}"
                                                                            class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail primary-image"
                                                                            alt="{{ $article->name }}"
                                                                            loading="lazy"
                                                                            onerror="this.src='https://via.placeholder.com/300x300?text=No+Image'">
                                                                        @else
                                                                        <img width="300" height="300"
                                                                            src="https://via.placeholder.com/300x300?text=No+Image"
                                                                            class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail primary-image"
                                                                            alt="{{ $article->name }}">
                                                                        @endif

                                                                        {{-- Image secondaire (affichée au survol) - UNIQUEMENT si plus d'une image --}}
                                                                        @if($secondaryImage)
                                                                        <img width="300" height="300"
                                                                            src="{{ $secondaryImage->fichier }}"
                                                                            class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail secondary-image"
                                                                            alt="{{ $article->name }} - Vue alternative"
                                                                            loading="lazy"
                                                                            onerror="this.style.display='none'">
                                                                        @endif
                                                                    </figure>
                                                                </a>

                                                                @if($discount)
                                                                <div class="product-label">
                                                                    <span class="onsale percent">
                                                                        <span>{{ __('home.products.offer') }}</span>
                                                                    </span>
                                                                </div>
                                                                @endif
                                                            </div>
                                                            <div class="meta-wrapper" style="text-align: center;">
                                                                <h3 class="heading-title product-name">
                                                                    <a href="{{ route('product.show', $article->slug) }}">
                                                                        {{ $article->name }}
                                                                    </a>
                                                                </h3>
                                                              <div class="star-rating-wrapper">
                <div class="star-rating">
                    @php
                        $rating = $article->average_rating ?? 0;
                        $ratingPercentage = ($rating / 5) * 100;
                    @endphp
                    <span style="width:{{ $ratingPercentage }}%;"></span>
                </div>
                <span class="rating-number">({{ number_format($rating, 1) }})</span>
            </div>
                                                                <span class="price">
                                                                    @if($prixOriginal && $prixOriginal > $prixActuel)
                                                                    <del aria-hidden="true">
                                                                        <span class="woocommerce-Price-amount amount">
                                                                            <bdi>{{ number_format($prixOriginal, 2, '.', ',') }}&nbsp;<span class="woocommerce-Price-currencySymbol">€</span></bdi>
                                                                        </span>
                                                                    </del>
                                                                    <ins aria-hidden="true">
                                                                        <span class="woocommerce-Price-amount amount">
                                                                            <bdi>{{ number_format($prixActuel, 2, '.', ',') }}&nbsp;<span class="woocommerce-Price-currencySymbol">€</span></bdi>
                                                                        </span>
                                                                    </ins>
                                                                    @else
                                                                    <span class="woocommerce-Price-amount amount">
                                                                        <bdi>{{ number_format($prixActuel, 2, '.', ',') }}&nbsp;<span class="woocommerce-Price-currencySymbol">€</span></bdi>
                                                                    </span>
                                                                    @endif
                                                                </span>
                                                            </div>

                                                            <div class="meta-wrapper meta-wrapper-2">
                                                                <div class="product-group-button-meta">
                                                                    <div class="button-in quickshop">
                                                                        <a class="quickshop" href="#" data-product_id="{{ $article->id }}">

                                                                        </a>
                                                                    </div>
                                                                    <div class="button-in add-to-cart">
                                                                        <a class="add_to_cart_button" href="#"
                                                                            data-product-id="{{ $article->id }}"
                                                                            data-product-name="{{ $article->name }}"
                                                                            data-product-price="{{ $prixActuel }}"
                                                                            data-product-image="{{ $primaryImage ? $primaryImage->fichier : 'https://via.placeholder.com/300x300?text=No+Image' }}"
                                                                            data-product-slug="{{ $article->slug }}">

                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </section>
                                                    @empty
                                                    <div class="no-products-found" style="grid-column: 1/-1; text-align: center; padding: 50px;">
                                                        <h3>{{ __('home.products.no_products.title') }}</h3>
                                                        <p>{{ __('home.products.no_products.text') }}</p>
                                                        <a href="{{ route('shop') }}" class="button" style="display: inline-block; padding: 12px 30px; background: #495057; color: #fff; text-decoration: none; border-radius: 8px; margin-top: 20px;">
                                                            {{ __('home.products.no_products.clear_filters') }}
                                                        </a>
                                                    </div>
                                                    @endforelse
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @include('layouts.partials.features')
                        </div>
                </article>
            </div>
        </div>
    </div>
    <!-- Quickview Modal -->
    <div class="zoo-quickview-overlay" id="quickview-overlay"></div>
    <div class="zoo-quickview-modal" id="quickview-modal">
        <a href="#" class="close-btn close-quickview" id="close-quickview" title="{{ __('home.quickview.close') }}">✕</a>
        <div class="zoo-quickview-content" id="quickview-content">
            <div class="zoo-quickview-loader">{{ __('home.quickview.loading') }}</div>
        </div>
    </div>
</div>
@endsection

@push('scripts')

@endpush