@extends('layouts.app')

@section('title', __('privacy.page_title'))

@push('styles')

@endpush
@section('body_class', 'wp-singular page-template-default page page-id-12301 wp-theme-merto theme-merto woocommerce-js wide header-v1 product-label-rectangle product-hover-style-v2 product-border-radius vertical-menu-fixed ts_desktop elementor-default elementor-kit-10348 e--ua-blink e--ua-chrome e--ua-webkit cht-in-desktop cht-landscape')

@section('content')

<div id="main" class="wrapper ">
	<div class="breadcrumb-title-wrapper breadcrumb-v3">
		<div class="container">
			<div class="breadcrumb-title">
				<h1 class="heading-title page-title entry-title ">{{ __('privacy.cookie_policy_title') }}</h1>
				<div class="ts-breadcrumbs breadcrumbs">
					<div class="breadcrumbs-container">
						<a href="{{ route('home') }}">{{ __('privacy.breadcrumb_home') }}</a>
						<span class="brn_arrow">/</span>
						<span class="current">{{ __('privacy.breadcrumb_cookie_current') }}</span>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="page-container show_breadcrumb_v3 no-sidebar">

		<div class="page-content">
			<div data-elementor-type="wp-page" data-elementor-id="11049" class="elementor elementor-11049">
				<div class="elementor-inner">
					<div class="elementor-section-wrap">
						<section class="elementor-section elementor-top-section elementor-element elementor-element-cd98a29 elementor-section-boxed elementor-section-height-default elementor-section-height-default" data-id="cd98a29" data-element_type="section">
							<div class="elementor-container elementor-column-gap-default">
								<div class="elementor-row">
									<div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-6c55294" data-id="6c55294" data-element_type="column">
										<div class="elementor-column-wrap elementor-element-populated">
											<div class="elementor-widget-wrap">
												<div class="elementor-element elementor-element-87139ac elementor-widget elementor-widget-text-editor" data-id="87139ac" data-element_type="widget" data-widget_type="text-editor.default">
													<div class="elementor-widget-container">
														<div class="elementor-text-editor elementor-clearfix">
															<p>{{ __('privacy.cookie.intro') }}</p>
															<p>{!! __('privacy.cookie.summary') !!}</p>
															<p>{{ __('privacy.cookie.who_we_are_title') }}</p>
															<p>{!! __('privacy.cookie.who_we_are_content') !!}</p>
															<p>{{ __('privacy.cookie.what_is_cookie_title') }}</p>
															<p>{!! __('privacy.cookie.what_is_cookie_content') !!}</p>
															<p>{{ __('privacy.cookie.session_persistent') }}</p>
															<p>{{ __('privacy.cookie.how_we_use_title') }}</p>
															<p>{!! __('privacy.cookie.how_we_use_content') !!}</p>
															<p>{{ __('privacy.cookie.types_title') }}</p>
															<p>{{ __('privacy.cookie.types_intro') }}</p>
															<p>{{ __('privacy.cookie.strictly_necessary') }}</p>
															<p>{{ __('privacy.cookie.functional') }}</p>
															<p>{!! __('privacy.cookie.performance') !!}</p>
															<p>{{ __('privacy.cookie.third_party_title') }}</p>
															<p>{!! __('privacy.cookie.third_party_content') !!}</p>
															<p>{{ __('privacy.cookie.contact_title') }}</p>
															<p>{{ __('privacy.cookie.contact_content') }}</p>
															<p>{{ __('privacy.cookie.modification_title') }}</p>
															<p>{{ __('privacy.cookie.modification_content') }}</p>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</section>
					</div>
				</div>
			</div>
		</div>

	</div>

</div>

@endsection

@push('scripts')

@endpush