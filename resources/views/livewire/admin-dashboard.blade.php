    {{-- Card --}}
    <div class="col-12 mb-4">
        <div class="row">
            <div class="col-xxl-3 col-xl-4 col-sm-6 widget">
                <div class="creat-vcard-card-bg shadow-md rounded-10 p-xxl-5 px-4 py-5 my-3 d-flex flex-column">
                    <div class="text-center text-white mb-1">
                        <h5 class="mb-2 fw-bold">{{ __('messages.hey') }} {{ Auth::user()->full_name }},</h5>
                        <p class="mb-3 opacity-90">{{ __('messages.vcard_creat_card_detail') }}</</p>
                    </div>
                    <div class="text-center">
                        <a href="{{ route('vcards.create') }}" class="btn btn-light text-primary fw-bold rounded-pill px-4 py-2">+
                            {{ __('messages.add_new_card') }}</a>
                    </div>
                </div>
            </div>
             <div class="col-xxl-3 col-xl-4 col-sm-6 widget">
                 <div class="bg-primary shadow-md rounded-10 p-xxl-10 px-7 py-10 d-flex align-items-center
                     justify-content-between my-3 gap-3">
                     <div class="bg-cyan-300 widget-icon rounded-10 d-flex align-items-center justify-content-center">
                         <i class="fa-solid fa-id-card-clip fs-1-xl text-white"></i>
                     </div>
                     <div class="text-end text-white">
                         <h2 class="fs-1-xxl fw-bolder text-white">{{ $activeVcard }}</h2>
                         <h3 class="mb-0 fs-4 fw-light">{{ __('messages.common.total__active_vcards') }}</h3>
                     </div>
                 </div>
             </div>
             <div class="col-xxl-3 col-xl-4 col-sm-6 widget">
                 <div class="bg-success shadow-md rounded-10 p-xxl-10 px-7 py-10 d-flex align-items-center justify-content-between my-3 gap-3">
                     <div class="bg-green-300 widget-icon rounded-10 d-flex align-items-center justify-content-center">
                         {{-- <i class="fa-solid fa-user-large-slash fs-1-xl text-white"></i> --}}
                         <img src="{{ asset('assets/img/dashboard/deactive-vcard.svg') }}" alt="" class="w-50 h-50">
                     </div>
                     <div class="text-end text-white">
                         <h2 class="fs-1-xxl fw-bolder text-white">{{ $deActiveVcard }}</h2>
                         <h3 class="mb-0 fs-4 fw-light">{{ __('messages.common.total__deactive_vcards') }}</h3>
                     </div>
                 </div>
             </div>
             <div class="col-xxl-3 col-xl-4 col-sm-6 widget">
                 <div class="bg-info shadow-md rounded-10 p-xxl-10 px-7 py-10 d-flex align-items-center justify-content-between my-3 gap-3">
                     <div class="bg-blue-300 widget-icon rounded-10 d-flex align-items-center justify-content-center">
                         <i class="fa-solid fa-question fs-1-xl text-white"></i>
                     </div>
                     <div class="text-end text-white">
                         <h2 class="fs-1-xxl fw-bolder text-white">{{ $enquiry }}</h2>
                         <h3 class="mb-0 fs-4 fw-light">{{ __('messages.common.today_enquiry') }}</h3>
                     </div>
                 </div>
             </div>
             <div class="col-xxl-3 col-xl-4 col-sm-6 widget">
                 <div class="bg-warning shadow-md rounded-10 p-xxl-10 px-7 py-10 d-flex align-items-center justify-content-between my-3 gap-3">
                     <div class="bg-yellow-300 widget-icon rounded-10 d-flex align-items-center justify-content-center">
                         <i class="fa-solid fa-calendar-check fs-1-xl text-white"></i>
                     </div>
                     <div class="text-end text-white">
                         <h2 class="fs-1-xxl fw-bolder text-white">{{ $appointment }}</h2>
                         <h3 class="mb-0 fs-4 fw-light">{{ __('messages.common.today_appointments') }}</h3>
                     </div>
                 </div>
             </div>
             <div class="col-xxl-3 col-xl-4 col-sm-6 widget">
                 <div class="bg-danger shadow-md rounded-10 p-xxl-10 px-7 py-10 d-flex align-items-center justify-content-between my-3 gap-3">
                     <div class="bg-red-300  widget-icon rounded-10 d-flex align-items-center justify-content-center">
                         <i class="fa-solid fa-file-alt fs-1-xl text-white"></i>
                     </div>
                     <div class="text-end text-white">
                         <h2 class="fs-1-xxl fw-bolder text-white">{{ $totalWpTemplate }}</h2>
                         <h3 class="mb-0 fs-4 fw-light">{{ __('messages.common.whatsapp_store') }}</h3>
                     </div>
                 </div>
             </div>
             <div class="col-xxl-3 col-xl-4 col-sm-6 widget">
                 <div class="card-bg-purple shadow-md rounded-10 p-xxl-10 px-7 py-10 d-flex align-items-center justify-content-between my-3 gap-3">
                     <div class="card-bg-purple-300  widget-icon rounded-10 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-cart-shopping fs-1-xl text-white"></i>
                     </div>
                     <div class="text-end text-white">
                         <h2 class="fs-1-xxl fw-bolder text-white">{{ $totalOrder }}</h2>
                         <h3 class="mb-0 fs-4 fw-light">{{ __('messages.common.whatsapp_store_order') }}</h3>
                     </div>
                 </div>
             </div>
             <div class="col-xxl-3 col-xl-4 col-sm-6 widget">
                 <div class="card-bg-blue shadow-md rounded-10 p-xxl-10 px-7 py-10 d-flex align-items-center justify-content-between my-3 gap-3">
                     <div class="card-bg-blue-300  widget-icon rounded-10 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-clock fs-1-xl text-white"></i>
                     </div>
                     <div class="text-end text-white">
                         <h2 class="fs-1-xxl fw-bolder text-white">{{ $totalPendingOrder }}</h2>
                         <h3 class="mb-0 fs-4 fw-light">{{ __('messages.common.whatsapp_store_pending_order') }}</h3>
                     </div>
                 </div>
             </div>
         </div>
     </div>
