<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Frontend\Admin\CacheController;
use App\Repositories\Frontend\Pages\PagesRepository;
use App\Services\Api\ApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Modules\Translations\Entities\Translation;
use Spatie\TranslationLoader\LanguageLine;
use App\Http\Requests\Wishes\StoreWishesRequest;
use Illuminate\Support\Facades\Lang;

/**
 * Class FrontendController.
 */
class FrontendController extends Controller
{
    const BODY_CLASS = 'landing';

    // TODO: Better solution for these arrays:
    const ADULTS_ARR = [
        1 => "1",
        2 => "2",
        3 => "3",
        4 => "4",
        5 => "5",
        6 => "6",
        7 => "7",
        8 => "8",
        9 => "9",
    ];
    const KIDS_ARR = [
        0 => "0",
        1 => "1",
        2 => "2",
        3 => "3",
        4 => "4",
    ];
    const AGES_ARR = [
        "<2" => "<2",
        2 => "2",
        3 => "3",
        4 => "4",
        5 => "5",
        6 => "6",
        7 => "7",
        8 => "8",
        9 => "9",
        10 => "10",
        11 => "11",
        12 => "12",
        13 => "13",
        14 => "14",
        15 => "15",
        16 => "16",
    ];
    const CATERING_ARR = [
        1 => "Ohne Verpflegung",
        2 => "Frühstück",
        3 => "Halbpension",
        4 => "Vollpension",
        5 => "all inclusive",
    ];
    const PETS_ARR = [
        'Ohne Haustier',
        'Mit Haustier',
    ];
    const ROOMS_ARR = [
        1 => "1",
        2 => "2",
        3 => "3",
        4 => "4",
    ];

    private $childrenArr;

    private $classArr;

    private $petsArr;

    private $duration_arr;

    private $catering;

    private $purpose_arr;

    protected $apiService;

    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
        $this->initDurationArr();
        $this->initCatering();
        $this->initPurposeArr();
        $this->initChildrenArr();
        $this->initPetsArr();
        $this->initClassArr();
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $body_class = $this::BODY_CLASS;
        return view('frontend.whitelabel.index', compact( 'body_class'));
    }

    /**
     * Return the specified resource.
     *
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request)
    {
        $this->initCatering();
        $this->initDurationArr();
        $this->initPurposeArr();
        $host = $this->getHost($request, request()->headers->get('referer'));
        $whitelabel = json_decode(json_encode($this->apiService->getWlFromHost(str_replace('/','_', $host))), true);
        $layerVersion = $request->query->has('version') ? $request->input('version') : "";
        $layer = $request->query->has('version') ? 'layers.' . $request->input('version') : 'layer';

        $translation = [
            "title" => Lang::get('layer.general.layer_title', [], session()->get('wl-locale')),
            "sub_title" => Lang::get('layer.general.sub_title', [], session()->get('wl-locale')),
            "sonnen" => Lang::get('layer.general.suns', [], session()->get('wl-locale')),
            "sonne" => Lang::get('layer.general.sun', [], session()->get('wl-locale')),
            "stern" => Lang::get('layer.general.star', [], session()->get('wl-locale')),
            "sterne" => Lang::get('layer.general.stars', [], session()->get('wl-locale')),
            "adult"  => Lang::get('layer.general.adult_label', [], session()->get('wl-locale')),
            "adults"  => Lang::get('layer.general.adults_label', [], session()->get('wl-locale')),
            "kid"  => Lang::get('layer.general.kid_label', [], session()->get('wl-locale')),
            "kids"  => Lang::get('layer.general.kids_label', [], session()->get('wl-locale')),
        ];

        $html = view('frontend.whitelabel.' . $layer)->with([
            'adults_arr'   => $this::ADULTS_ARR,
            'kids_arr'     => $this::KIDS_ARR,
            'ages_arr'     => $layerVersion === "flight" ? $this->childrenArr : $this::AGES_ARR,
            'catering_arr' => $this->catering,
            'duration_arr' => $this->duration_arr,
            'pets_arr'     => $this->petsArr,
            'rooms_arr'    => $this::ROOMS_ARR,
            'purpose_arr'  => $this->purpose_arr,
            'request'      => $request->all(),
            'whitelabel'   => $whitelabel,
            'translation'  => $translation,
        ])->render();

        return response()->json(['success' => true, 'html'=>$html]);
    }


    /**
     * Return whitelabel info as json.
     *
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getWhitelabelData(Request $request)
    {
        $host = $this->getHost($request, request()->headers->get('referer'));
        $whitelabel = json_decode(json_encode($this->apiService->getWlFromHost(str_replace('/','_', $host))), true);
        $data = [
            'color' => $whitelabel['color']
        ];

        return response()->json(['success' => true, 'data' => $data]);
    }

    /**
     * @param \App\Http\Requests\Wishes\StoreWishesRequest $request
     *
     * @return mixed
     */

    public function store(StoreWishesRequest $request)
    {
        $this->initCatering();
        $this->initDurationArr();
        $this->initPurposeArr();
        $host = $this->getHost($request, request()->headers->get('referer'));
        $layerVersion = $request->query->has('version') ? $request->input('version') : "";
        $whitelabel = json_decode(json_encode($this->apiService->getWlFromHost(str_replace('/','_', $host))), true);

        if ($request->failed()) {
            $layer = $request->query->has('version') ? 'layers.' . $request->input('version') : 'layer';

            $translation = [
                "title" => Lang::get('layer.general.layer_title', [], session()->get('wl-locale')),
                "sub_title" => Lang::get('layer.general.sub_title', [], session()->get('wl-locale')),
                "sonnen" => Lang::get('layer.general.suns', [], session()->get('wl-locale')),
                "sonne" => Lang::get('layer.general.sun', [], session()->get('wl-locale')),
                "stern" => Lang::get('layer.general.star', [], session()->get('wl-locale')),
                "sterne" => Lang::get('layer.general.stars', [], session()->get('wl-locale')),
                "adult"  => Lang::get('layer.general.adult_label', [], session()->get('wl-locale')),
                "adults"  => Lang::get('layer.general.adults_label', [], session()->get('wl-locale')),
                "kid"  => Lang::get('layer.general.kid_label', [], session()->get('wl-locale')),
                "kids"  => Lang::get('layer.general.kids_label', [], session()->get('wl-locale')),
                "price_until"  => Lang::get('layer.general.price_until', [], session()->get('wl-locale')),
                "stars_from"  => Lang::get('layer.general.stars_from', [], session()->get('wl-locale')),
            ];

            $html = view('frontend.whitelabel.' . $layer)->with([
                'adults_arr'   => $this::ADULTS_ARR,
                'kids_arr'     => $this::KIDS_ARR,
                'ages_arr'     => $layerVersion === "flight" ? $this->childrenArr : $this::AGES_ARR,
                'catering_arr' => $this->catering,
                'duration_arr' => $this->duration_arr,
                'pets_arr'     => $this->petsArr,
                'rooms_arr'    => $this::ROOMS_ARR,
                'purpose_arr'  => $this->purpose_arr,
                'request'      => $request->all(),
                'errors'       => $request->errors(),
                'whitelabel'   => $whitelabel,
                'translation'  => $translation
            ])->render();

            return response()->json(['success' => true, 'html'=>$html]);
        }

        $data = $request->all();
        $data['whitelabel_id'] = $whitelabel['id'];
        $data['title'] = "&nbsp;";

        $data['variant_id'] = $this->apiService->getVariantId($host);

        if(isset($data['events_interested'])) {
            $data['events_interested'] = $data['events_interested'] === 'on' ? 1 : 0;
        }

        try {
            $response = $this->apiService->get('/wish/store', $data);

            $external = (strpos($host, 'travelwishservice.com') === false &&
                strpos($host, 'reise-wunsch.de') === false &&
                strpos($host, 'wish-service.com') === false) ? '' : '_WL';

            $html = view('frontend.whitelabel.created')->with([
                'whitelabel_name'        => $whitelabel['name'].$external,
                'layers'                 => $whitelabel['layers'],
            ])->render();

            return response()->json(['success' => true, 'html'=>$html]);
        } catch (RequestException $ex) {
            return response()->json(['success' => true, 'html'=>"<h4>Algo fallo :_(</h4>"]);
        }
    }
    /**
     * show page by $page_slug.
     */
    public function showPage($slug, PagesRepository $pages)
    {
        $result = $pages->findBySlug($slug);

        return view('frontend.pages.index')
            ->withpage($result);
    }

    public function getAllDestinations()
    {
        $whitelabel = current_whitelabel();
        if ($whitelabel['traffics'])
            $response = $this->apiService->get('/destinations');
        elseif ($whitelabel['tt'])
            $response = $this->apiService->get('/ttdestinations');
        else
            $response = $this->apiService->get('/destinations');

        $destinations = $response->formatResponse('array');

        return $destinations;
    }

    public function getAllAirports(Request $request)
    {
        $whitelabel = current_whitelabel();

        if ($whitelabel['traffics'])
            $response = $this->apiService->get('/airports');
        elseif ($whitelabel['tt'])
            $response = $this->apiService->get('/ttairports');
        else
            $response = $this->apiService->get('/airports');

        $airports = $response->formatResponse('array');

        return $airports;
    }

    /**
     * Respective Domain Teilnahmebedingungen.
     *
     * @return view
     */
    public function showTnb()
    {
        try{
            $response = $this->apiService->get('/tnb', ['id' => getWhitelabelInfo()['id']]);
            $tnb = $response->formatResponse('array')['data'];

            return view('frontend.tnb.tnb', compact(['tnb']));
        } catch (\Exception $e) {
            Log::error($e);
            abort(503, Lang::get('errors.tnb.notset', [], session()->get('wl-locale')));
        }
    }

    public function getWhitelabelByHostname(Request $request){
        $host = $this->getHost($request, request()->headers->get('referer'));
        $whitelabel = json_decode(json_encode($this->apiService->getWlFromHost(str_replace('/','_', $host))), true);
        $fromWL = strpos($host, 'reise-wunsch.de') === false
            && strpos($host, 'travelwishservice.com') === false
            && strpos($host, 'wish-service.com') === false ? "" : "_WL";
        return response()->json(['success' => true, 'whitelabel_name'=>$whitelabel['name'].$fromWL]);
    }

    public function getHost($request, $origin){
        $host = preg_replace('#^https?://#', '', rtrim($origin,'/'));
        $host = preg_replace('#^http?://#', '', rtrim($host,'/'));
        return $host ? $host : $request->header('Host');
    }

    public function initPurposeArr(){
        $this->purpose_arr = [
            Lang::get('layer.general.purpose.family', [], session()->get('wl-locale')),
            Lang::get('layer.general.purpose.wellness', [], session()->get('wl-locale')),
            Lang::get('layer.general.purpose.aktivurlaub', [], session()->get('wl-locale')),
            Lang::get('layer.general.purpose.fahrradurlaub', [], session()->get('wl-locale')),
            Lang::get('layer.general.purpose.natur', [], session()->get('wl-locale')),
            Lang::get('layer.general.purpose.studienreise', [], session()->get('wl-locale')),
            Lang::get('layer.general.purpose.kulturreise', [], session()->get('wl-locale')),
            Lang::get('layer.general.purpose.bussiness', [], session()->get('wl-locale'))
        ];
    }

    public function initDurationArr(){
        $this->duration_arr = [
            "exact" => Lang::get('labels.frontend.wishes.exact', [], session()->get('wl-locale')),
            "7-" => trans_choice('labels.frontend.wishes.week', 1, ['value' => 1], session()->get('wl-locale')),
            "14-" => trans_choice('labels.frontend.wishes.week', 2, ['value' => 2], session()->get('wl-locale')),
            "21-" => trans_choice('labels.frontend.wishes.week', 3, ['value' => 3], session()->get('wl-locale')),
            "28-" => trans_choice('labels.frontend.wishes.week', 4, ['value' => 4], session()->get('wl-locale')),
            "1-4" => "1-4 ". Lang::get('labels.frontend.wishes.nights', [], session()->get('wl-locale')),
            "5-8" => "5-8 ". Lang::get('labels.frontend.wishes.nights', [], session()->get('wl-locale')),
            "9-12" => "9-12 ". Lang::get('labels.frontend.wishes.nights', [], session()->get('wl-locale')),
            "13-15" => "13-15 ". Lang::get('labels.frontend.wishes.nights', [], session()->get('wl-locale')),
            "16-22" => "16-22 ". Lang::get('labels.frontend.wishes.nights', [], session()->get('wl-locale')),
            "22-" => ">22 ". Lang::get('labels.frontend.wishes.nights', [], session()->get('wl-locale')),
        ];
        for($i = 1; $i<29;$i++){
            $this->duration_arr[$i] = trans_choice('labels.frontend.wishes.night', $i, ['value' => $i], session()->get('wl-locale'));
        }
    }

    public function initCatering(){
        $this->catering = [
            1 => Lang::get('labels.frontend.wishes.catering.ov', [], session()->get('wl-locale')),
            2 => Lang::get('labels.frontend.wishes.catering.bf', [], session()->get('wl-locale')),
            3 => Lang::get('labels.frontend.wishes.catering.hp', [], session()->get('wl-locale')),
            4 => Lang::get('labels.frontend.wishes.catering.vp', [], session()->get('wl-locale')),
            5 => Lang::get('labels.frontend.wishes.catering.ai', [], session()->get('wl-locale')),
        ];
    }

    public function initChildrenArr(){
        $this->childrenArr = [
            "0" => Lang::get('layer.general.flight.kid_age_0', [], session()->get('wl-locale')),
            "1" => Lang::get('layer.general.flight.kid_age_1', [], session()->get('wl-locale')),
            "2" => Lang::get('layer.general.flight.kid_age_2', [], session()->get('wl-locale')),
            "3" => Lang::get('layer.general.flight.kid_age_3', [], session()->get('wl-locale')),
            "4" => Lang::get('layer.general.flight.kid_age_4', [], session()->get('wl-locale')),
        ];
    }

    public function initPetsArr(){
        $this->petsArr = [
            Lang::get('layer.general.with_pets', [], session()->get('wl-locale')),
            Lang::get('layer.general.without_pets', [], session()->get('wl-locale')),
        ];
    }

    public function initClassArr(){
        $this->classArr = [
            'Economy' => Lang::get('layer.general.flight.economy', [], session()->get('wl-locale')),
            'Premium Economy' => Lang::get('layer.general.flight.premium', [], session()->get('wl-locale')),
            'Business' => Lang::get('layer.general.flight.buiness', [], session()->get('wl-locale')),
            'First' => Lang::get('layer.general.flight.first', [], session()->get('wl-locale')),
        ];
    }
}
