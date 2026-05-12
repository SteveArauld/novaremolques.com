@extends('layouts.app')

@section('title', __('delivery.page_title'))

@section('body_class', 'wp-singular page-template-default page page-id-12301 wp-theme-merto theme-merto woocommerce-js wide header-v1 product-label-rectangle product-hover-style-v2 product-border-radius vertical-menu-fixed ts_desktop elementor-default elementor-kit-10348 e--ua-blink e--ua-chrome e--ua-webkit cht-in-desktop cht-landscape')

@section('content')

<div id="main" class="wrapper ">
	<div class="breadcrumb-title-wrapper breadcrumb-v3">
		<div class="container">
			<div class="breadcrumb-title">
				<h1 class="heading-title page-title entry-title ">{{ __('delivery.page_title') }}</h1>
				<div class="ts-breadcrumbs breadcrumbs">
					<div class="breadcrumbs-container">
						<a href="{{ route('home') }}">{{ __('delivery.breadcrumb_home') }}</a>
						<span class="brn_arrow">/</span>
						<span class="current">{{ __('delivery.breadcrumb_current') }}</span>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="page-container show_breadcrumb_v3 no-sidebar">

		<div class="page-content">
			<div data-elementor-type="wp-page" data-elementor-id="11065" class="elementor elementor-11065">
				<div class="elementor-inner">
					<div class="elementor-section-wrap">
						<section class="elementor-section elementor-top-section elementor-element elementor-element-7eff708 elementor-section-boxed elementor-section-height-default elementor-section-height-default" data-id="7eff708" data-element_type="section">
							<div class="elementor-container elementor-column-gap-default">
								<div class="elementor-row">
									<div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-3ab4e27" data-id="3ab4e27" data-element_type="column">
										<div class="elementor-column-wrap elementor-element-populated">
											<div class="elementor-widget-wrap">
												<div class="elementor-element elementor-element-5b44307 elementor-widget elementor-widget-text-editor" data-id="5b44307" data-element_type="widget" data-widget_type="text-editor.default">
													<div class="elementor-widget-container">
														<div class="elementor-text-editor elementor-clearfix">
															<p>{{ __('delivery.content.title') }}</p>
															<p>{{ __('delivery.content.paragraph_1') }}</p>
															<p>{{ __('delivery.content.paragraph_2') }}</p>
															<p>{{ __('delivery.content.paragraph_3') }}</p>
															<p>{{ __('delivery.content.shipping_methods_title') }}</p>
															<p>{{ __('delivery.content.shipping_methods_description') }}</p>
															<p>{{ __('delivery.content.additional_costs_title') }}</p>
															<p>{{ __('delivery.content.additional_costs_description') }}</p>
															<p>{!! __('delivery.content.islands_delivery') !!}</p>
															<p>{{ __('delivery.content.at_your_service') }}</p>
															<p>{{ __('delivery.content.after_sales_service') }}</p>
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