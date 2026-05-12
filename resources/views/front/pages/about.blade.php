@extends('layouts.app')

@section('title', __('faq.page_title'))

@push('styles')
<link rel="stylesheet" id="widget-toggle-css"
	href="../assets/uploads/elementor/css/custom-widget-toggle.minaec1.css" type="text/css"
	media="all">
<link rel="stylesheet" id="elementor-post-9575-css"
	href="../assets/uploads/elementor/css/post-95756f26.css" type="text/css" media="all">


@endpush

@section('body_class', 'wp-singular page-template-default page page-id-12301 wp-theme-merto theme-merto woocommerce-js wide header-v1 product-label-rectangle product-hover-style-v2 product-border-radius vertical-menu-fixed ts_desktop elementor-default elementor-kit-10348 e--ua-blink e--ua-chrome e--ua-webkit cht-in-desktop cht-landscape')

@section('content')

<div id="main" class="wrapper ">
	<div class="breadcrumb-title-wrapper breadcrumb-v3">
		<div class="container">
			<div class="breadcrumb-title">
				<h1 class="heading-title page-title entry-title ">{{ __('faq.page_title') }}</h1>
				<div class="ts-breadcrumbs breadcrumbs">
					<div class="breadcrumbs-container">
						<a href="{{ route('home') }}">{{ __('faq.breadcrumb_home') }}</a>
						<span class="brn_arrow">/</span>
						<span class="current">{{ __('faq.breadcrumb_current') }}</span>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="page-container show_breadcrumb_v3 no-sidebar">



		<div class="page-content">
			<div data-elementor-type="wp-page" data-elementor-id="11084" class="elementor elementor-11084">
				<div class="elementor-inner">
					<div class="elementor-section-wrap">
						<section class="elementor-section elementor-top-section elementor-element elementor-element-4ec29df elementor-section-boxed elementor-section-height-default elementor-section-height-default" data-id="4ec29df" data-element_type="section">
							<div class="elementor-container elementor-column-gap-default">
								<div class="elementor-row">
									<div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-af43b4b" data-id="af43b4b" data-element_type="column">
										<div class="elementor-column-wrap elementor-element-populated">
											<div class="elementor-widget-wrap">
												<div class="elementor-element elementor-element-51e04d9 elementor-widget elementor-widget-text-editor" data-id="51e04d9" data-element_type="widget" data-widget_type="text-editor.default">
													<div class="elementor-widget-container">
														<div class="elementor-text-editor elementor-clearfix">
															<p>{{ __('faq.legal_warranty_info') }}</p>
															<p>{{ __('faq.legal_warranty_title') }}</p>
															<p>{!! __('faq.legal_warranty_intro') !!}</p>
															<p>{{ __('faq.legal_warranty_description') }}</p>
															<p>{{ __('faq.conformity_warranty_title') }}</p>
															<p>{{ __('faq.conformity_warranty_content') }}</p>
															<p>{!! __('faq.brand_warranty_extension') !!}</p>
															<p>{{ __('faq.hidden_defects_warranty_title') }}</p>
															<p>{{ __('faq.hidden_defects_warranty_content') }}</p>
															<p>{{ __('faq.benefits_title') }}</p>
															<p>{{ __('faq.benefits_intro') }}</p>
															<p>{!! __('faq.benefits_content') !!}</p>
															<p>{{ __('faq.what_to_do_title') }}</p>
															<p>{!! __('faq.what_to_do_content') !!}</p>
															<p>{{ __('faq.dispute_resolution_title') }}</p>
															<p>{!! __('faq.dispute_resolution_content') !!}</p>
															<p>{{ __('faq.response_commitment') }}</p>
															<p><br><br></p>
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