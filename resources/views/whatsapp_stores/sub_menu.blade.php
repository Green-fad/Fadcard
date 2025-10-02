<div id="mySidebar" class="sidebar d-lg-block d-xl-block">
    <a href="javascript:void(0)" class="closebtn d-lg-none d-block pt-3" onclick="closeNav()">×</a>
    <ul class="nav nav-tabs-1 mb-sm-7 mb-5 pb-1 flex-nowrap text-nowrap flex-sm-column d-sm-flex d-block">
        <div class="d-sm-flex flex-sm-column overflow-auto">
            <li class="nav-item nav-item-1 position-relative">
                @if (isset($whatsappStore))
                    <a class="nav-link-1 nav-link p-3 {{ isset($partName) && $partName == 'basics' ? 'active' : '' }} "
                        href="{{ route('whatsapp.stores.edit', ['whatsappStore' => $whatsappStore->id, 'part' => 'basics']) }}">
                        <i class="fa-solid fa-circle-question p-1 icon-color-bs-blue"></i>
                        {{ __('messages.vcard.basic_details') }}
                    </a>
                @else
                    <a class="nav-link-1 nav-link p-3 {{ isset($partName) && $partName == 'basics' ? 'active' : '' }} "
                        href="{{ route('whatsapp.stores') . '?part=basics' }}">
                        <i class="fa-solid fa-circle-question p-1 icon-color-bs-blue"></i>
                        {{ __('messages.vcard.basic_details') }}
                    </a>
                @endif
            </li>
            <li class="nav-item nav-item-1 position-relative">
                @if (isset($whatsappStore))
                    <a class="nav-link-1 nav-link p-3  {{ isset($partName) && $partName == 'whatsapp-template' ? 'active' : '' }} "
                        href="{{ route('whatsapp.stores.edit', ['whatsappStore' => $whatsappStore->id, 'part' => 'whatsapp-template']) }}">
                        <i class="fa-solid fa-file-lines p-1 text-success"></i>
                        {{ __('messages.whatsapp_stores.whatsapp_templates') }}
                    </a>
                @else
                    <a class="nav-link-1 nav-link p-3 opacity-50  disabled" href="#">
                        <i class="fa-solid fa-file-lines p-1 text-success"></i>
                        {{ __('messages.whatsapp_stores.whatsapp_templates') }}
                    </a>
                @endif

            </li>
            <li class="nav-item nav-item-1 position-relative">
                @if (isset($whatsappStore))
                    <a class="nav-link-1 nav-link p-3  {{ isset($partName) && $partName == 'business-hours' ? 'active' : '' }} "
                        href="{{ route('whatsapp.stores.edit', ['whatsappStore' => $whatsappStore->id, 'part' => 'business-hours']) }}">
                        <i class="fa-solid fa-clock p-1 icon-color-bs-yellow"></i>
                        {{ __('messages.vcard.business_hours') }}
                    </a>
                @else
                    <a class="nav-link-1 nav-link p-3 opacity-50  disabled" href="#">
                        <i class="fa-solid fa-clock p-1 icon-color-bs-yellow"></i>
                        {{ __('messages.vcard.business_hours') }}
                    </a>
                @endif

            </li>
            <li class="nav-item nav-item-1 position-relative">
                @if (isset($whatsappStore))
                    <a class="nav-link-1 nav-link p-3  {{ isset($partName) && $partName == 'products-categories' ? 'active' : '' }} "
                        href="{{ route('whatsapp.stores.edit', ['whatsappStore' => $whatsappStore->id, 'part' => 'products-categories']) }}">
                        <i class="fa-solid fa-layer-group p-1 text-warning"></i>
                        {{ __('messages.whatsapp_stores.products_categories') }}
                    </a>
                @else
                    <a class="nav-link-1 nav-link p-3 opacity-50 disabled " href="#">
                        <i class="fa-solid fa-layer-group p-1 text-warning"></i>
                        {{ __('messages.whatsapp_stores.products_categories') }}
                    </a>
                @endif
            </li>
            <li class="nav-item nav-item-1 position-relative">
                @if (isset($whatsappStore))
                    <a class="nav-link-1 nav-link p-3  {{ isset($partName) && $partName == 'products' ? 'active' : '' }}"
                        href="{{ route('whatsapp.stores.edit', ['whatsappStore' => $whatsappStore->id, 'part' => 'products']) }}">
                        <i class="fa-solid fa-boxes-stacked p-1 text-primary"></i>
                        {{ __('messages.whatsapp_stores.products') }}
                    </a>
                @else
                    <a class="nav-link-1 nav-link p-3 opacity-50  disabled" href="#">
                        <i class="fa-solid fa-boxes-stacked p-1 text-primary"></i>
                        {{ __('messages.whatsapp_stores.products') }}
                    </a>
                @endif
            </li>
            <li class="nav-item nav-item-1 position-relative">
                @if (isset($whatsappStore))
                    <a class="nav-link-1 nav-link p-3  {{ isset($partName) && $partName == 'product-orders' ? 'active' : '' }}"
                        href="{{ route('whatsapp.stores.edit', ['whatsappStore' => $whatsappStore->id, 'part' => 'product-orders']) }}">
                        <i class="fas fa-money-bills icon-color-bs-darkyellow"></i>
                        {{ __('messages.product_orders') }}
                    </a>
                @else
                    <a class="nav-link-1 nav-link p-3 opacity-50  disabled" href="#">
                        <i class="fas fa-money-bills icon-color-bs-darkyellow"></i>
                        {{ __('messages.product_orders') }}
                    </a>
                @endif
            </li>
            <li class="nav-item nav-item-1 position-relative">
                @if (isset($whatsappStore))
                    <a class="nav-link-1 nav-link p-3  {{ isset($partName) && $partName == 'advanced' ? 'active' : '' }}"
                        href="{{ route('whatsapp.stores.edit', ['whatsappStore' => $whatsappStore->id, 'part' => 'advanced']) }}">
                        <i class="fa-solid fa-gears p-1 icon-color-bs-orange"></i>
                        {{ __('messages.vcard.advanced') }}
                    </a>
                @else
                    <a class="nav-link-1 nav-link p-3 opacity-50  disabled" href="#">
                        <i class="fa-solid fa-gears p-1 icon-color-bs-orange"></i>
                        {{ __('messages.vcard.advanced') }}
                    </a>
                @endif
            </li>
            <li class="nav-item nav-item-1 position-relative">
                @if (isset($whatsappStore))
                    <a class="nav-link-1 nav-link p-3  {{ isset($partName) && $partName == 'custom-fonts' ? 'active' : '' }}"
                        href="{{ route('whatsapp.stores.edit', ['whatsappStore' => $whatsappStore->id, 'part' => 'custom-fonts']) }}">
                        <i class="fa-solid fa-font p-1 icon-color-bs-yellow"></i>
                        {{ __('messages.font.fonts') }}
                    </a>
                @else
                    <a class="nav-link-1 nav-link p-3 opacity-50  disabled" href="#">
                        <i class="fa-solid fa-font p-1 icon-color-bs-yellow"></i>
                        {{ __('messages.font.fonts') }}
                    </a>
                @endif
            </li>
            <li class="nav-item nav-item-1 position-relative">
                @if (isset($whatsappStore))
                    <a class="nav-link-1 nav-link p-3  {{ isset($partName) && $partName == 'seo' ? 'active' : '' }}"
                        href="{{ route('whatsapp.stores.edit', ['whatsappStore' => $whatsappStore->id, 'part' => 'seo']) }}">
                        <i class="fa-solid fa-magnifying-glass p-1 icon-color-bs-green"></i>
                        {{ __('messages.plan.seo') }}
                    </a>
                @else
                    <a class="nav-link-1 nav-link p-3 opacity-50  disabled" href="#">
                        <i class="fa-solid fa-magnifying-glass p-1 icon-color-bs-green"></i>
                        {{ __('messages.plan.seo') }}
                    </a>
                @endif
            </li>
        </div>
    </ul>
</div>


<script>
    function openNav() {
        document.getElementById("mySidebar").style.width = "250px";
        //   document.getElementById("main").style.marginLeft = "250px";
    }

    function closeNav() {
        document.getElementById("mySidebar").style.width = "0";
        //   document.getElementById("main").style.marginLeft= "0";
    }
</script>
