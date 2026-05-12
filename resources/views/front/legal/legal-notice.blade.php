@extends('layouts.app')

@section('title', __('legal.title'))

@section('body_class', 'wp-singular page-template-default page page-id-12301 wp-theme-merto theme-merto woocommerce-js wide header-v1 product-label-rectangle product-hover-style-v2 product-border-radius vertical-menu-fixed ts_desktop elementor-default elementor-kit-10348 e--ua-blink e--ua-chrome e--ua-webkit cht-in-desktop cht-landscape')

@section('content')
    <div id="main" class="wrapper ">
        <div class="breadcrumb-title-wrapper breadcrumb-v3">
            <div class="container">
                <div class="breadcrumb-title"><h1 class="heading-title page-title entry-title ">{{ __('legal.title') }}</h1>
                    <div class="ts-breadcrumbs breadcrumbs">
                        <div class="breadcrumbs-container"><a href="{{ route('home') }}">{{ __('legal.breadcrumb_home') }}</a> <span
                                    class="brn_arrow">/</span> <span class="current">{{ __('legal.breadcrumb_current') }}</span></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-container show_breadcrumb_v3 no-sidebar">

            <div id="main-content">
                <div id="primary" class="site-content">
                    <article id="post-12301" class="post-12301 page type-page status-publish hentry">

                        <h2 class="wp-block-heading">{{ __('legal.section_1.title') }}</h2>


                        <p>{{ __('legal.section_1.description') }}</p>


                        <ul class="wp-block-list">
                            <li>{{ __('legal.section_1.item_1') }}</li>


                            <li>{{ __('legal.section_1.item_2') }}</li>


                            <li>{{ __('legal.section_1.item_3') }}</li>


                            <li>{{ __('legal.section_1.item_4') }}</li>
                        </ul>


                        <hr class="wp-block-separator has-alpha-channel-opacity">


                        <h2 class="wp-block-heading">{{ __('legal.section_2.title') }}</h2>


                        <p>{!! __('legal.section_2.paragraph_1', ['url' => route('home')]) !!}</p>


                        <p>{!! __('legal.section_2.company_info', ['vat' => '06330420651', 'vat_eu' => 'IT06330420651']) !!}</p>


                        <p>{!! __('legal.section_2.address') !!}</p>


                        <p>{!! __('legal.section_2.contact') !!}</p>


                        <p>{{ __('legal.section_2.description') }}</p>


                        <hr class="wp-block-separator has-alpha-channel-opacity">


                        <h2 class="wp-block-heading">{{ __('legal.section_3.title') }}</h2>


                        <p>{!! __('legal.section_3.description') !!}</p>


                        <hr class="wp-block-separator has-alpha-channel-opacity">


                        <h2 class="wp-block-heading">{{ __('legal.section_4.title') }}</h2>


                        <p>{!! __('legal.section_4.paragraph_1', ['url' => route('home')]) !!}</p>


                        <p>{{ __('legal.section_4.paragraph_2') }}</p>


                        <ul class="wp-block-list">
                            <li>{{ __('legal.section_4.item_1') }}</li>


                            <li>{{ __('legal.section_4.item_2') }}</li>


                            <li>{{ __('legal.section_4.item_3') }}</li>
                        </ul>


                        <hr class="wp-block-separator has-alpha-channel-opacity">


                        <h2 class="wp-block-heading">{{ __('legal.section_5.title') }}</h2>


                        <p>{!! __('legal.section_5.paragraph_1') !!}</p>


                        <p>{{ __('legal.section_5.paragraph_2') }}</p>


                        <p>{{ __('legal.section_5.paragraph_3') }}</p>


                        <p>{!! __('legal.section_5.source', ['url' => route('home')]) !!}</p>


                        <hr class="wp-block-separator has-alpha-channel-opacity">


                        <h2 class="wp-block-heading">{{ __('legal.section_6.title') }}</h2>


                        <p>{!! __('legal.section_6.paragraph_1') !!}</p>


                        <h3 class="wp-block-heading">{{ __('legal.section_6.subtitle_1') }}</h3>


                        <p>{{ __('legal.section_6.paragraph_2') }}</p>


                        <ul class="wp-block-list">
                            <li>{{ __('legal.section_6.item_1') }}</li>


                            <li>{{ __('legal.section_6.item_2') }}</li>


                            <li>{{ __('legal.section_6.item_3') }}</li>


                            <li>{{ __('legal.section_6.item_4') }}</li>
                        </ul>


                        <h3 class="wp-block-heading">{{ __('legal.section_6.subtitle_2') }}</h3>


                        <p>{{ __('legal.section_6.paragraph_3') }}</p>


                        <ul class="wp-block-list">
                            <li>{{ __('legal.section_6.right_1') }}</li>


                            <li>{{ __('legal.section_6.right_2') }}</li>


                            <li>{{ __('legal.section_6.right_3') }}</li>


                            <li>{{ __('legal.section_6.right_4') }}</li>
                        </ul>


                        <p>{!! __('legal.section_6.contact_email') !!}</p>


                        <p>{{ __('legal.section_6.privacy_link') }}</p>


                        <hr class="wp-block-separator has-alpha-channel-opacity">


                        <h2 class="wp-block-heading">{{ __('legal.section_7.title') }}</h2>


                        <p>{{ __('legal.section_7.paragraph_1') }}</p>


                        <ul class="wp-block-list">
                            <li>{{ __('legal.section_7.item_1') }}</li>


                            <li>{{ __('legal.section_7.item_2') }}</li>


                            <li>{{ __('legal.section_7.item_3') }}</li>


                            <li>{{ __('legal.section_7.item_4') }}</li>
                        </ul>


                        <p>{{ __('legal.section_7.paragraph_2') }}</p>


                        <hr class="wp-block-separator has-alpha-channel-opacity">


                        <h2 class="wp-block-heading">{{ __('legal.section_8.title') }}</h2>


                        <p>{!! __('legal.section_8.paragraph_1') !!}</p>


                        <ul class="wp-block-list">
                            <li>{{ __('legal.section_8.item_1') }}</li>


                            <li>{{ __('legal.section_8.item_2') }}</li>


                            <li>{{ __('legal.section_8.item_3') }}</li>


                            <li>{{ __('legal.section_8.item_4') }}</li>
                        </ul>


                        <p>{{ __('legal.section_8.paragraph_2') }}</p>


                        <p>{{ __('legal.section_8.paragraph_3') }}</p>


                        <hr class="wp-block-separator has-alpha-channel-opacity">


                        <h2 class="wp-block-heading">{{ __('legal.section_9.title') }}</h2>


                        <p>{!! __('legal.section_9.paragraph_1', ['url' => route('home')]) !!}</p>


                        <hr class="wp-block-separator has-alpha-channel-opacity">


                        <h2 class="wp-block-heading">{{ __('legal.section_10.title') }}</h2>


                        <p>{{ __('legal.section_10.paragraph_1') }}</p>


                        <p>{{ __('legal.section_10.paragraph_2') }}</p>


                        <p>{{ __('legal.section_10.paragraph_3') }}</p>


                        <p>{!! __('legal.section_10.paragraph_4') !!}</p>


                        <hr class="wp-block-separator has-alpha-channel-opacity">


                        <h2 class="wp-block-heading">{{ __('legal.section_11.title') }}</h2>


                        <p>{!! __('legal.section_11.paragraph_1') !!}</p>


                        <p>{{ __('legal.section_11.paragraph_2') }}</p>


                        <hr class="wp-block-separator has-alpha-channel-opacity">


                        <h2 class="wp-block-heading">{{ __('legal.section_12.title') }}</h2>


                        <p>{!! __('legal.section_12.contact_info') !!}</p>


                        <p>{!! __('legal.section_12.last_update') !!}</p>


                        <figure class="wp-block-image size-full is-resized">
                            <img fetchpriority="high" decoding="async"
                                width="512" height="512"
                                src="/assets/uploads/2026/02/cropped-PORTABOX-SOLUTION-scaled-1.png"
                                alt="" class="wp-image-12724"
                                style="width:401px;height:auto"
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