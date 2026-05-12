// ============ CART MANAGER ============
(function() {
    'use strict';
    
    // Traductions
  // Dans vos fichiers JavaScript
const translations = window.cartTranslations || {
    cartAdded: 'Produit ajouté au panier !',
    cartRemoved: 'Produit retiré du panier',
    cartEmpty: 'Votre panier est vide.',
    loading: 'Chargement...',
    loadError: 'Erreur de chargement. Réessayer',
    viewDetails: 'Voir les détails complets →',
    addToCart: '🛒 Ajouter au panier',
    addedToCart: '✅ Ajouté !',
    soldRecently: 'vendus récemment',
    qty: 'Qté:',
    noProducts: 'Aucun produit trouvé',
    seeAllProducts: 'Voir tous les produits',
    sortDefault: 'Tri par défaut',
    sortNewest: 'Plus récents',
    sortPriceAsc: 'Prix: bas à haut',
    sortPriceDesc: 'Prix: haut à bas',
    sortNameAsc: 'Nom: A-Z',
    sortNameDesc: 'Nom: Z-A',
    showing: 'Affichage',
    of: 'sur',
    results: 'résultats',
    page: 'Page',
    next: 'Suivant',
    previous: 'Précédent',
    promo: 'Promo',
    sku: 'SKU',
    categories: 'Catégories',
    close: 'Fermer'
};

    function initializeCartManager() {
        if (typeof window.cart === 'undefined') {
            createCartManager();
        }
        initializeCartButtons();
    }

    function initializeCartButtons() {
        const buttons = document.querySelectorAll('.add_to_cart_button');
        
        if (buttons.length === 0) {
            setTimeout(initializeCartButtons, 1000);
            return;
        }

        buttons.forEach(function(button) {
            const newButton = button.cloneNode(true);
            button.parentNode.replaceChild(newButton, button);

            newButton.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                const productData = {
                    id: parseInt(this.getAttribute('data-product-id')),
                    name: this.getAttribute('data-product-name'),
                    price: parseFloat(this.getAttribute('data-product-price')),
                    image: this.getAttribute('data-product-image') || 'https://via.placeholder.com/300x300?text=No+Image',
                    slug: this.getAttribute('data-product-slug') || '',
                    quantity: 1
                };

                const buttonContainer = this.closest('.button-in');
                if (buttonContainer) {
                    buttonContainer.style.transform = 'scale(0.8)';
                    setTimeout(function() {
                        buttonContainer.style.transform = 'scale(1)';
                    }, 200);
                }

                if (window.cart && typeof window.cart.addToCart === 'function') {
                    window.cart.addToCart(productData);
                }
            });
        });
    }

    function createCartManager() {
        window.cart = {
            cart: JSON.parse(localStorage.getItem('portabox_cart') || '[]'),

            addToCart: function(product) {
                const existing = this.cart.find(item => item.id === product.id);

                if (existing) {
                    existing.quantity += product.quantity || 1;
                } else {
                    this.cart.push(product);
                }

                this.saveCart();
                this.updateDisplay();
                this.showNotification(translations.cartAdded);
            },

            removeFromCart: function(productId) {
                this.cart = this.cart.filter(item => item.id !== productId);
                this.saveCart();
                this.updateDisplay();
                this.showNotification(translations.cartRemoved);
            },

            updateQuantity: function(productId, quantity) {
                const product = this.cart.find(item => item.id === productId);
                if (product) {
                    product.quantity = Math.max(1, parseInt(quantity) || 1);
                    this.saveCart();
                    this.updateDisplay();
                }
            },

            getTotal: function() {
                return this.cart.reduce((total, item) => total + (item.price * item.quantity), 0);
            },

            getItemCount: function() {
                return this.cart.reduce((count, item) => count + item.quantity, 0);
            },

            saveCart: function() {
                localStorage.setItem('portabox_cart', JSON.stringify(this.cart));
            },

            updateDisplay: function() {
                const count = this.getItemCount();
                const total = this.getTotal();

                const countElements = document.querySelectorAll('#cart-count, #cart-count-sidebar');
                countElements.forEach(el => {
                    if (el) el.textContent = count;
                });

                const subtotalElement = document.getElementById('cart-subtotal');
                if (subtotalElement) {
                    subtotalElement.innerHTML = `
                        <span class="woocommerce-Price-amount amount">
                            ${total.toFixed(2).replace('.', ',')}<span class="woocommerce-Price-currencySymbol">€</span>
                        </span>
                    `;
                }

                this.updateSidebar();

                const cartLabel = document.querySelector('.cafe-canvas-cart');
                if (cartLabel) {
                    if (this.cart.length === 0) {
                        cartLabel.classList.add('cart-empty');
                    } else {
                        cartLabel.classList.remove('cart-empty');
                    }
                }
            },

            updateSidebar: function() {
                const cartItemsContainer = document.getElementById('cart-items-container');
                const cartTotalContainer = document.getElementById('cart-total-container');
                const totalPriceElement = document.getElementById('cart-total-price');

                if (!cartItemsContainer || !cartTotalContainer) return;

                if (this.cart.length === 0) {
                    cartItemsContainer.innerHTML = `
                        <p class="woocommerce-mini-cart__empty-message">${translations.cartEmpty}</p>
                    `;
                    cartTotalContainer.style.display = 'none';
                } else {
                    let itemsHTML = '';
                    this.cart.forEach(item => {
                        itemsHTML += `
                            <div class="woocommerce-mini-cart-item mini_cart_item" data-product-id="${item.id}">
                                <a href="/product/${item.slug}">
                                    <img src="${item.image}" alt="${item.name}" width="70" height="70"
                                         onerror="this.src='https://via.placeholder.com/70x70?text=No+Image'">
                                </a>
                                <div class="product-info">
                                    <a href="/product/${item.slug}" class="product-name">${item.name.length > 20 ? item.name.substring(0, 20) + '...' : item.name}</a>
                                    <div class="quantity">
                                        <div style="display: flex;  gap: 10px;">
                                        <p>${translations.qty}</p>
                                        <p class="cart-quantity-input" >${item.quantity}   </p>
                                        </div>
                                        <span> × ${item.price.toFixed(2).replace('.', ',')}€</span>
                                         <div class="product-subtotal">
                                        ${(item.price * item.quantity).toFixed(2).replace('.', ',')}€
                                    </div>
                                    </div>
                                   
                                </div>
                                <a href="#" class="remove remove_from_cart_button" data-product-id="${item.id}">×</a>
                            </div>
                        `;
                    });

                    cartItemsContainer.innerHTML = itemsHTML;
                    cartTotalContainer.style.display = 'block';

                    if (totalPriceElement) {
                        totalPriceElement.textContent = this.getTotal().toFixed(2).replace('.', ',') + '€';
                    }

                    this.addQuantityEvents();
                    this.addRemoveEvents();
                }
            },

            addQuantityEvents: function() {
                const self = this;
                const quantityInputs = document.querySelectorAll('.cart-quantity-input');
                quantityInputs.forEach(input => {
                    input.addEventListener('change', function(e) {
                        const productId = parseInt(this.dataset.productId);
                        const quantity = parseInt(this.value);
                        self.updateQuantity(productId, quantity);
                    });
                });
            },

            addRemoveEvents: function() {
                const self = this;
                const removeButtons = document.querySelectorAll('.remove_from_cart_button');
                removeButtons.forEach(button => {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        const productId = parseInt(this.dataset.productId);
                        self.removeFromCart(productId);
                    });
                });
            },

            showNotification: function(message) {
    if (typeof Swal !== 'undefined') {
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
}
        };

        window.cart.updateDisplay();
    }

    // Initialisation
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(initializeCartManager, 500);
        });
    } else {
        setTimeout(initializeCartManager, 500);
    }

    window.addEventListener('load', function() {
        setTimeout(initializeCartManager, 1000);
    });

})();

// ============ QUICKVIEW SYSTEM ============
(function() {
    'use strict';
    
    const quickviewModal = document.getElementById('quickview-modal');
    const quickviewOverlay = document.getElementById('quickview-overlay');
    const quickviewContent = document.getElementById('quickview-content');
    const closeBtn = document.getElementById('close-quickview');
    let currentImageIndex = 0;
    let productImages = [];

    const translations = window.cartTranslations || {};
    
    function openQuickview(productId) {
        quickviewOverlay.classList.add('active');
        quickviewModal.classList.add('active');
        quickviewContent.innerHTML = `<div class="zoo-quickview-loader">${translations.loading || 'Chargement...'}</div>`;
        document.body.style.overflow = 'hidden';
        
        fetch(`/api/quickview/${productId}`)
            .then(response => response.json())
            .then(product => {
                currentImageIndex = 0;
                productImages = product.images;
                quickviewContent.innerHTML = buildQuickviewHTML(product);
                initGallery();
            })
            .catch(error => {
                quickviewContent.innerHTML = `<div class="zoo-quickview-loader">${translations.loadError || 'Erreur de chargement.'} <a href="#" onclick="location.reload()">${translations.retry || 'Réessayer'}</a></div>`;
            });
    }
    
    function buildQuickviewHTML(product) {
        const hasDiscount = product.discount && product.discount > 0;
        const mainImage = product.images.length > 0 ? product.images[0].url : 'https://via.placeholder.com/600x450?text=No+Image';
        
        let imagesHTML = '';
        product.images.forEach((image, index) => {
            imagesHTML += `
                <div class="zoo-thumbnail-item ${index === 0 ? 'active' : ''}" data-index="${index}">
                    <img src="${image.url}" alt="${image.alt || product.name}" 
                         onerror="this.src='https://via.placeholder.com/150x110?text=No+Image'">
                </div>
            `;
        });
        
        let priceHTML = '';
        if (hasDiscount) {
            priceHTML = `
                <del><span>${product.prix_original.toFixed(2).replace('.', ',')} €</span></del>
                <ins><span>${product.prix_actuel.toFixed(2).replace('.', ',')} €</span></ins>
            `;
        } else {
            priceHTML = `
                <span class="current-price">${product.prix_actuel.toFixed(2).replace('.', ',')} €</span>
            `;
        }
        
        return `
            <div class="wrap-single-product-images">
                <div class="zoo-product-gallery">
                    <div class="zoo-main-image">
                        <img id="quickview-main-image" 
                             src="${mainImage}" 
                             alt="${product.name}"
                             onerror="this.src='https://via.placeholder.com/600x450?text=No+Image'">
                        ${product.images.length > 1 ? `
                            <button class="zoo-gallery-nav prev" onclick="window.quickviewPrevImage()">❮</button>
                            <button class="zoo-gallery-nav next" onclick="window.quickviewNextImage()">❯</button>
                        ` : ''}
                    </div>
                    ${product.images.length > 1 ? `
                        <div class="zoo-thumbnails">
                            ${imagesHTML}
                        </div>
                    ` : ''}
                </div>
            </div>
            <div class="zoo-quickview-summary">
                <h1 class="product-title">${product.name}</h1>
                
                <div class="product-price">
                    ${priceHTML}
                </div>
                
                ${product.description ? `
                    <div class="product-description">
                        ${product.description.substring(0, 200)}${product.description.length > 200 ? '...' : ''}
                    </div>
                ` : ''}
                
                <form class="cart-form" onsubmit="event.preventDefault(); window.quickviewAddToCart(${product.id}, '${product.name.replace(/'/g, "\\'")}', ${product.prix_actuel}, '${product.images[0]?.url || ''}', '${product.slug}');">
                    <div class="quantity-wrapper">
                        <button type="button" class="qty-btn" onclick="this.nextElementSibling.stepDown()">−</button>
                        <input type="number" class="qty-input" value="1" min="1" step="1">
                        <button type="button" class="qty-btn" onclick="this.previousElementSibling.stepUp()">+</button>
                    </div>
                    <button type="submit" class="add-to-cart-btn">
                        ${translations.addToCart || '🛒 Ajouter au panier'}
                    </button>
                </form>
                
                <a href="/product/${product.slug}" class="view-details-btn">
                    ${translations.viewDetails || 'Voir les détails complets →'}
                </a>
                
                <div class="product-meta">
                    ${product.sku ? `<span>${translations.sku || 'SKU'}: <span class="sku">${product.sku}</span></span>` : ''}
                    ${product.categories ? `<span>${translations.categories || 'Catégories'}: ${product.categories}</span>` : ''}
                    ${product.sold_count ? `<span>🔥 ${product.sold_count} ${translations.soldRecently || 'vendus récemment'}</span>` : ''}
                </div>
            </div>
        `;
    }
    
    function initGallery() {
        const thumbnails = document.querySelectorAll('.zoo-thumbnail-item');
        thumbnails.forEach(thumb => {
            thumb.addEventListener('click', function() {
                const index = parseInt(this.dataset.index);
                updateMainImage(index);
            });
        });
    }
    
    function updateMainImage(index) {
        if (index >= 0 && index < productImages.length) {
            currentImageIndex = index;
            const mainImage = document.getElementById('quickview-main-image');
            if (mainImage && productImages[index]) {
                mainImage.src = productImages[index].url;
            }
            
            document.querySelectorAll('.zoo-thumbnail-item').forEach((thumb, i) => {
                thumb.classList.toggle('active', i === index);
            });
        }
    }
    
    window.quickviewPrevImage = function() {
        const newIndex = currentImageIndex > 0 ? currentImageIndex - 1 : productImages.length - 1;
        updateMainImage(newIndex);
    };
    
    window.quickviewNextImage = function() {
        const newIndex = currentImageIndex < productImages.length - 1 ? currentImageIndex + 1 : 0;
        updateMainImage(newIndex);
    };
    
    window.quickviewAddToCart = function(id, name, price, image, slug) {
        const qtyInput = document.querySelector('.qty-input');
        const quantity = qtyInput ? parseInt(qtyInput.value) : 1;
        
        const productData = {
            id: id,
            name: name,
            price: price,
            image: image || 'https://via.placeholder.com/300x300?text=No+Image',
            slug: slug,
            quantity: quantity
        };
        
        if (window.cart && typeof window.cart.addToCart === 'function') {
            window.cart.addToCart(productData);
        }
        
        const btn = document.querySelector('.add-to-cart-btn');
        if (btn) {
            const originalText = btn.innerHTML;
            btn.innerHTML = translations.addedToCart || '✅ Ajouté !';
            btn.style.background = '#4CAF50';
            setTimeout(() => {
                btn.innerHTML = originalText;
                btn.style.background = '#495057';
            }, 2000);
        }
    };
    
    function closeQuickview() {
        quickviewOverlay.classList.remove('active');
        quickviewModal.classList.remove('active');
        document.body.style.overflow = '';
    }
    
    if (closeBtn) {
        closeBtn.addEventListener('click', function(e) {
            e.preventDefault();
            closeQuickview();
        });
    }
    
    if (quickviewOverlay) {
        quickviewOverlay.addEventListener('click', closeQuickview);
    }
    
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && quickviewModal.classList.contains('active')) {
            closeQuickview();
        }
    });
    
    document.addEventListener('keydown', function(e) {
        if (quickviewModal.classList.contains('active')) {
            if (e.key === 'ArrowLeft') {
                window.quickviewPrevImage();
            } else if (e.key === 'ArrowRight') {
                window.quickviewNextImage();
            }
        }
    });
    
    function attachQuickviewEvents() {
        const quickshopButtons = document.querySelectorAll('.quickshop');
        quickshopButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                const productId = this.getAttribute('data-product_id');
                if (productId) {
                    openQuickview(productId);
                }
            });
        });
    }
    
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(attachQuickviewEvents, 500);
        });
    } else {
        setTimeout(attachQuickviewEvents, 500);
    }
    
    window.addEventListener('load', function() {
        setTimeout(attachQuickviewEvents, 1000);
    });
    
    window.openQuickview = openQuickview;
    window.closeQuickview = closeQuickview;
    
})();

// ============ IMAGE HOVER EFFECT ============
document.addEventListener('DOMContentLoaded', function() {
    const productWrappers = document.querySelectorAll('.product-wrapper');
    
    productWrappers.forEach(wrapper => {
        const secondaryImage = wrapper.querySelector('.secondary-image');
        
        if (secondaryImage) {
            wrapper.classList.add('has-secondary-image');
        }
    });
});