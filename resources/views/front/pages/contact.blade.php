@extends('layouts.app')

@section('title', __('contact.page_title'))

@push('styles')

    <link rel="stylesheet" id="widget-icon-list-css"
          href="/assets/uploads/elementor/css/custom-widget-icon-list.min.css" type="text/css"
          media="all">
    <link rel="stylesheet" id="elementor-post-7194-css"
          href="/assets/uploads/elementor/css/post-7194.css" type="text/css" media="all">

@endpush


@section('body_class', 'wp-singular page-template-default page page-id-12301 wp-theme-merto theme-merto woocommerce-js wide header-v1 product-label-rectangle product-hover-style-v2 product-border-radius vertical-menu-fixed ts_desktop elementor-default elementor-kit-10348 e--ua-blink e--ua-chrome e--ua-webkit cht-in-desktop cht-landscape')

@section('content')

    <div class="page-container  no-sidebar">

        <!-- Left Sidebar -->


        <!-- Main Content -->
        <div id="main-content">
            <div id="primary" class="site-content">
                <article id="post-7194" class="post-7194 page type-page status-publish hentry">
                    <div data-elementor-type="wp-page" data-elementor-id="7194" class="elementor elementor-7194">
                        <div class="elementor-element elementor-element-baf882f e-flex e-con-boxed e-con e-parent e-lazyloaded"
                             data-id="baf882f" data-element_type="container">
                            <div class="e-con-inner">
                                <div class="elementor-element elementor-element-aa94d98 elementor-widget elementor-widget-heading"
                                     data-id="aa94d98" data-element_type="widget" data-widget_type="heading.default">
                                    <h1 class="elementor-heading-title elementor-size-default">{{ __('contact.title') }}</h1>
                                </div>
                            </div>
                        </div>
                        <div class="elementor-element elementor-element-78e8b44 e-flex e-con-boxed e-con e-parent e-lazyloaded"
                             data-id="78e8b44" data-element_type="container">
                            <div class="e-con-inner">
                                <div class="elementor-element elementor-element-499ddd9 e-con-full e-flex e-con e-child"
                                     data-id="499ddd9" data-element_type="container">
                                    <div class="elementor-element elementor-element-0b35fca elementor-icon-list--layout-traditional elementor-list-item-link-full_width elementor-widget elementor-widget-icon-list"
                                         data-id="0b35fca" data-element_type="widget"
                                         data-widget_type="icon-list.default">
                                        <ul class="elementor-icon-list-items">
                                            <li class="elementor-icon-list-item">
                                                <span class="elementor-icon-list-icon">
                                                    <svg aria-hidden="true" class="e-font-icon-svg e-fas-map-marker-alt" viewBox="0 0 384 512"
                                                         xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M172.268 501.67C26.97 291.031 0 269.413 0 192 0 85.961 85.961 0 192 0s192 85.961 192 192c0 77.413-26.97 99.031-172.268 309.67-9.535 13.774-29.93 13.773-39.464 0zM192 272c44.183 0 80-35.817 80-80s-35.817-80-80-80-80 35.817-80 80 35.817 80 80 80z"></path>
                                                    </svg>
                                                </span>
                                                <span class="elementor-icon-list-text"></span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="elementor-element elementor-element-f3c70fc elementor-widget elementor-widget-text-editor"
                                         data-id="f3c70fc" data-element_type="widget"
                                         data-widget_type="text-editor.default">
                                        <p>{{ __('contact.address') }}</p>
                                    </div>
                                </div>
                                <div class="elementor-element elementor-element-530c8c7 e-con-full e-flex e-con e-child"
                                     data-id="530c8c7" data-element_type="container">
                                    <div class="elementor-element elementor-element-ab49d1e elementor-icon-list--layout-traditional elementor-list-item-link-full_width elementor-widget elementor-widget-icon-list"
                                         data-id="ab49d1e" data-element_type="widget"
                                         data-widget_type="icon-list.default">
                                        <ul class="elementor-icon-list-items">
                                            <li class="elementor-icon-list-item">
                                                <span class="elementor-icon-list-icon">
                                                    <svg aria-hidden="true" class="e-font-icon-svg e-fab-whatsapp-square" viewBox="0 0 448 512"
                                                         xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M224 122.8c-72.7 0-131.8 59.1-131.9 131.8 0 24.9 7 49.2 20.2 70.1l3.1 5-13.3 48.6 49.9-13.1 4.8 2.9c20.2 12 43.4 18.4 67.1 18.4h.1c72.6 0 133.3-59.1 133.3-131.8 0-35.2-15.2-68.3-40.1-93.2-25-25-58-38.7-93.2-38.7zm77.5 188.4c-3.3 9.3-19.1 17.7-26.7 18.8-12.6 1.9-22.4.9-47.5-9.9-39.7-17.2-65.7-57.2-67.7-59.8-2-2.6-16.2-21.5-16.2-41s10.2-29.1 13.9-33.1c3.6-4 7.9-5 10.6-5 2.6 0 5.3 0 7.6.1 2.4.1 5.7-.9 8.9 6.8 3.3 7.9 11.2 27.4 12.2 29.4s1.7 4.3.3 6.9c-7.6 15.2-15.7 14.6-11.6 21.6 15.3 26.3 30.6 35.4 53.9 47.1 4 2 6.3 1.7 8.6-1 2.3-2.6 9.9-11.6 12.5-15.5 2.6-4 5.3-3.3 8.9-2 3.6 1.3 23.1 10.9 27.1 12.9s6.6 3 7.6 4.6c.9 1.9.9 9.9-2.4 19.1zM400 32H48C21.5 32 0 53.5 0 80v352c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V80c0-26.5-21.5-48-48-48zM223.9 413.2c-26.6 0-52.7-6.7-75.8-19.3L64 416l22.5-82.2c-13.9-24-21.2-51.3-21.2-79.3C65.4 167.1 136.5 96 223.9 96c42.4 0 82.2 16.5 112.2 46.5 29.9 30 47.9 69.8 47.9 112.2 0 87.4-72.7 158.5-160.1 158.5z"></path>
                                                    </svg>
                                                </span>
                                                <span class="elementor-icon-list-text"></span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="elementor-element elementor-element-7123791 elementor-widget elementor-widget-text-editor"
                                         data-id="7123791" data-element_type="widget"
                                         data-widget_type="text-editor.default">
                                        <p>{{ __('contact.phone') }}</p>
                                    </div>
                                </div>
                                <div class="elementor-element elementor-element-a647ddf e-con-full e-flex e-con e-child"
                                     data-id="a647ddf" data-element_type="container">
                                    <div class="elementor-element elementor-element-a4129bd elementor-icon-list--layout-traditional elementor-list-item-link-full_width elementor-widget elementor-widget-icon-list"
                                         data-id="a4129bd" data-element_type="widget"
                                         data-widget_type="icon-list.default">
                                        <ul class="elementor-icon-list-items">
                                            <li class="elementor-icon-list-item">
                                                <span class="elementor-icon-list-icon">
                                                    <i aria-hidden="true" class="icomoon-icon icon-mail"></i>
                                                </span>
                                                <span class="elementor-icon-list-text"></span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="elementor-element elementor-element-0605244 elementor-widget elementor-widget-text-editor"
                                         data-id="0605244" data-element_type="widget"
                                         data-widget_type="text-editor.default">
                                        <p>{{ __('contact.email') }} <strong data-start="1196" data-end="1231"><a
                                                        class="decorated-link cursor-pointer" rel="noopener"
                                                        data-start="1198" data-end="1229">contacto@novaremolques.com</a></strong>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="elementor-element elementor-element-8716d6d e-flex e-con-boxed e-con e-parent e-lazyloaded"
                             data-id="8716d6d" data-element_type="container">
                            <div class="e-con-inner">
                                <div class="elementor-element elementor-element-6b98511 elementor-widget elementor-widget-heading"
                                     data-id="6b98511" data-element_type="widget" data-widget_type="heading.default">
                                    <h3 class="elementor-heading-title elementor-size-default">{{ __('contact.question_title') }}</h3>
                                </div>
                                <div class="elementor-element elementor-element-4d91c85 elementor-widget elementor-widget-shortcode"
                                     data-id="4d91c85" data-element_type="widget" data-widget_type="shortcode.default">
                                    <div class="elementor-shortcode">
                                        <div class="wpcf7 js" id="wpcf7-f10398-p7194-o1" lang="en-US" dir="ltr"
                                             data-wpcf7-id="10398">
                                            <div class="screen-reader-response"><p role="status" aria-live="polite"
                                                                                   aria-atomic="true"></p>
                                                <ul></ul>
                                            </div>
                                            <form id="contact-form" class="wpcf7-form init" aria-label="Contact form" novalidate="novalidate" data-status="init">
                                                @csrf
                                                <p class="ts-col-6">
                                                    <label>
            <span class="wpcf7-form-control-wrap" data-name="your-name">
                <input size="40" maxlength="400"
                       class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required"
                       aria-required="true" aria-invalid="false"
                       placeholder="{{ __('contact.form.name') }}"
                       value="" type="text" name="your-name" id="contact-name" required>
            </span>
                                                    </label>
                                                </p>
                                                <p class="ts-col-6">
                                                    <label>
            <span class="wpcf7-form-control-wrap" data-name="your-email">
                <input size="40" maxlength="400"
                       class="wpcf7-form-control wpcf7-email wpcf7-validates-as-required wpcf7-text wpcf7-validates-as-email"
                       aria-required="true" aria-invalid="false"
                       placeholder="{{ __('contact.form.email') }}"
                       value="" type="email" name="your-email" id="contact-email" required>
            </span>
                                                    </label>
                                                </p>
                                                <p>
                                                    <label>
            <span class="wpcf7-form-control-wrap" data-name="your-subject">
                <input size="40" maxlength="400"
                       class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required"
                       aria-required="true" aria-invalid="false"
                       placeholder="{{ __('contact.form.subject') }}"
                       value="" type="text" name="your-subject" id="contact-subject" required>
            </span>
                                                    </label>
                                                </p>
                                                <p>
                                                    <label>
            <span class="wpcf7-form-control-wrap" data-name="your-message">
                <textarea cols="40" rows="10" maxlength="2000"
                          class="wpcf7-form-control wpcf7-textarea"
                          aria-invalid="false"
                          placeholder="{{ __('contact.form.message') }}"
                          name="your-message" id="contact-message" required></textarea>
            </span>
                                                    </label>
                                                </p>
                                                <p class="wpcf7-form-submit">
                                                    <button type="submit" id="contact-submit" class="wpcf7-form-control wpcf7-submit">
                                                        <span class="btn-text">{{ __('contact.form.submit') }}</span>
                                                        <span class="spinner" style="display: none;"></span>
                                                    </button>
                                                </p>
                                                <div class="wpcf7-response-output success-message" aria-hidden="true" id="contact-response" style="display: none;"></div>
                                            </form>

                                            <style>
                                                /* Style du bouton avec loader */
                                                #contact-submit {
                                                    position: relative;
                                                    padding: 12px 30px;
                                                    background-color: #007bff;
                                                    color: white;
                                                    border: none;
                                                    border-radius: 5px;
                                                    font-size: 16px;
                                                    font-weight: 600;
                                                    cursor: pointer;
                                                    transition: all 0.3s;
                                                    min-width: 150px;
                                                    display: inline-flex;
                                                    align-items: center;
                                                    justify-content: center;
                                                    gap: 10px;
                                                }

                                                #contact-submit:hover {
                                                    background-color: #0056b3;
                                                }

                                                #contact-submit:disabled {
                                                    opacity: 0.7;
                                                    cursor: not-allowed;
                                                }

                                                /* Style du spinner dans le bouton */
                                                .spinner {
                                                    width: 20px;
                                                    height: 20px;
                                                    border: 3px solid rgba(255, 255, 255, 0.3);
                                                    border-radius: 50%;
                                                    border-top-color: #ffffff;
                                                    animation: spin 1s ease-in-out infinite;
                                                    display: inline-block;
                                                }

                                                @keyframes spin {
                                                    to { transform: rotate(360deg); }
                                                }

                                                /* Style du message de succès (vert et permanent) */
                                                .success-message {
                                                    margin-top: 20px;
                                                    padding: 15px 20px;
                                                    background-color: #d4edda;
                                                    color: #155724;
                                                    border: 1px solid #c3e6cb;
                                                    border-radius: 5px;
                                                    font-size: 15px;
                                                    font-weight: 500;
                                                    text-align: center;
                                                    animation: slideDown 0.5s ease-out;
                                                }

                                                @keyframes slideDown {
                                                    from {
                                                        opacity: 0;
                                                        transform: translateY(-20px);
                                                    }
                                                    to {
                                                        opacity: 1;
                                                        transform: translateY(0);
                                                    }
                                                }

                                                /* Style pour les champs invalides */
                                                .wpcf7-form-control.invalid {
                                                    border-color: #dc3545 !important;
                                                    background-color: #fff8f8;
                                                }

                                                /* Icône de succès */
                                                .success-message::before {
                                                    content: "✓";
                                                    display: inline-block;
                                                    margin-right: 10px;
                                                    font-weight: bold;
                                                    font-size: 18px;
                                                }

                                                /* Style pour le conteneur du bouton */
                                                .wpcf7-form-submit {
                                                    text-align: center;
                                                    margin-top: 20px;
                                                }

                                                /* Style pour masquer le spinner par défaut */
                                                .wpcf7-spinner {
                                                    display: none;
                                                }

                                                /* Style pour les champs désactivés après envoi (optionnel) */
                                                .form-submitted input,
                                                .form-submitted textarea {
                                                    background-color: #f5f5f5;
                                                    cursor: not-allowed;
                                                }
                                            </style>

                                            <script>
                                                document.addEventListener('DOMContentLoaded', function() {
                                                    const form = document.getElementById('contact-form');
                                                    const submitBtn = document.getElementById('contact-submit');
                                                    const btnText = submitBtn.querySelector('.btn-text');
                                                    const spinner = submitBtn.querySelector('.spinner');
                                                    const responseDiv = document.getElementById('contact-response');

                                                    // Récupérer tous les champs du formulaire
                                                    const nameInput = document.getElementById('contact-name');
                                                    const emailInput = document.getElementById('contact-email');
                                                    const subjectInput = document.getElementById('contact-subject');
                                                    const messageInput = document.getElementById('contact-message');
                                                    const allInputs = [nameInput, emailInput, subjectInput, messageInput];

                                                    // Fonction pour vider tous les champs
                                                    function clearFormFields() {
                                                        nameInput.value = '';
                                                        emailInput.value = '';
                                                        subjectInput.value = '';
                                                        messageInput.value = '';

                                                        // Retirer la classe invalid de tous les champs
                                                        allInputs.forEach(input => {
                                                            input.classList.remove('invalid');
                                                        });
                                                    }

                                                    // Fonction pour désactiver tous les champs (optionnel)
                                                    function disableFormFields(disabled = true) {
                                                        allInputs.forEach(input => {
                                                            input.disabled = disabled;
                                                        });
                                                    }

                                                    // Fonction de validation simple
                                                    function validateForm() {
                                                        const name = nameInput.value.trim();
                                                        const email = emailInput.value.trim();
                                                        const subject = subjectInput.value.trim();
                                                        const message = messageInput.value.trim();
                                                        let isValid = true;

                                                        // Réinitialiser les styles d'erreur
                                                        allInputs.forEach(input => {
                                                            input.classList.remove('invalid');
                                                        });

                                                        // Validation du nom
                                                        if (name === '') {
                                                            nameInput.classList.add('invalid');
                                                            isValid = false;
                                                        }

                                                        // Validation de l'email
                                                        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                                                        if (!emailRegex.test(email)) {
                                                            emailInput.classList.add('invalid');
                                                            isValid = false;
                                                        }

                                                        // Validation du sujet
                                                        if (subject === '') {
                                                            subjectInput.classList.add('invalid');
                                                            isValid = false;
                                                        }

                                                        // Validation du message
                                                        if (message === '') {
                                                            messageInput.classList.add('invalid');
                                                            isValid = false;
                                                        }

                                                        return isValid;
                                                    }

                                                    // Gestion de la soumission du formulaire
                                                    form.addEventListener('submit', function(e) {
                                                        e.preventDefault();

                                                        // Validation
                                                        if (!validateForm()) {
                                                            alert('{{ __("contact.form.validation_error") }}');
                                                            return;
                                                        }

                                                        // Désactiver le bouton et afficher le spinner dans le bouton
                                                        submitBtn.disabled = true;
                                                        btnText.style.opacity = '0.7';
                                                        spinner.style.display = 'inline-block';

                                                        // Désactiver les champs pendant l'envoi (optionnel)
                                                        disableFormFields(true);

                                                        // Simuler l'envoi (délai de 2 secondes)
                                                        setTimeout(() => {
                                                            // Cacher le spinner
                                                            spinner.style.display = 'none';
                                                            btnText.style.opacity = '1';

                                                            // VIDER LES CHAMPS
                                                            clearFormFields();

                                                            // Réactiver les champs (optionnel - si vous voulez permettre une nouvelle soumission)
                                                            disableFormFields(false);

                                                            // Réactiver le bouton
                                                            submitBtn.disabled = false;

                                                            // Afficher le message de succès (permanent)
                                                            responseDiv.textContent = '{{ __("contact.form.success") }}';
                                                            responseDiv.style.display = 'block';

                                                            // Optionnel : faire défiler jusqu'au message
                                                            responseDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });

                                                            // Ajouter une classe au formulaire (optionnel)
                                                            form.classList.add('form-submitted');

                                                        }, 2000);
                                                    });

                                                    // Validation en temps réel
                                                    allInputs.forEach(input => {
                                                        input.addEventListener('input', function() {
                                                            this.classList.remove('invalid');
                                                        });
                                                    });
                                                });
                                            </script>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                       
                    </div>
                </article>
            </div>
        </div>

        <!-- Right Sidebar -->

    </div>

@endsection

@push('scripts')

@endpush
