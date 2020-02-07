<?php

namespace App\Http\Controllers\Frontend\Autooffers;

use App\Services\Api\ApiService;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;

class AutooffersController extends Controller
{
    const BODY_CLASS_PREFIX = 'autooffer';

    protected $status = [
        'Active'       => 'Active',
        'Inactive'     => 'Inactive',
        'Deleted'      => 'Deleted',
    ];

    protected $category = [
        '1'  => 1,
        '2'  => 2,
        '3'  => 3,
        '4'  => 4,
        '5'  => 5,
    ];

    protected $catering = [
        'any'           => 'any',
        'Breakfast'     => 'Breakfast',
        'Pension'       => 'Pension',
        'Full Pension'  => 'Full Pension',
        'All Inclusive' => 'All Inclusive',
    ];

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
// dd($offers->data);
            $wishResponse = $this->apiService->get('/wishes' . '/' . $wishId);

            $wish = $wishResponse->formatResponse('object')->data;

            return view('frontend.autooffer.list')->with([
                'body_class'    => $this::BODY_CLASS_PREFIX . '_list',
                'wish'          => $wish,
                'offers'        => $offers,
            ]);

        } catch (\Exception $e) {
            Log::error($e);
            return redirect()->back()->withErrors(['message' => $e->getMessage()]);
        }
    }
}
