(function() {
    'use strict';

    if (window.InquiryForm) return;

    let form = null;
    let submitBtn = null;

    function init(config) {
        form = document.getElementById('product-inquiry-form');
        submitBtn = document.getElementById('inquiry-submit');

        if (form) {
            form.addEventListener('submit', handleSubmit);
        }
    }

    function handleSubmit(e) {
        e.preventDefault();

        const formData = new FormData(form);

        // Validation région
        const regionValue = window.RegionManager.getRegionValue();
        if (!regionValue) {
            showError(window.productConfig?.translations?.regionRequired || 'Veuillez entrer votre région');
            return;
        }
        formData.set('region', regionValue);

        // Validation téléphone
        const phoneValue = formData.get('phone');
        if (!phoneValue || phoneValue.trim() === '') {
            showError(window.productConfig?.translations?.phoneRequired || 'Veuillez entrer votre numéro de téléphone');
            return;
        }

        const phoneRegex = /^\+?[0-9\s\-\(\)]{8,20}$/;
        if (!phoneRegex.test(phoneValue)) {
            showError(window.productConfig?.translations?.phoneInvalid || 'Format de téléphone invalide');
            return;
        }

        setButtonLoading(true);
        sendInquiry(formData);
    }

    function sendInquiry(formData) {
        const soumitions = window.productConfig?.inquiryUrl;

        fetch(`${soumitions}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: formData
        })
        .then(response => response.json())
        .then(handleResponse)
        .catch(handleError)
        .finally(() => {
            setTimeout(() => setButtonLoading(false), 1000);
        });
    }

    function handleResponse(data) {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: window.productConfig?.translations?.success || 'Succès!',
                text: data.message,
                timer: 3000,
                showConfirmButton: false,
                position: 'top-end',
                toast: true,
                background: '#28a745',
                color: '#fff'
            });

            form.reset();
            resetRegionFields();
        } else {
            let errorMessage = data.message;
            if (data.errors) {
                errorMessage = Object.values(data.errors).flat().join('\n');
            }
            showError(errorMessage);
        }
    }

    function handleError() {
        showError('Une erreur est survenue. Veuillez réessayer.');
    }

    function showError(message) {
        Swal.fire({
            icon: 'error',
            title: window.productConfig?.translations?.error || 'Erreur',
            text: message,
            confirmButtonColor: '#dc2626'
        });
    }

    function setButtonLoading(isLoading) {
        if (!submitBtn) return;

        submitBtn.disabled = isLoading;

        const btnText = submitBtn.querySelector('.btn-text');
        const spinner = submitBtn.querySelector('.spinner');

        if (btnText) {
            btnText.style.display = isLoading ? 'none' : 'inline';
        }

        if (spinner) {
            spinner.style.display = isLoading ? 'inline-block' : 'none';
        }
    }

    function resetRegionFields() {
        const regionSelect = document.getElementById('region');
        const regionManual = document.getElementById('region_manual');
        const regionInfo = document.querySelector('.region-info');

        if (regionSelect) {
            regionSelect.innerHTML = '<option value="">Sélectionnez d\'abord un pays</option>';
            regionSelect.disabled = true;
            regionSelect.style.display = 'block';
        }

        if (regionManual) {
            regionManual.style.display = 'none';
        }

        if (regionInfo) {
            regionInfo.style.display = 'none';
        }
    }

    window.InquiryForm = {
        init
    };
})();
