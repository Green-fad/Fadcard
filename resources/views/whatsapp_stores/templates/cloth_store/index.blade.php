<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    @if (checkFeature('seo') && $whatsappStore->site_title && $whatsappStore->home_title)
        <title>{{ $whatsappStore->home_title }} | {{ $whatsappStore->site_title }}</title>
    @else
        <title>{{ $whatsappStore->store_name }} | {{ getAppName() }}</title>
    @endif
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="{{ $whatsappStore->logo_url }}" type="image/png">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if (checkFeature('seo'))
        @if ($whatsappStore->meta_description)
            <meta name="description" content="{{ $whatsappStore->meta_description }}">
        @endif
        @if ($whatsappStore->meta_keyword)
            <meta name="keywords" content="{{ $whatsappStore->meta_keyword }}">
        @endif
    @else
        <meta name="description" content="{{ $whatsappStore->description }}">
        <meta name="keywords" content="">
    @endif
    <!-- PWA  -->
    <meta name="theme-color" content="#6777ef" />
    <link rel="apple-touch-icon" href="{{ asset('logo.png') }}">
    <link rel="manifest" href="{{ asset('pwa/1.json') }}">

    <link href="{{ asset('front/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ mix('assets/css/whatsappp_store/cloth_store.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/slider/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/slider/css/slick-theme.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/third-party.css') }}">
    <link rel="stylesheet" href="{{ asset('css/plugins.css') }}">
    <link rel="stylesheet" href="{{ mix('assets/css/whatsappp_store/custom.css') }}" />
    @if ($whatsappStore->font_family || $whatsappStore->font_size || $whatsappStore->custom_css)
        <style>
            @if ($whatsappStore->font_family)
                body {
                    font-family: {{ $whatsappStore->font_family }};
                }
            @endif

            @if ($whatsappStore->font_size)
                div > h4 {
                    font-size: {{ $whatsappStore->font_size }}px !important;
                }
            @endif

            @if ($whatsappStore->custom_css)
                {!! $whatsappStore->custom_css !!}
            @endif
        </style>
    @endif
</head>

<body>
    <div class="main-content mx-auto w-100 overflow-hidden d-flex flex-column justify-content-between {{ getLocalLanguage() == 'ar' ? 'rtl' : '' }}"
        @if (getLanguage($whatsappStore->default_language) == 'Arabic') dir="rtl" @endif>
        <div>
            <nav class="navbar navbar-expand-lg px-50 position-relative">
                <div class="container-fluid p-0">
                    <div class="d-flex align-items-center gap-3">
                        <a class="navbar-brand p-0 m-0" href="{{ request()->url() }}">
                            <img src="{{ $whatsappStore->logo_url }}" alt="logo"
                                class="w-100 h-100 object-fit-cover" />
                        </a>
                        <span class="fw-5 fs-18"><a
                                href="{{ route('whatsapp.store.show', $whatsappStore->url_alias) }}"
                                style="color: #212529 ">{{ $whatsappStore->store_name }}</a></span>
                    </div>

                    <div class="d-flex align-items-center gap-lg-4 gap-sm-3 gap-2">
                        <div class="language-dropdown position-relative">
                            <button class="dropdown-btn position-relative" id="dropdownMenuButton"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                @if (array_key_exists(checkLanguageSession($whatsappStore->url_alias), \App\Models\User::FLAG))
                                    <img class="flag" alt="flag"
                                        src="{{ asset(\App\Models\User::FLAG[getLanguageIsoCode($whatsappStore->default_language) ?? 'en']) }}" />
                                @endif
                                {{ strtoupper(getLanguageIsoCode($whatsappStore->default_language) ?? 'en') }}
                            </button>
                            <svg class="dropdown-arrow" xmlns="http://www.w3.org/2000/svg" width="14" height="8"
                                viewBox="0 0 18 10" fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M0.615983 0.366227C0.381644 0.600637 0.25 0.918522 0.25 1.24998C0.25 1.58143 0.381644 1.89932 0.615983 2.13373L8.11598 9.63373C8.35039 9.86807 8.66828 9.99971 8.99973 9.99971C9.33119 9.99971 9.64907 9.86807 9.88348 9.63373L17.3835 2.13373C17.6112 1.89797 17.7372 1.58222 17.7343 1.25448C17.7315 0.92673 17.6 0.613214 17.3683 0.381454C17.1365 0.149694 16.823 0.0182329 16.4952 0.0153849C16.1675 0.0125369 15.8517 0.13853 15.616 0.366227L8.99973 6.98248L2.38348 0.366227C2.14907 0.131889 1.83119 0.000244141 1.49973 0.000244141C1.16828 0.000244141 0.850393 0.131889 0.615983 0.366227Z"
                                    fill="black" />
                            </svg>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                @foreach (getAllLanguageWithFullData() as $language)
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)" id="languageName"
                                            data-name="{{ $language->iso_code }}">

                                            @if (array_key_exists($language->iso_code, \App\Models\User::FLAG))
                                                <img class="flag" alt="flag"
                                                    src="{{ asset(\App\Models\User::FLAG[$language->iso_code]) }}" />
                                            @else
                                                @if (count($language->media) != 0)
                                                    <img src="{{ $language->image_url }}" class="me-1" />
                                                @else
                                                    <i class="fa fa-flag fa-xl me-3 text-danger" aria-hidden="true"></i>
                                                @endif
                                            @endif
                                            {{ strtoupper($language->iso_code) }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <button
                            class="add-to-cart-btn d-flex align-items-center justify-content-center position-relative"
                            id="addToCartViewBtn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30"
                                fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M20.0048 9.03985C20.0048 9.27694 19.9106 9.50433 19.7429 9.67198C19.5753 9.83964 19.3479 9.93382 19.1108 9.93382C18.8737 9.93382 18.6463 9.83964 18.4787 9.67198C18.311 9.50433 18.2168 9.27694 18.2168 9.03985V7.2519C18.2168 6.38254 17.8715 5.54879 17.2567 4.93406C16.642 4.31934 15.8083 3.97399 14.9389 3.97399C14.0696 3.97399 13.2358 4.31934 12.6211 4.93406C12.0063 5.54879 11.661 6.38254 11.661 7.2519V9.03985C11.661 9.27694 11.5668 9.50433 11.3992 9.67198C11.2315 9.83964 11.0041 9.93382 10.767 9.93382C10.5299 9.93382 10.3025 9.83964 10.1349 9.67198C9.96723 9.50433 9.87305 9.27694 9.87305 9.03985V7.2519C9.87305 5.90835 10.4068 4.61982 11.3568 3.66979C12.3068 2.71976 13.5954 2.18604 14.9389 2.18604C16.2825 2.18604 17.571 2.71976 18.521 3.66979C19.471 4.61982 20.0048 5.90835 20.0048 7.2519V9.03985Z"
                                    fill="#292929" />
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M23.6898 10.6489L24.6434 24.9525C24.6674 25.3188 24.616 25.6862 24.4924 26.0318C24.3688 26.3775 24.1756 26.6942 23.9249 26.9623C23.6741 27.2304 23.371 27.4442 23.0343 27.5905C22.6977 27.7369 22.3346 27.8127 21.9675 27.8132H7.90939C7.54218 27.813 7.17892 27.7375 6.84209 27.5913C6.50526 27.445 6.20204 27.2312 5.95119 26.963C5.70034 26.6948 5.5072 26.378 5.38374 26.0322C5.26028 25.6864 5.20912 25.3189 5.23342 24.9525L6.187 10.6489C6.23235 9.97006 6.534 9.33384 7.03086 8.86907C7.52771 8.40431 8.18262 8.14575 8.86296 8.14575H21.0139C21.6942 8.14575 22.3491 8.40431 22.846 8.86907C23.3428 9.33384 23.6445 9.97006 23.6898 10.6489ZM17.9017 13.4238C17.6351 13.984 17.2153 14.4571 16.6909 14.7884C16.1664 15.1197 15.5588 15.2955 14.9384 15.2955C14.3181 15.2955 13.7105 15.1197 13.186 14.7884C12.6615 14.4571 12.2417 13.984 11.9752 13.4238C11.9248 13.3177 11.854 13.2227 11.7668 13.144C11.6797 13.0653 11.5779 13.0045 11.4673 12.9652C11.3566 12.9258 11.2393 12.9086 11.1221 12.9146C11.0048 12.9206 10.8899 12.9496 10.7838 13C10.6778 13.0504 10.5827 13.1212 10.504 13.2084C10.4253 13.2955 10.3646 13.3973 10.3252 13.508C10.2859 13.6186 10.2687 13.7359 10.2747 13.8532C10.2807 13.9704 10.3097 14.0854 10.3601 14.1914C10.7706 15.0583 11.4188 15.7908 12.2293 16.3037C13.0398 16.8166 13.9793 17.0889 14.9384 17.0889C15.8976 17.0889 16.837 16.8166 17.6475 16.3037C18.458 15.7908 19.1062 15.0583 19.5168 14.1914C19.5672 14.0854 19.5962 13.9704 19.6022 13.8532C19.6082 13.7359 19.591 13.6186 19.5516 13.508C19.5123 13.3973 19.4515 13.2955 19.3728 13.2084C19.2942 13.1212 19.1991 13.0504 19.093 13C18.987 12.9496 18.872 12.9206 18.7548 12.9146C18.6375 12.9086 18.5202 12.9258 18.4096 12.9652C18.2989 13.0045 18.1972 13.0653 18.11 13.144C18.0229 13.2226 17.9521 13.3177 17.9017 13.4238Z"
                                    fill="#292929" />
                            </svg>

                            <div
                                class="position-absolute product-count-badge count-product  badge rounded-pill bg-danger">

                            </div>

                        </button>
                    </div>
                </div>
            </nav>
            <div class="banner-section position-relative">
                <div class="banner-img">
                    <img src="{{ $whatsappStore->cover_url }}" class="w-100 h-100 object-fit-cover" alt="banner" />
                </div>
            </div>
            <div class="category-section px-50 pt-30 position-relative">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-30">
                    <div class="section-heading mb-0">
                        <h2 class="position-relative mb-0">
                            {{ __('messages.whatsapp_stores_templates.choos_your_category') }}</h2>
                    </div>

                </div>
                @if ($whatsappStore->categories->count() > 0)
                    <div class="category-slider">
                        @foreach ($whatsappStore->categories as $category)
                            <a href="{{ route('whatsapp.store.products', ['alias' => $whatsappStore->url_alias, 'category' => $category->id]) }}"
                                style="color: #212529">
                                <div>
                                    <div class="category-box mx-auto">
                                        <div class="category-img h-100 w-100 mb-20 mx-auto">
                                            <img src="{{ $category->image_url ?? '' }}" alt="images"
                                                class="h-100 w-100 object-fit-cover" />
                                        </div>
                                        <p class="fs-20 fw-5 text-center lh-sm mb-0 text-black">{{ $category->name }}
                                        </p>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
                @if ($whatsappStore->categories->count() == 0)
                    <div class="d-flex justify-content-center mb-5 mt-3">
                        <h3 class="fs-20 fw-6 mb-0">
                            {{ __('messages.whatsapp_stores_templates.category_not_found') }}</h3>
                    </div>
                @endif
            </div>
            <div class="product-section px-50 pt-30 position-relative">
                <div class="section-heading">
                    <h2 class="mb-0">{{ __('messages.whatsapp_stores_templates.choose_your_product') }}</h2>
                </div>
                <div class="mb-50 product-list-section">

                    <div class="row row-gap-4 ">

                        @foreach ($whatsappStore->products()->latest()->take(8)->get() as $product)
                            <div class="col-xl-3 col-lg-4 col-sm-6 product-box-section bg-white">
                                <div class="h-100 flex-column justify-content-between d-flex">
                                    <a href="{{ route('whatsapp.store.product.details', [$whatsappStore->url_alias, $product->id]) }}"
                                        class="d-flex text-black flex-column justify-content-between product-card">
                                        <div class="product-img w-100 h-100 mb-10 mx-auto">
                                            <img src="{{ $product->images_url[0] ?? '' }}" alt="product"
                                                class="w-100 h-100 object-fit-cover product-image" />
                                        </div>
                                        <div class="product-details h-100">
                                            <div class="d-flex flex-column h-100">
                                                <div>
                                                    <div class="d-flex gap-2  mb-10 ">
                                                        <h5 class="fs-20 fw-6 mb-0 w-75 product-name">
                                                            {{ $product->name }}</h5>

                                                    </div>
                                                    <p class="fs-14 fw-5 mb-2 text-gray-200 lh-sm product-category">
                                                        {{ $product->category->name }}</p>
                                                    <p class="fs-18 fw-7 lh-sm mb-10">
                                                        <span class="currency_icon">
                                                            {{ $product->currency->currency_icon }}</span>
                                                        <span
                                                            class="selling_price">{{ $product->selling_price }}</span>
                                                        @if ($product->net_price)
                                                            <del class="fs-14 fw-7 text-gray-200">{{ $product->currency->currency_icon }}
                                                                {{ $product->net_price }}</del>
                                                        @endif
                                                    </p>
                                                    <input type="hidden" value="{{ $product->available_stock }}"
                                                        class="available-stock">
                                                </div>

                                            </div>
                                        </div>
                                    </a>
                                    <div class="d-flex justify-content-center">
                                        <button
                                            class="@if ($product->available_stock == 0) disabled @endif btn btn-primary d-flex gap-2 align-items-center fs-14 fw-6 addToCartBtn addToCartButton add-to-cart-min-w-142px"
                                            data-id="{{ $product->id }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25"
                                                viewBox="0 0 31 30" fill="none">
                                                <path
                                                    d="M10.8571 8.64281C10.8571 6.07855 12.9356 4 15.4999 4C18.0641 4 20.1427 6.07855 20.1427 8.64281C20.1427 8.83225 20.0674 9.01393 19.9335 9.14788C19.7995 9.28184 19.6178 9.35709 19.4284 9.35709C19.239 9.35709 19.0573 9.28184 18.9233 9.14788C18.7894 9.01393 18.7141 8.83225 18.7141 8.64281C18.7141 7.79034 18.3755 6.97278 17.7727 6.36999C17.1699 5.7672 16.3523 5.42856 15.4999 5.42856C14.6474 5.42856 13.8298 5.7672 13.227 6.36999C12.6243 6.97278 12.2856 7.79034 12.2856 8.64281C12.2856 8.83225 12.2104 9.01393 12.0764 9.14788C11.9425 9.28184 11.7608 9.35709 11.5713 9.35709C11.3819 9.35709 11.2002 9.28184 11.0663 9.14788C10.9323 9.01393 10.8571 8.83225 10.8571 8.64281ZM16.2141 15.0713C16.2141 14.8819 16.1389 14.7002 16.0049 14.5662C15.871 14.4323 15.6893 14.357 15.4999 14.357C15.3104 14.357 15.1287 14.4323 14.9948 14.5662C14.8608 14.7002 14.7856 14.8819 14.7856 15.0713V17.2142H12.6428C12.4533 17.2142 12.2716 17.2894 12.1377 17.4234C12.0037 17.5573 11.9285 17.739 11.9285 17.9284C11.9285 18.1179 12.0037 18.2996 12.1377 18.4335C12.2716 18.5675 12.4533 18.6427 12.6428 18.6427H14.7856V20.7855C14.7856 20.975 14.8608 21.1567 14.9948 21.2906C15.1287 21.4246 15.3104 21.4998 15.4999 21.4998C15.6893 21.4998 15.871 21.4246 16.0049 21.2906C16.1389 21.1567 16.2141 20.975 16.2141 20.7855V18.6427H18.357C18.5464 18.6427 18.7281 18.5675 18.8621 18.4335C18.996 18.2996 19.0713 18.1179 19.0713 17.9284C19.0713 17.739 18.996 17.5573 18.8621 17.4234C18.7281 17.2894 18.5464 17.2142 18.357 17.2142H16.2141V15.0713Z"
                                                    fill="currentColor" />
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M7.00281 12.6614C7.10921 11.9891 7.45206 11.3768 7.96967 10.9348C8.48728 10.4927 9.14566 10.2499 9.82635 10.25H21.173C21.8538 10.2498 22.5122 10.4926 23.0299 10.9346C23.5476 11.3767 23.8905 11.989 23.9969 12.6614L25.4644 21.947C25.7383 23.682 24.3962 25.2499 22.6405 25.2499H8.35922C6.60352 25.2499 5.2614 23.682 5.53568 21.947L7.00281 12.6614ZM9.82635 11.6786C9.48591 11.6784 9.15661 11.7998 8.89768 12.0208C8.63875 12.2419 8.46719 12.548 8.41386 12.8843L6.94638 22.1699C6.91421 22.3739 6.92667 22.5825 6.9829 22.7813C7.03913 22.9801 7.1378 23.1643 7.27209 23.3213C7.40638 23.4783 7.57312 23.6043 7.7608 23.6906C7.94848 23.7769 8.15264 23.8215 8.35922 23.8213H22.6405C22.8471 23.8214 23.0512 23.7768 23.2389 23.6905C23.4265 23.6041 23.5932 23.4781 23.7275 23.3212C23.8618 23.1642 23.9604 22.98 24.0167 22.7813C24.0729 22.5825 24.0855 22.3739 24.0534 22.1699L22.5859 12.8843C22.5325 12.548 22.3609 12.2417 22.1019 12.0207C21.8429 11.7997 21.5135 11.6784 21.173 11.6786H9.82635Z"
                                                    fill="currentColor" />
                                            </svg>
                                            {{ __('messages.whatsapp_stores_templates.add_to_cart') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        @if ($whatsappStore->products->count() == 0)
                            <div class="text-center mb-5 mt-3">
                                <h3 class="fs-20 fw-6 mb-0 text-break">
                                    {{ __('messages.whatsapp_stores_templates.product_not_found') }}</h3>
                            </div>
                        @endif
                    </div>

                </div>


                @if ($whatsappStore->products->count() > 0)
                    <div class="text-center mb-3 mb-sm-4 mb-lg-5">
                        <a href="{{ route('whatsapp.store.products', $whatsappStore->url_alias) }}"
                            class="btn view-more-btn d-flex align-items-center justify-content-center mx-auto gap-20 fs-16 fw-medium">
                            <span class="text">{{ __('messages.whatsapp_stores_templates.view_more') }}</span>
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25"
                                    viewBox="0 0 25 25" fill="none">
                                    <g clip-path="url(#clip0_410_200)">
                                        <path
                                            d="M0.976545 11.5234H21.6581L18.2321 8.11406C17.8498 7.73359 17.8484 7.11528 18.2288 6.733C18.6093 6.35068 19.2277 6.34926 19.6099 6.72968L24.7127 11.8078L24.7136 11.8087C25.0949 12.1892 25.0961 12.8095 24.7137 13.1913L24.7128 13.1922L19.61 18.2703C19.2278 18.6507 18.6095 18.6494 18.2289 18.267C17.8485 17.8847 17.8499 17.2664 18.2322 16.8859L21.6581 13.4766H0.976545C0.437189 13.4766 -1.71661e-05 13.0394 -1.71661e-05 12.5C-1.71661e-05 11.9606 0.437189 11.5234 0.976545 11.5234Z"
                                            fill="currentColor" />
                                    </g>
                                    <defs>
                                        <clippath id="clip0_410_200">
                                            <rect width="25" height="25" fill="currentColor"
                                                transform="matrix(-1 0 0 1 25 0)" />
                                        </clippath>
                                    </defs>
                                </svg>
                            </span>
                        </a>
                    </div>
                @endif
                {{-- Business Hours section --}}
                @if ($business_hours == true)
                @if ($whatsappStore->businessHours->count())
                <div class="businesshour-section">
                    <div class="section-heading">
                        <h2 class="mb-0">{{ __('messages.business.business_hours') }}</h2>
                    </div>
                    <div class="row row-gap-3">
                        @php
                            $todayWeekName = strtolower(\Carbon\Carbon::now()->rawFormat('D'));
                        @endphp

                        @foreach ($businessDaysTime as $key => $dayTime)
                            <div class="col-xl-3 col-lg-4 col-md-6">
                                <div class="businesshour-item d-flex gap-2 align-items-center flex-column">
                                    <div class="time-icons d-flex align-items-center justify-content-center">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-calendar-time text-white" width="24" height="24"
                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M11.795 21h-6.795a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v4"></path>
                                            <path d="M18 18m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                                            <path d="M15 3v4"></path>
                                            <path d="M7 3v4"></path>
                                            <path d="M3 11h16"></path>
                                            <path d="M18 16.496v1.504l1 1"></path>
                                        </svg>
                                    </div>
                                    <div class="businesshour-content d-flex gap-2 gap-xl-1 gap-xxl-2 align-items-center">
                                        <h3 class="fs-14 fw-5 mb-0 text-break">{{ __('messages.business.' .
                                            \App\Models\BusinessHour::DAY_OF_WEEK[$key]) }}:</h3>
                                        <p class="fs-16 fw-6 mb-0 text-break">
                                            {{ $dayTime ?? __('messages.common.closed') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
                @endif
            </div>
        </div>
        <div>

        {{-- Sticky Bar Button --}}
        @php
            $shareUrl = $whatsappStoreUrl;
        @endphp
        <div class="btn-section cursor-pointer @if (getLanguage($whatsappStore->default_language) == 'Arabic') rtl @endif">
            <div class="fixed-btn-section">
                @if (empty($whatsappStore->hide_stickybar))
                    <div class="bars-btn whatsapp-store-bars-btn">
                        <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M15.4135 0.540405H22.4891C23.5721 0.540405 24.4602 1.42855 24.4602 2.51152V9.58713C24.4602 10.6773 23.5732 11.5582 22.4891 11.5582H15.4135C14.3223 11.5582 13.4424 10.6783 13.4424 9.58713V2.51152C13.4424 1.42746 14.3234 0.540405 15.4135 0.540405Z"
                                stroke="#ffffff" />
                            <path
                                d="M2.97143 0.5H8.74589C10.1129 0.5 11.2173 1.6122 11.2173 2.97143V8.74589C11.2173 10.1139 10.1139 11.2173 8.74589 11.2173H2.97143C1.6122 11.2173 0.5 10.1129 0.5 8.74589V2.97143C0.5 1.61328 1.61328 0.5 2.97143 0.5Z"
                                stroke="#ffffff" />
                            <path
                                d="M2.97143 13.7828H8.74589C10.1139 13.7828 11.2173 14.8862 11.2173 16.2543V22.0287C11.2173 23.388 10.1129 24.5002 8.74589 24.5002H2.97143C1.61328 24.5002 0.5 23.3869 0.5 22.0287V16.2543C0.5 14.8873 1.6122 13.7828 2.97143 13.7828Z"
                                stroke="#ffffff" />
                            <path
                                d="M16.2537 13.7828H22.0281C23.3873 13.7828 24.4995 14.8873 24.4995 16.2543V22.0287C24.4995 23.3869 23.3863 24.5002 22.0281 24.5002H16.2537C14.8867 24.5002 13.7822 23.388 13.7822 22.0287V16.2543C13.7822 14.8862 14.8856 13.7828 16.2537 13.7828Z"
                                stroke="#ffffff" />
                        </svg>
                    </div>
                @endif
                <div class="sub-btn d-none">
                    <div class="sub-btn-div @if (getLanguage($whatsappStore->default_language) == 'Arabic') sub-btn-div-left @endif">
                        @if (empty($whatsappStore->hide_stickybar))
                            <div class="stickyIcon">
                                <button type="button"
                                    class="whatsapp-store-btn-group whatsapp-store-share whatsapp-store-sticky-btn mb-3 px-2 py-1">
                                    <i class="fas fa-share-alt fs-4 pt-0"></i>
                                </button>
                                @if (!empty($whatsappStore->enable_download_qr_code))
                                    <div class="qr-code-image d-none">
                                        {!! QrCode::size($whatsappStore->qr_code_download_size ?? 200)->format('svg')->generate($shareUrl) !!}
                                    </div>
                                    <a type="button"
                                        class="whatsapp-store-btn-group whatsapp-store-sticky-btn d-flex justify-content-center align-items-center text-decoration-none px-2 mb-3 py-2 whatsapp-store-qr-code-btn"
                                        title="{{ __('messages.vcard.qr_code') }}"
                                        download="whatsapp_store_qr_code.png">
                                        <i class="fa-solid fa-qrcode fs-4"></i>
                                    </a>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>


        {{-- share modal code --}}
        <div id="whatsapp-store-shareModel" class="modal fade" role="dialog" style="z-index: 9999;">
            <div class="modal-dialog modal-dialog-centered" style="max-width: 500px;">
                <div class="modal-content" @if (getLanguage($whatsappStore->default_language) == 'Arabic') dir="rtl" @endif>
                    <div class="">
                        <div class="row align-items-center mt-3">
                            <div class="col-10 text-center">
                                <h5 class="modal-title pl-50">{{ __('messages.whatsapp_stores.share_my_whatsapp_store') }}</h5>
                            </div>
                            <div class="col-2 p-0">
                                <button type="button" aria-label="Close"
                                    class="p-3 btn btn-sm btn-icon btn-active-color-danger border-none"
                                    data-bs-dismiss="modal">
                                    <span class="svg-icon svg-icon-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px"
                                            viewBox="0 0 24 24" version="1.1">
                                            <g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)"
                                                fill="#000000">
                                                <rect fill="#000000" x="0" y="7" width="16" height="2"
                                                    rx="1" />
                                                <rect fill="#000000" opacity="0.5"
                                                    transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000)"
                                                    x="0" y="7" width="16" height="2" rx="1" />
                                            </g>
                                        </svg>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="modal-body p-2">
                        <a href="http://www.facebook.com/sharer.php?u={{ $shareUrl }}" target="_blank"
                            class="text-decoration-none share" title="Facebook">
                            <div class="row">
                                <div class="col-2">
                                    <i class="fab fa-facebook fa-2x" style="color: #1B95E0"></i>
                                </div>
                                <div class="col-9 p-1">
                                    <p class="align-items-center text-dark fw-bolder">
                                        {{ __('messages.social.Share_on_facebook') }}</p>
                                </div>
                                <div class="col-1 p-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="arrow" version="1.0"
                                        height="16px" viewBox="0 0 512.000000 512.000000"
                                        preserveAspectRatio="xMidYMid meet">
                                        <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"
                                            fill="#000000" stroke="none">
                                            <path
                                                d="M1277 4943 l-177 -178 1102 -1102 1103 -1103 -1103 -1103 -1102 -1102 178 -178 177 -177 1280 1280 1280 1280 -1280 1280 -1280 1280 -178 -177z" />
                                        </g>
                                    </svg>
                                </div>
                            </div>
                        </a>
                        <a href="http://twitter.com/share?url={{ $shareUrl }}&text={{ $whatsappStore->name }}&hashtags=sharebuttons"
                            target="_blank" class="text-decoration-none share" title="Twitter">
                            <div class="row">
                                <div class="col-2">
                                    <span><svg xmlns="http://www.w3.org/2000/svg" height="2em"
                                            viewBox="0 0 512 512">
                                            <path
                                                d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z" />
                                        </svg></span>
                                </div>
                                <div class="col-9 p-1">
                                    <p class="align-items-center text-dark fw-bolder">
                                        {{ __('messages.social.Share_on_twitter') }}</p>
                                </div>
                                <div class="col-1 p-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="arrow" version="1.0"
                                        height="16px" viewBox="0 0 512.000000 512.000000"
                                        preserveAspectRatio="xMidYMid meet">
                                        <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"
                                            fill="#000000" stroke="none">
                                            <path
                                                d="M1277 4943 l-177 -178 1102 -1102 1103 -1103 -1103 -1103 -1102 -1102 178 -178 177 -177 1280 1280 1280 1280 -1280 1280 -1280 1280 -178 -177z" />
                                        </g>
                                    </svg>
                                </div>
                            </div>
                        </a>
                        <a href="http://www.linkedin.com/shareArticle?mini=true&url={{ $shareUrl }}"
                            target="_blank" class="text-decoration-none share" title="Linkedin">
                            <div class="row">
                                <div class="col-2">
                                    <i class="fab fa-linkedin fa-2x" style="color: #1B95E0"></i>
                                </div>
                                <div class="col-9 p-1">
                                    <p class="align-items-center text-dark fw-bolder">
                                        {{ __('messages.social.Share_on_linkedin') }}</p>
                                </div>
                                <div class="col-1 p-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="arrow" version="1.0"
                                        height="16px" viewBox="0 0 512.000000 512.000000"
                                        preserveAspectRatio="xMidYMid meet">
                                        <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"
                                            fill="#000000" stroke="none">
                                            <path
                                                d="M1277 4943 l-177 -178 1102 -1102 1103 -1103 -1103 -1103 -1102 -1102 178 -178 177 -177 1280 1280 1280 1280 -1280 1280 -1280 1280 -178 -177z" />
                                        </g>
                                    </svg>
                                </div>
                            </div>
                        </a>
                        <a href="mailto:?Subject=&Body={{ $shareUrl }}" target="_blank"
                            class="text-decoration-none share" title="Email">
                            <div class="row">
                                <div class="col-2">
                                    <i class="fas fa-envelope fa-2x" style="color: #191a19  "></i>
                                </div>
                                <div class="col-9 p-1">
                                    <p class="align-items-center text-dark fw-bolder">
                                        {{ __('messages.social.Share_on_email') }}</p>
                                </div>
                                <div class="col-1 p-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="arrow" version="1.0"
                                        height="16px" viewBox="0 0 512.000000 512.000000"
                                        preserveAspectRatio="xMidYMid meet">
                                        <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"
                                            fill="#000000" stroke="none">
                                            <path
                                                d="M1277 4943 l-177 -178 1102 -1102 1103 -1103 -1103 -1103 -1102 -1102 178 -178 177 -177 1280 1280 1280 1280 -1280 1280 -1280 1280 -178 -177z" />
                                        </g>
                                    </svg>
                                </div>
                            </div>
                        </a>
                        <a href="http://pinterest.com/pin/create/link/?url={{ $shareUrl }}" target="_blank"
                            class="text-decoration-none share" title="Pinterest">
                            <div class="row">
                                <div class="col-2">
                                    <i class="fab fa-pinterest fa-2x" style="color: #bd081c"></i>
                                </div>
                                <div class="col-9 p-1">
                                    <p class="align-items-center text-dark fw-bolder">
                                        {{ __('messages.social.Share_on_pinterest') }}</p>
                                </div>
                                <div class="col-1 p-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="arrow" version="1.0"
                                        height="16px" viewBox="0 0 512.000000 512.000000"
                                        preserveAspectRatio="xMidYMid meet">
                                        <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"
                                            fill="#000000" stroke="none">
                                            <path
                                                d="M1277 4943 l-177 -178 1102 -1102 1103 -1103 -1103 -1103 -1102 -1102 178 -178 177 -177 1280 1280 1280 1280 -1280 1280 -1280 1280 -178 -177z" />
                                        </g>
                                    </svg>
                                </div>
                            </div>
                        </a>
                        <a href="http://reddit.com/submit?url={{ $shareUrl }}&title={{ $whatsappStore->name }}"
                            target="_blank" class="text-decoration-none share" title="Reddit">
                            <div class="row">
                                <div class="col-2">
                                    <i class="fab fa-reddit fa-2x" style="color: #ff4500"></i>
                                </div>
                                <div class="col-9 p-1">
                                    <p class="align-items-center text-dark fw-bolder">
                                        {{ __('messages.social.Share_on_reddit') }}</p>
                                </div>
                                <div class="col-1 p-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="arrow" version="1.0"
                                        height="16px" viewBox="0 0 512.000000 512.000000"
                                        preserveAspectRatio="xMidYMid meet">
                                        <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"
                                            fill="#000000" stroke="none">
                                            <path
                                                d="M1277 4943 l-177 -178 1102 -1102 1103 -1103 -1103 -1103 -1102 -1102 178 -178 177 -177 1280 1280 1280 1280 -1280 1280 -1280 1280 -178 -177z" />
                                        </g>
                                    </svg>
                                </div>
                            </div>
                        </a>
                        <a href="https://wa.me/?text={{ $shareUrl }}" target="_blank"
                            class="text-decoration-none share" title="Whatsapp">
                            <div class="row">
                                <div class="col-2">
                                    <i class="fab fa-whatsapp fa-2x" style="color: limegreen"></i>
                                </div>
                                <div class="col-9 p-1">
                                    <p class="align-items-center text-dark fw-bolder">
                                        {{ __('messages.social.Share_on_whatsapp') }}</p>
                                </div>
                                <div class="col-1 p-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="arrow" version="1.0"
                                        height="16px" viewBox="0 0 512.000000 512.000000"
                                        preserveAspectRatio="xMidYMid meet">
                                        <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"
                                            fill="#000000" stroke="none">
                                            <path
                                                d="M1277 4943 l-177 -178 1102 -1102 1103 -1103 -1103 -1103 -1102 -1102 178 -178 177 -177 1280 1280 1280 1280 -1280 1280 -1280 1280 -178 -177z" />
                                        </g>
                                    </svg>
                                </div>
                            </div>
                        </a>
                        <a href="https://www.snapchat.com/scan?attachmentUrl={{ $shareUrl }}"
                            target="_blank" class="text-decoration-none share" title="Snapchat">
                            <div class="row">
                                <div class="col-2">
                                    <svg width="30px" height="30px" viewBox="147.353 39.286 514.631 514.631"
                                        version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve"
                                        fill="#000000">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                            stroke-linejoin="round">
                                        </g>
                                        <g id="SVGRepo_iconCarrier">
                                            <path style="fill:#FFFC00;"
                                                d="M147.553,423.021v0.023c0.308,11.424,0.403,22.914,2.33,34.268 c2.042,12.012,4.961,23.725,10.53,34.627c7.529,14.756,17.869,27.217,30.921,37.396c9.371,7.309,19.608,13.111,30.94,16.771 c16.524,5.33,33.571,7.373,50.867,7.473c10.791,0.068,21.575,0.338,32.37,0.293c78.395-0.33,156.792,0.566,235.189-0.484 c10.403-0.141,20.636-1.41,30.846-3.277c19.569-3.582,36.864-11.932,51.661-25.133c17.245-15.381,28.88-34.205,34.132-56.924 c3.437-14.85,4.297-29.916,4.444-45.035v-3.016c0-1.17-0.445-256.892-0.486-260.272c-0.115-9.285-0.799-18.5-2.54-27.636 c-2.117-11.133-5.108-21.981-10.439-32.053c-5.629-10.641-12.68-20.209-21.401-28.57c-13.359-12.81-28.775-21.869-46.722-26.661 c-16.21-4.327-32.747-5.285-49.405-5.27c-0.027-0.004-0.09-0.173-0.094-0.255H278.56c-0.005,0.086-0.008,0.172-0.014,0.255 c-9.454,0.173-18.922,0.102-28.328,1.268c-10.304,1.281-20.509,3.21-30.262,6.812c-15.362,5.682-28.709,14.532-40.11,26.347 c-12.917,13.386-22.022,28.867-26.853,46.894c-4.31,16.084-5.248,32.488-5.271,49.008">
                                            </path>
                                            <path style="fill:#FFFFFF;"
                                                d="M407.001,473.488c-1.068,0-2.087-0.039-2.862-0.076c-0.615,0.053-1.25,0.076-1.886,0.076 c-22.437,0-37.439-10.607-50.678-19.973c-9.489-6.703-18.438-13.031-28.922-14.775c-5.149-0.854-10.271-1.287-15.22-1.287 c-8.917,0-15.964,1.383-21.109,2.389c-3.166,0.617-5.896,1.148-8.006,1.148c-2.21,0-4.895-0.49-6.014-4.311 c-0.887-3.014-1.523-5.934-2.137-8.746c-1.536-7.027-2.65-11.316-5.281-11.723c-28.141-4.342-44.768-10.738-48.08-18.484 c-0.347-0.814-0.541-1.633-0.584-2.443c-0.129-2.309,1.501-4.334,3.777-4.711c22.348-3.68,42.219-15.492,59.064-35.119 c13.049-15.195,19.457-29.713,20.145-31.316c0.03-0.072,0.065-0.148,0.101-0.217c3.247-6.588,3.893-12.281,1.926-16.916 c-3.626-8.551-15.635-12.361-23.58-14.882c-1.976-0.625-3.845-1.217-5.334-1.808c-7.043-2.782-18.626-8.66-17.083-16.773 c1.124-5.916,8.949-10.036,15.273-10.036c1.756,0,3.312,0.308,4.622,0.923c7.146,3.348,13.575,5.045,19.104,5.045 c6.876,0,10.197-2.618,11-3.362c-0.198-3.668-0.44-7.546-0.674-11.214c0-0.004-0.005-0.048-0.005-0.048 c-1.614-25.675-3.627-57.627,4.546-75.95c24.462-54.847,76.339-59.112,91.651-59.112c0.408,0,6.674-0.062,6.674-0.062 c0.283-0.005,0.59-0.009,0.908-0.009c15.354,0,67.339,4.27,91.816,59.15c8.173,18.335,6.158,50.314,4.539,76.016l-0.076,1.23 c-0.222,3.49-0.427,6.793-0.6,9.995c0.756,0.696,3.795,3.096,9.978,3.339c5.271-0.202,11.328-1.891,17.998-5.014 c2.062-0.968,4.345-1.169,5.895-1.169c2.343,0,4.727,0.456,6.714,1.285l0.106,0.041c5.66,2.009,9.367,6.024,9.447,10.242 c0.071,3.932-2.851,9.809-17.223,15.485c-1.472,0.583-3.35,1.179-5.334,1.808c-7.952,2.524-19.951,6.332-23.577,14.878 c-1.97,4.635-1.322,10.326,1.926,16.912c0.036,0.072,0.067,0.145,0.102,0.221c1,2.344,25.205,57.535,79.209,66.432 c2.275,0.379,3.908,2.406,3.778,4.711c-0.048,0.828-0.248,1.656-0.598,2.465c-3.289,7.703-19.915,14.09-48.064,18.438 c-2.642,0.408-3.755,4.678-5.277,11.668c-0.63,2.887-1.271,5.717-2.146,8.691c-0.819,2.797-2.641,4.164-5.567,4.164h-0.441 c-1.905,0-4.604-0.346-8.008-1.012c-5.95-1.158-12.623-2.236-21.109-2.236c-4.948,0-10.069,0.434-15.224,1.287 c-10.473,1.744-19.421,8.062-28.893,14.758C444.443,462.88,429.436,473.488,407.001,473.488">
                                            </path>
                                            <path style="fill:#020202;"
                                                d="M408.336,124.235c14.455,0,64.231,3.883,87.688,56.472c7.724,17.317,5.744,48.686,4.156,73.885 c-0.248,3.999-0.494,7.875-0.694,11.576l-0.084,1.591l1.062,1.185c0.429,0.476,4.444,4.672,13.374,5.017l0.144,0.008l0.15-0.003 c5.904-0.225,12.554-2.059,19.776-5.442c1.064-0.498,2.48-0.741,3.978-0.741c1.707,0,3.521,0.321,5.017,0.951l0.226,0.09 c3.787,1.327,6.464,3.829,6.505,6.093c0.022,1.28-0.935,5.891-14.359,11.194c-1.312,0.518-3.039,1.069-5.041,1.7 c-8.736,2.774-21.934,6.96-26.376,17.427c-2.501,5.896-1.816,12.854,2.034,20.678c1.584,3.697,26.52,59.865,82.631,69.111 c-0.011,0.266-0.079,0.557-0.229,0.9c-0.951,2.24-6.996,9.979-44.612,15.783c-5.886,0.902-7.328,7.5-9,15.17 c-0.604,2.746-1.218,5.518-2.062,8.381c-0.258,0.865-0.306,0.914-1.233,0.914c-0.128,0-0.278,0-0.442,0 c-1.668,0-4.2-0.346-7.135-0.922c-5.345-1.041-12.647-2.318-21.982-2.318c-5.21,0-10.577,0.453-15.962,1.352 c-11.511,1.914-20.872,8.535-30.786,15.543c-13.314,9.408-27.075,19.143-48.071,19.143c-0.917,0-1.812-0.031-2.709-0.076 l-0.236-0.01l-0.237,0.018c-0.515,0.045-1.034,0.068-1.564,0.068c-20.993,0-34.76-9.732-48.068-19.143 c-9.916-7.008-19.282-13.629-30.791-15.543c-5.38-0.896-10.752-1.352-15.959-1.352c-9.333,0-16.644,1.428-21.978,2.471 c-2.935,0.574-5.476,1.066-7.139,1.066c-1.362,0-1.388-0.08-1.676-1.064c-0.844-2.865-1.461-5.703-2.062-8.445 c-1.676-7.678-3.119-14.312-9.002-15.215c-37.613-5.809-43.659-13.561-44.613-15.795c-0.149-0.352-0.216-0.652-0.231-0.918 c56.11-9.238,81.041-65.408,82.63-69.119c3.857-7.818,4.541-14.775,2.032-20.678c-4.442-10.461-17.638-14.653-26.368-17.422 c-2.007-0.635-3.735-1.187-5.048-1.705c-11.336-4.479-14.823-8.991-14.305-11.725c0.601-3.153,6.067-6.359,10.837-6.359 c1.072,0,2.012,0.173,2.707,0.498c7.747,3.631,14.819,5.472,21.022,5.472c9.751,0,14.091-4.537,14.557-5.055l1.057-1.182 l-0.085-1.583c-0.197-3.699-0.44-7.574-0.696-11.565c-1.583-25.205-3.563-56.553,4.158-73.871 c23.37-52.396,72.903-56.435,87.525-56.435c0.36,0,6.717-0.065,6.717-0.065C407.744,124.239,408.033,124.235,408.336,124.235 M408.336,115.197h-0.017c-0.333,0-0.646,0-0.944,0.004c-2.376,0.024-6.282,0.062-6.633,0.066c-8.566,0-25.705,1.21-44.115,9.336 c-10.526,4.643-19.994,10.921-28.14,18.66c-9.712,9.221-17.624,20.59-23.512,33.796c-8.623,19.336-6.576,51.905-4.932,78.078 l0.006,0.041c0.176,2.803,0.361,5.73,0.53,8.582c-1.265,0.581-3.316,1.194-6.339,1.194c-4.864,0-10.648-1.555-17.187-4.619 c-1.924-0.896-4.12-1.349-6.543-1.349c-3.893,0-7.997,1.146-11.557,3.239c-4.479,2.63-7.373,6.347-8.159,10.468 c-0.518,2.726-0.493,8.114,5.492,13.578c3.292,3.008,8.128,5.782,14.37,8.249c1.638,0.645,3.582,1.261,5.641,1.914 c7.145,2.271,17.959,5.702,20.779,12.339c1.429,3.365,0.814,7.793-1.823,13.145c-0.069,0.146-0.138,0.289-0.201,0.439 c-0.659,1.539-6.807,15.465-19.418,30.152c-7.166,8.352-15.059,15.332-23.447,20.752c-10.238,6.617-21.316,10.943-32.923,12.855 c-4.558,0.748-7.813,4.809-7.559,9.424c0.078,1.33,0.39,2.656,0.931,3.939c0.004,0.008,0.009,0.016,0.013,0.023 c1.843,4.311,6.116,7.973,13.063,11.203c8.489,3.943,21.185,7.26,37.732,9.855c0.836,1.59,1.704,5.586,2.305,8.322 c0.629,2.908,1.285,5.898,2.22,9.074c1.009,3.441,3.626,7.553,10.349,7.553c2.548,0,5.478-0.574,8.871-1.232 c4.969-0.975,11.764-2.305,20.245-2.305c4.702,0,9.575,0.414,14.48,1.229c9.455,1.574,17.606,7.332,27.037,14 c13.804,9.758,29.429,20.803,53.302,20.803c0.651,0,1.304-0.021,1.949-0.066c0.789,0.037,1.767,0.066,2.799,0.066 c23.88,0,39.501-11.049,53.29-20.799l0.022-0.02c9.433-6.66,17.575-12.41,27.027-13.984c4.903-0.814,9.775-1.229,14.479-1.229 c8.102,0,14.517,1.033,20.245,2.15c3.738,0.736,6.643,1.09,8.872,1.09l0.218,0.004h0.226c4.917,0,8.53-2.699,9.909-7.422 c0.916-3.109,1.57-6.029,2.215-8.986c0.562-2.564,1.46-6.674,2.296-8.281c16.558-2.6,29.249-5.91,37.739-9.852 c6.931-3.215,11.199-6.873,13.053-11.166c0.556-1.287,0.881-2.621,0.954-3.979c0.261-4.607-2.999-8.676-7.56-9.424 c-51.585-8.502-74.824-61.506-75.785-63.758c-0.062-0.148-0.132-0.295-0.205-0.438c-2.637-5.354-3.246-9.777-1.816-13.148 c2.814-6.631,13.621-10.062,20.771-12.332c2.07-0.652,4.021-1.272,5.646-1.914c7.039-2.78,12.07-5.796,15.389-9.221 c3.964-4.083,4.736-7.995,4.688-10.555c-0.121-6.194-4.856-11.698-12.388-14.393c-2.544-1.052-5.445-1.607-8.399-1.607 c-2.011,0-4.989,0.276-7.808,1.592c-6.035,2.824-11.441,4.368-16.082,4.588c-2.468-0.125-4.199-0.66-5.32-1.171 c0.141-2.416,0.297-4.898,0.458-7.486l0.067-1.108c1.653-26.19,3.707-58.784-4.92-78.134c-5.913-13.253-13.853-24.651-23.604-33.892 c-8.178-7.744-17.678-14.021-28.242-18.661C434.052,116.402,416.914,115.197,408.336,115.197">
                                            </path>
                                            <rect x="147.553" y="39.443" style="fill:none;" width="514.231"
                                                height="514.23"></rect>
                                        </g>
                                    </svg>
                                </div>
                                <div class="col-9 p-1">
                                    <p class="align-items-center text-dark fw-bolder">
                                        {{ __('messages.social.Share_on_snapchat') }}</p>
                                </div>
                                <div class="col-1 p-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="arrow" version="1.0"
                                        height="16px" viewBox="0 0 512.000000 512.000000"
                                        preserveAspectRatio="xMidYMid meet">
                                        <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"
                                            fill="#000000" stroke="none">
                                            <path
                                                d="M1277 4943 l-177 -178 1102 -1102 1103 -1103 -1103 -1103 -1102 -1102 178 -178 177 -177 1280 1280 1280 1280 -1280 1280 -1280 1280 -178 -177z" />
                                        </g>
                                    </svg>
                                </div>
                            </div>
                        </a>
                        <div class="col-12 justify-content-between social-link-modal">
                            <div class="input-group">
                                <input type="text" class="form-control"
                                    placeholder="{{ request()->fullUrl() }}" disabled>
                                <span id="whatsappStoreUrlCopy{{ $whatsappStore->id }}" class="d-none" target="_blank">
                                    {{ $whatsappStoreUrl }} </span>
                                <button class="copy-whatsapp-store-clipboard btn btn-dark" title="Copy Link"
                                    data-id="{{ $whatsappStore->id }}">
                                    <i class="fa-regular fa-copy fa-2x"></i>
                                </button>
                            </div>
                        </div>
                        <div class="text-center">

                        </div>
                    </div>
                </div>
            </div>
        </div>

            {{-- Newsletter Popup --}}
            @if ($whatsappStore->news_letter_popup)
                <div class="modal fade" id="newsLetterModal" tabindex="-1" aria-labelledby="newsLetterModalLabel" aria-hidden="true">
                    <div class="modal-dialog news-modal modal-dialog-centered">
                        <div class="modal-content animate-bottom" id="newsLetter-content">
                            <div class="newsmodal-header px-0 position-relative">
                                <button type="button" class="btn-close close-modal" data-bs-dismiss="modal"
                                    aria-label="Close" id="closeNewsLetterModal">
                                </button>
                            </div>
                            <div class="modal-body">
                                <h3 class="content newsmodal-title text-start mb-2">{{ __('messages.vcard.subscribe_newslatter') }}</h3>
                                <p class="modal-desc text-start">{{ __('messages.vcard.update_directly') }}</p>
                                <form action="" method="post" id="newsLetterForm">
                                    @csrf
                                    <input type="hidden" name="whatsapp_store_id" value="{{ $whatsappStore->id ?? '' }}">
                                    <div class="mb-3 d-flex gap-1 justify-content-center align-items-center email-input">
                                        <div class="w-100">
                                            <input type="email"
                                                class="email-input form-control bg-light border-dark text-dark w-100"
                                                placeholder="{{ __('messages.form.enter_your_email') }}"
                                                name="email" id="emailSubscription" aria-label="Email"
                                                aria-describedby="button-addon2">
                                        </div>
                                        <button class="btn ms-1" type="submit"
                                            id="email-send">{{ __('messages.subscribe') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if (isset($enable_pwa) && $enable_pwa == 1 && !isiOSDevice())
                <div class="mt-0">
                    <div class="pwa-support d-flex align-items-center justify-content-center">
                        <div>
                            <h1 class="text-start pwa-heading">{{ __('messages.pwa.add_to_home_screen') }}</h1>
                            <p class="text-start pwa-text text-dark fs-16 fw-5">
                                {{ __('messages.pwa.pwa_description') }} </p>
                            <div class="text-end d-flex">
                                <button id="installPwaBtn"
                                    class="pwa-install-button w-50 mb-1 btn">{{ __('messages.pwa.install') }}
                                </button>
                                <button
                                    class= "pwa-cancel-button w-50  pwa-close btn btn-secondary mb-1 {{ getLocalLanguage() == 'ar' ? 'me-2' : 'ms-2' }}">{{ __('messages.common.cancel') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @include('whatsapp_stores.templates.cloth_store.cart_modal')

            @include('whatsapp_stores.templates.order_modal')
            <footer>
                <div class="text-center fw-5 fs-16 fw-medium text-white">
                    <div class="mb-2">
                        <i class="fas fa-map-marker-alt"></i> {{ $whatsappStore->address }}
                    </div>
                    <div>
                        © Copyright {{ now()->year }} {{ env('APP_NAME') }}. All Rights Reserved.
                    </div>
                </div>
            </footer>
        </div>
    </div>
</body>
<script>
    @if ($whatsappStore->custom_js)
        {!! $whatsappStore->custom_js !!}
    @endif
</script>
<script>
    let vcardAlias = "{{ $whatsappStore->url_alias }}";
    let languageChange = "{{ url('whatsapp-stores/language') }}";
    let lang = "{{ checkLanguageSession($whatsappStore->url_alias) }}";
    let userlanguage = "{{ getLanguage($whatsappStore->default_language) }}"
    let isRtl = "{{ getLocalLanguage() == 'ar' ? 'true' : 'false' }}" === "true";
</script>
<script src="{{ asset('messages.js?$mixID') }}"></script>
<script src="{{ asset('assets/js/intl-tel-input/build/intlTelInput.js') }}"></script>
<script src="{{ asset('assets/js/vcard11/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/front-third-party-vcard11.js') }}"></script>
<script type="text/javascript" src="{{ asset('front/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ mix('assets/js/custom/helpers.js') }}"></script>
<script src="{{ asset('assets/js/slider/js/slick.min.js') }}" type="text/javascript"></script>
<script type="text/javascript" src="{{ mix('assets/js/whatsapp_store_template.js') }}"></script>
<script>
    $(document).ready(function() {
        $(".category-slider").slick({
            infinite: true,
            slidesToShow: 5,
            slidesToScroll: 1,
            // autoplay: true,
            rtl: isRtl,
            arrows: true,
            prevArrow: '<button class="slide-arrow category-arrow prev-arrow"><svg xmlns="http://www.w3.org/2000/svg" width="7" height="12" viewBox="0 0 7 12" fill="none"><path d="M2.61048 5.99881L2.52357 5.91829L2.61048 6.01208L6.74799 10.4776C6.74801 10.4776 6.74802 10.4777 6.74804 10.4777C6.89859 10.6459 6.98199 10.8714 6.98011 11.1056C6.97822 11.3398 6.89118 11.5637 6.73792 11.7291C6.58468 11.8945 6.37755 11.9882 6.16119 11.9902C5.94487 11.9922 5.7363 11.9025 5.58044 11.7401C5.58042 11.74 5.58039 11.74 5.58037 11.74L0.851898 6.63663C0.696935 6.46933 0.609765 6.24231 0.609765 6.00545C0.609765 5.76859 0.696935 5.54156 0.851899 5.37426L5.58049 0.270777C5.73548 0.103552 5.94549 0.00976553 6.1643 0.00976555C6.3831 0.00976557 6.59311 0.103552 6.7481 0.270777L6.7481 0.270775C6.90306 0.438075 6.99023 0.665102 6.99023 0.901961C6.99023 1.13882 6.90306 1.36585 6.7481 1.53315L2.61048 5.99881Z" stroke="#141414" stroke-width="0.0195312"/></svg></button>',
            nextArrow: '<button class="slide-arrow category-arrow next-arrow"><svg xmlns="http://www.w3.org/2000/svg" width="7" height="12" viewBox="0 0 7 12" fill="none"><path d="M4.38952 6.00119L4.47643 6.08171L4.38952 5.98792L0.252014 1.52238C0.251996 1.52236 0.251977 1.52234 0.251959 1.52232C0.101415 1.35406 0.0180061 1.12857 0.0198916 0.894392C0.0217773 0.660185 0.108825 0.43628 0.262083 0.270871C0.415319 0.105486 0.622448 0.0118285 0.838806 0.0098001C1.05513 0.00776977 1.2637 0.097502 1.41956 0.259938C1.41958 0.25996 1.41961 0.259983 1.41963 0.260006L6.1481 5.36337C6.30307 5.53067 6.39024 5.75769 6.39024 5.99455C6.39024 6.23141 6.30307 6.45844 6.1481 6.62574L1.41951 11.7292C1.26452 11.8964 1.05451 11.9902 0.835705 11.9902C0.616899 11.9902 0.406885 11.8964 0.251898 11.7292L0.2519 11.7292C0.0969359 11.5619 0.00976574 11.3349 0.00976578 11.098C0.00976582 10.8612 0.096936 10.6342 0.2519 10.4669L4.38952 6.00119Z" stroke="#2650D7" stroke-width="0.0195312"/></svg></button>',
            responsive: [
                {
                breakpoint: 991,
                settings: {
                    slidesToShow: 4,
                },
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 3,
                },
            },
            {
                breakpoint: 575,
                settings: {
                    arrows:false,
                    slidesToShow: 3,
                    dots: true,
                },
            },
            {
                breakpoint: 460,
                settings: {
                    slidesToShow: 2,
                    dots: true,
                    arrows:false,
                },
            }, {
                breakpoint: 360,
                settings: {
                    slidesToShow: 1,
                    dots: true,
                    arrows:false,
                },
            }, ],
        });
    });
</script>
<script>
    let deferredPrompt = null;
    window.addEventListener("beforeinstallprompt", (event) => {
        /* event.preventDefault(); */
        deferredPrompt = event;
        document.getElementById("installPwaBtn").style.display = "block";
    });
    document.getElementById("installPwaBtn").addEventListener("click", async () => {
        if (deferredPrompt) {
            deferredPrompt.prompt();
            await deferredPrompt.userChoice;
            deferredPrompt = null;
        }
    });
</script>
<script>
    let defaultCountryCodeValue = "{{ getSuperAdminSettingValue('default_country_code') }}"
</script>
<script>
    const getCookieUrl = "{{ route('whatsapp.store.getCookie') }}";
    const emailSubscriptionUrl = "{{ route('whatsapp.store.emailSubscriprion-store', ['alias' => $whatsappStore->url_alias]) }}";
</script>
</html>
