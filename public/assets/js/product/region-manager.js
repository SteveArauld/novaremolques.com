(function() {
    'use strict';

    if (window.RegionManager) return;

    let countrySelect = null;
    let regionSelect = null;
    let regionManual = null;
    let regionInfo = null;

    // Base de données des régions (garder la même structure que précédemment)
    const regionsDatabase = {
        'FR': [{code: 'ARA', name: 'Auvergne-Rhône-Alpes'}, /* ... reste du code ... */],
        'US': [{code: 'AL', name: 'Alabama'}, /* ... reste du code ... */],
        // ... tout le reste de la base de données
    };

    function init(config) {
        countrySelect = document.getElementById('country');
        regionSelect = document.getElementById('region');
        regionManual = document.getElementById('region_manual');
        regionInfo = document.querySelector('.region-info');

        if (countrySelect) {
            countrySelect.addEventListener('change', handleCountryChange);
        }

        detectCountry();
    }

    function handleCountryChange() {
        const countryCode = countrySelect.value;
        if (countryCode) {
            loadRegions(countryCode);
        } else {
            toggleRegionInput(false);
            if (regionSelect) {
                regionSelect.innerHTML = `<option value="">${window.productConfig?.translations?.selectCountryFirst || 'Sélectionnez d\'abord un pays'}</option>`;
            }
        }
    }

    function toggleRegionInput(useSelect, regions = null) {
        if (useSelect && regions && regions.length > 0) {
            regionSelect.style.display = 'block';
            regionManual.style.display = 'none';
            regionInfo.style.display = 'none';

            regionSelect.disabled = false;
            regionSelect.required = true;
            regionManual.required = false;
            regionManual.disabled = true;

            let options = `<option value="">${window.productConfig?.translations?.selectRegion || 'Sélectionnez une région'}</option>`;
            regions.forEach(region => {
                const value = region.code || region.name || region;
                const name = region.name || region;
                options += `<option value="${value}">${name}</option>`;
            });
            regionSelect.innerHTML = options;
        } else {
            regionSelect.style.display = 'none';
            regionManual.style.display = 'block';
            regionInfo.style.display = 'block';

            regionSelect.disabled = true;
            regionSelect.required = false;
            regionManual.required = true;
            regionManual.disabled = false;

            regionManual.value = '';
            regionManual.placeholder = 'Entrez votre région';
        }
    }

    function loadRegions(countryCode) {
        if (!countryCode) {
            toggleRegionInput(false);
            return;
        }

        if (regionSelect) {
            regionSelect.innerHTML = `<option value="">${window.productConfig?.translations?.loadingRegions || 'Chargement des régions...'}</option>`;
            regionSelect.disabled = true;
        }

        try {
            if (regionsDatabase[countryCode] && regionsDatabase[countryCode].length > 0) {
                const states = [...regionsDatabase[countryCode]];
                states.sort((a, b) => a.name.localeCompare(b.name));
                toggleRegionInput(true, states);
            } else {
                toggleRegionInput(false);
            }
        } catch (error) {
            console.error('Erreur chargement régions:', error);
            toggleRegionInput(false);
        }
    }

    function detectCountry() {
        fetch('https://ipapi.co/json')
            .then(res => res.json())
            .then(data => {
                if (data.country_code && countrySelect) {
                    countrySelect.value = data.country_code;
                    loadRegions(data.country_code);
                }
            })
            .catch(() => {});
    }

    function getRegionValue() {
        if (regionManual.style.display === 'block') {
            return regionManual.value.trim();
        }
        return regionSelect.value;
    }

    window.RegionManager = {
        init,
        getRegionValue
    };
})();
