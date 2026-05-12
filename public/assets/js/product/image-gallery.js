(function() {
    'use strict';

    if (window.ImageGallery) return;

    let mainImages = [];
    let thumbnails = [];
    let modal = null;
    let modalImage = null;
    let currentImageIndex = 0;
    let allImages = [];
function init() {

    mainImages = document.querySelectorAll('.testpourgrand');
    thumbnails = document.querySelectorAll('.flex-control-thumbs li img');

    // Toujours initialiser le modal
    if (mainImages.length > 0) {

        // Initialiser thumbnails seulement si elles existent
        if (thumbnails.length > 0) {
            initThumbnails();
        }

        // IMPORTANT
        initModal();

        // Afficher première image
        showImage(0);
    }
}

    function getFullSizeImageUrl(thumbnailUrl) {
        if (!thumbnailUrl) return '';

        // Éviter les URLs vides
        if (thumbnailUrl.includes('.png') && thumbnailUrl.endsWith('/.png')) {
            return thumbnailUrl;
        }

        const patterns = [
            /-300x300\.jpg/g, /-300x300\.png/g, /-300x300\.jpeg/g,
            /-300x292\.jpeg/g, /-300x295\.jpeg/g, /-300x290\.jpeg/g,
            /-300x300\.webp/g
        ];

        let fullUrl = thumbnailUrl;
        patterns.forEach(pattern => {
            fullUrl = fullUrl.replace(pattern, '.' + pattern.source.split('\\').pop().replace('\.', ''));
        });

        return fullUrl;
    }

    function initThumbnails() {
        thumbnails.forEach((thumb, index) => {
            if (mainImages[index]) {
                updateMainImage(mainImages[index], thumb);
            }
        });

        thumbnails.forEach((thumb, index) => {
            thumb.addEventListener('click', function(e) {
                e.preventDefault();
                showImage(index);
            });
        });

        if (mainImages[0]) {
            showImage(0);
        }
    }

    function updateMainImage(mainImageDiv, thumbnailImg) {
        if (!thumbnailImg || !thumbnailImg.src) return;

        const thumbnailUrl = thumbnailImg.src;
        const fullSizeUrl = getFullSizeImageUrl(thumbnailUrl);
        const mainImg = mainImageDiv.querySelector('img');
        const mainLink = mainImageDiv.querySelector('a');

        if (mainImg && fullSizeUrl) {
            mainImg.src = fullSizeUrl;
            mainImg.srcset = '';
            mainImg.setAttribute('data-src', fullSizeUrl);
            mainImg.setAttribute('data-large_image', fullSizeUrl);
            applyImageStyles(mainImg);
        }

        if (mainLink && fullSizeUrl) {
            mainLink.href = fullSizeUrl;
        }

        mainImageDiv.setAttribute('data-thumb', fullSizeUrl || '');
    }

    function applyImageStyles(img) {
        img.style.width = '100%';
        img.style.height = '100%';
        img.style.objectFit = 'contain';
        img.style.maxWidth = '100%';
        img.style.maxHeight = '100%';
        img.style.cursor = 'pointer';
    }

    function showImage(index) {
        mainImages.forEach(img => img.style.display = 'none');

        if (mainImages[index]) {
            mainImages[index].style.display = 'block';
            const activeImg = mainImages[index].querySelector('img');
            if (activeImg) {
                applyImageStyles(activeImg);
            }
        }

        thumbnails.forEach(t => t.classList.remove('flex-active'));
        if (thumbnails[index]) {
            thumbnails[index].classList.add('flex-active');
        }
    }

    function initModal() {
        createModal();
        loadAllImages();
        attachModalEvents();
    }

    function createModal() {
        // Vérifier si le modal existe déjà
        if (document.getElementById('image-modal')) {
            modal = document.getElementById('image-modal');
            modalImage = document.getElementById('modal-image');
            return;
        }

        const modalHTML = `
            <div id="image-modal" class="image-modal" style="display: none;">
                <div class="modal-content">
                    <span class="modal-close">&times;</span>
                    <div class="modal-body">
                        <img id="modal-image" src="" alt="">
                    </div>
                    <div class="modal-navigation">
                        <button class="modal-prev">&#10094;</button>
                        <button class="modal-next">&#10095;</button>
                    </div>
                    <div class="modal-counter">
                        <span id="modal-current">1</span> / <span id="modal-total">1</span>
                    </div>
                </div>
            </div>
        `;
        document.body.insertAdjacentHTML('beforeend', modalHTML);

        modal = document.getElementById('image-modal');
        modalImage = document.getElementById('modal-image');
    }

    function loadAllImages() {
        allImages = [];
        mainImages.forEach((img) => {
            const imgElement = img.querySelector('img');
            if (imgElement && imgElement.src) {
                const fullSizeUrl = getFullSizeImageUrl(imgElement.src);
                if (fullSizeUrl && !fullSizeUrl.includes('/.png')) {
                    allImages.push({
                        src: fullSizeUrl,
                        alt: imgElement.alt || ''
                    });
                }
            }
        });

        const modalTotal = document.getElementById('modal-total');
        if (modalTotal) {
            modalTotal.textContent = allImages.length || 1;
        }
    }

    function attachModalEvents() {
        mainImages.forEach((img) => {
            const imgElement = img.querySelector('img');
            if (imgElement) {
                imgElement.addEventListener('click', function(e) {
                    e.preventDefault();
                    let visibleIndex = 0;
                    mainImages.forEach((mainImg, idx) => {
                        if (mainImg.style.display === 'block') visibleIndex = idx;
                    });
                    openModal(visibleIndex);
                });
            }
        });

        const modalClose = document.querySelector('.modal-close');
        if (modalClose) {
            modalClose.addEventListener('click', closeModal);
        }

        const modalPrev = document.querySelector('.modal-prev');
        const modalNext = document.querySelector('.modal-next');

        if (modalPrev) modalPrev.addEventListener('click', showPrevImage);
        if (modalNext) modalNext.addEventListener('click', showNextImage);

        modal.addEventListener('click', function(e) {
            if (e.target === modal) closeModal();
        });

        document.addEventListener('keydown', handleKeyPress);
    }

    function openModal(index) {
        if (allImages.length > 0 && allImages[index]) {
            currentImageIndex = index;
            modalImage.src = allImages[index].src;
            modalImage.alt = allImages[index].alt;

            const modalCurrent = document.getElementById('modal-current');
            if (modalCurrent) {
                modalCurrent.textContent = index + 1;
            }

            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }
    }

    function closeModal() {
        modal.style.display = 'none';
        document.body.style.overflow = '';
    }

    function showPrevImage() {
        if (allImages.length > 0) {
            currentImageIndex = (currentImageIndex - 1 + allImages.length) % allImages.length;
            updateModalImage();
        }
    }

    function showNextImage() {
        if (allImages.length > 0) {
            currentImageIndex = (currentImageIndex + 1) % allImages.length;
            updateModalImage();
        }
    }

    function updateModalImage() {
        modalImage.src = allImages[currentImageIndex].src;
        modalImage.alt = allImages[currentImageIndex].alt;

        const modalCurrent = document.getElementById('modal-current');
        if (modalCurrent) {
            modalCurrent.textContent = currentImageIndex + 1;
        }
    }

    function handleKeyPress(e) {
        if (modal && modal.style.display === 'flex') {
            if (e.key === 'Escape') closeModal();
            else if (e.key === 'ArrowLeft') showPrevImage();
            else if (e.key === 'ArrowRight') showNextImage();
        }
    }

    window.ImageGallery = {
        init
    };
})();
