@extends('settings.edit')
@section('section')
    <div class="card w-100">
        <div class="card-body d-flex">
            @include('settings.setting_menu')
            <div class="w-100">
                <div class="card-header px-0">
                    <div class="d-flex align-items-center justify-content-center">
                        <h3 class="m-0">{{ __('messages.payment_method') }}
                        </h3>
                    </div>
                </div>
                <div class="card-body border-top p-3">
                    {{ Form::open(['route' => ['payment.method.update'], 'method' => 'post', 'id' => 'SuperAdminCredentialsSettings']) }}
                    <div class="">
                        <div class="form-group mb-5 mt-10">
                            <label class="form-check form-switch form-check-custom ">
                                <input class="form-check-input" type="checkbox" value="{{ \App\Models\Plan::STRIPE }}"
                                    name="payment_gateway[{{ \App\Models\Plan::STRIPE }}]"
                                    {{ isset($selectedPaymentGateways['Stripe']) ? 'checked' : '' }} id="stripe_payment">
                                <span class="form-check-label fw-bold"
                                    for="flexSwitchCheckDefault">{{ __('messages.setting.stripe') }}</span>&nbsp;&nbsp;
                            </label>
                        </div>
                        <div
                            class="col-lg-10 row stripe-cred {{ !isset($selectedPaymentGateways['Stripe']) ? 'd-none' : '' }}">
                            <div class="form-group col-lg-6 mb-5">
                                {{ Form::label('stripe_key', __('messages.setting.stripe_key') . ':', ['class' => 'form-label mb-3 required']) }}
                                <div class="position-relative">
                                    {{ Form::input(isset($setting['stripe_key']) ?? null ? 'password' : 'text', 'stripe_key', $setting['stripe_key'] ?? null, ['class' => 'form-control  stripe-key ' . (getLogInUser()->language == 'ar' ? 'payment-input-left' : 'payment-input-right'), 'placeholder' => __('messages.setting.stripe_key'), 'data-toggle' => 'password']) }}
                                    <span
                                        class="position-absolute d-flex align-items-center top-0 bottom-0 payment-eye-icon
                                    @if (getLogInUser()->language == 'ar') start-0 pe-3
                                    @else
                                        end-0 pe-3 ps-3 @endif input-icon input-password-hide cursor-pointer text-gray-600">
                                        <i class="bi bi-eye-slash-fill"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group col-lg-6 mb-5">
                                {{ Form::label('stripe_secret', __('messages.setting.stripe_secret') . ':', ['class' => 'form-label stripe-secret-label mb-3 required']) }}
                                <div class="position-relative">
                                    {{ Form::input(isset($setting['stripe_secret']) ?? null ? 'password' : 'text', 'stripe_secret', $setting['stripe_secret'] ?? null, ['class' => 'form-control stripe-secret ' . (getLogInUser()->language == 'ar' ? 'payment-input-left' : 'payment-input-right'), 'placeholder' => __('messages.setting.stripe_secret'), 'data-toggle' => 'password']) }}
                                    <span
                                        class="position-absolute d-flex align-items-center top-0 bottom-0 payment-eye-icon
                                @if (getLogInUser()->language == 'ar') start-0 pe-3
                                @else
                                    end-0 pe-3 ps-3 @endif input-icon input-password-hide cursor-pointer text-gray-600">
                                        <i class="bi bi-eye-slash-fill"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <div class="form-group mb-5 mt-10">
                            <label class="form-check form-switch form-check-custom ">
                                <input class="form-check-input" type="checkbox" value="{{ \App\Models\Plan::PAYPAL }}"
                                    name="payment_gateway[{{ \App\Models\Plan::PAYPAL }}]" id="paypal_payment"
                                    {{ isset($selectedPaymentGateways['Paypal']) ? 'checked' : '' }}>
                                <span class="form-check-label fw-bold"
                                    for="flexSwitchCheckDefault">{{ __('messages.setting.paypal') }}</span>&nbsp;&nbsp;
                            </label>
                        </div>
                        <div
                            class="col-lg-10 row paypal-cred {{ !isset($selectedPaymentGateways['Paypal']) ? 'd-none' : '' }}">
                            <div class="form-group col-lg-6 mb-5">
                                {{ Form::label('paypal_client_id', __('messages.setting.paypal_client_id') . ':', ['class' => 'form-label paypal-client-id-label mb-3 required']) }}
                                <div class="position-relative">
                                    {{ Form::input(isset($setting['paypal_client_id']) ?? null ? 'password' : 'text', 'paypal_client_id', $setting['paypal_client_id'] ?? null, ['class' => 'form-control  paypal-client-id ' . (getLogInUser()->language == 'ar' ? 'payment-input-left' : 'payment-input-right'), 'placeholder' => __('messages.setting.paypal_client_id'), 'data-toggle' => 'password']) }}
                                    <span
                                        class="position-absolute d-flex align-items-center top-0 bottom-0 payment-eye-icon
                                @if (getLogInUser()->language == 'ar') start-0 pe-3
                                @else
                                    end-0 pe-3 ps-3 @endif input-icon input-password-hide cursor-pointer text-gray-600">
                                        <i class="bi bi-eye-slash-fill"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group col-lg-6 mb-5">
                                {{ Form::label('paypal_secret', __('messages.setting.paypal_secret') . ':', ['class' => 'form-label paypal-secret-label mb-3 required']) }}
                                <div class="position-relative">
                                    {{ Form::input(isset($setting['paypal_secret']) ?? null ? 'password' : 'text', 'paypal_secret', $setting['paypal_secret'] ?? null, ['class' => 'form-control paypal-secret ' . (getLogInUser()->language == 'ar' ? 'payment-input-left' : 'payment-input-right'), 'placeholder' => __('messages.setting.paypal_secret'), 'data-toggle' => 'password']) }}
                                    <span
                                        class="position-absolute d-flex align-items-center top-0 bottom-0 payment-eye-icon
                                @if (getLogInUser()->language == 'ar') start-0 pe-3
                                @else
                                    end-0 pe-3 ps-3 @endif input-icon input-password-hide cursor-pointer text-gray-600">
                                        <i class="bi bi-eye-slash-fill"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group col-lg-4 mb-5">
                                {{ Form::label('paypal_mode', __('messages.setting.paypal_mode') . ':', ['class' => 'form-label paypal-secret-label mb-3 required']) }}
                                {{ Form::select('paypal_mode', $paypalMode, $setting['paypal_mode'], ['class' => 'form-control paypal-secret ', 'data-control' => 'select2', 'data-minimum-results-for-search' => 'Infinity']) }}
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <div class="form-group mb-5 mt-10">
                            <label class="form-check form-switch form-check-custom ">
                                <input class="form-check-input" type="checkbox" value="{{ \App\Models\Plan::RAZORPAY }}"
                                    name="payment_gateway[{{ \App\Models\Plan::RAZORPAY }}]" id="razorpay_payment"
                                    {{ isset($selectedPaymentGateways['Razorpay']) ? 'checked' : '' }}>
                                <span class="form-check-label fw-bold"
                                    for="razorpay">{{ __('messages.setting.razorpay') }}</span>&nbsp;&nbsp;
                            </label>
                        </div>
                        <div
                            class="col-lg-10 row razorpay-cred {{ !isset($selectedPaymentGateways['Razorpay']) ? 'd-none' : '' }}">
                            <div class="form-group col-lg-6 mb-5">
                                {{ Form::label('razorpay_key', __('messages.setting.razorpay_key') . ':', ['class' => 'form-label razorpay-key-label mb-3 required']) }}
                                <div class="position-relative">
                                    {{ Form::input(isset($setting['razorpay_key']) ?? null ? 'password' : 'text', 'razorpay_key', $setting['razorpay_key'] ?? null, ['class' => 'form-control razorpay-key ' . (getLogInUser()->language == 'ar' ? 'payment-input-left' : 'payment-input-right'), 'placeholder' => __('messages.setting.razorpay_key'), 'data-toggle' => 'password']) }}
                                    <span
                                        class="position-absolute d-flex align-items-center top-0 bottom-0 payment-eye-icon
                                @if (getLogInUser()->language == 'ar') start-0 pe-3
                                @else
                                    end-0 pe-3 ps-3 @endif input-icon input-password-hide cursor-pointer text-gray-600">
                                        <i class="bi bi-eye-slash-fill"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group col-lg-6 mb-5">
                                {{ Form::label('razorpay_secret', __('messages.setting.razorpay_secret') . ':', ['class' => 'form-label razorpay-secret-label mb-3 required']) }}
                                <div class="position-relative">
                                    {{ Form::input(isset($setting['razorpay_secret']) ?? null ? 'password' : 'text', 'razorpay_secret', $setting['razorpay_secret'] ?? null, ['class' => 'form-control razorpay-secret ' . (getLogInUser()->language == 'ar' ? 'payment-input-left' : 'payment-input-right'), 'placeholder' => __('messages.setting.razorpay_secret'), 'data-toggle' => 'password']) }}
                                    <span
                                        class="position-absolute d-flex align-items-center top-0 bottom-0 payment-eye-icon
                                @if (getLogInUser()->language == 'ar') start-0 pe-3
                                @else
                                    end-0 pe-3 ps-3 @endif input-icon input-password-hide cursor-pointer text-gray-600">
                                        <i class="bi bi-eye-slash-fill"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <div class="form-group mb-5 mt-10">
                            <label class="form-check form-switch form-check-custom ">
                                <input class="form-check-input" type="checkbox" value="{{ \App\Models\Plan::FLUTTERWAVE }}"
                                    name="payment_gateway[{{ \App\Models\Plan::FLUTTERWAVE }}]" id="flutterwave_payment"
                                    {{ isset($selectedPaymentGateways['Flutterwave']) ? 'checked' : '' }}>
                                <span class="form-check-label fw-bold"
                                    for="flutterwave">{{ __('messages.setting.flutterwave') }}</span>&nbsp;&nbsp;
                            </label>
                        </div>
                        <div
                            class="col-lg-10 row flutterwave-cred {{ !isset($selectedPaymentGateways['Flutterwave']) ? 'd-none' : '' }}">
                            <div class="form-group col-lg-6 mb-5">
                                {{ Form::label('flutterwave_key', __('messages.setting.flutterwave_key') . ':', ['class' => 'form-label razorpay-key-label mb-3 required']) }}
                                <div class="position-relative">
                                    {{ Form::input(isset($setting['flutterwave_key']) ?? null ? 'password' : 'text', 'flutterwave_key', $setting['flutterwave_key'] ?? null, ['class' => 'form-control flutterwave-key ' . (getLogInUser()->language == 'ar' ? 'payment-input-left' : 'payment-input-right'), 'placeholder' => __('messages.setting.flutterwave_key'), 'data-toggle' => 'password']) }}
                                    <span
                                        class="position-absolute d-flex align-items-center top-0 bottom-0 payment-eye-icon
                                @if (getLogInUser()->language == 'ar') start-0 pe-3
                                @else
                                    end-0 pe-3 ps-3 @endif input-icon input-password-hide cursor-pointer text-gray-600">
                                        <i class="bi bi-eye-slash-fill"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group col-lg-6 mb-5">
                                {{ Form::label('flutterwave_secret', __('messages.setting.flutterwave_secret') . ':', ['class' => 'form-label razorpay-secret-label mb-3 required']) }}
                                <div class="position-relative">
                                    {{ Form::input(isset($setting['flutterwave_secret']) ?? null ? 'password' : 'text', 'flutterwave_secret', $setting['flutterwave_secret'] ?? null, ['class' => 'form-control flutterwave-secret ' . (getLogInUser()->language == 'ar' ? 'payment-input-left' : 'payment-input-right'), 'placeholder' => __('messages.setting.flutterwave_secret'), 'data-toggle' => 'password']) }}
                                    <span
                                        class="position-absolute d-flex align-items-center top-0 bottom-0 payment-eye-icon
                                @if (getLogInUser()->language == 'ar') start-0 pe-3
                                @else
                                    end-0 pe-3 ps-3 @endif input-icon input-password-hide cursor-pointer text-gray-600">
                                        <i class="bi bi-eye-slash-fill"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <div class="form-group mb-5 mt-10">
                            <label class="form-check form-switch form-check-custom">
                                <input class="form-check-input" type="checkbox" value="{{ \App\Models\Plan::PAYSTACK }}"
                                    name="payment_gateway[{{ \App\Models\Plan::PAYSTACK }}]"
                                    {{ isset($selectedPaymentGateways['Paystack']) ? 'checked' : '' }}
                                    id="paystack_payment">
                                <span class="form-check-label fw-bold"
                                    for="manually_payment">{{ __('messages.setting.paystack') }}</span>&nbsp;&nbsp;
                            </label>
                        </div>
                        <div
                            class="col-lg-10 row paystack-cred {{ !isset($selectedPaymentGateways['Paystack']) ? 'd-none' : '' }}">
                            <div class="form-group col-lg-6 mb-5">
                                {{ Form::label('paystack_key', __('messages.setting.paystack_key') . ':', ['class' => 'form-label mb-3 required']) }}
                                <div class="position-relative">
                                    {{ Form::input(isset($setting['paystack_key']) ?? null ? 'password' : 'text', 'paystack_key', $setting['paystack_key'] ?? null, ['class' => 'form-control  paystack-key ' . (getLogInUser()->language == 'ar' ? 'payment-input-left' : 'payment-input-right'), 'placeholder' => __('messages.setting.paystack_key'), 'data-toggle' => 'password']) }}
                                    <span
                                        class="position-absolute d-flex align-items-center top-0 bottom-0 payment-eye-icon
                                @if (getLogInUser()->language == 'ar') start-0 pe-3
                                @else
                                    end-0 pe-3 ps-3 @endif input-icon input-password-hide cursor-pointer text-gray-600">
                                        <i class="bi bi-eye-slash-fill"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group col-lg-6 mb-5">
                                {{ Form::label('paystack_secret', __('messages.setting.paystack_secret') . ':', ['class' => 'form-label stripe-secret-label mb-3 required']) }}
                                <div class="position-relative">
                                    {{ Form::input(isset($setting['paystack_secret']) ?? null ? 'password' : 'text', 'paystack_secret', $setting['paystack_secret'] ?? null, ['class' => 'form-control paystack-secret ' . (getLogInUser()->language == 'ar' ? 'payment-input-left' : 'payment-input-right'), 'placeholder' => __('messages.setting.paystack_secret'), 'data-toggle' => 'password']) }}
                                    <span
                                        class="position-absolute d-flex align-items-center top-0 bottom-0 payment-eye-icon
                                @if (getLogInUser()->language == 'ar') start-0 pe-3
                                @else
                                    end-0 pe-3 ps-3 @endif input-icon input-password-hide cursor-pointer text-gray-600">
                                        <i class="bi bi-eye-slash-fill"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <div class="form-group mb-5 mt-10">
                            <label class="form-check form-switch form-check-custom">
                                <input class="form-check-input" type="checkbox" value="{{ \App\Models\Plan::PHONEPE }}"
                                    name="payment_gateway[{{ \App\Models\Plan::PHONEPE }}]"
                                    {{ isset($selectedPaymentGateways['PhonePe']) ? 'checked' : '' }}
                                    id="phonepe_payment">
                                <span class="form-check-label fw-bold"
                                    for="phonepe_payment">{{ __('messages.setting.phonepe') }}</span>&nbsp;&nbsp;
                            </label>
                        </div>
                        <div
                            class="col-lg-10 row phonepe-cred {{ !isset($selectedPaymentGateways['PhonePe']) ? 'd-none' : '' }}">
                            <div class="form-group col-lg-6 mb-5">
                                {{ Form::label('phonepe_merchant_id', __('messages.setting.phonepe_merchant_id') . ':', ['class' => 'form-label mb-3 required']) }}
                                <div class="position-relative">
                                    {{ Form::input(isset($setting['phonepe_merchant_id']) ?? null ? 'password' : 'text', 'phonepe_merchant_id', $setting['phonepe_merchant_id'], ['class' => 'form-control  phonepe_merchant_id ' . (getLogInUser()->language == 'ar' ? 'payment-input-left' : 'payment-input-right'), 'placeholder' => __('messages.setting.phonepe_merchant_id'), 'data-toggle' => 'password']) }}
                                    <span
                                        class="position-absolute d-flex align-items-center top-0 bottom-0 payment-eye-icon
                                @if (getLogInUser()->language == 'ar') start-0 pe-3
                                @else
                                    end-0 pe-3 ps-3 @endif input-icon input-password-hide cursor-pointer text-gray-600">
                                        <i class="bi bi-eye-slash-fill"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group col-lg-6 mb-5">
                                {{ Form::label('phonepe_merchant_user_id', __('messages.setting.phonepe_merchant_user_id') . ':', ['class' => 'form-label stripe-secret-label mb-3 required']) }}
                                <div class="position-relative">
                                    {{ Form::input(isset($setting['phonepe_merchant_user_id']) ?? null ? 'password' : 'text', 'phonepe_merchant_user_id', $setting['phonepe_merchant_user_id'], ['class' => 'form-control phonepe_merchant_user_id ' . (getLogInUser()->language == 'ar' ? 'payment-input-left' : 'payment-input-right'), 'placeholder' => __('messages.setting.phonepe_merchant_user_id'), 'data-toggle' => 'password']) }}
                                    <span
                                        class="position-absolute d-flex align-items-center top-0 bottom-0 payment-eye-icon
                                @if (getLogInUser()->language == 'ar') start-0 pe-3
                                @else
                                    end-0 pe-3 ps-3 @endif input-icon input-password-hide cursor-pointer text-gray-600">
                                        <i class="bi bi-eye-slash-fill"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group col-lg-6 mb-5">
                                {{ Form::label('phonepe_env', __('messages.setting.phonepe_env') . ':', ['class' => 'form-label mb-3 required']) }}
                                <div class="position-relative">
                                    {{ Form::input(isset($setting['phonepe_env']) ?? null ? 'password' : 'text', 'phonepe_env', $setting['phonepe_env'], ['class' => 'form-control  phonepe_env ' . (getLogInUser()->language == 'ar' ? 'payment-input-left' : 'payment-input-right'), 'placeholder' => __('messages.setting.phonepe_env'), 'data-toggle' => 'password']) }}
                                    <span
                                        class="position-absolute d-flex align-items-center top-0 bottom-0 payment-eye-icon
                                @if (getLogInUser()->language == 'ar') start-0 pe-3
                                @else
                                    end-0 pe-3 ps-3 @endif input-icon input-password-hide cursor-pointer text-gray-600">
                                        <i class="bi bi-eye-slash-fill"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group col-lg-6 mb-5">
                                {{ Form::label('phonepe_salt_key', __('messages.setting.phonepe_salt_key') . ':', ['class' => 'form-label stripe-secret-label mb-3 required']) }}
                                <div class="position-relative">
                                    {{ Form::input(isset($setting['phonepe_salt_key']) ?? null ? 'password' : 'text', 'phonepe_salt_key', $setting['phonepe_salt_key'], ['class' => 'form-control phonepe_salt_key ' . (getLogInUser()->language == 'ar' ? 'payment-input-left' : 'payment-input-right'), 'placeholder' => __('messages.setting.phonepe_salt_key'), 'data-toggle' => 'password']) }}
                                    <span
                                        class="position-absolute d-flex align-items-center top-0 bottom-0 payment-eye-icon
                                @if (getLogInUser()->language == 'ar') start-0 pe-3
                                @else
                                    end-0 pe-3 ps-3 @endif input-icon input-password-hide cursor-pointer text-gray-600">
                                        <i class="bi bi-eye-slash-fill"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group col-lg-6 mb-5">
                                {{ Form::label('phonepe_salt_index', __('messages.setting.phonepe_salt_index') . ':', ['class' => 'form-label mb-3 required']) }}
                                <div class="position-relative">
                                    {{ Form::input(isset($setting['phonepe_salt_index']) ?? null ? 'password' : 'text', 'phonepe_salt_index', $setting['phonepe_salt_index'], ['class' => 'form-control  phonepe_salt_index ' . (getLogInUser()->language == 'ar' ? 'payment-input-left' : 'payment-input-right'), 'placeholder' => __('messages.setting.phonepe_salt_index'), 'data-toggle' => 'password']) }}
                                    <span
                                        class="position-absolute d-flex align-items-center top-0 bottom-0 payment-eye-icon
                                @if (getLogInUser()->language == 'ar') start-0 pe-3
                                @else
                                    end-0 pe-3 ps-3 @endif input-icon input-password-hide cursor-pointer text-gray-600">
                                        <i class="bi bi-eye-slash-fill"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Iyzico Payment Gateway Start --}}
                    <div class="form-group mb-5 mt-10">
                        <label class="form-check form-switch form-check-custom ">
                            <input class="form-check-input" type="checkbox" value="{{ \App\Models\Plan::IYZICO }}"
                                name="payment_gateway[{{ \App\Models\Plan::IYZICO }}]"
                                {{ isset($selectedPaymentGateways['Iyzico']) ? 'checked' : '' }} id="iyzico_payment">
                            <span class="form-check-label fw-bold"
                                for="flexSwitchCheckDefault">{{ __('messages.setting.iyzico') }}</span>&nbsp;&nbsp;
                        </label>
                    </div>
                    <div
                        class="col-lg-10 row iyzico-cred {{ !isset($selectedPaymentGateways['Iyzico']) ? 'd-none' : '' }}">
                        <div class="form-group col-lg-6 mb-5">
                            {{ Form::label('iyzico_key', __('messages.setting.iyzico_key') . ':', ['class' => 'form-label mb-3 required']) }}
                            <div class="position-relative">
                                {{ Form::input(isset($setting['iyzico_key']) ?? null ? 'password' : 'text', 'iyzico_key', $setting['iyzico_key'] ?? null, ['class' => 'form-control  iyzico-key ' . (getLogInUser()->language == 'ar' ? 'payment-input-left' : 'payment-input-right'), 'placeholder' => __('messages.setting.iyzico_key'), 'data-toggle' => 'password']) }}
                                <span
                                    class="position-absolute d-flex align-items-center top-0 bottom-0 payment-eye-icon
                            @if (getLogInUser()->language == 'ar') start-0 pe-3
                            @else
                                end-0 pe-3 ps-3 @endif input-icon input-password-hide cursor-pointer text-gray-600">
                                    <i class="bi bi-eye-slash-fill"></i>
                                </span>
                            </div>
                        </div>
                        <div class="form-group col-lg-6 mb-5">
                            {{ Form::label('iyzico_secret',__('messages.setting.iyzico_secret') . ':', ['class' => 'form-label iyzico-secret-label mb-3 required']) }}
                            <div class="position-relative">
                                {{ Form::input(isset($setting['iyzico_secret']) ?? null ? 'password' : 'text', 'iyzico_secret', $setting['iyzico_secret'] ?? null, ['class' => 'form-control iyzico-secret ' . (getLogInUser()->language == 'ar' ? 'payment-input-left' : 'payment-input-right'), 'placeholder' => __('messages.setting.iyzico_secret'), 'data-toggle' => 'password']) }}
                                <span
                                    class="position-absolute d-flex align-items-center top-0 bottom-0 payment-eye-icon
                        @if (getLogInUser()->language == 'ar') start-0 pe-3
                        @else
                            end-0 pe-3 ps-3 @endif input-icon input-password-hide cursor-pointer text-gray-600">
                                    <i class="bi bi-eye-slash-fill"></i>
                                </span>
                            </div>
                        </div>
                        <div class="form-group col-lg-4 mb-5">
                            {{ Form::label('iyzico_mode', __('messages.setting.iyzico_mode') . ':', ['class' => 'form-label iyzico-secret-label mb-3 required']) }}
                            {{ Form::select('iyzico_mode', $iyzicoMode, $setting['iyzico_mode'] ?? null, ['class' => 'form-control iyzico-secret ', 'data-control' => 'select2', 'data-minimum-results-for-search' => 'Infinity']) }}
                        </div>
                    </div>
                    {{-- Iyzico Payment Gateway End --}}
                    {{-- payfast section start --}}
                    <div class="">
                        <div class="form-group mb-5 mt-10">
                            <label class="form-check form-switch form-check-custom ">
                                <input class="form-check-input" type="checkbox" value="{{ \App\Models\Plan::PAYFAST }}"
                                    name="payment_gateway[{{ \App\Models\Plan::PAYFAST }}]" id="payfast_payment"
                                    {{ isset($selectedPaymentGateways['Payfast']) ? 'checked' : '' }}>
                                <span class="form-check-label fw-bold"
                                    for="flexSwitchCheckDefault">{{ __('messages.setting.payfast') }}</span>&nbsp;&nbsp;
                            </label>
                        </div>
                        <div
                            class="col-lg-10 row payfast-cred {{ !isset($selectedPaymentGateways['Payfast']) ? 'd-none' : '' }}">
                            <div class="form-group col-lg-6 mb-5">
                                {{ Form::label('payfast_merchant_id',  __('messages.setting.payfast_merchant_id') . ':', ['class' => 'form-label payfast-client-id-label mb-3 required']) }}
                                <div class="position-relative">
                                    {{ Form::input(isset($setting['payfast_merchant_id']) ?? null ? 'password' : 'text', 'payfast_merchant_id', $setting['payfast_merchant_id'] ?? null, ['class' => 'form-control  ' . (getLogInUser()->language == 'ar' ? 'payment-input-left' : 'payment-input-right'), 'placeholder' =>  __('messages.setting.payfast_merchant_id'), 'data-toggle' => 'password']) }}
                                    <span
                                        class="position-absolute d-flex align-items-center top-0 bottom-0 payment-eye-icon
                                @if (getLogInUser()->language == 'ar') start-0 pe-3
                                @else
                                    end-0 pe-3 ps-3 @endif input-icon input-password-hide cursor-pointer text-gray-600">
                                        <i class="bi bi-eye-slash-fill"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group col-lg-6 mb-5">
                                {{ Form::label('payfast_merchant_key', __('messages.setting.payfast_merchant_key') . ':', ['class' => 'form-label payfast-secret-label mb-3 required']) }}
                                <div class="position-relative">
                                    {{ Form::input(isset($setting['payfast_merchant_key']) ?? null ? 'password' : 'text', 'payfast_merchant_key', $setting['payfast_merchant_key'] ?? null, ['class' => 'form-control ' . (getLogInUser()->language == 'ar' ? 'payment-input-left' : 'payment-input-right'), 'placeholder' => __('messages.setting.payfast_merchant_key'), 'data-toggle' => 'password']) }}
                                    <span
                                        class="position-absolute d-flex align-items-center top-0 bottom-0 payment-eye-icon
                                @if (getLogInUser()->language == 'ar') start-0 pe-3
                                @else
                                    end-0 pe-3 ps-3 @endif input-icon input-password-hide cursor-pointer text-gray-600">
                                        <i class="bi bi-eye-slash-fill"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group col-lg-6 mb-5">
                                {{ Form::label('payfast_passphrase_key', __('messages.setting.passphrase_key') . ':', ['class' => 'form-label  mb-3 required']) }}
                                <div class="position-relative">
                                    {{ Form::input(isset($setting['payfast_passphrase_key']) ?? null ? 'password' : 'text', 'payfast_passphrase_key', $setting['payfast_passphrase_key'] ?? null, ['class' => 'form-control ' . (getLogInUser()->language == 'ar' ? 'payment-input-left' : 'payment-input-right'), 'placeholder' => __('messages.setting.passphrase_key'), 'data-toggle' => 'password']) }}
                                    <span
                                        class="position-absolute d-flex align-items-center top-0 bottom-0 payment-eye-icon
                                @if (getLogInUser()->language == 'ar') start-0 pe-3
                                @else
                                    end-0 pe-3 ps-3 @endif input-icon input-password-hide cursor-pointer text-gray-600">
                                        <i class="bi bi-eye-slash-fill"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group col-lg-4 mb-5">
                                {{ Form::label('payfast_mode', __('messages.setting.payfast_mode') . ':', ['class' => 'form-label  mb-3 required']) }}
                                {{ Form::select('payfast_mode', $payfastMode, $setting['payfast_mode'] ?? null, ['class' => 'form-control  ', 'data-control' => 'select2', 'data-minimum-results-for-search' => 'Infinity']) }}
                            </div>
                        </div>
                    </div>
                    {{-- payfast section end --}}

                    {{-- Sslcommerz section start --}}

                    {{-- <div class="">
                        <div class="form-group mb-5 mt-10">
                            <label class="form-check form-switch form-check-custom ">
                                <input class="form-check-input" type="checkbox" value="{{ \App\Models\Plan::SSLCOMMERZ }}"
                                    name="payment_gateway[{{ \App\Models\Plan::SSLCOMMERZ }}]" id="sslcommerz_payment"
                                    {{ isset($selectedPaymentGateways['Sslcommerz']) ? 'checked' : '' }}>
                                <span class="form-check-label fw-bold"
                                    for="flexSwitchCheckDefault">{{ __('messages.Sslcommerz') }}</span>&nbsp;&nbsp;
                            </label>
                        </div>
                        <div
                            class="col-lg-10 row sslcommerz-cred {{ !isset($selectedPaymentGateways['Sslcommerz']) ? 'd-none' : '' }}">
                            <div class="form-group col-lg-6 mb-5">
                                {{ Form::label('sslc_store_id',  __('messages.setting.sslcommerz_store_id') . ':', ['class' => 'form-label sslcommerz-store-id-label mb-3 required']) }}
                                <div class="position-relative">
                                    {{ Form::input(isset($setting['sslc_store_id']) ?? null ? 'password' : 'text', 'sslc_store_id', $setting['sslc_store_id'] ?? null, ['class' => 'form-control  ' . (getLogInUser()->language == 'ar' ? 'payment-input-left' : 'payment-input-right'), 'placeholder' =>  __('messages.setting.sslcommerz_store_id'), 'data-toggle' => 'password']) }}
                                    <span
                                        class="position-absolute d-flex align-items-center top-0 bottom-0 payment-eye-icon
                                @if (getLogInUser()->language == 'ar') start-0 pe-3
                                @else
                                    end-0 pe-3 ps-3 @endif input-icon input-password-hide cursor-pointer text-gray-600">
                                        <i class="bi bi-eye-slash-fill"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group col-lg-6 mb-5">
                                {{ Form::label('sslc_store_password', __('messages.setting.sslcommerz_store_password') . ':', ['class' => 'form-label sslcommerz-password-label mb-3 required']) }}
                                <div class="position-relative">
                                    {{ Form::input(isset($setting['sslc_store_password']) ?? null ? 'password' : 'text', 'sslc_store_password', $setting['sslc_store_password'] ?? null, ['class' => 'form-control ' . (getLogInUser()->language == 'ar' ? 'payment-input-left' : 'payment-input-right'), 'placeholder' => __('messages.setting.sslcommerz_store_password'), 'data-toggle' => 'password']) }}
                                    <span
                                        class="position-absolute d-flex align-items-center top-0 bottom-0 payment-eye-icon
                                @if (getLogInUser()->language == 'ar') start-0 pe-3
                                @else
                                    end-0 pe-3 ps-3 @endif input-icon input-password-hide cursor-pointer text-gray-600">
                                        <i class="bi bi-eye-slash-fill"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group col-lg-4 mb-5">
                                {{ Form::label('sslcommerz_mode', __('messages.setting.sslcommerz_mode') . ':', ['class' => 'form-label  mb-3 required']) }}
                                {{ Form::select('sslcommerz_mode', $sslcommerzMode, $setting['sslcommerz_mode'] ?? null, ['class' => 'form-control  ', 'data-control' => 'select2', 'data-minimum-results-for-search' => 'Infinity']) }}
                            </div>
                        </div>
                    </div> --}}

                    {{-- Sslcommerz section end --}}

                    @if (moduleExists('MercadoPago'))
                        <div class="">
                            <div class="form-group mb-5 mt-10">
                                <label class="form-check form-switch form-check-custom ">
                                    <input class="form-check-input" type="checkbox"
                                        value="{{ \App\Models\Plan::MERCADO_PAGO }}"
                                        name="payment_gateway[{{ \App\Models\Plan::MERCADO_PAGO }}]"
                                        {{ isset($selectedPaymentGateways['Mercadopago']) ? 'checked' : '' }}
                                        id="mercado_pago_payment">
                                    <span class="form-check-label fw-bold"
                                        for="flexSwitchCheckDefault">{{ __('messages.setting.mercado_pago') }}</span>&nbsp;&nbsp;
                                </label>
                            </div>
                            <div
                                class="col-lg-10 row mercado-pago {{ !isset($selectedPaymentGateways['Mercadopago']) ? 'd-none' : '' }}">
                                <div class="form-group col-lg-6 mb-5">
                                    {{ Form::label('mp_public_key', __('messages.setting.mp_public_key') . ':', ['class' => 'form-label mb-3 required']) }}
                                    <div class="position-relative">
                                        {{ Form::input(isset($setting['mp_public_key']) ?? null ? 'password' : 'text', 'mp_public_key', $setting['mp_public_key'] ?? '', ['class' => 'form-control mp_public_key ' . (getLogInUser()->language == 'ar' ? 'payment-input-left' : 'payment-input-right'), 'placeholder' => __('messages.setting.mp_public_key'), 'data-toggle' => 'password']) }}
                                        <span
                                            class="position-absolute d-flex align-items-center top-0 bottom-0 payment-eye-icon
                                    @if (getLogInUser()->language == 'ar') start-0 pe-3
                                    @else
                                        end-0 pe-3 ps-3 @endif input-icon input-password-hide cursor-pointer text-gray-600">
                                            <i class="bi bi-eye-slash-fill"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group col-lg-6 mb-5">
                                    {{ Form::label('mp_access_token', __('messages.setting.mp_access_token') . ':', ['class' => 'form-label mb-3 required']) }}
                                    <div class="position-relative">
                                        {{ Form::input(isset($setting['mp_access_token']) ?? null ? 'password' : 'text', 'mp_access_token', $setting['mp_access_token'] ?? '', ['class' => 'form-control mp_access_token ' . (getLogInUser()->language == 'ar' ? 'payment-input-left' : 'payment-input-right'), 'placeholder' => __('messages.setting.mp_access_token'), 'data-toggle' => 'password']) }}
                                        <span
                                            class="position-absolute d-flex align-items-center top-0 bottom-0 payment-eye-icon
                                    @if (getLogInUser()->language == 'ar') start-0 pe-3
                                    @else
                                        end-0 pe-3 ps-3 @endif input-icon input-password-hide cursor-pointer text-gray-600">
                                            <i class="bi bi-eye-slash-fill"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="">
                        <div class="form-group mb-5 mt-10">
                            <label class="form-check form-switch form-check-custom">
                                <input class="form-check-input" type="checkbox" value="{{ \App\Models\Plan::MANUALLY }}"
                                    name="payment_gateway[{{ \App\Models\Plan::MANUALLY }}]"
                                    {{ isset($selectedPaymentGateways['Manually']) ? 'checked' : '' }}
                                    id="manually_payment">
                                <span class="form-check-label fw-bold"
                                    for="manually_payment">{{ __('messages.setting.manually') }}</span>&nbsp;&nbsp;
                            </label>
                        </div>
                        <div
                            class="col-lg-10 row manually-cred{{ !isset($selectedPaymentGateways['Manually']) ? ' d-none' : '' }}">
                            {{ Form::hidden('manual_payment_guide', $setting['manual_payment_guide'], ['id' => 'manualPaymentGuideData']) }}
                            {{ Form::hidden('is_manual_payment_guide_on', $setting['is_manual_payment_guide_on'], ['id' => 'isManualPaymentGuideOnData']) }}
                            <div class="col-lg-12">
                                <div class="mb-5">
                                    {{ Form::label('manual_payment_guide', __('messages.vcard.manual_payment_guide') . ':', ['class' => 'form-label']) }}
                                    <div id="manualPaymentGuideId" class="editor-height" style="height: 200px"></div>
                                    {{ Form::hidden('manual_payment_guide', null, ['id' => 'guideData']) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    {{ Form::submit(__('messages.common.save'), ['class' => 'btn btn-primary me-3', 'data-turbo' => 'false']) }}
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection
