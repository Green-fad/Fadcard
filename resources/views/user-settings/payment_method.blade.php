@extends('settings.edit')
@section('section')
    <div class="card w-100">
        <div class="card-body d-flex">
            <div class="">
                <div class="">
                    @include('user-settings.setting_menu')
                </div>
            </div>
            <div class="w-100">
                <button type="button"
                    class="btn px-0 aside-menu-container__aside-menubar d-block d-xl-none d-lg-none d-block edit-menu"
                    onclick="openNav()">
                    <i class="fa-solid fa-bars fs-1"></i>
                </button>
                <div class="card-header px-0">
                    <div class="d-flex align-items-center justify-content-center">
                        <h3 class="m-0">{{ __('messages.payment_method') }}
                        </h3>
                    </div>
                </div>
                <div class="card-body border-top p-3">
                    {{ Form::open(['route' => 'user.payment.method.update', 'id' => 'UserCredentialsSettings', 'files' => true, 'class' => 'form']) }}
                    {{ Form::hidden('sectionName', $sectionName) }}
                    <div class="row">

                        {{--  STRIPE --}}
                        <div class="col-12 d-flex align-items-center">
                            <span class="fs-3 my-3 me-3">{{ __('messages.setting.stripe') }}</span>
                            <label class="form-switch">
                                <input type="checkbox" name="stripe_enable" class="form-check-input stripe-enable"
                                    value="1" {{ !empty($setting['stripe_enable']) == '1' ? 'checked' : '' }}
                                    id="stripeEnable">
                                <span class="custom-switch-indicator"></span>
                            </label>
                        </div>
                        <div class="stripe-div {{ !empty($setting['stripe_enable']) == '1' ? '' : 'd-none' }} col-12">
                            <div class="row">
                                <div class="form-group col-sm-6 mb-5">
                                    {{ Form::label('stripe_key', __('messages.setting.stripe_key') . ':', ['class' => 'form-label required']) }}
                                    {{ Form::text('stripe_key', isset($setting['stripe_key']) ? $setting['stripe_key'] : null, ['class' => 'form-control', 'id' => 'stripeKey', 'placeholder' => __('messages.setting.stripe_key')]) }}
                                </div>
                                <div class="form-group col-sm-6 mb-5">
                                    {{ Form::label('stripe_secret', __('messages.setting.stripe_secret') . ':', ['class' => 'form-label required']) }}
                                    {{ Form::text('stripe_secret', isset($setting['stripe_secret']) ? $setting['stripe_secret'] : null, ['class' => 'form-control', 'id' => 'stripeSecret', 'placeholder' => __('messages.setting.stripe_secret')]) }}
                                </div>
                            </div>
                        </div>
                        {{--  PAYSTACK --}}
                        <div class="col-12 d-flex align-items-center">
                            <span class="fs-3 my-3 me-3">{{ __('messages.setting.paystack') }}</span>
                            <label class="form-switch">
                                <input type="checkbox" name="paytack_enable" class="form-check-input paystack-enable"
                                    value="1" {{ !empty($setting['paytack_enable']) == '1' ? 'checked' : '' }}
                                    id="paystackEnable">
                                <span class="custom-switch-indicator"></span>
                            </label>
                        </div>
                        <div class="paystack-div {{ !empty($setting['paytack_enable']) == '1' ? '' : 'd-none' }} col-12">
                            <div class="row">
                                <div class="form-group col-sm-6 mb-5">
                                    {{ Form::label('paystack_key', __('messages.setting.paystack_key') . ':', ['class' => 'form-label required']) }}
                                    {{ Form::text('paystack_key', isset($setting['paystack_key']) ? $setting['paystack_key'] : null, ['class' => 'form-control', 'id' => 'paystackKey', 'placeholder' => __('messages.setting.paystack_key')]) }}
                                </div>
                                <div class="form-group col-sm-6 mb-5">
                                    {{ Form::label('paystack_secret', __('messages.setting.paystack_secret') . ':', ['class' => 'form-label required']) }}
                                    {{ Form::text('paystack_secret', isset($setting['paystack_secret']) ? $setting['paystack_secret'] : null, ['class' => 'form-control', 'id' => 'paystackSecret', 'placeholder' => __('messages.setting.paystack_secret')]) }}
                                </div>
                            </div>
                        </div>
                        {{--  flutterwave --}}
                        <div class="col-12 d-flex align-items-center">
                            <span class="fs-3 my-3 me-3">{{ __('messages.setting.flutterwave') }}</span>
                            <label class="form-switch">
                                <input type="checkbox" name="flutterwave_enable" class="form-check-input flutterwave-enable"
                                    value="1" {{ !empty($setting['flutterwave_enable']) == '1' ? 'checked' : '' }}
                                    id="flutterwaveEnable">
                                <span class="custom-switch-indicator"></span>
                            </label>
                        </div>
                        <div
                            class="flutterwave-div {{ !empty($setting['flutterwave_enable']) == '1' ? '' : 'd-none' }} col-12">
                            <div class="row">
                                <div class="form-group col-sm-6 mb-5">
                                    {{ Form::label('flutterwave_key', __('messages.setting.flutterwave_key') . ':', ['class' => 'form-label required']) }}
                                    {{ Form::text('flutterwave_key', isset($setting['flutterwave_key']) ? $setting['flutterwave_key'] : null, ['class' => 'form-control', 'id' => 'flutterwaveKey', 'placeholder' => __('messages.setting.flutterwave_key')]) }}
                                </div>
                                <div class="form-group col-sm-6 mb-5">
                                    {{ Form::label('flutterwave_secret', __('messages.setting.flutterwave_secret') . ':', ['class' => 'form-label required']) }}
                                    {{ Form::text('flutterwave_secret', isset($setting['flutterwave_secret']) ? $setting['flutterwave_secret'] : null, ['class' => 'form-control', 'id' => 'flutterwaveSecret', 'placeholder' => __('messages.setting.flutterwave_secret')]) }}
                                </div>
                            </div>
                        </div>
                        {{-- ROZOR PAY --}}
                        <div class="">
                            <div class="col-12 d-flex align-items-center">
                                <span class="fs-3 my-3">{{ __('messages.setting.razorpay') }}</span>
                                <label class="form-check form-switch ms-3">
                                    <input class="form-check-input" type="checkbox" value="1"
                                        {{ !empty($setting['rozorpay_enable']) == '1' ? 'checked' : '' }}
                                        name="rozorpay_enable" id="rozorpayEnable">
                                    <span class="custom-switch-indicator"></span>
                                </label>
                            </div>
                            <div
                                class="razorpay-cred {{ !empty($setting['rozorpay_enable']) == '1' ? '' : 'd-none' }} col-12">
                                <div class="row">
                                    <div class="form-group col-lg-6 mb-5">
                                        {{ Form::label('razorpay_key', __('messages.setting.razorpay_key') . ':', ['class' => 'form-label razorpay-key-label mb-3 required']) }}
                                        {{ Form::text('razorpay_key', isset($setting['razorpay_key']) ? $setting['razorpay_key'] : null, ['class' => 'form-control', 'id' => 'razorpayKey', 'placeholder' => __('messages.setting.razorpay_key')]) }}
                                    </div>
                                    <div class="form-group col-lg-6 mb-5">
                                        {{ Form::label('razorpay_secret', __('messages.setting.razorpay_secret') . ':', ['class' => 'form-label razorpay-secret-label mb-3 required']) }}
                                        {{ Form::text('razorpay_secret', isset($setting['razorpay_secret']) ? $setting['razorpay_secret'] : null, ['class' => 'form-control', 'id' => 'razorpaySecret', 'placeholder' => __('messages.setting.razorpay_secret')]) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{--  Phonepe --}}
                        <div class="col-12 d-flex align-items-center">
                            <span class="fs-3 my-3">{{ __('messages.setting.phonepe') }}</span>
                            <label class="form-check form-switch ms-3">
                                <input type="checkbox" name="phonepe_enable" class="form-check-input phonepe-enable"
                                    value="1" {{ !empty($setting['phonepe_enable']) == '1' ? 'checked' : '' }}
                                    id="phonepeEnable">
                                <span class="custom-switch-indicator"></span>
                            </label>
                        </div>
                        <div class="phonepe-div {{ !empty($setting['phonepe_enable']) == '1' ? '' : 'd-none' }} col-12">
                            <div class="row">
                                <div class="form-group col-lg-6 mb-5">
                                    {{ Form::label('phonepe_merchant_id', __('messages.setting.phonepe_merchant_id') . ':', ['class' => 'form-label mb-3 required']) }}
                                    {{ Form::text('phonepe_merchant_id', isset($setting['phonepe_merchant_id']) ? $setting['phonepe_merchant_id'] : null, ['class' => 'form-control  phonepe_merchant_id', 'id' => 'phonepeMerchantId', 'placeholder' => __('messages.setting.phonepe_merchant_id')]) }}
                                </div>
                                <div class="form-group col-lg-6 mb-5">
                                    {{ Form::label('phonepe_merchant_user_id', __('messages.setting.phonepe_merchant_user_id') . ':', ['class' => 'form-label stripe-secret-label mb-3 required']) }}
                                    {{ Form::text('phonepe_merchant_user_id', isset($setting['phonepe_merchant_user_id']) ? $setting['phonepe_merchant_user_id'] : null, ['class' => 'form-control phonepe_merchant_user_id ', 'id' => 'phonepeMerchantUserId', 'placeholder' => __('messages.setting.phonepe_merchant_user_id')]) }}
                                </div>
                                <div class="form-group col-lg-6 mb-5">
                                    {{ Form::label('phonepe_env', __('messages.setting.phonepe_env') . ':', ['class' => 'form-label mb-3 required']) }}
                                    {{ Form::text('phonepe_env', isset($setting['phonepe_env']) ? $setting['phonepe_env'] : null, ['class' => 'form-control  phonepe_env ', 'id' => 'phonepeEnv', 'placeholder' => __('messages.setting.phonepe_env')]) }}
                                </div>
                                <div class="form-group col-lg-6 mb-5">
                                    {{ Form::label('phonepe_salt_key', __('messages.setting.phonepe_salt_key') . ':', ['class' => 'form-label stripe-secret-label mb-3 required']) }}
                                    {{ Form::text('phonepe_salt_key', isset($setting['phonepe_salt_key']) ? $setting['phonepe_salt_key'] : null, ['class' => 'form-control phonepe_salt_key ', 'id' => 'phonepeSaltKey', 'placeholder' => __('messages.setting.phonepe_salt_key')]) }}
                                </div>
                                <div class="form-group col-lg-6 mb-5">
                                    {{ Form::label('phonepe_salt_index', __('messages.setting.phonepe_salt_index') . ':', ['class' => 'form-label mb-3 required']) }}
                                    {{ Form::text('phonepe_salt_index', isset($setting['phonepe_salt_index']) ? $setting['phonepe_salt_index'] : null, ['class' => 'form-control  phonepe_salt_index ', 'id' => 'phonepeSaltIndex', 'placeholder' => __('messages.setting.phonepe_salt_index')]) }}
                                </div>
                            </div>
                        </div>
                        {{--  PAYPAL --}}
                        <div class="col-12 d-flex align-items-center">
                            <span class="fs-3 my-3">{{ __('messages.setting.paypal') }}</span>
                            <label class="form-check form-switch ms-3">
                                <input type="checkbox" name="paypal_enable" class="form-check-input paypal-enable"
                                    value="1" {{ !empty($setting['paypal_enable']) == '1' ? 'checked' : '' }}
                                    id="paypalEnable">
                                <span class="custom-switch-indicator"></span>
                            </label>
                        </div>
                        <div class="row">
                            <div
                                class="form-group col-sm-6 mb-5 paypal-div {{ !empty($setting['paypal_enable']) == '1' ? '' : 'd-none' }} col-12">
                                {{ Form::label('paypal_client_id', __('messages.setting.paypal_client_id') . ':', ['class' => 'form-label required']) }}
                                {{ Form::text('paypal_client_id', !empty($setting['paypal_client_id']) ? $setting['paypal_client_id'] : null, ['class' => 'form-control', 'id' => 'paypalKey', 'placeholder' => __('messages.setting.paypal_client_id')]) }}
                            </div>
                            <div
                                class="form-group col-sm-6 mb-5 paypal-div {{ !empty($setting['paypal_enable']) == '1' ? '' : 'd-none' }} col-12">
                                {{ Form::label('paypal_secret', __('messages.setting.paypal_secret') . ':', ['class' => 'form-label required']) }}
                                {{ Form::text('paypal_secret', !empty($setting['paypal_secret']) ? $setting['paypal_secret'] : null, ['class' => 'form-control', 'id' => 'paypalSecret', 'placeholder' => __('messages.setting.paypal_secret')]) }}
                            </div>
                            <div
                                class="form-group col-sm-6 mb-5 paypal-div {{ !empty($setting['paypal_enable']) == '1' ? '' : 'd-none' }} col-12">
                                {{ Form::label('paypal_mode', __('messages.setting.paypal_mode') . ':', ['class' => 'form-label required']) }}
                                {{ Form::text('paypal_mode', !empty($setting['paypal_mode']) ? $setting['paypal_mode'] : null, ['class' => 'form-control', 'id' => 'paypalMode', 'placeholder' => __('messages.setting.paypal_mode')]) }}
                            </div>
                        </div>

                        {{-- Mercado Pago --}}

                        @if (moduleExists('MercadoPago'))
                            <div class="col-12 d-flex align-items-center">
                                <span class="fs-3 my-3 me-3">{{ __('Mercado Pago') }}</span>
                                <label class="form-switch">
                                    <input type="checkbox" name="mercado_pago_enable"
                                        class="form-check-input mercado-pago-enable" value="1"
                                        {{ !empty($setting['mercado_pago_enable']) == '1' ? 'checked' : '' }}
                                        id="mercado_pago_payment">
                                    <span class="custom-switch-indicator"></span>
                                </label>
                            </div>
                            <div
                                class="mercado-pago {{ !empty($setting['mercado_pago_enable']) == '1' ? '' : 'd-none' }} col-12">
                                <div class="row">
                                    <div class="form-group col-sm-6 mb-5">
                                        {{ Form::label('mp_public_key', __('messages.setting.mp_public_key') . ':', ['class' => 'form-label required']) }}
                                        {{ Form::text('mp_public_key', isset($setting['mp_public_key']) ? $setting['mp_public_key'] : null, ['class' => 'form-control', 'id' => 'mpPublicKey', 'placeholder' => __('messages.setting.mp_public_key')]) }}
                                    </div>
                                    <div class="form-group col-sm-6 mb-5">
                                        {{ Form::label('mp_access_token', __('messages.setting.mp_access_token') . ':', ['class' => 'form-label required']) }}
                                        {{ Form::text('mp_access_token', isset($setting['mp_access_token']) ? $setting['mp_access_token'] : null, ['class' => 'form-control', 'id' => 'mpAccessToken', 'placeholder' => __('messages.setting.mp_access_token')]) }}
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- Payfast --}}
                        <div class="col-12 d-flex align-items-center">
                            <span class="fs-3 my-3">{{ __('messages.setting.payfast') }}</span>
                            <label class="form-check form-switch ms-3">
                                <input type="checkbox" name="payfast_enable" class="form-check-input payfast-enable"
                                    value="1" {{ !empty($setting['payfast_enable']) == '1' ? 'checked' : '' }}
                                    id="payfastEnable">
                                <span class="custom-switch-indicator"></span>
                            </label>
                        </div>
                        <div class="row">
                            <div
                                class="form-group col-sm-6 mb-5 payfast-div {{ !empty($setting['payfast_enable']) == '1' ? '' : 'd-none' }} col-12">
                                {{ Form::label('payfast_merchant_id', __('messages.setting.payfast_merchant_id') . ':', ['class' => 'form-label required']) }}
                                {{ Form::text('payfast_merchant_id', !empty($setting['payfast_merchant_id']) ? $setting['payfast_merchant_id'] : null, ['class' => 'form-control', 'id' => 'payfastKey', 'placeholder' => __('messages.setting.payfast_merchant_id')]) }}
                            </div>
                            <div
                                class="form-group col-sm-6 mb-5 payfast-div {{ !empty($setting['payfast_enable']) == '1' ? '' : 'd-none' }} col-12">
                                {{ Form::label('payfast_merchant_key', __('messages.setting.payfast_merchant_key') . ':', ['class' => 'form-label required']) }}
                                {{ Form::text('payfast_merchant_key', !empty($setting['payfast_merchant_key']) ? $setting['payfast_merchant_key'] : null, ['class' => 'form-control', 'id' => 'payfastSecret', 'placeholder' => __('messages.setting.payfast_merchant_key')]) }}
                            </div>
                            <div
                                class="form-group col-sm-6 mb-5 payfast-div {{ !empty($setting['payfast_enable']) == '1' ? '' : 'd-none' }} col-12">
                                {{ Form::label('payfast_passphrase_key', __('messages.setting.passphrase_key') . ':', ['class' => 'form-label required']) }}
                                {{ Form::text('payfast_passphrase_key', !empty($setting['payfast_passphrase_key']) ? $setting['payfast_passphrase_key'] : null, ['class' => 'form-control', 'id' => 'payfastPassphraseKey', 'placeholder' => __('messages.setting.passphrase_key')]) }}
                            </div>
                            <div
                                class="form-group col-lg-4 mb-5 payfast-div {{ !empty($setting['payfast_enable']) == '1' ? '' : 'd-none' }} col-12 ">
                                {{ Form::label('payfast_mode', __('messages.setting.payfast_mode') . ':', ['class' => 'form-label  mb-3 required']) }}
                                {{ Form::select('payfast_mode', $paymentMode, $setting['payfast_mode'] ?? null, ['class' => 'form-control  ', 'data-control' => 'select2', 'data-minimum-results-for-search' => 'Infinity']) }}
                            </div>
                        </div>
                        {{-- Payfast --}}

                        {{--  SSLCOMMERZ --}}
                        {{-- <div class="col-12 d-flex align-items-center">
                            <span class="fs-3 my-3">{{ __('messages.Sslcommerz') }}</span>
                            <label class="form-check form-switch ms-3">
                                <input type="checkbox" name="sslcommerz_enable" class="form-check-input sslcommerz-enable"
                                    value="1" {{ !empty($setting['sslcommerz_enable']) == '1' ? 'checked' : '' }}
                                    id="sslcommerzEnable">
                                <span class="custom-switch-indicator"></span>
                            </label>
                        </div>
                        <div class="row">
                            <div
                                class="form-group col-sm-6 mb-5 sslcommerz-div {{ !empty($setting['sslcommerz_enable']) == '1' ? '' : 'd-none' }} col-12">
                                {{ Form::label('sslc_store_id', __('messages.setting.sslcommerz_store_id') . ':', ['class' => 'form-label required']) }}
                                {{ Form::text('sslc_store_id', !empty($setting['sslc_store_id']) ? $setting['sslc_store_id'] : null, ['class' => 'form-control', 'id' => 'sslcommerzStoreId', 'placeholder' => __('messages.setting.sslcommerz_store_id')]) }}
                            </div>
                            <div
                                class="form-group col-sm-6 mb-5 sslcommerz-div {{ !empty($setting['sslcommerz_enable']) == '1' ? '' : 'd-none' }} col-12">
                                {{ Form::label('sslc_store_password', __('messages.setting.sslcommerz_store_password') . ':', ['class' => 'form-label required']) }}
                                {{ Form::text('sslc_store_password', !empty($setting['sslc_store_password']) ? $setting['sslc_store_password'] : null, ['class' => 'form-control', 'id' => 'sslcommerzPassword', 'placeholder' => __('messages.setting.sslcommerz_store_password')]) }}
                            </div>
                            <div
                                class="form-group col-lg-4 mb-5 sslcommerz-div {{ !empty($setting['sslcommerz_enable']) == '1' ? '' : 'd-none' }} col-12 ">
                                {{ Form::label('sslcommerz_mode', __('messages.setting.sslcommerz_mode') . ':', ['class' => 'form-label  mb-3 required']) }}
                                {{ Form::select('sslcommerz_mode', $sslcommerzMode, $setting['sslcommerz_mode'] ?? null, ['class' => 'form-control  ', 'data-control' => 'select2', 'data-minimum-results-for-search' => 'Infinity']) }}
                            </div>
                        </div> --}}
                        {{-- Iyzico --}}
                        <div class="col-12 d-flex align-items-center">
                            <span class="fs-3 my-3">{{ __('messages.setting.iyzico') }}</span>
                            <label class="form-check form-switch ms-3">
                                <input type="checkbox" name="iyzico_enable" class="form-check-input iyzico-enable"
                                    value="1" {{ !empty($setting['iyzico_enable']) == '1' ? 'checked' : '' }}
                                    id="iyzicoEnable">
                                <span class="custom-switch-indicator"></span>
                            </label>
                        </div>
                        <div class="row">
                            <div
                                class="form-group col-sm-6 mb-5 iyzico-div {{ !empty($setting['iyzico_enable']) == '1' ? '' : 'd-none' }} col-12">
                                {{ Form::label('iyzico_key', __('messages.setting.iyzico_key') . ':', ['class' => 'form-label required']) }}
                                {{ Form::text('iyzico_key', !empty($setting['iyzico_key']) ? $setting['iyzico_key'] : null, ['class' => 'form-control', 'id' => 'iyzicoKey', 'placeholder' => __('messages.setting.iyzico_key')]) }}
                            </div>
                            <div
                                class="form-group col-sm-6 mb-5 iyzico-div {{ !empty($setting['iyzico_enable']) == '1' ? '' : 'd-none' }} col-12">
                                {{ Form::label('iyzico_secret', __('messages.setting.iyzico_secret') . ':', ['class' => 'form-label required']) }}
                                {{ Form::text('iyzico_secret', !empty($setting['iyzico_secret']) ? $setting['iyzico_secret'] : null, ['class' => 'form-control', 'id' => 'iyzicoSecret', 'placeholder' => __('messages.setting.iyzico_secret')]) }}
                            </div>

                            <div
                                class="form-group col-lg-4 mb-5 iyzico-div {{ !empty($setting['iyzico_enable']) == '1' ? '' : 'd-none' }} col-12 ">
                                {{ Form::label('iyzico_mode', __('messages.setting.iyzico_mode') . ':', ['class' => 'form-label  mb-3 required']) }}
                                {{ Form::select('iyzico_mode', $paymentMode, $setting['iyzico_mode'] ?? null, ['class' => 'form-control  ', 'data-control' => 'select2', 'data-minimum-results-for-search' => 'Infinity']) }}
                            </div>
                        </div>
                        {{-- Iyzico --}}


                        {{-- MANUALLY --}}
                        <div class="col-12 d-flex align-items-center">
                            <span class="fs-3 my-3">{{ __('messages.setting.manually') }}</span>
                            <label class="form-check form-switch ms-3">
                                <input type="checkbox" name="manually_payment"
                                    class="form-check-input manually-payment-enable" value="1"
                                    {{ !empty($setting['manually_payment']) == '1' ? 'checked' : '' }}
                                    id="userManualPaymentSetting">
                                <span class="custom-switch-indicator"></span>&nbsp;&nbsp;
                            </label>
                        </div>
                        <div
                            class="col-lg-10 row user-manually-cred{{ (isset($setting['manually_payment']) && $setting['manually_payment'] == false) || empty($setting['manually_payment']) ? ' d-none' : '' }}">
                            {{ Form::hidden('manual_payment_guide', isset($setting['manual_payment_guide']) ? $setting['manual_payment_guide'] : '', ['id' => 'manualPaymentGuideData']) }}
                            <div class="col-lg-12">
                                <div class="mb-5">
                                    {{ Form::label('manual_payment_guide', __('messages.vcard.manual_payment_guide') . ':', ['class' => 'form-label']) }}
                                    <div id="manualPaymentGuideId" class="editor-height" style="height: 200px">
                                    </div>
                                    {{ Form::hidden('manual_payment_guide', null, ['id' => 'guideData']) }}
                                </div>
                            </div>
                        </div>
                        {{--  Notifation --}}
                        {{-- <div class="col-12 d-flex align-items-center">
                            <span class="fs-3 my-3 me-3">{{ __('messages.setting.notification') }}</span>
                            <label class="form-switch">
                                <input type="checkbox" name="notifation_enable" class="form-check-input notifation-enable"
                                    value="1" {{ !empty($setting['notifation_enable']) == '1' ? 'checked' : '' }}
                                    id="notifationEnable">
                                <span class="custom-switch-indicator"></span>
                            </label>
                        </div>
                        <div class="notifation-div {{ !empty($setting['notifation_enable']) == '1' ? '' : 'd-none' }} col-12">
                            <div class="row">
                                <div class="form-group col-sm-6 mb-5">
                                    {{ Form::label('onesignal_app_id', __('messages.setting.onesignal_app_id') . ':', ['class' => 'form-label']) }}
                                    {{ Form::text('onesignal_app_id', isset($setting['onesignal_app_id']) ? $setting['onesignal_app_id'] : null, ['class' => 'form-control', 'id' => 'onesignalAppId', 'placeholder' => __('messages.setting.onesignal_app_id')]) }}
                                </div>
                                <div class="form-group col-sm-6 mb-5">
                                    {{ Form::label('onesignal_rest_api_key', __('messages.setting.onesignal_rest_api_key') . ':', ['class' => 'form-label']) }}
                                    {{ Form::text('onesignal_rest_api_key', isset($setting['onesignal_rest_api_key']) ? $setting['onesignal_rest_api_key'] : null, ['class' => 'form-control', 'id' => 'onesignalRestApiKey', 'placeholder' => __('messages.setting.onesignal_rest_api_key')]) }}
                                </div>
                            </div>
                        </div> --}}
                    </div>


                    <button type="submit" class="btn btn-primary"
                        id="userCredentialSettingBtn">{{ __('messages.common.save') }}</button>

                    {{ Form::close() }}
                </div>
            </div>
        </div>
    @endsection
