@extends('layouts.app')

@section('title', __('cart.page_title'))

@push('styles')
<link rel='stylesheet' id='font-icomoon-css' href='{{ asset("assets/css/cart.css") }}'
          type='text/css' media='all'/>
@endpush

@section('content')
<div id="main" class="wrapper">
    <div class="breadcrumb-title-wrapper breadcrumb-v3">
        <div class="container">
            <div class="breadcrumb-title">
                <h1 class="heading-title page-title entry-title">{{ __('cart.page_title') }}</h1>
                <div class="ts-breadcrumbs breadcrumbs">
                    <div class="breadcrumbs-container">
                        <a href="{{ route('home') }}">{{ __('cart.breadcrumb_home') }}</a>
                        <span class="brn_arrow">/</span>
                        <span class="current">{{ __('cart.breadcrumb_current') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-container show_breadcrumb_v3 no-sidebar">
        <div class="container cart-page-container">
            <div id="cart-app">
                <!-- Le contenu sera généré par JavaScript -->
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// ============ GESTION DE LA PAGE PANIER ============
(function() {
    
    class CartPage {
        constructor() {
            this.cart = this.loadCart();
            this.translations = {
                empty_title: '{{ __("cart.empty_title") }}',
                empty_text: '{{ __("cart.empty_text") }}',
                continue_shopping: '{{ __("cart.continue_shopping") }}',
                product: '{{ __("cart.product") }}',
                unit_price: '{{ __("cart.unit_price") }}',
                quantity: '{{ __("cart.quantity") }}',
                subtotal: '{{ __("cart.subtotal") }}',
                summary_title: '{{ __("cart.summary_title") }}',
                subtotal_label: '{{ __("cart.subtotal_label") }}',
                shipping: '{{ __("cart.shipping") }}',
                free_shipping: '{{ __("cart.free_shipping") }}',
                tax_label: '{{ __("cart.tax_label") }}',
                total: '{{ __("cart.total") }}',
                tax_info: '{{ __("cart.tax_info") }}',
                checkout: '{{ __("cart.checkout") }}',
                update_cart: '{{ __("cart.update_cart") }}',
                remove_notification: '{{ __("cart.remove_notification") }}',
                update_notification: '{{ __("cart.update_notification") }}'
            };
            this.init();
        }
        
        loadCart() {
            try {
                const cart = localStorage.getItem('portabox_cart');
                return cart ? JSON.parse(cart) : [];
            } catch(e) {
                console.error('Erreur chargement panier:', e);
                return [];
            }
        }
        
        saveCart() {
            try {
                localStorage.setItem('portabox_cart', JSON.stringify(this.cart));
                this.updateHeaderCart();
            } catch(e) {
                console.error('Erreur sauvegarde panier:', e);
            }
        }
        
        getTotal() {
            return this.cart.reduce((total, item) => total + (item.price * item.quantity), 0);
        }
        
        getItemCount() {
            return this.cart.reduce((count, item) => count + item.quantity, 0);
        }
        
        updateHeaderCart() {
            if (window.cart && typeof window.cart.updateCartDisplay === 'function') {
                window.cart.updateCartDisplay();
            }
        }
        
        removeItem(productId) {
            const row = document.querySelector(`[data-product-id="${productId}"]`);
            if (row) {
                row.classList.add('cart-item-removing');
            }
            
            setTimeout(() => {
                this.cart = this.cart.filter(item => item.id !== productId);
                this.saveCart();
                this.render();
                this.showNotification(this.translations.remove_notification);
            }, 300);
        }
        
        updateQuantity(productId, quantity) {
            const product = this.cart.find(item => item.id === productId);
            if (product) {
                product.quantity = Math.max(1, parseInt(quantity) || 1);
                this.saveCart();
                this.render();
            }
        }
        
        incrementQuantity(productId) {
            const product = this.cart.find(item => item.id === productId);
            if (product) {
                product.quantity += 1;
                this.saveCart();
                this.render();
            }
        }
        
        decrementQuantity(productId) {
            const product = this.cart.find(item => item.id === productId);
            if (product && product.quantity > 1) {
                product.quantity -= 1;
                this.saveCart();
                this.render();
            }
        }
        
        showNotification(message) {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end', 
                showConfirmButton: false,
                showCloseButton: true, 
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                }
            });

            Toast.fire({
                icon: 'success',
                title: message
            });
        }
        
        render() {
            const app = document.getElementById('cart-app');
            if (!app) return;
            
            if (this.cart.length === 0) {
                app.innerHTML = this.renderEmptyCart();
            } else {
                app.innerHTML = this.renderCartContent();
                this.attachEvents();
            }
        }
        
        renderEmptyCart() {
            const t = this.translations;
            return `
                <div class="cart-empty-message">
                    <div class="empty-icon">🛒</div>
                    <h2>${t.empty_title}</h2>
                    <p>${t.empty_text}</p>
                    <a href="{{ route('shop') }}" class="back-shop-btn">${t.continue_shopping}</a>
                </div>
            `;
        }
        
        renderCartContent() {
            const t = this.translations;
            const total = this.getTotal();
            const tax = total * 0.21;
            const shipping = total > 100 ? 0 : 9.90;
            const grandTotal = total + shipping;
            
            let productsHTML = '';
            this.cart.forEach(item => {
                productsHTML += `
                    <div class="cart-item" data-product-id="${item.id}">
                        <div class="cart-item-remove">
                            <button class="remove-btn" data-action="remove" data-product-id="${item.id}">×</button>
                        </div>
                        <div class="cart-item-image">
                            <a href="/product/${item.slug}">
                                <img src="${item.image}" alt="${item.name}" 
                                     onerror="this.src='https://via.placeholder.com/80x80?text=No+Image'">
                            </a>
                        </div>
                        <div class="cart-item-name">
                            <a href="/product/${item.slug}">${item.name}</a>
                        </div>
                        <div class="cart-item-price">
                            ${item.price.toFixed(2).replace('.', ',')} €
                        </div>
                        <div class="cart-item-quantity">
                            <div class="quantity-selector">
                                <button data-action="decrement" data-product-id="${item.id}">−</button>
                                <input type="number" class="quantity-input" value="${item.quantity}" 
                                       min="1" data-product-id="${item.id}" data-action="quantity">
                                <button data-action="increment" data-product-id="${item.id}">+</button>
                            </div>
                        </div>
                        <div class="cart-item-subtotal">
                            ${(item.price * item.quantity).toFixed(2).replace('.', ',')} €
                        </div>
                    </div>
                `;
            });
            
            return `
                <div class="cart-content-wrapper">
                    <div class="cart-products-card">
                        <div class="cart-header">
                            <div></div>
                            <div>${t.product}</div>
                            <div></div>
                            <div>${t.unit_price}</div>
                            <div>${t.quantity}</div>
                            <div>${t.subtotal}</div>
                        </div>
                        <div class="cart-items-list">
                            ${productsHTML}
                        </div>
                        <div class="cart-actions">
                            <a href="{{ route('shop') }}" class="back-shop-btn">
                                ← ${t.continue_shopping}
                            </a>
                            <button class="update-cart-btn" data-action="update">
                                ${t.update_cart}
                            </button>
                        </div>
                    </div>
                    
                    <div class="cart-summary-card">
                        <h2>${t.summary_title}</h2>
                        <div class="summary-row">
                            <span>${t.subtotal_label}</span>
                            <span id="cart-subtotal-total">${total.toFixed(2).replace('.', ',')} €</span>
                        </div>
                        <div class="summary-row">
                            <span>${t.shipping}</span>
                            <span id="cart-shipping">${shipping === 0 ? t.free_shipping : shipping.toFixed(2).replace('.', ',') + ' €'}</span>
                        </div>
                        <div class="summary-row">
                            <span>${t.tax_label}</span>
                            <span id="cart-tax">${tax.toFixed(2).replace('.', ',')} €</span>
                        </div>
                        <div class="summary-row total">
                            <span>${t.total}</span>
                            <span id="cart-total-price" class="amount">${grandTotal.toFixed(2).replace('.', ',')} €</span>
                        </div>
                        <p class="tax-info" style="margin-top:10px;font-size:12px;color:#999;">
                            ${t.tax_info.replace(':tax', tax.toFixed(2).replace('.', ','))}
                        </p>
                        <a href="{{ route('checkout') }}" class="checkout-btn">
                            ${t.checkout}
                        </a>
                    </div>
                </div>
            `;
        }
        
        attachEvents() {
            const self = this;
            
            document.querySelectorAll('[data-action="remove"]').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const productId = parseInt(this.dataset.productId);
                    self.removeItem(productId);
                });
            });
            
            document.querySelectorAll('[data-action="increment"]').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const productId = parseInt(this.dataset.productId);
                    self.incrementQuantity(productId);
                });
            });
            
            document.querySelectorAll('[data-action="decrement"]').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const productId = parseInt(this.dataset.productId);
                    self.decrementQuantity(productId);
                });
            });
            
            document.querySelectorAll('[data-action="quantity"]').forEach(input => {
                input.addEventListener('change', function() {
                    const productId = parseInt(this.dataset.productId);
                    const quantity = parseInt(this.value);
                    self.updateQuantity(productId, quantity);
                });
                
                input.addEventListener('keypress', function(e) {
                    if (e.key === '-' || e.key === 'e') {
                        e.preventDefault();
                    }
                });
            });
            
            const updateBtn = document.querySelector('[data-action="update"]');
            if (updateBtn) {
                updateBtn.addEventListener('click', function() {
                    self.showNotification(self.translations.update_notification);
                });
            }
        }
        
        init() {
            this.render();
        }
    }
    
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => new CartPage());
    } else {
        new CartPage();
    }
    
})();
</script>
@endpush