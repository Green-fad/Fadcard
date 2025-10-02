<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Product;
use App\Models\Template;
use Laracasts\Flash\Flash;
use App\Models\WpOrderItem;
use Illuminate\Support\Str;
use App\Models\BusinessHour;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Models\WhatsappStore;
use App\Models\ProductCategory;
use App\Models\WpStoreTemplate;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Models\WhatsappStoreProduct;
use App\Http\Requests\WpProductBuyRequest;
use App\Repositories\WhatsappStoreRepository;
use App\Models\WhatsappStoreEmailSubscription;
use App\Http\Requests\CreateWhatsappStoreRequest;
use App\Http\Requests\UpdateWhatsappStoreRequest;
use App\Http\Requests\CreateWhatsappStoreEmailSubscribersRequest;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class WhatsappStoreController extends AppBaseController
{
    private WhatsappStoreRepository $whatsappStoreRepository;

    public function __construct(WhatsappStoreRepository $whatsappStoreRepository)
    {
        $this->whatsappStoreRepository = $whatsappStoreRepository;
    }

    public function index(Request $request)
    {
        $partName = $request->part;

        if($partName === null){
            return view('whatsapp_stores.index');
        }

        return view('whatsapp_stores.create', compact('partName'));
    }

    public function store(CreateWhatsappStoreRequest $request)
    {
        $input = $request->all();

        $whatsappStore = $this->whatsappStoreRepository->store($input);

        Flash::success(__('messages.flash.whatsapp_store_create'));

        return redirect(route('whatsapp.stores.edit', [$whatsappStore->id]));
    }

    public function edit(WhatsappStore $whatsappStore, Request $request)
    {
        $isWhatsappStoreAllowed = getPlanFeature(getCurrentSubscription()->plan)['whatsapp_store'];

        if(!$isWhatsappStoreAllowed){
            abort(404);
        }

        $access = $whatsappStore->tenant_id == getLogInTenantId();

        if(!$access){
            abort(404);
        }

        $partName = ($request->part === null) ? 'basics' : $request->part;

        $templates = WpStoreTemplate::all()->pluck('path','id')->toArray();

        $productsCategories = ProductCategory::where('whatsapp_store_id', $whatsappStore->id)->pluck('name', 'id')->toArray();

        return view('whatsapp_stores.edit', compact('whatsappStore', 'partName', 'productsCategories','templates'));
    }

    public function show($alias)
    {
        $whatsappStore = WhatsappStore::where('url_alias', $alias)->first();

        if($whatsappStore === null || $whatsappStore->status == 0) {
            abort(404);
        }

        if (empty(getLocalLanguage())) {
            $alias = $whatsappStore->url_alias;
            $languageName = $whatsappStore->default_language;
            session(['languageChange_' . $alias => $languageName]);
            setLocalLang(getLocalLanguage());
        }

        $whatsappStoreUrl = route('whatsapp.store.show', ['alias' => $alias]);
        $user = User::whereTenantId($whatsappStore->tenant_id)->first();
        $userId = $user->id;
        $enable_pwa = getUserSettingValue('enable_pwa', $userId);
        $hide_sticky_bar = $whatsappStore->hide_stickybar;
        $news_letter_popup =  $whatsappStore->news_letter_popup;
        $business_hours = $whatsappStore->business_hours;

        $businessDaysTime = [];

        if (!empty($whatsappStore->businessHours) && $whatsappStore->businessHours->count()) {
                $dayKeys = [1, 2, 3, 4, 5, 6, 7];
            $openDayKeys = [];
            $openDays = [];
            $closeDays = [];

            foreach ($whatsappStore->businessHours as $key => $openDay) {
                $openDayKeys[] = $openDay->day_of_week;
                $openDays[$openDay->day_of_week] = $openDay->start_time . ' - ' . $openDay->end_time;
            }

            $closedDayKeys = array_diff($dayKeys, $openDayKeys);

            foreach ($closedDayKeys as $closeDayKey) {
                $closeDays[$closeDayKey] = null;
            }

            $businessDaysTime = $openDays + $closeDays;
            ksort($businessDaysTime);
        }

        return view('whatsapp_stores.templates.'.$whatsappStore->template->name.'.index', compact('whatsappStore', 'enable_pwa', 'news_letter_popup','business_hours','businessDaysTime', 'hide_sticky_bar', 'whatsappStoreUrl'));
    }

    public function update(WhatsappStore $whatsappStore,UpdateWhatsappStoreRequest $request)
    {
        $input = $request->all();

        $whatsappStore = $this->whatsappStoreRepository->update($whatsappStore, $input);

        Flash::success(__('messages.flash.whatsapp_store_update'));

        return redirect(route('whatsapp.stores.edit', [$whatsappStore->id]));
    }

    public function destroy($id)
    {
        $whatsappStore = WhatsappStore::findOrFail($id);

        if($whatsappStore->tenant_id != getLogInTenantId()){
            return $this->sendError('Unauthorized.');
        }

        $whatsappStore->clearMediaCollection(WhatsappStore::LOGO);
        $whatsappStore->clearMediaCollection(WhatsappStore::COVER_IMAGE);
        $whatsappStore->delete();

        return $this->sendSuccess(__('messages.flash.whatsapp_store_delete'));
    }

    public function wpTemplateUpate(WhatsappStore $whatsappStore, Request $request)
    {

        $whatsappStore->update(['template_id' => $request->template_id]);

        return $this->sendSuccess(__('messages.flash.whatsapp_store_update'));

    }

    public function updateStatus(WhatsappStore $whatsappStore): JsonResponse
    {
        if ($whatsappStore->status == 0) {
            $user = getLogInUser();

            $activeWhatsappStores = WhatsappStore::where('tenant_id', $user->tenant_id)
                ->where('status', 1)
                ->get();

            $limitOfWhatsappStore = Subscription::whereTenantId($user->tenant_id)
                ->where('status', Subscription::ACTIVE)
                ->latest()
                ->first()
                ->no_of_whatsapp_store;

            if ($limitOfWhatsappStore <= $activeWhatsappStores->count()) {
                return $this->sendError(__('messages.whatsapp_stores_templates.you_have_reached_whatsapp_store_limit'));
            }
        }

        $whatsappStore->update([
            'status' => !$whatsappStore->status,
        ]);

        return $this->sendSuccess(__('messages.flash.whatsapp_store_status'));
    }

    public function wpTemplateSEOUpdate(WhatsappStore $whatsappStore, Request $request)
    {
        $data = $request->only([
            'template_id',
            'site_title',
            'home_title',
            'meta_keyword',
            'meta_description',
            'google_analytics',
        ]);

        $whatsappStore->update($data);

        return $this->sendSuccess(__('messages.flash.whatsapp_store_update'));
    }

    public function wpTemplateAdvanceUpdate(WhatsappStore $whatsappStore, Request $request)
    {
        $data = $request->only([
            'custom_css',
            'custom_js',
        ]);

        $whatsappStore->update($data);

        return $this->sendSuccess(__('messages.flash.whatsapp_store_update'));
    }

    public function wpTemplateCustomFontUpdate(WhatsappStore $whatsappStore, Request $request)
    {
        $request->validate([
            'font_family' => 'string',
            'font_size' => 'nullable|numeric|min:14|max:40',
        ]);

        $data = $request->only([
            'font_family',
            'font_size',
        ]);

        $whatsappStore->update($data);

        return $this->sendSuccess(__('messages.flash.whatsapp_store_update'));
    }

    public function showProducts($alias,$categoryId = null)
    {
        $whatsappStore = WhatsappStore::where('url_alias', $alias)->first();
        if(!$whatsappStore){
            abort(404);
        }

        if (empty(getLocalLanguage())) {
            $alias = $whatsappStore->url_alias;
            $languageName = $whatsappStore->default_language;
            session(['languageChange_' . $alias => $languageName]);
            setLocalLang(getLocalLanguage());
        }


        $template = $whatsappStore->template->name;
        if($whatsappStore === null){
            abort(404);
        }
        return view('whatsapp_stores.templates.'.$template.'.products',compact('whatsappStore','categoryId'));
    }

    public function productDetails($alias, $id)
    {
        $whatsappStore = WhatsappStore::where('url_alias', $alias)->first();
        if (!$whatsappStore) {
            abort(404);
        }
        $product = WhatsappStoreProduct::where('id', $id)->whereHas('whatsappStore', function ($query) use ($whatsappStore) {
            $query->where('id', $whatsappStore->id);
        })->first();

        if (!$product) {
            abort(404);
        }

        if (empty(getLocalLanguage())) {
            $alias = $whatsappStore->url_alias;
            $languageName = $whatsappStore->default_language;
            session(['languageChange_' . $alias => $languageName]);
            setLocalLang(getLocalLanguage());
        }


        $template = $whatsappStore->template->name;

        return view('whatsapp_stores.templates.' . $template . '.product-details', compact('whatsappStore', 'product'));
    }

    public function analytics(WhatsappStore $whatsappStore, Request $request): \Illuminate\View\View
    {
        $input = $request->all();
        $data = $this->whatsappStoreRepository->analyticsData($input, $whatsappStore);
        $partName = ($request->part === null) ? 'overview' : $request->part;

        return view('whatsapp_stores.analytic', compact('whatsappStore', 'partName', 'data'));
    }

    public function chartData(Request $request): JsonResponse
    {
        try {
            $input = $request->all();
            $data = $this->whatsappStoreRepository->chartData($input);

            return $this->sendResponse($data, 'Users fetch successfully.');
        } catch (Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    public function emailSubscriprionStore(CreateWhatsappStoreEmailSubscribersRequest $request)
    {
        $input = $request->all();

        WhatsappStoreEmailSubscription::create($input);

        return $this->sendSuccess(__('messages.flash.email_send'));
    }

    public function showSubscribers(WhatsappStore $whatsappStore)
    {
        $whatsappStoreId = $whatsappStore->id;
        return view('whatsapp_stores.whatsappStore-subscribers', compact('whatsappStoreId'));
    }

    public function getCookie(Request $request)
    {
        $fullUrl = $request->url;
        $path = trim(parse_url($fullUrl, PHP_URL_PATH), '/');
        $segments = explode('/', $path);
        $urlAlias = end($segments);
        $whatsappStore = WhatsappStore::where('url_alias', $urlAlias)->first();
        $valuedata = 5 * 1000;
        if ($whatsappStore) {
            $user = User::where('tenant_id', $whatsappStore->tenant_id)->first();
            if ($user) {
                $value = getUserSettingValue('subscription_model_time', $user->id);
                $timeValue = empty($value) ? 5 : $value;
                $valuedata = intval($timeValue) * 1000;
            }
        }

        return $this->sendResponse($valuedata, '');
    }

    public function cloneTo(WhatsappStore $whatsappStore)
    {
        $users = User::role('admin')
            ->where('tenant_id', '!=', $whatsappStore->tenant_id)
            ->get()
            ->mapWithKeys(function ($user) {
                return [$user->id => $user->full_name];
            })
            ->toArray();

        $data = [
            'whatsappStore' => $whatsappStore,
            'users' => $users
        ];

        return $this->sendResponse($data,  'Whatsapp Store Retrieved Successfully.');
    }

    public function sadminDuplicateWhatsappStore($id, $userId = null): JsonResponse
    {
        try {
            $whatsappStore = WhatsappStore::with([
                'products',
                'categories',
            ])->where('id', $id)->first();
            $this->whatsappStoreRepository->getDuplicateVcard($whatsappStore, $userId);

            return $this->sendSuccess(__('messages.common.duplicate_whatsapp_store_create'));
        } catch (Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    public function language($languageName, $alias)
    {
        $currentLanguage = getLocalLanguage();
        session(['languageChange_' . $alias => $languageName]);
        setLocalLang(getLocalLanguage());

        return $this->sendSuccess(__('messages.flash.language_update', [], $currentLanguage));
    }


    public function wpBusinessHoursUpate(WhatsappStore $whatsappStore, Request $request)
    {
        $input = $request->all();

        BusinessHour::where('whatsapp_store_id', $whatsappStore->id)->delete();

        if (isset($input['days'])) {
            foreach ($input['days'] as $day) {
                BusinessHour::create([
                    'whatsapp_store_id' => $whatsappStore->id,
                    'day_of_week' => $day,
                    'start_time' => $input['startTime'][$day],
                    'end_time' => $input['endTime'][$day],
                ]);
            }
        }

        return $this->sendSuccess(__('messages.flash.whatsapp_store_update'));

    }
}
