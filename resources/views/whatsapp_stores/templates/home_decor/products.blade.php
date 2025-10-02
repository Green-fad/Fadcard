<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <link rel="icon" href="{{ $whatsappStore->logo_url }}" type="image/png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('messages.whatsapp_stores_templates.product_listing') }} | {{ $whatsappStore->store_name }}</title>
    <link href="{{ asset('front/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ mix('assets/css/whatsappp_store/home_decor.css') }}" />
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

  {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
    integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" /> --}}

    @livewireStyles
</head>
<body>
  <div class="main-content mx-auto w-100 d-flex flex-column justify-content-between"
    @if (getLanguage($whatsappStore->default_language) == 'Arabic') dir="rtl" @endif>
    <div class="position-relative">
      <div class="position-sticky top-0 nav-top w-100 px-50 z-3">
        <nav class="navbar navbar-expand-lg w-100" id="header">
          <div class="container-fluid p-0">
            <div class="d-flex align-items-center gap-2 gap-sm-3">
              <a class="navbar-brand p-1 m-0" href="{{ route('whatsapp.store.show', $whatsappStore->url_alias) }}">
                <img src="{{ $whatsappStore->logo_url }}" alt="logo" class="w-100 h-100 object-fit-cover" />
              </a>
              <span class="fw-bold fs-18 text-black"><a
                    href="{{ route('whatsapp.store.show', $whatsappStore->url_alias) }}"
                    style="color: #212529 ">{{ $whatsappStore->store_name }}</a>
              </span>
            </div>
            {{-- language button --}}
              <div class="d-flex align-items-center gap-lg-4 gap-sm-3 gap-2">
                <div class="language-dropdown position-relative">
                  <button class="dropdown-btn position-relative text-black"
                    id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                    @if (array_key_exists(checkLanguageSession($whatsappStore->url_alias), \App\Models\User::FLAG))
                        <img class="flag" alt="flag"
                            src="{{ asset(\App\Models\User::FLAG[getLanguageIsoCode($whatsappStore->default_language) ?? 'en']) }}"
                            loading="lazy"/>
                    @endif
                    {{ strtoupper(getLanguageIsoCode($whatsappStore->default_language) ?? 'en') }}
                  </button>
                  <svg xmlns="http://www.w3.org/2000/svg" class="dropdown-arrow" width="30" height="30" viewBox="0 0 30 30" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M6.61626 10.3665C6.38192 10.6009 6.25027 10.9188 6.25027 11.2502C6.25027 11.5817 6.38192 11.8996 6.61626 12.134L14.1163 19.634C14.3507 19.8683 14.6686 20 15 20C15.3315 20 15.6493 19.8683 15.8838 19.634L23.3838 12.134C23.6115 11.8982 23.7375 11.5825 23.7346 11.2547C23.7318 10.927 23.6003 10.6135 23.3685 10.3817C23.1368 10.1499 22.8233 10.0185 22.4955 10.0156C22.1678 10.0128 21.852 10.1388 21.6163 10.3665L15 16.9827L8.38376 10.3665C8.14935 10.1321 7.83146 10.0005 7.50001 10.0005C7.16855 10.0005 6.85067 10.1321 6.61626 10.3665Z" fill="black"/>
                    </svg>
                  <ul class="dropdown-menu w-100" aria-labelledby="dropdownMenuButton">
                    @foreach (getAllLanguageWithFullData() as $language)
                        <li>
                            <a class="dropdown-item" href="javascript:void(0)" id="languageName"
                                data-name="{{ $language->iso_code }}">
                                @if (array_key_exists($language->iso_code, \App\Models\User::FLAG))
                                    <img class="flag" alt="flag"
                                        src="{{ asset(\App\Models\User::FLAG[$language->iso_code]) }} "
                                        loading="lazy" />
                                @else
                                    @if (count($language->media) != 0)
                                        <img src="{{ $language->image_url }}" class="me-1"
                                            loading="lazy" />
                                    @else
                                        <i class="fa fa-flag fa-xl me-3 text-danger"
                                            aria-hidden="true"></i>
                                    @endif
                                @endif
                                {{ strtoupper($language->iso_code) }}
                            </a>
                        </li>
                        @endforeach
                  </ul>
                </div>
                {{-- Add to card button --}}
                <button class="add-to-cart-btn d-flex align-items-center justify-content-center position-relative"
                  id="addToCartViewBtn">
                <svg xmlns="http://www.w3.org/2000/svg" width="41" height="40" viewBox="0 0 41 40" fill="none">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M27.1301 11.6667C27.1301 11.9982 26.9984 12.3161 26.764 12.5505C26.5296 12.785 26.2116 12.9167 25.8801 12.9167C25.5486 12.9167 25.2306 12.785 24.9962 12.5505C24.7618 12.3161 24.6301 11.9982 24.6301 11.6667V9.16666C24.6301 7.95109 24.1472 6.7853 23.2877 5.92576C22.4281 5.06621 21.2623 4.58333 20.0468 4.58333C18.8312 4.58333 17.6654 5.06621 16.8059 5.92576C15.9463 6.7853 15.4634 7.95109 15.4634 9.16666V11.6667C15.4634 11.9982 15.3317 12.3161 15.0973 12.5505C14.8629 12.785 14.545 12.9167 14.2134 12.9167C13.8819 12.9167 13.564 12.785 13.3296 12.5505C13.0951 12.3161 12.9634 11.9982 12.9634 11.6667V9.16666C12.9634 7.28804 13.7097 5.48637 15.0381 4.15799C16.3665 2.82961 18.1682 2.08333 20.0468 2.08333C21.9254 2.08333 23.7271 2.82961 25.0554 4.15799C26.3838 5.48637 27.1301 7.28804 27.1301 9.16666V11.6667Z" fill="white"/>
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M32.2835 13.9167L33.6168 33.9167C33.6503 34.4289 33.5784 34.9425 33.4056 35.4258C33.2328 35.9092 32.9627 36.352 32.6121 36.7268C32.2614 37.1017 31.8376 37.4007 31.3669 37.6053C30.8961 37.81 30.3884 37.9159 29.8751 37.9167H10.2185C9.70502 37.9164 9.19708 37.8108 8.72611 37.6063C8.25514 37.4018 7.83116 37.1028 7.48041 36.7279C7.12966 36.3529 6.85961 35.9099 6.68698 35.4264C6.51435 34.9428 6.44281 34.429 6.4768 33.9167L7.81013 13.9167C7.87355 12.9675 8.29533 12.0779 8.99005 11.428C9.68477 10.7782 10.6005 10.4167 11.5518 10.4167H28.5418C29.4931 10.4167 30.4088 10.7782 31.1035 11.428C31.7983 12.0779 32.22 12.9675 32.2835 13.9167ZM24.1901 17.7967C23.8175 18.5799 23.2305 19.2415 22.4971 19.7047C21.7638 20.1679 20.9142 20.4138 20.0468 20.4138C19.1794 20.4138 18.3298 20.1679 17.5965 19.7047C16.8631 19.2415 16.2761 18.5799 15.9035 17.7967C15.833 17.6484 15.734 17.5154 15.6121 17.4054C15.4903 17.2954 15.3479 17.2104 15.1933 17.1554C15.0386 17.1004 14.8746 17.0764 14.7106 17.0847C14.5466 17.0931 14.3859 17.1337 14.2376 17.2042C14.0893 17.2746 13.9564 17.3736 13.8464 17.4955C13.7363 17.6173 13.6514 17.7597 13.5964 17.9144C13.5414 18.069 13.5173 18.2331 13.5257 18.397C13.5341 18.561 13.5747 18.7217 13.6451 18.87C14.2192 20.0821 15.1255 21.1063 16.2588 21.8235C17.3921 22.5407 18.7056 22.9214 20.0468 22.9214C21.3879 22.9214 22.7015 22.5407 23.8348 21.8235C24.9681 21.1063 25.8744 20.0821 26.4485 18.87C26.5189 18.7217 26.5595 18.561 26.5679 18.397C26.5762 18.2331 26.5522 18.069 26.4972 17.9144C26.4422 17.7597 26.3573 17.6173 26.2472 17.4955C26.1372 17.3736 26.0042 17.2746 25.856 17.2042C25.7077 17.1337 25.547 17.0931 25.383 17.0847C25.219 17.0764 25.055 17.1004 24.9003 17.1554C24.7456 17.2104 24.6033 17.2954 24.4815 17.4054C24.3596 17.5154 24.2606 17.6484 24.1901 17.7967Z" fill="white"/>
                  </svg>
                    <div
                        class="position-absolute product-count-badge count-product  badge rounded-pill bg-danger">
                    </div>
                </button>
              </div>
          </div>
        </nav>
      </div>
      <div class="hero-img position-relative">
        <img src="{{ $whatsappStore->cover_url }}" loading="lazy" alt="banner-img"
          class="h-100 w-100 object-fit-cover hero-img-vector" />
      </div>
        <div class="items-section px-4 pt-3 mt-1 position-relative">
            <livewire:wp-store-templates-products-list :whatsappStoreId="$whatsappStore->id" />
        </div>
      <div class="position-absolute start-0 bottom-0 body-vector">
        <img src="{{ asset('assets/img/whatsapp_stores/home_decor/body-vector.png') }}" alt="images" class="w-100 object-fit-contain" />
      </div>
    </div>
    @include('whatsapp_stores.templates.order_modal')
    @include('whatsapp_stores.templates.home_decor.cart_modal')
    <footer class="position-relative">
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
</body>
@livewireScripts
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
</script>
<script src="{{ asset('messages.js?$mixID') }}"></script>
<script src="{{ asset('assets/js/intl-tel-input/build/intlTelInput.js') }}"></script>
<script src="{{ asset('assets/js/vcard11/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('front/js/bootstrap.bundle.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/front-third-party-vcard11.js') }}"></script>
<script src="{{ mix('assets/js/custom/helpers.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/whatsapp_store_template.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.custom-select-box').click(function() {
            $(this).next('.custom-select-options').toggle();
        });

        $('.custom-select-option').click(function() {
            var selectedValue = $(this).text();
            $('.select-text').text(selectedValue);
            $('.custom-select-options').hide();
        });
        $(document).click(function(event) {
            if (!$(event.target).closest('.custom-select-box').length) {
                $('.custom-select-options').hide();
            }
        });
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
