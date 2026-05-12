@extends('layouts.app')

@section('title', __('payment.page_title'))

@push('styles')

@endpush
@section('body_class', 'wp-singular page-template-default page page-id-12301 wp-theme-merto theme-merto woocommerce-js wide header-v1 product-label-rectangle product-hover-style-v2 product-border-radius vertical-menu-fixed ts_desktop elementor-default elementor-kit-10348 e--ua-blink e--ua-chrome e--ua-webkit cht-in-desktop cht-landscape')

@section('content')

    <div id="main" class="wrapper ">
        <div class="breadcrumb-title-wrapper breadcrumb-v3">
            <div class="container">
                <div class="breadcrumb-title">
                    <h1 class="heading-title page-title entry-title ">{{ __('payment.page_title') }}</h1>
                    <div class="ts-breadcrumbs breadcrumbs">
                        <div class="breadcrumbs-container">
                            <a href="{{ route('home') }}">{{ __('payment.breadcrumb_home') }}</a>
                            <span class="brn_arrow">/</span>
                            <span class="current">{{ __('payment.breadcrumb_current') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="page-container show_breadcrumb_v3 no-sidebar">

            


            
            <div id="main-content">
                <div id="primary" class="site-content">
                    <article id="post-12295" class="post-12295 page type-page status-publish hentry">

                        <p>{{ __('payment.section1.title') }}</p>

                        <p>
                            <a href="{{ route('home') }}">{{ __('payment.company_url') }}</a>
                            {{ __('payment.section1.text1') }}<br>
                            {{ __('payment.section1.text2') }}
                        </p>

                        <hr class="wp-block-separator has-alpha-channel-opacity">

                        <h2 class="wp-block-heading">{{ __('payment.section2.title') }}</h2>

                        <p>
                            <a href="{{ route('home') }}">{{ __('payment.company_url') }}</a>
                            {{ __('payment.section2.text1') }}<br>
                            {{ __('payment.section2.text2') }}
                        </p>

                        <p>
                            {{ __('payment.section2.text3') }} <strong>S</strong> {{ __('payment.section2.text4') }}<br>
                            <a href="{{ route('home') }}">{{ route('home') }}</a>
                        </p>

                        <hr class="wp-block-separator has-alpha-channel-opacity">

                        <h2 class="wp-block-heading">{{ __('payment.section3.title') }}</h2>

                        <p><em>{{ __('payment.section3.subtitle') }}</em></p>

                        <hr class="wp-block-separator has-alpha-channel-opacity">

                        <h2 class="wp-block-heading">{{ __('payment.section4.title') }}</h2>

                        <p>
                            {{ __('payment.section4.text1') }} <strong>{{ __('payment.company_name') }}</strong>
                            {{ __('payment.section4.text2') }}
                        </p>

                        <p>{{ __('payment.section4.text3') }}</p>

                        <figure class="wp-block-image size-full is-resized">
                            <img fetchpriority="high" decoding="async"
                                 width="512" height="512"
                                 src="/assets/uploads/2026/02/cropped-PORTABOX-SOLUTION-scaled-1.png"
                                 alt="" class="wp-image-12724"
                                 style="width:413px;height:auto"
                                 sizes="(max-width: 512px) 100vw, 512px">
                        </figure>
                    </article>
                </div>
            </div>

            

        </div>

    </div>

@endsection

@push('scripts')

@endpush
