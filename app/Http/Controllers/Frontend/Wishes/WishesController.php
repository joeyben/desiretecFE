<?php

namespace App\Http\Controllers\Frontend\Wishes;

use App\Http\Controllers\Controller;
use App\Services\Api\ApiService;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

//use App\Http\Requests\Frontend\Wishes\ChangeWishesStatusRequest;
//use App\Http\Requests\Frontend\Wishes\ManageWishesRequest;
//use App\Http\Requests\Frontend\Wishes\StoreWishesRequest;
//use App\Http\Requests\Frontend\Wishes\UpdateWishesRequest;
//use App\Http\Requests\Frontend\Wishes\UpdateNoteRequest;
//use App\Models\Access\User\User;
//use App\Models\Access\User\UserToken;
//use App\Models\Agents\Agent;
//use App\Models\Wishes\Wish;
//use App\Repositories\Frontend\Wishes\WishesRepository;
//use Illuminate\Auth\AuthManager;
//use Illuminate\Session\Store;
//use Illuminate\Support\Facades\Auth;
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
    /**
     * Wish Status.
     */
    protected $status = [
        'new'               => 'new',
        'offer_created'     => 'offer_created',
        'completed'         => 'completed',
    ];

    /**
     * Wish Category.
     */
    protected $category = [
        '1'  => 1,
        '2'  => 2,
        '3'  => 3,
        '4'  => 4,
        '5'  => 5,
    ];

    /**
     * Wish Catering.
     */
    protected $catering = [
        'any'           => 'any',
        'Breakfast'     => 'Breakfast',
        'Pension'       => 'Pension',
        'Full Pension'  => 'Full Pension',
        'All Inclusive' => 'All Inclusive',
    ];

    /**
     * @var WishesRepository
     */
    protected $wish;
    protected $categories;

    /**
     * @var \Illuminate\Auth\AuthManager
     */
    private $auth;

    /**
     * @var \Modules\Rules\Repositories\Eloquent\EloquentRulesRepository
     */
    private $rules;
    /**
     * @var \Illuminate\Session\Store
     */
    private $session;

    /**
     * @var UserRepository
     */
    protected $users;

    protected $apiService;


    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
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

    /**
     * @param \App\Http\Requests\Frontend\Wishes\ManageWishesRequest $request
     * @param \App\Models\Wishes\Wish                                $wish
     *
     * @return mixed
     */
    public function show(Wish $wish, ManageWishesRequest $request)
    {
        $agent = null;
        $wishTye = $this->manageRules($wish);

        if ($wishTye > 0) {
            return redirect()->route('autooffer.create', [$wish->id]);
        }

        $offers = $wish->offers;
        $avatar = [];
        $agentName = [];

        foreach ($offers as $offer) {
            array_push($avatar, Agent::where('id', $offer->agent_id)->value('avatar'));
            array_push($agentName, Agent::where('id', $offer->agent_id)->value('name'));
        }

        if ($this->session->has('agent_id')) {
            $agent = Agent::find((int) $this->session->get('agent_id'));
        }

        return view('frontend.wishes.wish')->with([
            'wish'               => $wish,
            'avatar'             => $avatar,
            'agent'              => $agent,
            'agent_name'         => $agentName,
            'body_class'         => $this::BODY_CLASS,
            'offer_url'          => $this::OFFER_URL,
            'categories'         => $this->categories,
            'extra'              => json_decode($wish->extra_params, true),
        ]);
    }

    public function getWish(Request $request)
    {
        $client = new Client();
        $response = $client->get('https://mvp.desiretec.com/api/v1/wish/'.$request->route('wish'),
            [
                'headers' => [
                    'Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwczovL212cC5kZXNpcmV0ZWMuY29tL2FwaS92MS9hdXRoL2xvZ2luIiwiaWF0IjoxNTc5MjQ4NjI3LCJleHAiOjE1ODE5MjcwMjcsIm5iZiI6MTU3OTI0ODYyNywianRpIjoiR2lLa2VRTUJwS3dDcUUwNSIsInN1YiI6MjQ3NywicHJ2IjoiOTRkYmQ5NjFhYWVmMGUzY2U2NmFkN2Q1MGU2NDc3MTc2MDlkZGEyNCIsImlkIjoyNDc3fQ.Yv3OHye9B6gW1TgOjJspjB_jsNp4kFif2Z6_HfRI9Ps'
                ]
            ]
        );
        $response_json = json_decode($response->getBody());
        $wish = $response_json->data;

        return view('frontend.wishes.wish')->with([
            'status'     => $this->status,
            'body_class' => $this::BODY_CLASS,
            'wish'     => $wish
        ]);
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
    public function getList()
    {


        $response = [
            "pagination" => [
                "total" => 7,
                "per_page" => 10,
                "current_page" => 1,
                "last_page" => 1,
                "from" => 1,
                "to" => 7,
            ],
            "data" => [
                "current_page" => 1,
                "data" => [
                    0 => [
                        "id" => 1140,
                        "title" => "-",
                        "airport" => "sad",
                        "destination" => "asd",
                        "duration" => "beliebig",
                        "adults" => 1,
                        "kids" => 4,
                        "budget" => 4000,
                        "earliest_start" => "2019-12-21",
                        "latest_return" => "2019-12-28",
                        "status" => "new",
                        "featured_image" => "bg.jpg",
                        "created_by" => 2271,
                        "created_at" => "2019-12-18 12:47:38",
                        "group_id" => 1,
                        "note" => null,
                        "first_name" => "Reisewunschportal",
                        "last_name" => "Kunde",
                        "whitelabel_id" => 156,
                        "whitelabel_name" => "TUI",
                        "offers" => 0,
                        "categories" => null,
                        "manuelFlag" => true,
                        "wlRule" => null,
                    ],
                    1 => [
                        "id" => 1139,
                        "title" => "-",
                        "airport" => "ds",
                        "destination" => "as",
                        "duration" => "beliebig",
                        "adults" => 1,
                        "kids" => 4,
                        "budget" => 4000,
                        "earliest_start" => "2019-12-21",
                        "latest_return" => "2019-12-28",
                        "status" => "new",
                        "featured_image" => "bg.jpg",
                        "created_by" => 2270,
                        "created_at" => "2019-12-18 12:41:45",
                        "group_id" => 1,
                        "note" => null,
                        "first_name" => "Reisewunschportal",
                        "last_name" => "Kunde",
                        "whitelabel_id" => 156,
                        "whitelabel_name" => "TUI",
                        "offers" => 0,
                        "categories" => null,
                        "manuelFlag" => true,
                        "wlRule" => null,
                    ],
                    2 => [
                        "id" => 1138,
                        "title" => "-",
                        "airport" => "dsa",
                        "destination" => "sa",
                        "duration" => "beliebig",
                        "adults" => 1,
                        "kids" => 4,
                        "budget" => null,
                        "earliest_start" => "2019-12-21",
                        "latest_return" => "2019-12-28",
                        "status" => "new",
                        "featured_image" => "bg.jpg",
                        "created_by" => 2269,
                        "created_at" => "2019-12-18 12:39:58",
                        "group_id" => 1,
                        "note" => null,
                        "first_name" => "Reisewunschportal",
                        "last_name" => "Kunde",
                        "whitelabel_id" => 156,
                        "whitelabel_name" => "TUI",
                        "offers" => 0,
                        "categories" => null,
                        "manuelFlag" => false,
                        "wlRule" => null,
                    ],
                    3 => [
                        "id" => 1137,
                        "title" => "-",
                        "airport" => "sad",
                        "destination" => "asd",
                        "duration" => "beliebig",
                        "adults" => 1,
                        "kids" => 4,
                        "budget" => 4000,
                        "earliest_start" => "2019-12-21",
                        "latest_return" => "2019-12-28",
                        "status" => "new",
                        "featured_image" => "bg.jpg",
                        "created_by" => 2268,
                        "created_at" => "2019-12-18 12:35:59",
                        "group_id" => 1,
                        "note" => null,
                        "first_name" => "Reisewunschportal",
                        "last_name" => "Kunde",
                        "whitelabel_id" => 156,
                        "whitelabel_name" => "TUI",
                        "offers" => 0,
                        "categories" => null,
                        "manuelFlag" => true,
                        "wlRule" => null,
                    ],
                    4 => [
                        "id" => 1136,
                        "title" => "-",
                        "airport" => "asd",
                        "destination" => "sad",
                        "duration" => "beliebig",
                        "adults" => 1,
                        "kids" => 3,
                        "budget" => 4000,
                        "earliest_start" => "2019-12-21",
                        "latest_return" => "2019-12-28",
                        "status" => "new",
                        "featured_image" => "bg.jpg",
                        "created_by" => 2267,
                        "created_at" => "2019-12-18 11:01:04",
                        "group_id" => 1,
                        "note" => null,
                        "first_name" => "Reisewunschportal",
                        "last_name" => "Kunde",
                        "whitelabel_id" => 156,
                        "whitelabel_name" => "TUI",
                        "offers" => 0,
                        "categories" => null,
                        "manuelFlag" => true,
                        "wlRule" => null,
                    ],
                    5 => [
                        "id" => 1135,
                        "title" => "-",
                        "airport" => "berlin",
                        "destination" => "hamburg",
                        "duration" => "beliebig",
                        "adults" => 1,
                        "kids" => 4,
                        "budget" => 4000,
                        "earliest_start" => "2019-12-20",
                        "latest_return" => "2019-12-27",
                        "status" => "new",
                        "featured_image" => "bg.jpg",
                        "created_by" => 2262,
                        "created_at" => "2019-12-17 15:02:20",
                        "group_id" => 1,
                        "note" => null,
                        "first_name" => "Reisewunschportal",
                        "last_name" => "Kunde",
                        "whitelabel_id" => 156,
                        "whitelabel_name" => "TUI",
                        "offers" => 0,
                        "categories" => null,
                        "manuelFlag" => true,
                        "wlRule" => null,
                    ],
                    6 => [
                        "id" => 153,
                        "title" => "Mali",
                        "airport" => "Berlin",
                        "destination" => "Mali",
                        "duration" => "14 Nächte",
                        "adults" => 5,
                        "kids" => 3,
                        "budget" => 8100,
                        "earliest_start" => "2019-03-29",
                        "latest_return" => "2019-04-06",
                        "status" => "new",
                        "featured_image" => "1522558148csm_ER_Namibia_b97bcd06f0.jpg",
                        "created_by" => 130,
                        "created_at" => "2019-03-26 12:52:47",
                        "group_id" => 1,
                        "note" => null,
                        "first_name" => "Muster",
                        "last_name" => "Name",
                        "whitelabel_id" => 156,
                        "whitelabel_name" => "TUI",
                        "offers" => 0,
                        "categories" => null,
                        "messageSentFlag" => true,
                        "manuelFlag" => true,
                        "wlRule" => null,
                    ],
                ],
                "first_page_url" => "http://tui.com:8000/wishes/getlist?page=1",
                "from" => 1,
                "last_page" => 1,
                "last_page_url" => "http://tui.com:8000/wishes/getlist?page=1",
                "next_page_url" => null,
                "path" => "http://tui.com:8000/wishes/getlist",
                "per_page" => 10,
                "prev_page_url" => null,
                "to" => 7,
                "total" => 7,
            ],
        ];

        try {
            $response = $this->apiService->get('/agents', []);

            $agents = $response->formatResponse('object')->data;

            return view('frontend.agents.index')->with([
                'body_class'    => $this::BODY_CLASS,
                'avatar_path'   => $this->storage->url('img/agent/'),
                'agents'        => $agents,
            ]);
            return response()->json($response);
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
    public function changeWishStatus(ChangeWishesStatusRequest $request)
    {
        try {
            $status_arr = [
                'new'               => '1',
                'offer_created'     => '2',
                'completed'         => '3',
            ];

            $status = $request->get('status') ? $status_arr[$request->get('status')] : '1';

            $wish = $this->wish->updateStatus($request->get('id'), $status);

            return json_response([]);
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
            $note = $this->wish->updateNote($request->get('id'), $request->get('note') ?? '');

            return json_response([]);
        } catch (Exception $e) {
            return json_response_error($e);
        }
    }
}
