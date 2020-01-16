<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Repositories\Frontend\Pages\PagesRepository;
use Illuminate\Http\Request;

/**
 * Class FrontendController.
 */
class FrontendController extends Controller
{

    const BODY_CLASS = 'landing';
    const BG_IMAGE = 'https://desiretec.s3.eu-central-1.amazonaws.com/uploads/whitelabels/background/15734971371569923197homepage_bcg.jpg';
    const DISPLAY_NAME = 'Default Whitelabel';
    const LOGO = '';
    const COLOR = '#000';
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

    public function __construct()
    {
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $body_class = $this::BODY_CLASS;
        $bg_image = $this::BG_IMAGE;
        $display_name = $this::DISPLAY_NAME;
        $logo = $this::LOGO;
        return view('frontend.whitelabel.index', compact( 'body_class','bg_image', 'display_name','logo'));
    }

    /**
     * Return the specified resource.
     *
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show()
    {
        $html = view('frontend.whitelabel.layer')->with([
            'color'        => $this::COLOR,
            'adults_arr'   => $this::ADULTS_ARR,
            'kids_arr'     => $this::KIDS_ARR,
            'ages_arr'     => $this::AGES_ARR,
            'catering_arr' => $this::CATERING_ARR,
            'duration_arr' => $this::DURATION_ARR,
            'request'      => $this::REQUEST_ARR,
            'bg_image'     => $this::BG_IMAGE,
            'display_name' => $this::DISPLAY_NAME,
            'logo'         => $this::LOGO,
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

    /**
     * URL: /get-all-destinations
     * Returns all destinations.
     *
     * @return array
     */
    public function getAllDestinations(Request $request)
    {
        $query = $request->get('query');
        $destinations = [];
        Regions::select('regionName')
            ->where('type', '1')
            ->where('regionName', 'like', $query . '%')
            ->groupBy('regionName')
            ->chunk(200, function ($regions) use (&$destinations) {
                foreach ($regions as $region) {
                    $destinations[] = $region->regionName;
                }
            });

        return $destinations;
    }

    /**
     * URL: /get-all-airports
     * Returns all airports.
     *
     * @return array
     */
    public function getAllAirports(Request $request)
    {
        $query = $request->get('query');
        $airports = [];
        Regions::select('regionCode', 'regionName')
            ->where('type', 0)
            ->where('regionName', 'like', $query . '%')
            ->groupBy('regionName')
            ->chunk(200, function ($regions) use (&$airports) {
                foreach ($regions as $region) {
                    $airports[] = $region->regionName;
                }
            });

        return $airports;
    }

    /**
     * Respective Domain Teilnahmebedingungen.
     *
     * @return view
     */
    public function showTnb()
    {
        return view('frontend.tnb.tnb');
    }
}
