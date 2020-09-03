<?php

namespace App\Http\Controllers\Frontend\Autooffers;
use App\ApiAuth;
use App\Http\Controllers\Frontend\Autooffers\Contracts\AutooffersControllerInterface;
use App\Services\Api\ApiService;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;

class AutooffersController extends Controller implements AutooffersControllerInterface
{
    const BODY_CLASS_PREFIX = 'autooffer';

    protected $apiService;

    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    public function list(string $subdomain, int $wishId)
    {
        try {

            $offersResponse = $this->apiService->get('/offer/list/' . $wishId);
            
            $offers = $offersResponse->formatResponse('array')['data'];

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

    public function listpw(string $subdomain, int $wishId)
    {
        try {

            $offersResponse = $this->apiService->get('/offer/listpw/' . $wishId);

            $offers = $offersResponse->formatResponse('array')['data'];

            $wishResponse = $this->apiService->get('/wishes' . '/' . $wishId);

            $wish = $wishResponse->formatResponse('object')->data;

            return view('frontend.autooffer.list_pw')->with([
                'body_class'    => $this::BODY_CLASS_PREFIX . '_list',
                'wish'          => $wish,
                'offers'        => $offers,
            ]);

        } catch (\Exception $e) {
            Log::error($e);
            return redirect()->back()->withErrors(['message' => $e->getMessage()]);
        }
    }

    public function listTt(string $subdomain, int $wishId)
    {

        try {

            $offersResponse = $this->apiService->get('/offer/ttlist/' . $wishId);
            $offers = $offersResponse->formatResponse('array')['data'];

            $wishResponse = $this->apiService->get('/wishes' . '/' . $wishId);

            $wish = $wishResponse->formatResponse('object')->data;

            return view('frontend.autooffer.list_tt')->with([
                'body_class'    => $this::BODY_CLASS_PREFIX . '_list',
                'wish'          => $wish,
                'offers'        => $offers,
            ]);

        } catch (\Exception $e) {
            Log::error($e);
            return redirect()->back()->withErrors(['message' => $e->getMessage()]);
        }
    }

    public function autooferToken(string $subdomain, int $id, string $token)
    {
        try {
            ApiAuth::byWishToken($id, $token);
            $whitelabel = current_whitelabel();
            if($whitelabel["traffics"]){
                return  redirect('offer/list/' . $id);
            }elseif($whitelabel["tt"]){
                return  redirect('offer/ttlist/' . $id);
            }elseif($whitelabel["peakwork"]){
                return  redirect('offer/listpw/' . $id);
            }
            return redirect()->back()->withErrors(['message' => 'Something went wrong!']);
        } catch (Exception $e) {
            return json_response_error($e);
        }
    }
}
