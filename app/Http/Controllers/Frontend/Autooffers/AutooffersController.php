<?php

namespace App\Http\Controllers\Frontend\Autooffers;

use App\Services\Api\ApiService;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;

class AutooffersController extends Controller
{
    const BODY_CLASS = 'autooffer';

    protected $apiService;

    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    public function list(int $wishId)
    {
        try {

            $offersResponse = $this->apiService->get('/offer/list/' . $wishId);

            $offers = $offersResponse->formatResponse('object')->data;

            $wishResponse = $this->apiService->get('/wishes' . '/' . $wishId);

            $wish = $wishResponse->formatResponse('object')->data;

            return view('frontend.agents.index')->with([
                'body_class'    => $this::BODY_CLASS . '_list',
                'wish'          => $wish,
                'offers'        => $offers,
            ]);

        } catch (\Exception $e) {
            Log::error($e);
            return redirect()->back()->withErrors(['message' => $e->getMessage()]);
        }
    }
}
