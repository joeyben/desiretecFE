<?php

namespace App\Http\Controllers\Frontend\Wishes;

use App\ApiAuth;
use Illuminate\Http\Request;
use App\Http\Requests\Wishes\ManageWishesRequest;
use App\Http\Requests\Wishes\UpdateNoteRequest;
use App\Models\Wishes\Wish;
use App\Http\Controllers\Controller;
use App\Services\Api\ApiService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

/**
 * Class WishesController.
 */
class WishesController extends Controller
{
    const BODY_CLASS = 'wish';
    const BODY_CLASS_LIST = 'wishlist';
    const OFFER_URL = 'img/offer/';

    protected $status = [
        'new'               => 'new',
        'offer_created'     => 'offer_created',
        'completed'         => 'completed',
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
    protected $wish;
    protected $categories;


    public function __construct(ApiService $apiService, Wish $wish)
    {
        $this->apiService = $apiService;
        $this->wish = $wish;
    }

    public function show(string $subdomain, int $id, ManageWishesRequest $request)
    {

        try {
            $response = $this->apiService->get('/wishes' . '/' . $id);
            $wish = $response->formatResponse('object')->data;
            return view('frontend.wishes.wish')->with([
                'body_class' => $this::BODY_CLASS,
                'wish'       => $wish
            ]);

        } catch (\Exception $e) {
            Log::error($e);
            return redirect()->back()->withErrors(['message' => $e->getMessage()]);
        }
    }

    /**
     * @param \App\Http\Requests\Frontend\Wishes\ManageWishesRequest $request
     *
     * @return mixed
     */
    public function wishList(string $subdomain)
    {
        return view( 'frontend.wishes.index')->with([
            'status'     => $this->status,
            'category'   => $this->category,
            'catering'   => $this->catering,
            'body_class' => $this::BODY_CLASS_LIST,
        ]);
    }

    /**
     * @param \App\Http\Requests\Frontend\Wishes\ManageWishesRequest $request
     *
     * @return mixed
     */
    public function getList(string $subdomain, Request $request)
    {
        try {
            $params['page'] = $request->get('page') ? $request->get('page') : '1';
            $params['status'] = $request->get('status') ? $request->get('status') : 'new';
            $params['filter'] = $request->get('filter') ? $request->get('filter') : '';

            $response = $this->apiService->get('/wishlist', $params);

            $wishes = $response->formatResponse('object');

            return response()->json($wishes);
        } catch (Exception $e) {
            return json_response_error($e);
        }
    }

    /**
     * @param \App\Http\Requests\Frontend\Wishes\ManageWishesRequest $request
     *
     * @return mixed
     */
    public function create(string $subdomain, ManageWishesRequest $request)
    {
        return view('frontend.wishes.create')->with([
            'status'         => $this->status,
            'category'       => $this->category,
            'catering'       => $this->catering,
            'body_class'     => $this::BODY_CLASS,
        ]);
    }

    /**
     * @param \App\Http\Requests\Frontend\Wishes\StoreWishesRequest $request
     *
     * @return mixed
     */
    public function store(string $subdomain, StoreWishesRequest $request)
    {
        $this->wish->create($request->except('_token'));

        return redirect()
            ->route('frontend.wishes.index')
            ->with('flash_success', trans('alerts.frontend.wishes.created'));
    }

    /**
     * @param \App\Http\Requests\Frontend\Wishes\ChangeWishesStatusRequest $request
     *
     * @return JSON response
     */
    public function changeWishStatus(string $subdomain, Request $request)
    {
        try {
            $response = $this->apiService->post('/wishes/changeWishStatus', $request->all());

            return response()->json($response->formatResponse('object'));
        } catch (Exception $e) {
            return json_response_error($e);
        }
    }

    /**
     * @param \App\Http\Requests\Frontend\Wishes\UpdateNoteRequest $request
     *
     * @return JSON response
     */
    public function updateNote(string $subdomain, UpdateNoteRequest $request)
    {
        try {
            $response = $this->apiService->post('/wishes/note/update', $request->all());

            return response()->json($response->formatResponse('object'));
        } catch (Exception $e) {
            return json_response_error($e);
        }
    }


    public function wishToken(string $subdomain, int $id, string $token)
    {
        try {
            ApiAuth::byWishToken($id, $token);

            return  redirect('wishes/' . $id);
        } catch (Exception $e) {
            return json_response_error($e);
        }
    }

    public function wishListToken(string $subdomain, string $token)
    {
        try {
            ApiAuth::byWishListToken($token);

            return  redirect('wishlist');
        } catch (Exception $e) {
            return json_response_error($e);
        }
    }
}
