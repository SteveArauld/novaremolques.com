@extends('layouts.app')

@section('title', __('refund.page_title'))

@push('styles')

@endpush
@section('body_class', 'wp-singular page-template-default page page-id-12301 wp-theme-merto theme-merto woocommerce-js wide header-v1 product-label-rectangle product-hover-style-v2 product-border-radius vertical-menu-fixed ts_desktop elementor-default elementor-kit-10348 e--ua-blink e--ua-chrome e--ua-webkit cht-in-desktop cht-landscape')

@section('content')

<div id="main" class="wrapper ">
	<div class="breadcrumb-title-wrapper breadcrumb-v3">
		<div class="container">
			<div class="breadcrumb-title">
				<h1 class="heading-title page-title entry-title ">{{ __('refund.page_title') }}</h1>
				<div class="ts-breadcrumbs breadcrumbs">
					<div class="breadcrumbs-container">
						<a href="{{ route('home') }}">{{ __('refund.breadcrumb_home') }}</a>
						<span class="brn_arrow">/</span>
						<span class="current">{{ __('refund.breadcrumb_current') }}</span>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="page-container show_breadcrumb_v3 no-sidebar">

		<div class="page-content">
			<div data-elementor-type="wp-page" data-elementor-id="10559" class="elementor elementor-10559">
				<div class="elementor-inner">
					<div class="elementor-section-wrap">
						<section class="elementor-section elementor-top-section elementor-element elementor-element-f42023c elementor-section-boxed elementor-section-height-default elementor-section-height-default" data-id="f42023c" data-element_type="section">
							<div class="elementor-container elementor-column-gap-default">
								<div class="elementor-row">
									<div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-56a6a40b" data-id="56a6a40b" data-element_type="column">
										<div class="elementor-column-wrap elementor-element-populated">
											<div class="elementor-widget-wrap">
												<div class="elementor-element elementor-element-42e58df2 elementor-widget elementor-widget-text-editor" data-id="42e58df2" data-element_type="widget" data-widget_type="text-editor.default">
													<div class="elementor-widget-container">
														<div class="elementor-text-editor elementor-clearfix">
															<div>
																<div>{{ __('refund.commitment') }}</div>
																<p>&nbsp;</p>
																<div>{{ __('refund.right_of_withdrawal_title') }}</div>
																<div>{{ __('refund.right_of_withdrawal_content') }}</div>
																<p>&nbsp;</p>
																<div>{{ __('refund.return_conditions_title') }}</div>
																<div>{{ __('refund.return_conditions_intro') }}</div>
																<p>&nbsp;</p>
																<div>{{ __('refund.return_condition_1') }}</div>
																<p>&nbsp;</p>
																<div>{{ __('refund.return_condition_2') }}</div>
																<p>&nbsp;</p>
																<div>{{ __('refund.return_condition_3') }}</div>
																<div>{{ __('refund.return_condition_4') }}</div>
																<p>&nbsp;</p>
																<div>{{ __('refund.return_procedure_title') }}</div>
																<p>&nbsp;</p>
																<div>{!! __('refund.return_procedure_step_1') !!}</div>
																<p>&nbsp;</p>
																<div>{{ __('refund.return_procedure_step_2') }}</div>
																<p>&nbsp;</p>
																<div>{{ __('refund.return_procedure_step_3') }}</div>
																<p>&nbsp;</p>
																<div>{{ __('refund.refund_procedure_title') }}</div>
																<div>{{ __('refund.refund_procedure_content') }}</div>
																<p>&nbsp;</p>
																<div>{{ __('refund.exclusions_title') }}</div>
																<div>{{ __('refund.exclusions_content') }}</div>
																<p>&nbsp;</p>
																<div>{{ __('refund.contact_title') }}</div>
																<div>{{ __('refund.contact_intro') }}</div>
																<p>&nbsp;</p>
																<div>{{ __('refund.contact_email') }}</div>
																<p>&nbsp;</p>
																<div>{{ __('refund.contact_phone') }}</div>
																<p>&nbsp;</p>
																<div>{{ __('refund.policy_update_title') }}</div>
																<div>{{ __('refund.policy_update_content') }}</div>
															</div>
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