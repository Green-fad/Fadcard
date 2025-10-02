<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Meta;
use App\Models\Plan;
use App\Models\User;
use App\Models\Vcard;
use App\Models\AboutUs;
use App\Models\Country;
use App\Models\Feature;
use App\Models\Setting;
use App\Models\ContactUs;
use App\Models\FrontFAQs;
use App\Models\FrontSlider;
use App\Models\WhatDrivesUs;
use Illuminate\Http\Request;
use App\Models\WhatsappStore;
use App\Models\FrontTestimonial;
use Illuminate\Http\JsonResponse;
use App\Mail\LandingContactUsMail;
use Illuminate\Routing\Redirector;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\CreateContactRequest;
use Illuminate\Contracts\Foundation\Application;

class HomeController extends AppBaseController
{
    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $testimonials = FrontTestimonial::with('media')->get();
        $faqs =  FrontFAQs::first();
        $metas = Meta::first();

        if (! empty($metas)) {
            $metas = $metas->toArray();
        }

        $setting = Setting::pluck('value', 'key')->toArray();

        $aboutUS = AboutUs::with('media')->get()->toArray();
        $frontSlider = FrontSlider::with('media')->get()->toArray();
        $whatDrivesUS = WhatDrivesUs::with('media')->get()->toArray();
        $features = Feature::all();
        $faq = FrontFAQs::all();

        $plans = Plan::with(['currency', 'planFeature', 'hasZeroPlan', 'planCustomFields'])->whereIsDefault(Plan::IS_DEACTIVE)->whereStatus(Plan::IS_ACTIVE)->get();
        $latestUsers = User::orderBy('created_at', 'desc')->limit(3)->get();
        $totalUser = User::count();
        $totalwhatsappStores = WhatsappStore::count();
        $totalCountries = Country::count();
        $whatDrivesUS = WhatDrivesUs::with('media')->get()->toArray();
        $activeUser = User::where('is_active', User::IS_ACTIVE)->count();
        $toalVcards = Vcard::count();
        if(getSuperAdminSettingValue('is_front_page')) {
            $themeMap = [
                1 => 'home',
                2 => 'home1',
                3 => 'home3',
                4 => 'home4',
            ];
            $theme = getSuperAdminSettingValue('home_page_theme');
            $homePage = $themeMap[$theme] ?? 'home3';

            return view("front.home.$homePage", compact('plans', 'setting', 'features', 'testimonials', 'aboutUS', 'metas', 'faq','faqs','frontSlider','latestUsers','totalUser','whatDrivesUS','activeUser', 'toalVcards', 'totalwhatsappStores', 'totalCountries'));
        } else {
            return redirect(route('login'));
        }
    }

    public function store(CreateContactRequest $request)
    {
        $input = $request->all();
        $user = getSuperAdminEmail();

        ContactUs::create($input);
        Mail::to($user)
            ->send(new LandingContactUsMail(
                $input,
                __('messages.placeholder.message_sent')
            ));

        return $this->sendSuccess(__('messages.placeholder.message_sent'));
    }

    /**
     * @return Application|Factory|View
     */
    public function showContactUs(): \Illuminate\View\View
    {
        return view('sadmin.contactus.index');
    }

    public function destroyContactUs(ContactUs $enquiry): JsonResponse
    {
        $enquiry->delete();
        return $this->sendSuccess(__('messages.flash.enquiry_delete'));
    }

    public function themeConfiguration(): \Illuminate\View\View
    {
        $setting = Setting::all()->pluck('value', 'key');

        $view = view('settings.theme_config.index', compact('setting'));

        return $view;
    }

    public function changeLanguage(Request $request): RedirectResponse
    {
        Session::put('languageName', $request->input('languageName'));

        return redirect()->back();
    }


    public function banner(Request $request): \Illuminate\View\View
    {
        $setting = Setting::all()->pluck('value', 'key');

        return view('sadmin.supportBanner.index', compact('setting'));
    }
    public function appDownload(Request $request): \Illuminate\View\View
    {
        $setting = Setting::all()->pluck('value', 'key');

        return view('sadmin.supportMobile.index', compact('setting'));
    }

    /**
     * @return Application|Factory|View|RedirectResponse|Redirector
     */
    public function termCondition()
    {
        $setting = Setting::all()->pluck('value', 'key');
        $faqs =  FrontFAQs::first();

        $view = view('front.terms_conditions', compact('setting', 'faqs'));

        return $view;
    }

    /**
     * @return Application|Factory|View
     */
    public function privacyPolicy(): \Illuminate\View\View
    {
        $setting = Setting::all()->pluck('value', 'key');
        $faqs =  FrontFAQs::first();

        return view('front.privacy_policy', compact('setting', 'faqs'));
    }

    public function refundCancellationPolicy(): \Illuminate\View\View
    {
        $setting = Setting::all()->pluck('value', 'key');
        $faqs =  FrontFAQs::first();

        return view('front.refund_policy', compact('setting', 'faqs'));
    }

    public function shippingDeliveryPolicy(): \Illuminate\View\View
    {
        $setting = Setting::all()->pluck('value', 'key');
        $faqs =  FrontFAQs::first();

        return view('front.shipping_policy', compact('setting', 'faqs'));
    }

    public function imprintPolicy(): \Illuminate\View\View
    {
        $setting = Setting::all()->pluck('value', 'key');
        $faqs =  FrontFAQs::first();

        return view('front.imprint_policy', compact('setting', 'faqs'));
    }

    public function declineCookie()
    {
        session(['declined' => 1]);
    }

    public function vcardTemplates()
    {

        $setting = Setting::pluck('value', 'key')->toArray();
        $faqs =  FrontFAQs::first();

        if(getSuperAdminSettingValue('home_page_theme') == 3){
            return view('front.home.vcard-templete-theme3', compact('setting', 'faqs'));
        }
        if(getSuperAdminSettingValue('home_page_theme') == 4){
            return view('front.home.vcard-template-theme4', compact('setting', 'faqs'));
        }
        return view('front.home.vcards-templates', compact('setting', 'faqs'));
    }

    public function forntFaq()
    {

        $setting = Setting::pluck('value', 'key')->toArray();
        $blogs = Blog::where('status', '1')->get();
        $faq = FrontFAQs::all();
        $faqs =  FrontFAQs::first();
        if (getSuperAdminSettingValue('home_page_theme') == 2) {
            return view('front.home.home-faq1', compact('setting', 'faq', 'faqs', 'blogs'));
        } else {
            return view('front.home.home-faq', compact('setting', 'faq', 'faqs', 'blogs'));
        }
    }

    public function ForntBlog()
    {
        $setting = Setting::pluck('value', 'key')->toArray();
        $blogs = Blog::where('status', '1')->get();
        $faqs =  FrontFAQs::first();

        if (getSuperAdminSettingValue('home_page_theme') == 2) {
            return view('front.home.home-blog1', compact('blogs', 'faqs', 'setting'));
        } else if (getSuperAdminSettingValue('home_page_theme') == 3) {
            return view('front.home.home-blog3', compact('blogs', 'faqs', 'setting'));
        } else if (getSuperAdminSettingValue('home_page_theme') == 4) {
            return view('front.home.home-blog4', compact('blogs', 'faqs', 'setting'));
        } else {
            return view('front.home.home-blog', compact('blogs', 'faqs', 'setting'));
        }
    }

    public function ForntBlogShow($slug)
    {
        $blog = Blog::where('slug', $slug)->first();
        $faqs =  FrontFAQs::first();
        $setting = Setting::pluck('value', 'key')->toArray();

        if (!$blog->status) {
            abort(404);
        }

        if (getSuperAdminSettingValue('home_page_theme') == 2) {
            return view('front.home.home-blog-show1', compact('blog', 'faqs', 'setting'));
        } else if (getSuperAdminSettingValue('home_page_theme') == 3) {
            return view('front.home.home-blog-show3', compact('blog', 'faqs', 'setting'));
        } else if (getSuperAdminSettingValue('home_page_theme') == 4) {
            return view('front.home.home-blog-show4', compact('blog', 'faqs', 'setting'));
        } else {
            return view('front.home.home-blog-show', compact('blog', 'faqs', 'setting'));
        }
    }

    public function ourMission(Request $request): \Illuminate\View\View
    {
        $setting = Setting::all()->pluck('value', 'key');
        return view('sadmin.ourMission.index', compact('setting'));
    }
}
