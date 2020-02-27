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
    const REQUEST_ARR = [
        "variant" => "eil-mobile",
        "category" => "3",
        "is_popup_allowed" => "true",
        "first_fetch" => "yes",
    ];
    const CLASS_ARR = [
        3 => "Economy",
        2 => "Premium Economy",
        1 => "Business",
        4 => "First",
    ];
    const ADULTS_ARR = [
        0 => "0",
        1 => "1",
        2 => "2",
        3 => "3",
        4 => "4",
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
        $host = $request->header('Host');
        $whitelabel = json_decode(json_encode($this->apiService->getWlFromHost($host)), true);
        $layer_details = [];
        if(!empty($whitelabel['layers'][0]) && !is_null($whitelabel['layers'][0])){
            $layer_details = $whitelabel['layers'][0];
        }
        $html = view('frontend.whitelabel.layer')->with([
            'adults_arr'   => $this::ADULTS_ARR,
            'kids_arr'     => $this::KIDS_ARR,
            'ages_arr'     => $this::AGES_ARR,
            'catering_arr' => $this::CATERING_ARR,
            'duration_arr' => $this::DURATION_ARR,
            'request'      => $this::REQUEST_ARR,
            'logo'         => $whitelabel['attachments']['logo'],
            'color'        => $whitelabel['color'],
            '$whitelabel'  => $whitelabel,
            'layer_details'=> $layer_details
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
        $host = $request->header('Host');

        $whitelabel = json_decode(json_encode($this->apiService->getWlFromHost($host)), true);
        $layer_details = [];
        if(!empty($whitelabel['layers'][0]) && !is_null($whitelabel['layers'][0])){
            $layer_details = $whitelabel['layers'][0];
        }
        if ($request->failed()) {
            $html = view('frontend.whitelabel.layer')->with([
                'errors'       => $request->errors(),
                'request'      => $request->all(),
                'adults_arr'   => $this::ADULTS_ARR,
                'kids_arr'     => $this::KIDS_ARR,
                'ages_arr'     => $this::AGES_ARR,
                'catering_arr' => $this::CATERING_ARR,
                'duration_arr' => $this::DURATION_ARR,
                'logo'         => $whitelabel['attachments']['logo'],
                'color'        => $whitelabel['color'],
                'layer_details'=> $layer_details
            ])->render();

            return response()->json(['success' => true, 'html'=>$html]);
        }
        $data = $request->all();
        $data['whitelabel_id'] = $whitelabel['id'];
        $data['title'] = "&nbsp;";
        $response = $this->apiService->get('/wish/store', $data);
        if(!$response){
            return response()->json(['success' => true, 'html'=>"<h4>Algo fallo :_(</h4>"]);
        }
        $headline_success = trans('layer.success.headline');
        $subheadline_success = trans('layer.success.subheadline');
        if(!empty($whitelabel['layers'][0]) && !is_null($whitelabel['layers'][0])){
            $headline_success = $whitelabel['layers'][0]['headline_success'];
            $subheadline_success = $whitelabel['layers'][0]['subheadline_success'];
        }
        $html = view('frontend.whitelabel.created')->with([
            'headline_success'       => $headline_success,
            'subheadline_success'    => $subheadline_success,
        ])->render();

        return response()->json(['success' => true, 'html'=>$html]);
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
        $response = $this->apiService->get('/destinations');

        $destinations = $response->formatResponse('array');

        return $destinations;
    }

    public function getAllAirports(Request $request)
    {
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
}
