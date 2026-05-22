@extends('layouts.app')

@section('title', $article->name)

@push('styles')
<link rel='stylesheet'
    href="{{ asset('assets/css/show.css') }}" type='text/css'
    media='all' />
<style>
    /* Styles pour les étoiles et avis */
    .star-rating-wrapper {
        display: flex;
        align-items: center;
        gap: 8px;
        margin: 5px 0;
    }
    
    .star-rating {
        font-family: 'star';
        overflow: hidden;
        position: relative;
        height: 1.2em;
        line-height: 1.2;
        font-size: 0.85em;
        width: 5.3em;
        color: #ddd;
        display: inline-block;
    }
    
    .star-rating::before {
        content: '\53\53\53\53\53';
        float: left;
        top: 0;
        left: 0;
        position: absolute;
        color: #ddd;
    }
    
    .star-rating span {
        overflow: hidden;
        float: left;
        top: 0;
        left: 0;
        position: absolute;
        padding-top: 1.2em;
        color: #f4c542;
    }
    
    .star-rating span::before {
        content: '\53\53\53\53\53';
        top: 0;
        position: absolute;
        left: 0;
        color: #f4c542;
    }
    
    .rating-text {
        font-size: 14px;
        color: #666;
        font-weight: 500;
    }
    
    .review-count {
        font-size: 14px;
        color: #666;
        text-decoration: underline;
    }
    
    /* Styles pour la section des avis */
    .reviews-section {
        margin-top: 40px;
        padding: 20px;
        background: #f9f9f9;
        border-radius: 8px;
    }
    
    .reviews-section h2 {
        margin-bottom: 20px;
        font-size: 24px;
        color: #333;
    }
    
    .review-item {
        background: white;
        padding: 20px;
        margin-bottom: 15px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .review-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }
    
    .review-author {
        font-weight: 600;
        color: #333;
    }
    
    .review-date {
        font-size: 12px;
        color: #999;
    }
    
    .review-stars {
        color: #f4c542;
        margin-bottom: 10px;
    }
    
    .review-comment {
        color: #555;
        line-height: 1.6;
    }
    
    .review-verified {
        font-size: 12px;
        color: #28a745;
        margin-top: 5px;
    }
    
    .review-country {
        font-size: 12px;
        color: #999;
        margin-left: 10px;
    }
    
    .no-reviews {
        text-align: center;
        padding: 40px;
        color: #999;
    }
    
    /* Formulaire d'avis */
    .review-form {
        margin-top: 30px;
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .review-form h3 {
        margin-bottom: 20px;
    }
    
    .form-group {
        margin-bottom: 15px;
    }
    
    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: 500;
    }
    
    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }
    
    .star-selector {
        display: flex;
        gap: 5px;
        font-size: 24px;
        color: #ddd;
        cursor: pointer;
    }
    
    .star-selector .star.selected {
        color: #f4c542;
    }
    
    .submit-review-btn {
        background: #28a745;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }
    
    .submit-review-btn:hover {
        background: #218838;
    }
</style>
@endpush

@section('body_class',
'wp-singular product-template-default single single-product postid-11363 wp-theme-merto
theme-merto woocommerce woocommerce-page woocommerce-js wide header-v1 product-label-rectangle product-hover-style-v2
product-border-radius vertical-menu-fixed ts_desktop elementor-default elementor-kit-10348 e--ua-blink e--ua-chrome
e--ua-webkit cht-in-desktop cht-landscape')

@section('content')
<div id="main" class="wrapper">
    <div class="breadcrumb-title-wrapper breadcrumb-v3 no-title">
        <div class="container">
            <div class="breadcrumb-title">
                <div class="ts-breadcrumbs breadcrumbs">
                    <div class="breadcrumbs-container">
                        <a href="{{ url('/') }}">{{ __('product.breadcrumb.home') }}</a>
                        <span class="brn_arrow">/</span>
                        <a href="{{ route('category.show', $article->category->slug ?? '#') }}">
                            {{ $article->category->name }}
                        </a>
                        <span class="brn_arrow">/</span>
                        {{ $article->name }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-container show_breadcrumb_v3 no-sidebar">
        <div id="main-content">
            <div id="primary" class="site-content">
                <div class="woocommerce-notices-wrapper"></div>

                <div id="product-{{ $article->id }}"
                    class="gallery-layout-vertical has-gallery color-variation-thumbnail product type-product">

                    {{-- Product Gallery --}}
                    <div class="woocommerce-product-gallery woocommerce-product-gallery--with-images woocommerce-product-gallery--columns-4 images"
                        data-columns="4">
                        <div class="woocommerce-product-gallery__wrapper" style="max-height: 900px;">
                            @if ($article->images->count() > 0)
                            @foreach ($article->images as $index => $image)
                            <div data-thumb="{{ asset($image->fichier) }}"
                                data-thumb-alt="{{ $article->name }}"
                                class="testpourgrand {{ $index == 0 ? 'flex-active-slide' : '' }}"
                                style="{{ $index == 0 ? 'display: block;' : 'display: none;' }}">
                                <a href="{{ asset($image->fichier) }}">
                                    <img fetchpriority="high" width="700" height="586"
                                        src="{{ asset($image->fichier) }}" class="wp-post-image"
                                        alt="{{ $article->name }}" data-caption=""
                                        data-src="{{ asset($image->fichier) }}"
                                        data-large_image="{{ asset($image->fichier) }}"
                                        data-large_image_width="1643" data-large_image_height="1375"
                                        decoding="async">
                                </a>
                            </div>
                            @endforeach
                            @else
                            <div class="testpourgrand flex-active-slide">
                                <a href="#">
                                    <img src="https://via.placeholder.com/700x586" alt="Placeholder">
                                </a>
                            </div>
                            @endif
                        </div>

                        @if ($article->images->count() > 1)
                        <ol class="flex-control-nav flex-control-thumbs"
                            style="max-height: 900px;overflow: auto; display: block;">
                            @foreach ($article->images as $index => $image)
                            <li>
                                <img src="{{ asset($image->fichier) }}"
                                    alt="{{ $article->name }} {{ $index + 1 }}"
                                    class="{{ $index == 0 ? 'flex-active' : '' }}" draggable="false"
                                    width="300" height="300">
                            </li>
                            @endforeach
                        </ol>
                        @endif
                    </div>

                    {{-- Product Summary --}}
                    <div class="summary entry-summary">
                        <h1 class="product_title entry-title">{{ $article->name }}</h1>

                        {{-- Section des étoiles et avis --}}
                        <div class="woocommerce-product-rating" style="margin-bottom:10px;">
                            @php
                                $averageRating = $article->average_rating ?? 0;
                                $reviewCount = $article->review_count ?? 0;
                                $ratingPercentage = ($averageRating / 5) * 100;
                            @endphp
                            
                            <div class="star-rating-wrapper">
                                <div class="star-rating">
                                    <span style="width:{{ $ratingPercentage }}%;"></span>
                                </div>
                                <span class="rating-text">({{ number_format($averageRating, 1) }})</span>
                                <a href="#reviews" class="review-count">
                                    {{ $reviewCount }} {{ __('product.reviews') }}
                                </a>
                            </div>
                        </div>

                        @if ($article->short_description)
                        <div class="woocommerce-product-details__short-description">
                            <p>{{ $article->short_description }}</p>
                        </div>
                        @endif

                        {{-- PRIX CORRIGÉ : Utilisation cohérente de prix_original et prix_actuel --}}
                        <p class="price">
                            @php
                            $prixOriginal = $article->prix_original;
                            $prixActuel = $article->prix_actuel;
                            @endphp

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
                        </p>

                        @if($prixOriginal && $prixOriginal > $prixActuel)
                        <span class="ts-discount-number">
                            ({{ __('product.save', ['amount' => number_format($prixOriginal - $prixActuel, 2, '.', ',')]) }})
                        </span>
                        @endif

                        {{-- Flamme animée --}}
                        <div class="sales-info">
                            <span class="fire-icon-wrapper">
                                <i class="fa-solid fa-fire fire-icon-animated"></i>
                            </span>
                            <span>{!! __('product.sales_count', ['count' => '<strong id="sales-count">36</strong>', 'hours' => '<strong>16</strong>']) !!}</span>
                        </div>

                        {{-- Compte à rebours --}}
                        <div class="countdown-notice">
                            <i class="fa-regular fa-clock clock-icon-animated"></i>
                            <span>{!! __('product.countdown', ['time' => '<strong id="countdown-timer">07 heures 42 minutes</strong>', 'date' => '<strong id="delivery-date">13 mai 2026</strong>']) !!}</span>
                        </div>

                        {{-- Visiteurs en temps réel --}}
                        <div class="visitor-count">
                            <span class="visitor-pulse"></span>
                            <span>{!! __('product.visitors', ['count' => '<strong id="visitor-number">138</strong>']) !!}</span>
                        </div>

                        {{-- Section panier personnalisé --}}
                        <div class="custom-cart-section">
                            <div class="custom-qty-row">
                                <div class="custom-qty-selector">
                                    <button type="button" id="custom-qty-decrease">−</button>
                                    <input type="number" id="custom-product-quantity" value="1" min="1" max="{{ $article->stock ?? 99 }}">
                                    <button type="button" id="custom-qty-increase">+</button>
                                </div>
                                <button type="button" class="custom-add-to-cart-btn" id="custom-add-to-cart-btn">
                                    {{ __('product.add_to_cart') }}
                                </button>
                            </div>

                            {{-- Bouton Acheter maintenant --}}
                            <a href="{{ route('checkout') }}" class="buy-now-btn" id="buy-now-btn">
                                {{ __('product.buy_now') }}
                            </a>

                            {{-- Boutons supplémentaires --}}
                            <div class="extra-buttons">
                                <a href="#" class="extra-btn add-to-wishlist-btn" data-id="{{ $article->id }}">
                                    {{ __('product.add_to_wishlist') }}
                                </a>
                                <a href="#" class="extra-btn add-to-compare-btn" data-id="{{ $article->id }}">
                                    {{ __('product.compare') }}
                                </a>
                            </div>
                        </div>

                        {{-- Garanties --}}
                        <div class="trust-section">
                            <div class="trust-badges">
                                <div class="trust-badge"><i class="fa-solid fa-truck-fast"></i> {{ __('product.fast_delivery') }}</div>
                                <div class="trust-badge"><i class="fa-solid fa-lock"></i> {{ __('product.secure_payment') }}</div>
                                <div class="trust-badge"><i class="fa-solid fa-box"></i> {{ __('product.satisfied_or_refunded') }}</div>
                            </div>
                            <div class="safe-checkout">
                                <i class="fa-solid fa-shield-halved"></i> {{ __('product.safe_checkout') }}
                            </div>
                        </div>

                        {{-- Réseaux sociaux --}}
                        <div class="share-section">
                            <span class="label-share">{{ __('product.share') }} :</span>
                            <div class="share-links">
                                <a href="https://www.facebook.com/sharer.php?u={{ url()->current() }}" target="_blank" class="share-facebook" title="Facebook">
                                    <i class="fa-brands fa-facebook-f"></i>
                                </a>
                                <a href="https://twitter.com/share?url={{ url()->current() }}&text={{ $article->name }}" target="_blank" class="share-twitter" title="Twitter">
                                    <i class="fa-brands fa-x-twitter"></i>
                                </a>
                                <a href="https://pinterest.com/pin/create/button/?url={{ url()->current() }}&media={{ $article->images->first() ? asset($article->images->first()->fichier) : '' }}&description={{ $article->name }}" target="_blank" class="share-pinterest" title="Pinterest">
                                    <i class="fa-brands fa-pinterest-p"></i>
                                </a>
                                <a href="mailto:?subject={{ $article->name }}&body={{ url()->current() }}" class="share-email" title="Email">
                                    <i class="fa-solid fa-envelope"></i>
                                </a>
                            </div>
                        </div>

                        <div class="meta-content">
                            @if ($article->sku)
                            <div class="sku-wrapper product_meta">
                                <span>{{ __('product.sku') }}: </span>
                                <span class="sku">{{ $article->sku }}</span>
                            </div>
                            @endif

                            @if ($article->category)
                            <div class="cats-link">
                                <span>{{ __('product.category') }}: </span>
                                <span class="cat-links">
                                    <a href="{{ route('category.show', $article->category->slug) }}" rel="tag">
                                        {{ $article->category->name }}
                                    </a>
                                </span>
                            </div>
                            @endif
                        </div>
                    </div>

                    {{-- Description en bas --}}
                    @if ($article->description)
                    <div class="product-description-section">
                        <h2>{{ __('product.description') }}</h2>
                        <div class="product-description">
                            {!! nl2br(e($article->description)) !!}
                        </div>
                    </div>
                    @endif

                    {{-- Section des avis --}}
                    <div class="reviews-section" id="reviews">
                        <h2>{{ __('product.customer_reviews') }}</h2>
                        
                        @php
                            $reviews = $article->reviews()->approved()->orderBy('created_at', 'desc')->get();
                        @endphp
                        
                        @if($reviews->count() > 0)
                            @foreach($reviews as $review)
                            <div class="review-item">
                                <div class="review-header">
                                    <span class="review-author">
                                        {{ $review->author_name }}
                                        @if($review->author_country)
                                        <span class="review-country">📍 {{ $review->author_country }}</span>
                                        @endif
                                    </span>
                                    <span class="review-date">{{ $review->created_at->format('d/m/Y') }}</span>
                                </div>
                                
                                <div class="review-stars">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $review->rating)
                                            <i class="fas fa-star"></i>
                                        @else
                                            <i class="far fa-star"></i>
                                        @endif
                                    @endfor
                                </div>
                                
                                <div class="review-comment">
                                    {{ $review->comment }}
                                </div>
                                
                                @if($review->is_verified)
                                <div class="review-verified">
                                    ✓ {{ __('product.verified_purchase') }}
                                </div>
                                @endif
                            </div>
                            @endforeach
                        @else
                            <div class="no-reviews">
                                <p>{{ __('product.no_reviews_yet') }}</p>
                            </div>
                        @endif
                        
                        {{-- Formulaire d'avis --}}
                        <div class="review-form">
                            <h3>{{ __('product.leave_review') }}</h3>
                            <form action="{{ route('product.review.submit', $article->id) }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="author_name">{{ __('product.your_name') }} *</label>
                                    <input type="text" id="author_name" name="author_name" required>
                                </div>
                                
                                <div class="form-group">
                                    <label for="author_email">{{ __('product.your_email') }} *</label>
                                    <input type="email" id="author_email" name="author_email" required>
                                </div>
                                
                                <div class="form-group">
                                    <label>{{ __('product.your_rating') }} *</label>
                                    <input type="hidden" name="rating" id="rating-input" value="5">
                                    <div class="star-selector" id="star-selector">
                                        @for($i = 1; $i <= 5; $i++)
                                            <span class="star selected" data-rating="{{ $i }}">★</span>
                                        @endfor
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="comment">{{ __('product.your_review') }} *</label>
                                    <textarea id="comment" name="comment" rows="4" required minlength="10"></textarea>
                                </div>
                                
                                <div class="form-group">
                                    <label for="country">{{ __('product.your_country') }}</label>
                                    <select id="country" name="country">
                                        <option value="PT">Portugal</option>
                                        <option value="FR">France</option>
                                        <option value="ES">Espagne</option>
                                        <option value="IT">Italie</option>
                                    </select>
                                </div>
                                
                                <button type="submit" class="submit-review-btn">
                                    {{ __('product.submit_review') }}
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- Related Products --}}
                    @if ($relatedArticles->count() > 0)
                    <section class="related products">
                        <h2>{{ __('product.related.title') }}</h2>
                        <div class="products swiper swiper-theme-4554-0">
                            <div class="swiper-wrapper">
                                @foreach ($relatedArticles as $related)
                                <section class="product type-product swiper-slide"
                                    data-product_id="{{ $related->id }}">
                                    <div class="product-wrapper">
                                        <div class="thumbnail-wrapper">
                                            <a href="{{ route('product.show', $related->slug) }}">
                                                <figure class="no-back-image">
                                                    @if ($related->images->first())
                                                    <img loading="lazy" width="300" height="300"
                                                        src="{{ asset($related->images->first()->fichier) }}"
                                                        class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
                                                        alt="{{ $related->name }}" decoding="async">
                                                    @else
                                                    <img loading="lazy" width="300" height="300"
                                                        src="https://via.placeholder.com/300x300"
                                                        alt="Placeholder">
                                                    @endif
                                                </figure>
                                            </a>

                                            @if ($related->prix_original && $related->prix_original > $related->prix_actuel)
                                            @php
                                            $discount = round(
                                            (($related->prix_original - $related->prix_actuel) / $related->prix_original) * 100
                                            );
                                            @endphp
                                            <div class="product-label">
                                                <span class="onsale percent"><span>-{{ $discount }}%</span></span>
                                            </div>
                                            @endif
                                        </div>

                                        <div class="meta-wrapper">
                                            <h3 class="heading-title product-name">
                                                <a href="{{ route('product.show', $related->slug) }}">
                                                    {{ $related->name }}
                                                </a>
                                            </h3>

                                            <span class="price">
                                                @if ($related->prix_original && $related->prix_original > $related->prix_actuel)
                                                <del aria-hidden="true">
                                                    <span class="woocommerce-Price-amount amount">
                                                        <bdi>{{ number_format($related->prix_original, 2, '.', ',') }}&nbsp;€</bdi>
                                                    </span>
                                                </del>
                                                <ins aria-hidden="true">
                                                    <span class="woocommerce-Price-amount amount">
                                                        <bdi>{{ number_format($related->prix_actuel, 2, '.', ',') }}&nbsp;€</bdi>
                                                    </span>
                                                </ins>
                                                @else
                                                <span class="woocommerce-Price-amount amount">
                                                    <bdi>{{ number_format($related->prix_actuel, 2, '.', ',') }}&nbsp;€</bdi>
                                                </span>
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </section>
                                @endforeach
                            </div>
                        </div>
                    </section>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@php
$productId = $article->id ?? 0;
$inquiryUrl = route('product.inquiry', ['id' => $article->id]);
@endphp

@push('scripts')
<script src="{{ asset('assets/js/product/image-gallery.js') }}"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        // Gestion des étoiles dans le formulaire
        const stars = document.querySelectorAll('#star-selector .star');
        const ratingInput = document.getElementById('rating-input');
        
        stars.forEach(star => {
            star.addEventListener('click', function() {
                const rating = this.getAttribute('data-rating');
                ratingInput.value = rating;
                
                stars.forEach(s => {
                    if (s.getAttribute('data-rating') <= rating) {
                        s.classList.add('selected');
                    } else {
                        s.classList.remove('selected');
                    }
                });
            });
            
            star.addEventListener('mouseover', function() {
                const rating = this.getAttribute('data-rating');
                stars.forEach(s => {
                    if (s.getAttribute('data-rating') <= rating) {
                        s.style.color = '#f4c542';
                    }
                });
            });
            
            star.addEventListener('mouseout', function() {
                const currentRating = ratingInput.value;
                stars.forEach(s => {
                    if (s.getAttribute('data-rating') <= currentRating) {
                        s.style.color = '#f4c542';
                    } else {
                        s.style.color = '#ddd';
                    }
                });
            });
        });

        const productConfig = {
            productId: '{{ $productId }}',
            inquiryUrl: '{{ $inquiryUrl }}',
            maxStock: {{ $article->stock ?? 0 }},
            minStock: 1,
            translations: {
                error: '{{ __("product.notification.error") }}',
                success: '{{ __("product.notification.success") }}',
                phoneRequired: '{{ __("product.notification.phone_required") }}',
                phoneInvalid: '{{ __("product.notification.phone_invalid") }}',
                regionRequired: '{{ __("product.notification.region_required") }}',
                quantityExceedsStock: '{{ __("product.notification.quantity_exceeds_stock") }}',
                maxStockReached: '{{ __("product.notification.max_stock_reached") }}',
                productOutOfStock: '{{ __("product.notification.out_of_stock") }}',
                selectRegion: '{{ __("product.notification.select_region") }}',
                selectCountryFirst: '{{ __("product.notification.select_country_first") }}',
                loadingRegions: '{{ __("product.notification.loading_regions") }}',
                addToCart: '{{ __("product.notification.add_to_cart") }}',
                acceptTerms: '{{ __("product.notification.accept_terms") }}',
                addToWishlist: '{{ __("product.notification.add_to_wishlist") }}',
                alreadyInWishlist: '{{ __("product.notification.already_in_wishlist") }}',
                addToCompare: '{{ __("product.notification.add_to_compare") }}',
                alreadyInCompare: '{{ __("product.notification.already_in_compare") }}'
            }
        };

        window.productConfig = productConfig;

        // Initialisations
        if (typeof QuantityManager !== 'undefined') QuantityManager.init(productConfig);
        if (typeof ImageGallery !== 'undefined') ImageGallery.init();
        if (typeof RegionManager !== 'undefined') RegionManager.init(productConfig);
        if (typeof InquiryForm !== 'undefined') InquiryForm.init(productConfig);

        // GESTION QUANTITÉ
        const qtyInput = document.getElementById('custom-product-quantity');
        const maxStock = {{ $article->stock ?? 99 }};

        const increaseBtn = document.getElementById('custom-qty-increase');
        const decreaseBtn = document.getElementById('custom-qty-decrease');

        if (increaseBtn) {
            increaseBtn.onclick = function() {
                let val = parseInt(qtyInput.value) || 1;
                if (val < maxStock) {
                    qtyInput.value = val + 1;
                }
            };
        }

        if (decreaseBtn) {
            decreaseBtn.onclick = function() {
                let val = parseInt(qtyInput.value) || 1;
                if (val > 1) {
                    qtyInput.value = val - 1;
                }
            };
        }

        if (qtyInput) {
            qtyInput.onchange = function() {
                let val = parseInt(this.value) || 1;
                if (val < 1) {
                    this.value = 1;
                }
                if (val > maxStock) {
                    this.value = maxStock;
                }
            };
        }

        // AJOUT PANIER
        const addToCartBtn = document.getElementById('custom-add-to-cart-btn');
        if (addToCartBtn) {
            addToCartBtn.onclick = function() {
                const quantity = parseInt(qtyInput.value) || 1;
                const product = {
                    id: {{ $article->id }},
                    name: '{{ addslashes($article->name) }}',
                    price: {{ $article->prix_actuel }},
                    old_price: {{ $article->prix_original ?? 'null' }},
                    image: '{{ $article->images->first() ? asset($article->images->first()->fichier) : '' }}',
                    slug: '{{ $article->slug }}',
                    quantity: quantity
                };

                this.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    this.style.transform = 'scale(1)';
                }, 150);

                if (window.cart && typeof window.cart.addToCart === 'function') {
                    window.cart.addToCart(product);
                } else {
                    let cart = JSON.parse(localStorage.getItem('portabox_cart') || '[]');
                    const existing = cart.find(item => item.id === product.id);
                    if (existing) {
                        existing.quantity += quantity;
                    } else {
                        cart.push(product);
                    }
                    localStorage.setItem('portabox_cart', JSON.stringify(cart));
                    if (typeof showNotification === 'function') {
                        showNotification(productConfig.translations.addToCart);
                    }
                }
            };
        }

        // FAVORIS
        const wishlistBtn = document.querySelector('.add-to-wishlist-btn');
        if (wishlistBtn) {
            wishlistBtn.onclick = function(e) {
                e.preventDefault();
                const wishlist = JSON.parse(localStorage.getItem('portabox_wishlist') || '[]');
                if (!wishlist.includes({{ $article->id }})) {
                    wishlist.push({{ $article->id }});
                    localStorage.setItem('portabox_wishlist', JSON.stringify(wishlist));
                    if (typeof showNotification === 'function') {
                        showNotification(productConfig.translations.addToWishlist);
                    }
                } else {
                    if (typeof showNotification === 'function') {
                        showNotification(productConfig.translations.alreadyInWishlist);
                    }
                }
            };
        }

        // COMPARATEUR
        const compareBtn = document.querySelector('.add-to-compare-btn');
        if (compareBtn) {
            compareBtn.onclick = function(e) {
                e.preventDefault();
                const compare = JSON.parse(localStorage.getItem('portabox_compare') || '[]');
                if (!compare.includes({{ $article->id }})) {
                    compare.push({{ $article->id }});
                    localStorage.setItem('portabox_compare', JSON.stringify(compare));
                    if (typeof showNotification === 'function') {
                        showNotification(productConfig.translations.addToCompare);
                    }
                } else {
                    if (typeof showNotification === 'function') {
                        showNotification(productConfig.translations.alreadyInCompare);
                    }
                }
            };
        }

        // ANIMATIONS
        function updateVisitors() {
            const el = document.getElementById('visitor-number');
            if (el) {
                el.textContent = Math.floor(Math.random() * (200 - 100 + 1)) + 100;
            }
        }
        setInterval(updateVisitors, 5000);

        function updateSales() {
            const el = document.getElementById('sales-count');
            if (el && Math.random() > 0.7) {
                el.textContent = parseInt(el.textContent) + 1;
            }
        }
        setInterval(updateSales, 30000);

        function updateCountdown() {
            const now = new Date();
            const endOfDay = new Date();
            endOfDay.setHours(23, 59, 59, 999);
            const diff = endOfDay - now;
            const hours = Math.floor(diff / (1000 * 60 * 60));
            const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            const timerEl = document.getElementById('countdown-timer');
            if (timerEl) {
                timerEl.textContent = `${hours.toString().padStart(2, '0')} heures ${minutes.toString().padStart(2, '0')} minutes`;
            }
            const delivery = new Date();
            delivery.setDate(delivery.getDate() + 3);
            const dateEl = document.getElementById('delivery-date');
            if (dateEl) {
                dateEl.textContent = delivery.toLocaleDateString('fr-FR', {
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric'
                });
            }
        }
        updateCountdown();
        setInterval(updateCountdown, 60000);
    });
</script>
@endpush