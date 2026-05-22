@extends('layouts.app')

@php
$locale = app()->getLocale();
@endphp

@section('title', $categoryName ?: __('shop.all_products'))

@push('styles')
<link rel='stylesheet' id='font-icomoon-css' href='{{ asset("assets/css/stylehome.css") }}'
    type='text/css' media='all' />


@endpush

@section('content')
<div id="main" class="wrapper">

    {{-- BREADCRUMB + TITRE (AJOUTÉ) --}}
    <div class="wrap-breadcrumb">
        <div class="container">
            <nav class="woocommerce-breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('home') }}">
                    <i class="fa-solid fa-house"></i> {{ __('shop.breadcrumb_home') }}
                </a>

                @if($category)
                <span class="zoo-separator">/</span>
                <span>{{ $categoryName }}</span>
                @else
                <span>{{ __('shop.category') }}</span>
                @endif
            </nav>
            <h2 class="shop-title">
                {{ $categoryName ?: '' }}
                <span class="total-product">({{ $articles->total() }}&nbsp;{{ __('shop.articles') }})</span>
            </h2>
        </div>
    </div>

    <div class="page-container no-sidebar">
        <div id="main-content">
            <div id="primary" class="site-content">
                <article id="post-8171" class="post-8171 page type-page status-publish hentry">
                    <div data-elementor-type="wp-page" data-elementor-id="8171" class="elementor elementor-8171">

                        <!-- Section Container -->
                        <div class="elementor-element elementor-element-7fe59cb1 e-flex e-con-boxed e-con e-parent"
                            data-id="7fe59cb1" data-element_type="container">
                            <div class="e-con-inner">
                                <div class="elementor-element elementor-element-6488a7da elementor-widget elementor-widget-ts-products"
                                    data-id="6488a7da" data-element_type="widget"
                                    data-widget_type="ts-products.default">
                                    <div class="elementor-widget-container">
                                        <div class="ts-product-wrapper ts-shortcode ts-product woocommerce columns-5 recent grid has-shop-more-button"
                                            style="--ts-columns: 5">

                                            {{-- BARRE DE TRI (AJOUTÉ) --}}
                                            <div id="top-shop-loop" class="wrap-top-shop-loop">
                                                <div class="row align-items-center">
                                                    <div class="left-top-shop-loop col-lg-4 col-12 d-flex align-items-center gap-3">
                                                        <form class="woocommerce-ordering" method="get" id="sort-form">
                                                            <select name="sort" class="orderby" aria-label="{{ __('shop.sort_label') }}">
                                                                <option value="default" {{ $sort == 'default' ? 'selected' : '' }}>{{ __('shop.sort_default') }}</option>
                                                                <option value="newest" {{ $sort == 'newest' ? 'selected' : '' }}>{{ __('shop.sort_newest') }}</option>
                                                                <option value="price-asc" {{ $sort == 'price-asc' ? 'selected' : '' }}>{{ __('shop.sort_price_asc') }}</option>
                                                                <option value="price-desc" {{ $sort == 'price-desc' ? 'selected' : '' }}>{{ __('shop.sort_price_desc') }}</option>
                                                                <option value="name-asc" {{ $sort == 'name-asc' ? 'selected' : '' }}>{{ __('shop.sort_name_asc') }}</option>
                                                                <option value="secte" {{ $sort == 'secte' ? 'selected' : '' }}>{{ __('shop.sort_secte') }}</option>
                                                            </select>
                                                        </form>
                                                        <div class="center-top-shop-loop col-lg-4 col-md-6 col-12">
                                                            <p class="woocommerce-result-count">
                                                                {{ __('shop.showing_results', ['first' => $articles->firstItem(), 'last' => $articles->lastItem(), 'total' => $articles->total()]) }}
                                                            </p>
                                                        </div>
                                                        <div class="right-top-shop-loop top-page-pagination col-lg-4 col-md-6 col-12">
                                                            {{ __('shop.page') }}
                                                            <span class="current-page">{{ $articles->currentPage() }}</span>
                                                            <span class="separator">/</span>
                                                            <span class="total-page">{{ $articles->lastPage() }}</span>
                                                            @if($articles->hasMorePages())
                                                            <div class="next-page">
                                                                <a href="{{ $articles->nextPageUrl() }}">
                                                                    {{ __('shop.next') }} <i class="fa-solid fa-chevron-right"></i>
                                                                </a>
                                                            </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- GRILLE PRODUITS (VOTRE CODE EXISTANT) --}}
                                                <div class="products">
                                                    @forelse($articles as $article)
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

                                                    $productName = $article->name;
                                                    if (is_array($productName)) {
                                                    $productName = $productName[$locale] ?? $productName['fr'] ?? '';
                                                    }
                                                    @endphp

                                                    <section class="product type-product status-publish first instock {{ $categorySlug ? 'product_cat-' . $categorySlug : '' }} has-post-thumbnail {{ $discount ? 'sale' : '' }} taxable shipping-taxable purchasable product-type-simple"
                                                        data-product_id="{{ $article->id }}">
                                                        <div class="product-wrapper {{ $secondaryImage ? 'has-secondary-image' : '' }}">

                                                            {{-- Zone image avec ratio fixe --}}
                                                            <div class="thumbnail-wrapper">
                                                                <a href="{{ route('product.show', $article->slug) }}">
                                                                    <figure class="no-back-image">
                                                                        @if($primaryImage)
                                                                        <img width="300" height="300"
                                                                            src="{{ asset($primaryImage->fichier) }}"
                                                                            class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail primary-image"
                                                                            alt="{{ $productName }}"
                                                                            loading="lazy"
                                                                            onerror="this.src='https://via.placeholder.com/300x300?text=No+Image'">
                                                                        @else
                                                                        <img width="300" height="300"
                                                                            src="https://via.placeholder.com/300x300?text=No+Image"
                                                                            class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail primary-image"
                                                                            alt="{{ $productName }}">
                                                                        @endif

                                                                        @if($secondaryImage)
                                                                        <img width="300" height="300"
                                                                            src="{{ asset($secondaryImage->fichier) }}"
                                                                            class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail secondary-image"
                                                                            alt="{{ $productName }} - Vue 2"
                                                                            loading="lazy"
                                                                            onerror="this.style.display='none'">
                                                                        @endif
                                                                    </figure>
                                                                </a>

                                                                @if($discount)
                                                                <div class="product-label">
                                                                    <span class="onsale percent">
                                                                        <span><i class="fa-solid fa-tag"></i> {{ __('shop.promo') }}</span>
                                                                    </span>
                                                                </div>
                                                                @endif
                                                            </div>

                                                            {{-- Zone texte avec hauteur fixe --}}
                                                            <div class="meta-wrapper">
                                                                <h3 class="heading-title product-name">
                                                                    <a href="{{ route('product.show', $article->slug) }}">
                                                                        {{ $productName }}
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
                                                                            <bdi>{{ number_format($prixOriginal, 2, ',', '.') }}&nbsp;<span class="woocommerce-Price-currencySymbol">€</span></bdi>
                                                                        </span>
                                                                    </del>
                                                                    <ins aria-hidden="true">
                                                                        <span class="woocommerce-Price-amount amount">
                                                                            <bdi>{{ number_format($prixActuel, 2, ',', '.') }}&nbsp;<span class="woocommerce-Price-currencySymbol">€</span></bdi>
                                                                        </span>
                                                                    </ins>
                                                                    @else
                                                                    <span class="woocommerce-Price-amount amount">
                                                                        <bdi>{{ number_format($prixActuel, 2, ',', '.') }}&nbsp;<span class="woocommerce-Price-currencySymbol">€</span></bdi>
                                                                    </span>
                                                                    @endif
                                                                </span>
                                                            </div>

                                                            {{-- Zone boutons - toujours en bas --}}
                                                            <div class="meta-wrapper meta-wrapper-2">
                                                                <div class="product-group-button-meta">
                                                                    <div class="button-in quickshop">
                                                                        <a class="quickshop" href="#" data-product_id="{{ $article->id }}"></a>
                                                                    </div>
                                                                    <div class="button-in add-to-cart">
                                                                        <a class="add_to_cart_button" href="#"
                                                                            data-product-id="{{ $article->id }}"
                                                                            data-product-name="{{ $productName }}"
                                                                            data-product-price="{{ $prixActuel }}"
                                                                            data-product-image="{{ $primaryImage ? asset($primaryImage->fichier) : 'https://via.placeholder.com/300x300?text=No+Image' }}"
                                                                            data-product-slug="{{ $article->slug }}"></a>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </section>
                                                    @empty
                                                    <div class="no-products-found" style="grid-column: 1/-1; text-align: center; padding: 50px;">
                                                        <i class="fa-solid fa-box-open fa-3x" style="color: #ccc; margin-bottom: 20px;"></i>
                                                        <h3>{{ __('shop.no_products') }}</h3>
                                                        <a href="{{ route('shop') }}" class="button" style="display: inline-block; padding: 12px 30px; background: #4CAF50; color: #fff; text-decoration: none; border-radius: 8px; margin-top: 20px;">
                                                            {{ __('shop.view_all_products') }}
                                                        </a>
                                                    </div>
                                                    @endforelse
                                                </div>

                                                {{-- PAGINATION (AJOUTÉ) --}}
                                                @if($articles->hasPages())
                                                <nav class="woocommerce-pagination" aria-label="{{ __('shop.pagination_label') }}">
                                                    <ul class="page-numbers">
                                                        @if($articles->onFirstPage())
                                                        <li><span><i class="fa-solid fa-chevron-left"></i></span></li>
                                                        @else
                                                        <li><a href="{{ $articles->previousPageUrl() }}"><i class="fa-solid fa-chevron-left"></i></a></li>
                                                        @endif

                                                        @php
                                                        $current = $articles->currentPage();
                                                        $last = $articles->lastPage();
                                                        $start = max(1, $current - 2);
                                                        $end = min($last, $current + 2);

                                                        if ($start > 1) {
                                                        echo '<li><a href="' . $articles->url(1) . '">1</a></li>';
                                                        if ($start > 2) echo '<li><span>…</span></li>';
                                                        }
                                                        @endphp

                                                        @for($i = $start; $i <= $end; $i++)
                                                            @if($i==$current)
                                                            <li><span aria-current="page" class="page-numbers current">{{ $i }}</span></li>
                                                            @else
                                                            <li><a href="{{ $articles->url($i) }}">{{ $i }}</a></li>
                                                            @endif
                                                            @endfor

                                                            @if($end < $last)
                                                                @if($end < $last - 1)
                                                                <li><span>…</span></li>
                                                                @endif
                                                                <li><a href="{{ $articles->url($last) }}">{{ $last }}</a></li>
                                                                @endif

                                                                @if($articles->hasMorePages())
                                                                <li><a href="{{ $articles->nextPageUrl() }}"> <i class="fa-solid fa-chevron-right"></i></a></li>
                                                                @else
                                                                <li><span><i class="fa-solid fa-chevron-right"></i></span></li>
                                                                @endif
                                                    </ul>
                                                </nav>
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                </article>
            </div>
        </div>
    </div>

    <!-- Quickview Modal -->
    <div class="zoo-quickview-overlay" id="quickview-overlay"></div>
    <div class="zoo-quickview-modal" id="quickview-modal">
        <a href="#" class="close-btn close-quickview" id="close-quickview" title="{{ __('shop.close') }}">✕</a>
        <div class="zoo-quickview-content" id="quickview-content">
            <div class="zoo-quickview-loader">{{ __('shop.loading') }}</div>
        </div>
    </div>
</div>
@endsection

@push('scripts')

@endpush