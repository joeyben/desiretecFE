<?php

namespace App\Http\Controllers\Frontend\Wishes;

use Illuminate\Http\Request;
//use App\Http\Requests\Frontend\Wishes\ChangeWishesStatusRequest;
use App\Http\Requests\Wishes\ManageWishesRequest;
//use App\Http\Requests\Frontend\Wishes\StoreWishesRequest;
//use App\Http\Requests\Frontend\Wishes\UpdateWishesRequest;
use App\Http\Requests\Wishes\UpdateNoteRequest;
//use App\Models\Access\User\User;
//use App\Models\Access\User\UserToken;
//use App\Models\Agents\Agent;
use App\Models\Wishes\Wish;
use App\Http\Controllers\Controller;
use App\Services\Api\ApiService;
use Illuminate\Support\Facades\Log;
//use App\Repositories\Frontend\Wishes\WishesRepository;
//use Illuminate\Auth\AuthManager;
//use Illuminate\Session\Store;
use Illuminate\Support\Facades\Auth;
//use Modules\Categories\Repositories\Contracts\CategoriesRepository;
//use Modules\Rules\Repositories\Eloquent\EloquentRulesRepository;
//use App\Repositories\Backend\Access\User\UserRepository;

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

    /**
     * @param \App\Http\Requests\Frontend\Wishes\ManageWishesRequest $request
     *
     * @return mixed
     */
    public function index(ManageWishesRequest $request)
    {
        return view('frontend.wishes.index')->with([
            'status'     => $this->status,
            'category'   => $this->category,
            'catering'   => $this->catering,
            'count'      => $this->wish->getForDataTable()->get()->where('whitelabel_id', getCurrentWhiteLabelId())->count(),
            'wishes'     => $this->wish->getForDataTable()->get()->toArray(),
            'body_class' => $this::BODY_CLASS,
        ]);
    }


    public function show($subdomain, $id, ManageWishesRequest $request)
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

    public function newWish(ManageWishesRequest $request)
    {
        return view('frontend.wishes.newwishes.wish')->with([
            'body_class' => $this::BODY_CLASS,
        ]);
    }

    public function newUserWish(ManageWishesRequest $request)
    {
        return view('frontend.wishes.newwishes.wish-user')->with([
            'body_class' => $this::BODY_CLASS,
        ]);
    }

    public function offerLink(ManageWishesRequest $request)
    {
        return view('frontend.wishes.newwishes.offertextlink')->with([
            'body_class' => $this::BODY_CLASS,
        ]);
    }

    public function offerText(ManageWishesRequest $request)
    {
        return view('frontend.wishes.newwishes.offerviatext')->with([
            'body_class' => $this::BODY_CLASS,
        ]);
    }

    public function attach(ManageWishesRequest $request)
    {
        return view('frontend.wishes.newwishes.attach')->with([
            'body_class' => $this::BODY_CLASS,
        ]);
    }

    /**
     * @param \App\Http\Requests\Frontend\Wishes\ManageWishesRequest $request
     *
     * @return mixed
     */
    public function wishList()
    {
        return view('frontend.wishes.index')->with([
            'status'     => $this->status,
            'category'   => $this->category,
            'catering'   => $this->catering,
            'count'      => 59,
            'body_class' => $this::BODY_CLASS_LIST,
        ]);
    }

    /**
     * @param \App\Http\Requests\Frontend\Wishes\ManageWishesRequest $request
     *
     * @return mixed
     */
    public function getList(Request $request)
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
    public function create(ManageWishesRequest $request)
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
    public function store(StoreWishesRequest $request)
    {
        $this->wish->create($request->except('_token'));

        return redirect()
            ->route('frontend.wishes.index')
            ->with('flash_success', trans('alerts.frontend.wishes.created'));
    }

    /**
     * @param \App\Models\Wishes\Wish                                $wish
     * @param \App\Http\Requests\Frontend\Wishes\ManageWishesRequest $request
     *
     * @return mixed
     */
    public function edit(Wish $wish, ManageWishesRequest $request)
    {
        return view('frontend.wishes.edit')->with([
            'wish'               => $wish,
            'status'             => $this->status,
            'category'           => $this->category,
            'catering'           => $this->catering,
            'body_class'         => $this::BODY_CLASS,
        ]);
    }

    /**
     * @param \App\Models\Wishes\Wish                                $wish
     * @param \App\Http\Requests\Frontend\Wishes\UpdateWishesRequest $request
     *
     * @return mixed
     */
    public function update(Wish $wish, UpdateWishesRequest $request)
    {
        $input = $request->all();

        $this->wish->update($wish, $request->except(['_token', '_method']));

        return redirect()
            ->route('frontend.wishes.index')
            ->with('flash_success', trans('alerts.frontend.wishes.updated'));
    }

    /**
     * @param \App\Models\Wishes\Wish                                $wish
     * @param \App\Http\Requests\Frontend\Wishes\ManageWishesRequest $request
     *
     * @return mixed
     */
    public function destroy(Wish $wish, ManageWishesRequest $request)
    {
        $this->wish->delete($wish);

        return redirect()
            ->route('admin.wishes.index')
            ->with('flash_success', trans('alerts.frontend.wishes.deleted'));
    }

    public function validateTokenWish(Wish $wish, $token)
    {
        $usertoken = UserToken::where('token', $token)->firstOrFail();

        $user_id = $usertoken->user_id;

        $user = User::where('id', $user_id)->firstOrFail();

        if ($user) {
            Auth::login($user);

            return redirect()->to('/wish/' . $wish->id);
        }

        return redirect()->to('/');
    }

    // To do: Define Auto and Manuel offer in const

    /**
     * @param \App\Models\Wishes\Wish $wish
     *
     * @return string
     */
    public function manageRules($wish)
    {
        $rules = $this->rules->getRuleForWhitelabel((int) (getCurrentWhiteLabelId()));
        $offer = 0;
        switch ($rules['type']) {
            case 'mix':
                $destinations = \is_array($rules['destination']) ? $rules['destination'] : [];
                $budget_lower = $wish->budget < $rules['budget'];
                $description_notset = !$wish->description || '' === $wish->description;
                $destination_exists = empty($destinations) || \in_array($wish->destination, $destinations, true);

                if ($budget_lower && $description_notset && $destination_exists) {
                    $offer = 1;
                } else {
                    $offer = 0;
                }
                break;
            case 'auto':
                $offer = 1;
                break;
            case 'manuel':
                $offer = 0;
                break;
            default:
                $offer = 0;
        }

        return $offer;
    }

    /**
     * @param \App\Http\Requests\Frontend\Wishes\ChangeWishesStatusRequest $request
     *
     * @return JSON response
     */
    public function changeWishStatus(Request $request)
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
    public function updateNote(UpdateNoteRequest $request)
    {
        try {
            $response = $this->apiService->post('/wishes/note/update', $request->all());

            return response()->json($response->formatResponse('object'));
        } catch (Exception $e) {
            return json_response_error($e);
        }
    }
}
