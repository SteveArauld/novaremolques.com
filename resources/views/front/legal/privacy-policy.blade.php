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
				<h1 class="heading-title page-title entry-title ">{{ __('privacy.page_title') }}</h1>
				<div class="ts-breadcrumbs breadcrumbs">
					<div class="breadcrumbs-container">
						<a href="{{ route('home') }}">{{ __('privacy.breadcrumb_home') }}</a>
						<span class="brn_arrow">/</span>
						<span class="current">{{ __('privacy.breadcrumb_current') }}</span>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="page-container show_breadcrumb_v3 no-sidebar">

		<div class="page-content">
			<div data-elementor-type="wp-page" data-elementor-id="11076" class="elementor elementor-11076">
				<div class="elementor-inner">
					<div class="elementor-section-wrap">
						<section class="elementor-section elementor-top-section elementor-element elementor-element-ba1d8b3 elementor-section-boxed elementor-section-height-default elementor-section-height-default" data-id="ba1d8b3" data-element_type="section">
							<div class="elementor-container elementor-column-gap-default">
								<div class="elementor-row">
									<div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-95b6958" data-id="95b6958" data-element_type="column">
										<div class="elementor-column-wrap elementor-element-populated">
											<div class="elementor-widget-wrap">
												<div class="elementor-element elementor-element-13ed518 elementor-widget elementor-widget-text-editor" data-id="13ed518" data-element_type="widget" data-widget_type="text-editor.default">
													<div class="elementor-widget-container">
														<div class="elementor-text-editor elementor-clearfix">
															<p>{!! __('privacy.welcome') !!}</p>
															<p>{!! __('privacy.summary') !!}</p>
															<p><span dir="auto">{{ __('privacy.age_notice') }}</span></p>
															<p><strong><span dir="auto">{{ __('privacy.who_we_are_title') }}</span></strong></p>
															<p>{!! __('privacy.who_we_are_content') !!}</p>
															<p><strong><span dir="auto">{{ __('privacy.how_to_contact_title') }}</span></strong></p>
															<p>{!! __('privacy.how_to_contact_content') !!}</p>
															<p>{!! __('privacy.when_we_collect') !!}</p>
															<p>{{ __('privacy.third_party_notice') }}</p>
															<p><strong><span dir="auto">{{ __('privacy.types_of_data_title') }}</span></strong></p>
															<p>{{ __('privacy.types_of_data_intro') }}</p>
															<p><strong><span dir="auto">{{ __('privacy.types_of_data_list_title') }}</span></strong></p>
															<p>{!! __('privacy.types_of_data_list') !!}</p>
															<p><strong><span dir="auto">{{ __('privacy.legal_bases_title') }}</span></strong></p>
															<p>{!! __('privacy.legal_bases_content') !!}</p>
															<p><strong><span dir="auto">{{ __('privacy.how_we_use_title') }}</span></strong></p>
															<p>{{ __('privacy.how_we_use_intro') }}</p>
															<p><strong><span dir="auto">{{ __('privacy.contractual_purposes_title') }}</span></strong><br>{!! __('privacy.contractual_purposes') !!}</p>
															<p>{!! __('privacy.consent_purposes') !!}</p>
															<p><strong><span dir="auto">{{ __('privacy.legal_obligations_title') }}</span></strong></p>
															<p>{!! __('privacy.legal_obligations') !!}</p>
															<p>{!! __('privacy.legitimate_interests') !!}</p>
															<p><strong><span dir="auto">{{ __('privacy.sharing_title') }}</span></strong></p>
															<p>{!! __('privacy.sharing_content') !!}</p>
															<p>{!! __('privacy.international_transfers') !!}</p>
															<p><strong><span dir="auto">{{ __('privacy.retention_title') }}</span></strong></p>
															<p>{{ __('privacy.retention_content') }}</p>
															<p><strong><span dir="auto">{{ __('privacy.security_title') }}</span></strong></p>
															<p>{!! __('privacy.security_content') !!}</p>
															<p><strong><span dir="auto">{{ __('privacy.your_rights_title') }}</span></strong></p>
															<p>{!! __('privacy.your_rights_content') !!}</p>
															<p>{{ __('privacy.exercise_rights') }}</p>
															<p><strong><span dir="auto">{{ __('privacy.third_party_sites_title') }}</span></strong></p>
															<p>{{ __('privacy.third_party_sites_content') }}</p>
															<p><strong><span dir="auto">{{ __('privacy.cookies_title') }}</span></strong></p>
															<p>{!! __('privacy.cookies_content') !!}</p>
															<p><strong><span dir="auto">{{ __('privacy.supervisory_authority_title') }}</span></strong></p>
															<p>{!! __('privacy.supervisory_authority_content') !!}</p>
															<p><strong><span dir="auto">{{ __('privacy.changes_title') }}</span></strong></p>
															<p>{!! __('privacy.changes_content') !!}</p>
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