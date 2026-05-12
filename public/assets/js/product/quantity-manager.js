(function() {
    'use strict';

    // Vérifier si déjà chargé
    if (window.QuantityManager) return;

    function init(config) {
        const quantityInput = document.getElementById('quantity');
        if (quantityInput) {
            quantityInput.addEventListener('input', function() {
                validate(quantityInput, config);
            });
            validate(quantityInput, config);
        }
    }

    function increment() {
        const input = document.getElementById('quantity');
        const maxStock = parseInt(input.getAttribute('max'));
        let currentValue = parseInt(input.value) || 1;

        if (currentValue < maxStock) {
            input.value = currentValue + 1;
            validate(input);
        }
    }

    function decrement() {
        const input = document.getElementById('quantity');
        const minValue = parseInt(input.getAttribute('min')) || 1;
        let currentValue = parseInt(input.value) || 1;

        if (currentValue > minValue) {
            input.value = currentValue - 1;
            validate(input);
        }
    }

    function validate(input, config = window.productConfig) {
        const maxStock = parseInt(input.getAttribute('max'));
        const minStock = parseInt(input.getAttribute('min')) || 1;
        const quantity = parseInt(input.value) || 1;
        const errorElement = document.getElementById('quantityError');
        const maxMessageElement = document.getElementById('maxStockMessage');
        const formGroup = input.closest('.form-group');

        const minusBtn = document.querySelector('.quantity-minus');
        const plusBtn = document.querySelector('.quantity-plus');

        if (minusBtn) {
            minusBtn.disabled = quantity <= minStock;
        }

        if (plusBtn) {
            plusBtn.disabled = quantity >= maxStock;
        }

        errorElement.style.display = 'none';
        errorElement.textContent = '';
        maxMessageElement.style.display = 'none';
        maxMessageElement.textContent = '';
        input.classList.remove('is-invalid');
        formGroup.classList.remove('max-stock-reached');

        if (quantity > maxStock) {
            errorElement.textContent = (config?.translations?.quantityExceedsStock || '')
                .replace(':quantity', quantity)
                .replace(':stock', maxStock);
            errorElement.style.display = 'block';
            input.classList.add('is-invalid');
        } else if (quantity === maxStock && maxStock > 0) {
            maxMessageElement.textContent = (config?.translations?.maxStockReached || '')
                .replace(':stock', maxStock);
            maxMessageElement.style.display = 'block';
            formGroup.classList.add('max-stock-reached');
        } else if (maxStock === 0) {
            maxMessageElement.textContent = config?.translations?.productOutOfStock || '';
            maxMessageElement.style.display = 'block';
        }
    }

    // Exposer les fonctions globalement
    window.QuantityManager = {
        init,
        increment,
        decrement,
        validate
    };

    // Exposer les fonctions individuelles pour les boutons onclick
    window.incrementQuantity = increment;
    window.decrementQuantity = decrement;
    window.validateQuantity = validate;
})();
