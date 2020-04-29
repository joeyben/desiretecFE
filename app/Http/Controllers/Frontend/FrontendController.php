<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Repositories\Frontend\Pages\PagesRepository;
use App\Services\Api\ApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Modules\Translations\Entities\Translation;
use Spatie\TranslationLoader\LanguageLine;
use App\Http\Requests\Wishes\StoreWishesRequest;

/**
 * Class FrontendController.
 */
class FrontendController extends Controller
{
    const BODY_CLASS = 'landing';

    // TODO: Better solution for these arrays:
    const CLASS_ARR = [
        3 => "Economy",
        2 => "Premium Economy",
        1 => "Business",
        4 => "First",
    ];
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
    const DURATION_ARR = [
        "exact" => "Exakt wie angegeben",
        "7-" => "1 Woche",
        "14-" => "2 Wochen",
        "21-" => "3 Wochen",
        "28-" => "4 Wochen",
        "1-4" => "1-4 Tage",
        "5-8" => "5-8 Tage",
        "9-12" => "9-12 Tage",
        "13-15" => "13-15 Tage",
        "16-22" => "16-22 Tage",
        "22-" => ">22 Tage",
        1 => "1 Nacht",
        2 => "2 Nächte",
        3 => "3 Nächte",
        4 => "4 Nächte",
        5 => "5 Nächte",
        6 => "6 Nächte",
        7 => "7 Nächte",
        8 => "8 Nächte",
        9 => "9 Nächte",
        10 => "10 Nächte",
        11 => "11 Nächte",
        12 => "12 Nächte",
        13 => "13 Nächte",
        14 => "14 Nächte",
        15 => "15 Nächte",
        16 => "16 Nächte",
        17 => "17 Nächte",
        18 => "18 Nächte",
        19 => "19 Nächte",
        20 => "20 Nächte",
        21 => "21 Nächte",
        22 => "22 Nächte",
        23 => "23 Nächte",
        24 => "24 Nächte",
        25 => "25 Nächte",
        26 => "26 Nächte",
        27 => "27 Nächte",
        28 => "28 Nächte",
    ];

    protected $apiService;

    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
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
        $host = $this->getHost($request, request()->headers->get('origin'));
        $whitelabel = json_decode(json_encode($this->apiService->getWlFromHost($host)), true);

        $layer = $request->query->has('version') ? 'layers.' . $request->input('version') : 'layer';

        $html = view('frontend.whitelabel.' . $layer)->with([
            'adults_arr'   => $this::ADULTS_ARR,
            'kids_arr'     => $this::KIDS_ARR,
            'ages_arr'     => $this::AGES_ARR,
            'catering_arr' => $this::CATERING_ARR,
            'class_arr'    => $this::CLASS_ARR,
            'duration_arr' => $this::DURATION_ARR,
            'pets_arr'     => $this::PETS_ARR,
            'rooms_arr'    => $this::ROOMS_ARR,
            'request'      => $request,
            'whitelabel'   => $whitelabel,
        ])->render();

        return response()->json(['success' => true, 'html'=>$html]);
    }

    /**
     * @param \App\Http\Requests\Wishes\StoreWishesRequest $request
     *
     * @return mixed
     */

    public function store(StoreWishesRequest $request)
    {
        $host = $this->getHost($request, request()->headers->get('origin'));
        $whitelabel = json_decode(json_encode($this->apiService->getWlFromHost($host)), true);

        if ($request->failed()) {
            $layer = $request->query->has('version') ? 'layers.' . $request->input('version') : 'layer';

            $html = view('frontend.whitelabel.' . $layer)->with([
                'adults_arr'   => $this::ADULTS_ARR,
                'kids_arr'     => $this::KIDS_ARR,
                'ages_arr'     => $this::AGES_ARR,
                'catering_arr' => $this::CATERING_ARR,
                'class_arr'    => $this::CLASS_ARR,
                'duration_arr' => $this::DURATION_ARR,
                'pets_arr'     => $this::PETS_ARR,
                'rooms_arr'    => $this::ROOMS_ARR,
                'request'      => $request->all(),
                'errors'       => $request->errors(),
                'whitelabel'   => $whitelabel,
            ])->render();

            return response()->json(['success' => true, 'html'=>$html]);
        }

        $data = $request->all();
        $data['whitelabel_id'] = $whitelabel['id'];
        $data['title'] = "&nbsp;";
        try {
            $response = $this->apiService->get('/wish/store', $data);
            $headline_success = trans('layer.success.headline');
            $subheadline_success = trans('layer.success.subheadline');
            if(!empty($whitelabel['layers'][0]) && !is_null($whitelabel['layers'][0])){
                $headline_success = $whitelabel['layers'][0]['headline_success'];
                $subheadline_success = $whitelabel['layers'][0]['subheadline_success'];
            }
            $external = (strpos($host, 'travelwishservice.com') === false &&
                strpos($host, 'reise-wunsch.de') === false &&
                strpos($host, 'wish-service.com') === false) ? '' : '_WL';
            
            $html = view('frontend.whitelabel.created')->with([
                'headline_success'       => $headline_success,
                'subheadline_success'    => $subheadline_success,
                'whitelabel_name'        => $whitelabel['name'].$external
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

        if ($whitelabel->traffics)
            $response = $this->apiService->get('/destinations');
        elseif ($whitelabel->tt)
            $response = $this->apiService->get('/ttdestinations');
        else
            $response = $this->apiService->get('/destinations');

        $destinations = $response->formatResponse('array');

        return $destinations;
    }

    public function getAllAirports(Request $request)
    {
        $whitelabel = current_whitelabel();

        if ($whitelabel->traffics)
            $response = $this->apiService->get('/airports');
        elseif ($whitelabel->tt)
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
            abort(503, trans('errors.tnb.notset'));
        }
    }

    public function getWhitelabelByHostname(Request $request){
        $host = $this->getHost($request, request()->headers->get('origin'));
        $whitelabel = json_decode(json_encode($this->apiService->getWlFromHost($host)), true);
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
}
