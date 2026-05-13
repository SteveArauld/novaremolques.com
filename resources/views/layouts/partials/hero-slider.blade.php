@php
    $slides = [
        [
            'bg_image' => '/assets/images/slides/slide-1.jpg',
            'typed_texts' => [
                __('slide.remolque.basculante'),
                __('slide.remolque.utilitario'),
                __('slide.remolque.portacoches'),
                __('slide.remolque.barco')
            ],
            'title_texts' => [__('slide.title.remolques.inga')],
            'title_animation' => 'bounceInLeft',
            'description' => __('slide.description.1'),
            'desc_animation' => 'bounceInUp',
            'btn_text' => __('slide.btn.remolques'),
            'btn_url' => '/product-category/remolques',
            'btn_animation' => 'bounceInUp',
            'btn_delay' => 500,
        ],
        [
            'bg_image' => '/assets/images/slides/slide-2.jpg',
            'typed_texts' => [],
            'title_texts' => [
                __('slide.title.remolques.inga'),
                __('slide.title.calidad.profesional'),
                __('slide.title.tu.mejor.eleccion')
            ],
            'title_animation' => 'bounceInDown',
            'description' => __('slide.description.2'),
            'desc_animation' => 'bounceInUp',
            'btn_text' => __('slide.btn.remolques'),
            'btn_url' => '/product-category/remolques',
            'btn_animation' => 'bounceInUp',
            'btn_delay' => 500,
        ],
    ];
@endphp


<div class="hero-slider-wrapper">
    {{-- Loader --}}
    <div class="hero-slider-loader">
        <div class="hero-loader-spinner"></div>
    </div>

    <div class="hero-slider" style="visibility: hidden;">
        @foreach ($slides as $index => $slide)
            <div class="hero-slide" data-slide-index="{{ $index }}">
                <div class="hero-slide-bg" style="background-image: url('{{ $slide['bg_image'] }}');"></div>
                <div class="hero-slide-overlay"></div>
                <div class="hero-slide-content">
                    {{-- Texte machine à écrire (uniquement slide 1) --}}
                    @if($index === 0 && isset($slide['typed_texts']) && !empty($slide['typed_texts']))
                    <div class="hero-typed-wrapper">
                        <span class="hero-typed-text" data-texts='@json($slide['typed_texts'])'></span>
                        <span class="hero-typed-cursor">|</span>
                    </div>
                    @endif

                    {{-- Titre principal avec textes changeants --}}
                    @if(isset($slide['title_texts']) && !empty($slide['title_texts']))
                        @if(count($slide['title_texts']) > 1)
                            <h1 class="hero-title-big animate-element hero-title-changing" 
                                data-animation="{{ $slide['title_animation'] ?? '' }}"
                                data-titles='@json($slide['title_texts'])'>
                                {!! $slide['title_texts'][0] !!}
                            </h1>
                        @else
                            <h1 class="hero-title-big animate-element" data-animation="{{ $slide['title_animation'] ?? '' }}">
                                {!! $slide['title_texts'][0] !!}
                            </h1>
                        @endif
                    @endif

                    {{-- Description --}}
                    @if(isset($slide['description']))
                    <p class="hero-description animate-element" data-animation="{{ $slide['desc_animation'] ?? '' }}">
                        {{ $slide['description'] }}
                    </p>
                    @endif

                    {{-- Bouton --}}
                    @if(isset($slide['btn_text']))
                    <div class="hero-btn-wrapper animate-element" data-animation="{{ $slide['btn_animation'] ?? '' }}" data-delay="{{ $slide['btn_delay'] ?? 0 }}">
                        <a href="{{ $slide['btn_url'] ?? '#' }}" class="hero-btn">{{ $slide['btn_text'] }}</a>
                    </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    {{-- Pagination personnalisée --}}
    <div class="hero-pagination-wrapper" style="opacity: 0;">
        <div class="hero-pagination">
            @foreach ($slides as $index => $slide)
                <button class="hero-dot" data-slide="{{ $index }}" aria-label="Slide {{ $index + 1 }}"></button>
            @endforeach
        </div>
    </div>

    {{-- Flèches (visibles au survol) --}}
    <button class="hero-arrow hero-arrow-prev" aria-label="Précédent" style="opacity: 0;">
        <i class="fas fa-chevron-left"></i>
    </button>
    <button class="hero-arrow hero-arrow-next" aria-label="Suivant" style="opacity: 0;">
        <i class="fas fa-chevron-right"></i>
    </button>
</div>

<style>
    .hero-slider-loader {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        min-height: 60vh;
        background: #1a1a1a;
        z-index: 99;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: opacity 0.4s ease, visibility 0.4s ease;
    }

    .hero-slider-loader.hidden {
        opacity: 0;
        visibility: hidden;
    }

    .hero-loader-spinner {
        width: 50px;
        height: 50px;
        border: 4px solid rgba(204, 0, 0, 0.3);
        border-top-color: #cc0000;
        border-radius: 50%;
        animation: loaderSpin 0.8s linear infinite;
    }

    @keyframes loaderSpin {
        to { transform: rotate(360deg); }
    }

    .hero-slider-wrapper {
        width: 100vw;
        position: relative;
        left: 50%;
        right: 50%;
        margin-left: -50vw;
        margin-right: -50vw;
        overflow: hidden;
    }

    .hero-slider {
        width: 100%;
    }

    .hero-slide {
        position: relative;
        width: 100%;
        min-height: 60vh;
        display: flex !important;
        align-items: center;
        justify-content: center;
    }

    .hero-slide-bg {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        z-index: 1;
    }

    .hero-slide-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.55);
        z-index: 2;
    }

    .hero-slide-content {
        position: relative;
        z-index: 3;
        color: #fff;
        padding: 40px 20px;
        max-width: 1000px;
        margin: 0 auto;
    }

    .hero-typed-wrapper {
        display: inline-block;
        margin-bottom: 20px;
        padding: 10px 24px;
        border-radius: 2px;
        min-height: 40px;
    }

    .hero-typed-text {
        font-size: 20px;
        font-weight: 600;
        letter-spacing: 3px;
        text-transform: uppercase;
        color: #ffffff;
        transition: opacity 0.3s ease;
    }

    .hero-typed-cursor {
        font-size: 40px;
        color: #cc0000;
        animation: cursorBlink 0.6s infinite;
        font-weight: 300;
    }

    @keyframes cursorBlink {
        0%, 50% { opacity: 1; }
        51%, 100% { opacity: 0; }
    }

    .hero-title-big {
        font-size: clamp(28px, 5vw, 52px);
        font-weight: 800;
        color: #cc0000;
        margin: 0 0 20px;
        text-transform: uppercase;
        line-height: 1.1;
        letter-spacing: 2px;
        transition: opacity 0.3s ease;
    }

    .hero-title-changing {
        transition: opacity 0.3s ease, transform 0.3s ease;
    }

    .hero-title-changing.changing {
        opacity: 0;
        transform: translateY(-10px);
    }

    .hero-description {
        font-size: clamp(14px, 1.8vw, 17px);
        color: #d0d0d0;
        margin: 0 auto 35px;
        max-width: 550px;
        line-height: 1.6;
    }

    .hero-btn-wrapper {
        margin-top: 10px;
        display: inline-block;
    }

    .hero-btn {
        display: inline-block;
        padding: 14px 40px;
        background: #cc0000;
        color: #fff;
        font-size: 14px;
        font-weight: 700;
        text-decoration: none;
        text-transform: uppercase;
        letter-spacing: 2px;
        border-radius: 3px;
        transition: background 0.3s, transform 0.3s;
    }

    .hero-btn:hover {
        background: #a00000;
        color: #fff;
        text-decoration: none;
        transform: translateY(-2px);
    }

    .animate-element {
        opacity: 0;
        visibility: hidden;
        animation-duration: 0.8s;
        animation-fill-mode: both;
        animation-timing-function: cubic-bezier(0.215, 0.61, 0.355, 1);
    }

    .animate-element.animated {
        opacity: 1;
        visibility: visible;
    }

    .bounceInLeft {
        animation-name: bounceInLeftAnim;
    }

    .bounceInUp {
        animation-name: bounceInUpAnim;
    }

    .bounceInDown {
        animation-name: bounceInDownAnim;
    }

    @keyframes bounceInLeftAnim {
        0% {
            opacity: 0;
            transform: translateX(-200px);
        }
        60% {
            opacity: 1;
            transform: translateX(30px);
        }
        80% {
            transform: translateX(-10px);
        }
        100% {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes bounceInUpAnim {
        0% {
            opacity: 0;
            transform: translateY(100px);
        }
        60% {
            opacity: 1;
            transform: translateY(-30px);
        }
        80% {
            transform: translateY(10px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes bounceInDownAnim {
        0% {
            opacity: 0;
            transform: translateY(-100px);
        }
        60% {
            opacity: 1;
            transform: translateY(30px);
        }
        80% {
            transform: translateY(-10px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .hero-arrow {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        z-index: 10;
        width: 50px;
        height: 50px;
        background: transparent;
        border: none;
        color: #fff;
        font-size: 24px;
        cursor: pointer;
        opacity: 0;
        transition: opacity 0.4s ease, background 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
    }

    .hero-slider-wrapper:hover .hero-arrow {
        opacity: 1;
    }

    .hero-arrow:hover {
        background: rgba(0, 0, 0, 0.5);
    }

    .hero-arrow-prev {
        left: 20px;
    }

    .hero-arrow-next {
        right: 20px;
    }

    .hero-pagination-wrapper {
        position: absolute;
        bottom: 40px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 10;
    }

    .hero-pagination {
        display: flex;
        align-items: center;
        gap: 0;
        background: rgba(0, 0, 0, 0.6);
        border-radius: 50px;
        padding: 5px 10px;
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
    }

    .hero-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: transparent;
        border: 2px solid rgba(255, 255, 255, 0.7);
        cursor: pointer;
        padding: 0;
        margin: 0 6px;
        transition: all 0.3s ease;
        outline: none;
    }

    .hero-dot:hover {
        border-color: #ffffff;
    }

    .hero-dot.active {
        background: #ffffff;
        border-color: #ffffff;
        transform: scale(1.2);
    }

    @media (max-width: 768px) {
        .hero-slide {
            min-height: 80vh;
        }

        .hero-arrow {
            width: 40px;
            height: 40px;
            font-size: 18px;
        }

        .hero-arrow-prev {
            left: 10px;
        }

        .hero-arrow-next {
            right: 10px;
        }

        .hero-pagination {
            padding: 8px 18px;
        }

        .hero-dot {
            width: 12px;
            height: 12px;
            margin: 0 5px;
        }

        .hero-pagination-wrapper {
            bottom: 30px;
        }

        .hero-btn {
            padding: 12px 30px;
            font-size: 13px;
        }
    }

    @media (max-width: 480px) {
        .hero-slide {
            min-height: 0vh;
        }

        .hero-slide-content {
            padding: 30px 15px;
        }

        .hero-typed-wrapper {
            padding: 8px 16px;
        }

        .hero-typed-text {
            font-size: 12px;
            letter-spacing: 2px;
        }

        .hero-pagination {
            padding: 6px 14px;
        }

        .hero-dot {
            width: 10px;
            height: 10px;
            margin: 0 4px;
        }

        .hero-pagination-wrapper {
            bottom: 20px;
        }

        .hero-arrow {
            opacity: 0.5;
        }
    }

    @media (max-width: 360px) {
        .hero-typed-text {
            font-size: 10px;
            letter-spacing: 1px;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    function initSlider() {
        if (typeof jQuery === 'undefined' || typeof jQuery.fn.slick === 'undefined') {
            setTimeout(initSlider, 100);
            return;
        }

        var $slider = jQuery('.hero-slider');
        var $dots = jQuery('.hero-dot');
        var $prevArrow = jQuery('.hero-arrow-prev');
        var $nextArrow = jQuery('.hero-arrow-next');
        var $loader = jQuery('.hero-slider-loader');
        var $pagination = jQuery('.hero-pagination-wrapper');
        var $arrows = jQuery('.hero-arrow');

        window.typedTimers = {};
        window.titleChangeTimers = {};
        window.slideAutoplayTimer = null;

        var config = {};
        config.typingSpeed = 10;
        config.letterDuration = 3000 / (120 * 5);
        config.typedPauseEnd = 1500;
        config.typedPauseStart = 300;
        config.titleChangeInterval = 3000;
        config.slideMinDuration = 15000;
        config.slideMaxDuration = 15000;

        function slideRandomDuration() {
            return Math.floor(Math.random() * (config.slideMaxDuration - config.slideMinDuration + 1) + config.slideMinDuration);
        }

        function slideScheduleNext(slick) {
            if (window.slideAutoplayTimer) {
                clearTimeout(window.slideAutoplayTimer);
            }
            var duration = slideRandomDuration();
            window.slideAutoplayTimer = setTimeout(function() {
                $slider.slick('slickNext');
            }, duration);
        }

        $slider.on('init afterChange', function(event, slick, currentSlide) {
            currentSlide = currentSlide || 0;
            $dots.removeClass('active');
            $dots.eq(currentSlide).addClass('active');
            slideScheduleNext(slick);
        });

        $slider.on('beforeChange', function(event, slick, currentSlide, nextSlide) {
            var currentSlideEl = jQuery(slick.$slides[currentSlide]);
            stopSlideEffects(currentSlideEl);
            if (window.slideAutoplayTimer) {
                clearTimeout(window.slideAutoplayTimer);
            }
        });

        $dots.on('click', function() {
            var slideIndex = jQuery(this).data('slide');
            $slider.slick('slickGoTo', slideIndex);
        });

        $prevArrow.on('click', function() {
            $slider.slick('slickPrev');
        });

        $nextArrow.on('click', function() {
            $slider.slick('slickNext');
        });

        $slider.on('init', function(event, slick) {
            $loader.addClass('hidden');
            $slider.css('visibility', 'visible');
            $pagination.css('opacity', '1');
            $arrows.css('opacity', '');

            var currentSlideEl = jQuery(slick.$slides[slick.currentSlide]);
            animateSlideElements(currentSlideEl);
            startSlideEffects(currentSlideEl);
        });

        $slider.on('afterChange', function(event, slick, currentSlide) {
            var currentSlideEl = jQuery(slick.$slides[currentSlide]);
            resetSlideAnimations(currentSlideEl);
            setTimeout(function() {
                animateSlideElements(currentSlideEl);
                startSlideEffects(currentSlideEl);
            }, 100);
        });

        $slider.slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            autoplay: false,
            speed: 500,
            infinite: true,
            arrows: false,
            dots: false,
            fade: true,
            cssEase: 'ease-in-out',
            pauseOnHover: true,
        });

        function animateSlideElements(slide) {
            slide.find('.animate-element').each(function(i) {
                var $el = jQuery(this);
                var animation = $el.data('animation');
                var delay = $el.data('delay') || (i * 200);
                setTimeout(function() {
                    $el.addClass('animated ' + animation);
                }, delay);
            });
        }

        function resetSlideAnimations(slide) {
            slide.find('.animate-element').removeClass('animated bounceInLeft bounceInUp bounceInDown');
            var $changingTitle = slide.find('.hero-title-changing');
            if ($changingTitle.length > 0) {
                $changingTitle.removeClass('changing');
                var titles = $changingTitle.data('titles');
                if (titles && titles.length > 0) {
                    $changingTitle.html(titles[0]);
                }
            }
        }

        function startSlideEffects(slide) {
            var slideIndex = slide.data('slide-index') || 0;
            
            var $typedText = slide.find('.hero-typed-text');
            if ($typedText.length > 0 && slideIndex === 0) {
                startTypedEffect($typedText[0], slideIndex);
            }
            
            var $changingTitle = slide.find('.hero-title-changing');
            if ($changingTitle.length > 0) {
                var titles = $changingTitle.data('titles');
                if (titles && titles.length > 1) {
                    startTitleChange($changingTitle[0], titles, slideIndex);
                }
            }
        }

        function stopSlideEffects(slide) {
            var slideIndex = slide.data('slide-index') || 0;
            
            if (window.typedTimers[slideIndex]) {
                clearTimeout(window.typedTimers[slideIndex]);
                delete window.typedTimers[slideIndex];
            }
            
            if (window.titleChangeTimers[slideIndex]) {
                clearInterval(window.titleChangeTimers[slideIndex]);
                clearTimeout(window.titleChangeTimers[slideIndex + '_timeout']);
                delete window.titleChangeTimers[slideIndex];
                delete window.titleChangeTimers[slideIndex + '_timeout'];
            }
        }

        function startTypedEffect(element, slideIndex) {
            element.textContent = '';
            
            var texts = jQuery(element).data('texts');
            if (!texts || texts.length === 0) return;
            
            var textIndex = 0;
            var charIndex = 0;
            var isDeleting = false;
            var isPaused = false;
            
            function typeNext() {
                if (!element || !document.body.contains(element)) {
                    return;
                }
                
                if (isPaused) {
                    window.typedTimers[slideIndex] = setTimeout(typeNext, 50);
                    return;
                }
                
                var fullText = texts[textIndex];
                
                if (!isDeleting) {
                    element.textContent = fullText.substring(0, charIndex + 1);
                    element.style.opacity = '1';
                    charIndex++;
                    
                    if (charIndex >= fullText.length) {
                        isPaused = true;
                        window.typedTimers[slideIndex] = setTimeout(function() {
                            isPaused = false;
                            isDeleting = true;
                            window.typedTimers[slideIndex] = setTimeout(typeNext, config.letterDuration);
                        }, config.typedPauseEnd);
                        return;
                    }
                    
                    window.typedTimers[slideIndex] = setTimeout(typeNext, config.letterDuration);
                } else {
                    if (charIndex <= Math.ceil(fullText.length * 0.7)) {
                        element.style.opacity = '0.3';
                    }
                    
                    element.textContent = fullText.substring(0, charIndex - 1);
                    charIndex--;
                    
                    if (charIndex <= 0) {
                        element.style.opacity = '0';
                        isDeleting = false;
                        textIndex = (textIndex + 1) % texts.length;
                        isPaused = true;
                        window.typedTimers[slideIndex] = setTimeout(function() {
                            element.style.opacity = '1';
                            isPaused = false;
                            window.typedTimers[slideIndex] = setTimeout(typeNext, config.letterDuration);
                        }, config.typedPauseStart);
                        return;
                    }
                    
                    window.typedTimers[slideIndex] = setTimeout(typeNext, config.letterDuration);
                }
            }
            
            window.typedTimers[slideIndex] = setTimeout(typeNext, 500);
        }

        function startTitleChange(element, titles, slideIndex) {
            if (!titles || titles.length <= 1) return;
            
            var currentTitleIndex = 0;
            var $el = jQuery(element);
            
            window.titleChangeTimers[slideIndex] = setInterval(function() {
                if (!element || !document.body.contains(element)) {
                    clearInterval(window.titleChangeTimers[slideIndex]);
                    return;
                }
                
                currentTitleIndex = (currentTitleIndex + 1) % titles.length;
                $el.addClass('changing');
                
                window.titleChangeTimers[slideIndex + '_timeout'] = setTimeout(function() {
                    if (element && document.body.contains(element)) {
                        $el.html(titles[currentTitleIndex]);
                        $el.removeClass('changing');
                    }
                }, 300);
                
            }, config.titleChangeInterval);
        }
    }

    initSlider();
});
</script>