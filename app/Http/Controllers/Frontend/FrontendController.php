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

    public function __construct()
    {
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $body_class = $this::BODY_CLASS;
        $bg_image = 'https://desiretec.s3.eu-central-1.amazonaws.com/uploads/whitelabels/background/15734971371569923197homepage_bcg.jpg';
        $display_name = 'Default Whitelabel';
        $logo = '';
        return view('frontend.whitelabel.index', compact( 'body_class','bg_image', 'display_name','logo'));
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
