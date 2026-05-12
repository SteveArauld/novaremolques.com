@extends('layouts.app')

@section('title', __('checkout.page_title'))

@push('styles')
<link rel='stylesheet' id='font-icomoon-css' href='{{ asset("assets/css/checkout.css") }}'
    type='text/css' media='all' />
@endpush

@section('content')
<div id="main" class="wrapper">
    <div class="breadcrumb-title-wrapper breadcrumb-v3">
        <div class="container">
            <div class="breadcrumb-title">
                <h1 class="heading-title page-title entry-title">{{ __('checkout.page_title') }}</h1>
                <div class="ts-breadcrumbs breadcrumbs">
                    <div class="breadcrumbs-container">
                        <a href="{{ route('home') }}">{{ __('checkout.breadcrumb_home') }}</a>
                        <span class="brn_arrow">/</span>
                        <a href="{{ route('cart') }}">{{ __('checkout.breadcrumb_cart') }}</a>
                        <span class="brn_arrow">/</span>
                        <span class="current">{{ __('checkout.breadcrumb_current') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-container show_breadcrumb_v3 no-sidebar">
        <div class="container checkout-page-container">
            <div id="checkout-app">
                <!-- Le contenu sera généré par JavaScript -->
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    (function() {
        console.log('💳 Initialisation de la page checkout...');

        class CheckoutPage {
            constructor() {
                this.cart = this.loadCart();
                this.translations = {
                    empty_title: '{{ __("checkout.empty_title") }}',
                    empty_text: '{{ __("checkout.empty_text") }}',
                    discover_products: '{{ __("checkout.discover_products") }}',
                    have_account: '{{ __("checkout.have_account") }}',
                    click_login: '{{ __("checkout.click_login") }}',
                    billing_details: '{{ __("checkout.billing_details") }}',
                    first_name: '{{ __("checkout.first_name") }}',
                    last_name: '{{ __("checkout.last_name") }}',
                    first_name_placeholder: '{{ __("checkout.first_name_placeholder") }}',
                    last_name_placeholder: '{{ __("checkout.last_name_placeholder") }}',
                    company: '{{ __("checkout.company") }}',
                    company_placeholder: '{{ __("checkout.company_placeholder") }}',
                    country: '{{ __("checkout.country") }}',
                    address: '{{ __("checkout.address") }}',
                    address_placeholder: '{{ __("checkout.address_placeholder") }}',
                    address2: '{{ __("checkout.address2") }}',
                    address2_placeholder: '{{ __("checkout.address2_placeholder") }}',
                    city: '{{ __("checkout.city") }}',
                    city_placeholder: '{{ __("checkout.city_placeholder") }}',
                    postcode: '{{ __("checkout.postcode") }}',
                    postcode_placeholder: '{{ __("checkout.postcode_placeholder") }}',
                    state: '{{ __("checkout.state") }}',
                    phone: '{{ __("checkout.phone") }}',
                    phone_placeholder: '{{ __("checkout.phone_placeholder") }}',
                    email: '{{ __("checkout.email") }}',
                    email_placeholder: '{{ __("checkout.email_placeholder") }}',
                    required: '{{ __("checkout.required") }}',
                    optional: '{{ __("checkout.optional") }}',
                    ship_different: '{{ __("checkout.ship_different") }}',
                    shipping_title: '{{ __("checkout.shipping_title") }}',
                    order_notes: '{{ __("checkout.order_notes") }}',
                    order_notes_placeholder: '{{ __("checkout.order_notes_placeholder") }}',
                    your_order: '{{ __("checkout.your_order") }}',
                    subtotal: '{{ __("checkout.subtotal") }}',
                    shipping: '{{ __("checkout.shipping") }}',
                    free_shipping: '{{ __("checkout.free_shipping") }}',
                    tax_label: '{{ __("checkout.tax_label") }}',
                    total: '{{ __("checkout.total") }}',
                    coupon_placeholder: '{{ __("checkout.coupon_placeholder") }}',
                    apply_coupon: '{{ __("checkout.apply_coupon") }}',
                    terms_text: '{{ __("checkout.terms_text") }}',
                    place_order: '{{ __("checkout.place_order") }}',
                    processing: '{{ __("checkout.processing") }}',
                    fill_required: '{{ __("checkout.fill_required") }}',
                    accept_terms: '{{ __("checkout.accept_terms") }}',
                    order_confirmed: '{{ __("checkout.order_confirmed") }}',
                    order_confirmed_text: '{{ __("checkout.order_confirmed_text") }}',
                    order_email_sent: '{{ __("checkout.order_email_sent") }}',
                    continue_shopping: '{{ __("checkout.continue_shopping") }}',
                    error_message: '{{ __("checkout.error_message") }}',
                    coupon_applied: '{{ __("checkout.coupon_applied") }}',
                    payment_transfer: '{{ __("checkout.payment_transfer") }}',
                    payment_card: '{{ __("checkout.payment_card") }}',
                    payment_paypal: '{{ __("checkout.payment_paypal") }}'
                };
                this.orderData = {
                    billing: {},
                    shipping: {},
                    payment: 'transfer',
                    notes: '',
                    coupon: '',
                    shipToDifferent: false
                };
                this.init();
            }

            loadCart() {
                try {
                    const cart = localStorage.getItem('portabox_cart');
                    return cart ? JSON.parse(cart) : [];
                } catch (e) {
                    return [];
                }
            }

            getSubtotal() {
                return this.cart.reduce((total, item) => total + (item.price * item.quantity), 0);
            }

            getShipping() {
                return this.getSubtotal() > 100 ? 0 : 9.90;
            }

            getTax() {
                return this.getSubtotal() * 0.21;
            }

            getTotal() {
                return this.getSubtotal() + this.getShipping();
            }

            getItemCount() {
                return this.cart.reduce((count, item) => count + item.quantity, 0);
            }

            showNotification(message) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 10000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });
                Toast.fire({
                    icon: 'success',
                    title: message,
                });
            }

            validateForm() {
                const required = ['billing_first_name', 'billing_last_name', 'billing_address_1',
                    'billing_city', 'billing_postcode', 'billing_phone', 'billing_email'
                ];

                let isValid = true;

                required.forEach(id => {
                    const input = document.getElementById(id);
                    if (input && !input.value.trim()) {
                        input.classList.add('error');
                        isValid = false;
                    } else if (input) {
                        input.classList.remove('error');
                    }
                });

                const termsCheckbox = document.getElementById('terms');
                if (termsCheckbox && !termsCheckbox.checked) {
                    isValid = false;
                    this.showNotification(this.translations.accept_terms);
                }

                return isValid;
            }

            async placeOrder() {
                if (!this.validateForm()) {
                    this.showNotification(this.translations.fill_required);
                    return;
                }

                const orderData = {
                    billing: {
                        firstName: document.getElementById('billing_first_name')?.value || '',
                        lastName: document.getElementById('billing_last_name')?.value || '',
                        company: document.getElementById('billing_company')?.value || '',
                        country: document.getElementById('billing_country')?.value || '',
                        address: document.getElementById('billing_address_1')?.value || '',
                        address2: document.getElementById('billing_address_2')?.value || '',
                        city: document.getElementById('billing_city')?.value || '',
                        state: document.getElementById('billing_state')?.value || '',
                        postcode: document.getElementById('billing_postcode')?.value || '',
                        phone: document.getElementById('billing_phone')?.value || '',
                        email: document.getElementById('billing_email')?.value || ''
                    },
                    shipping: {},
                    payment: document.querySelector('input[name="payment_method"]:checked')?.value || 'transfer',
                    notes: document.getElementById('order_comments')?.value || '',
                    coupon: document.getElementById('coupon_code')?.value || '',
                    items: this.cart,
                    subtotal: this.getSubtotal(),
                    shipping_cost: this.getShipping(),
                    tax: this.getTax(),
                    total: this.getTotal()
                };

                if (document.getElementById('ship-to-different')?.checked) {
                    orderData.shipping = {
                        firstName: document.getElementById('shipping_first_name')?.value || '',
                        lastName: document.getElementById('shipping_last_name')?.value || '',
                        address: document.getElementById('shipping_address_1')?.value || '',
                        city: document.getElementById('shipping_city')?.value || '',
                        postcode: document.getElementById('shipping_postcode')?.value || '',
                        country: document.getElementById('shipping_country')?.value || ''
                    };
                } else {
                    orderData.shipping = {
                        ...orderData.billing
                    };
                }

                const btn = document.getElementById('place-order-btn');
                btn.disabled = true;
                btn.textContent = this.translations.processing;

                try {
                    const response = await fetch('/checkout/process', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(orderData)
                    });

                    const result = await response.json();

                    if (result.success) {
                        localStorage.setItem('portabox_cart', JSON.stringify([]));

                        if (window.cart && typeof window.cart.updateCartDisplay === 'function') {
                            window.cart.cart = [];
                            window.cart.updateCartDisplay();
                        }

                        this.renderConfirmation({
                            ...orderData,
                            id: result.order.order_number
                        });

                        this.showNotification(this.translations.order_confirmed);
                    } else {
                        throw new Error(result.message || this.translations.error_message);
                    }
                } catch (error) {
                    console.error('Erreur:', error);
                    this.showNotification('Erreur: ' + error.message);
                    btn.disabled = false;
                    btn.textContent = `${this.translations.place_order} (${orderData.total.toFixed(2).replace('.', ',')}€)`;
                }
            }

            render() {
                const app = document.getElementById('checkout-app');
                if (!app) return;

                if (this.cart.length === 0) {
                    app.innerHTML = this.renderEmptyCart();
                } else {
                    app.innerHTML = this.renderCheckoutForm();
                    this.attachEvents();
                }
            }

            renderEmptyCart() {
                const t = this.translations;
                return `
                <div class="checkout-empty">
                    <h2>${t.empty_title}</h2>
                    <p>${t.empty_text}</p>
                    <a href="{{ route('shop') }}" class="back-shop-btn">${t.discover_products}</a>
                </div>
            `;
            }

            renderCheckoutForm() {
                const t = this.translations;
                const subtotal = this.getSubtotal();
                const shipping = this.getShipping();
                const tax = this.getTax();
                const total = this.getTotal();

                let productsHTML = '';
                this.cart.forEach(item => {
                    productsHTML += `
                    <li class="order-product-item">
                        <img src="${item.image}" alt="${item.name}" 
                             onerror="this.src='https://via.placeholder.com/60x60?text=No+Image'">
                        <div class="order-product-info">
                            <div class="order-product-name">${item.name}</div>
                            <div class="order-product-quantity">Qté: ${item.quantity} × ${item.price.toFixed(2).replace('.', ',')}€</div>
                        </div>
                        <div class="order-product-price">${(item.price * item.quantity).toFixed(2).replace('.', ',')}€</div>
                    </li>
                `;
                });

                return `
                <div class="checkout-wrapper">
                    <div>
                        <div class="checkout-card">
                            <h3>${t.billing_details}</h3>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label>${t.first_name} <span class="required">${t.required}</span></label>
                                    <input type="text" id="billing_first_name" placeholder="${t.first_name_placeholder}" required>
                                    <span class="error-message">${t.fill_required}</span>
                                </div>
                                <div class="form-group">
                                    <label>${t.last_name} <span class="required">${t.required}</span></label>
                                    <input type="text" id="billing_last_name" placeholder="${t.last_name_placeholder}" required>
                                    <span class="error-message">${t.fill_required}</span>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label>${t.company} ${t.optional}</label>
                                <input type="text" id="billing_company" placeholder="${t.company_placeholder}">
                            </div>
                            
                            <div class="form-group">
                                <label>${t.country} <span class="required">${t.required}</span></label>
                                <select id="billing_country" required>
                                    <option value="FR">France</option>
                                    <option value="BE">Belgique</option>
                                    <option value="CH">Suisse</option>
                                    <option value="ES">Espagne</option>
                                    <option value="IT">Italie</option>
                                    <option value="DE">Allemagne</option>
                                    <option value="PT">Portugal</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label>${t.address} <span class="required">${t.required}</span></label>
                                <input type="text" id="billing_address_1" placeholder="${t.address_placeholder}" required>
                                <span class="error-message">${t.fill_required}</span>
                            </div>
                            
                            <div class="form-group">
                                <label>${t.address2} ${t.optional}</label>
                                <input type="text" id="billing_address_2" placeholder="${t.address2_placeholder}">
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label>${t.city} <span class="required">${t.required}</span></label>
                                    <input type="text" id="billing_city" placeholder="${t.city_placeholder}" required>
                                    <span class="error-message">${t.fill_required}</span>
                                </div>
                                <div class="form-group">
                                    <label>${t.postcode} <span class="required">${t.required}</span></label>
                                    <input type="text" id="billing_postcode" placeholder="${t.postcode_placeholder}" required>
                                    <span class="error-message">${t.fill_required}</span>
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label>${t.phone} <span class="required">${t.required}</span></label>
                                    <input type="tel" id="billing_phone" placeholder="${t.phone_placeholder}" required>
                                    <span class="error-message">${t.fill_required}</span>
                                </div>
                                <div class="form-group">
                                    <label>${t.email} <span class="required">${t.required}</span></label>
                                    <input type="email" id="billing_email" placeholder="${t.email_placeholder}" required>
                                    <span class="error-message">${t.fill_required}</span>
                                </div>
                            </div>
                            
                            <div class="checkbox-group">
                                <input type="checkbox" id="ship-to-different">
                                <label for="ship-to-different">${t.ship_different}</label>
                            </div>
                            
                            <div id="shipping-fields" style="display:none;">
                                <h3 style="margin-top:20px;">${t.shipping_title}</h3>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>${t.first_name}</label>
                                        <input type="text" id="shipping_first_name" placeholder="${t.first_name_placeholder}">
                                    </div>
                                    <div class="form-group">
                                        <label>${t.last_name}</label>
                                        <input type="text" id="shipping_last_name" placeholder="${t.last_name_placeholder}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>${t.country}</label>
                                    <select id="shipping_country">
                                        <option value="FR">France</option>
                                        <option value="BE">Belgique</option>
                                        <option value="CH">Suisse</option>
                                        <option value="ES">Espagne</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>${t.address}</label>
                                    <input type="text" id="shipping_address_1" placeholder="${t.address_placeholder}">
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>${t.city}</label>
                                        <input type="text" id="shipping_city" placeholder="${t.city_placeholder}">
                                    </div>
                                    <div class="form-group">
                                        <label>${t.postcode}</label>
                                        <input type="text" id="shipping_postcode" placeholder="${t.postcode_placeholder}">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group" style="margin-top:20px;">
                                <label>${t.order_notes} ${t.optional}</label>
                                <textarea id="order_comments" rows="3" placeholder="${t.order_notes_placeholder}"></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <div class="order-summary">
                        <div class="checkout-card">
                            <h3>${t.your_order}</h3>
                            <ul class="order-product-list">
                                ${productsHTML}
                            </ul>
                            <div class="summary-row">
                                <span>${t.subtotal}</span>
                                <span>${subtotal.toFixed(2).replace('.', ',')}€</span>
                            </div>
                            <div class="summary-row">
                                <span>${t.shipping}</span>
                                <span>${shipping === 0 ? t.free_shipping : shipping.toFixed(2).replace('.', ',') + '€'}</span>
                            </div>
                            <div class="summary-row">
                                <span>${t.tax_label}</span>
                                <span>${tax.toFixed(2).replace('.', ',')}€</span>
                            </div>
                            <div class="summary-row total">
                                <span>${t.total}</span>
                                <span class="amount">${total.toFixed(2).replace('.', ',')}€</span>
                            </div>
                            
                            <div class="checkbox-group" style="margin-top:20px;">
                                <input type="checkbox" id="terms">
                                <label for="terms">${t.terms_text} <span class="required">${t.required}</span></label>
                            </div>
                            
                            <button type="button" class="place-order-btn" id="place-order-btn">
                                ${t.place_order} (${total.toFixed(2).replace('.', ',')}€)
                            </button>
                        </div>
                    </div>
                </div>
            `;
            }

            renderConfirmation(orderData) {
                const t = this.translations;
                const app = document.getElementById('checkout-app');
                if (!app) return;

                app.innerHTML = `
                <div class="checkout-card" style="text-align:center;padding:60px 30px;">
                    <div style="font-size:80px;margin-bottom:20px;">✅</div>
                    <h2 style="color:#4CAF50;">${t.order_confirmed}</h2>
                    <p style="font-size:18px;margin:15px 0;">${t.order_confirmed_text.replace(':id', orderData.id)}</p>
                    <p style="color:#777;">Total : <strong style="color:#FC6702;font-size:20px;">${orderData.total.toFixed(2).replace('.', ',')}€</strong></p>
                    <p style="color:#777;">${t.order_email_sent.replace(':email', orderData.billing.email)}</p>
                    <div style="margin-top:30px;">
                        <a href="{{ route('shop') }}" class="back-shop-btn" style=" display: inline-block; padding: 15px 40px; background: #FC6702;  color: white;   text-decoration: none;      border-radius: 5px;     font-weight: 600;      font-size: 16px;  transition: all 0.3s ease;">${t.continue_shopping}</a>
                    </div>
                </div>
            `;

                if (window.cart && typeof window.cart.updateCartDisplay === 'function') {
                    window.cart.cart = [];
                    window.cart.updateCartDisplay();
                }
            }

            attachEvents() {
                const self = this;

                const shipCheckbox = document.getElementById('ship-to-different');
                const shippingFields = document.getElementById('shipping-fields');
                if (shipCheckbox && shippingFields) {
                    shipCheckbox.addEventListener('change', function() {
                        shippingFields.style.display = this.checked ? 'block' : 'none';
                    });
                }

                const placeOrderBtn = document.getElementById('place-order-btn');
                if (placeOrderBtn) {
                    placeOrderBtn.addEventListener('click', function() {
                        self.placeOrder();
                    });
                }

                document.querySelectorAll('input[required], select[required]').forEach(input => {
                    input.addEventListener('blur', function() {
                        if (!this.value.trim()) {
                            this.classList.add('error');
                        } else {
                            this.classList.remove('error');
                        }
                    });

                    input.addEventListener('input', function() {
                        if (this.value.trim()) {
                            this.classList.remove('error');
                        }
                    });
                });
            }

            init() {
                this.render();
                console.log('✅ Page checkout initialisée');
            }
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => new CheckoutPage());
        } else {
            new CheckoutPage();
        }

    })();
</script>
@endpush