<?php

namespace App\Http\Controllers\Frontend\Offers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Offers\ManageOffersRequest;
use App\Http\Requests\Frontend\Offers\StoreOffersRequest;
use App\Http\Requests\Frontend\Offers\UpdateOffersRequest;
use App\Models\Offers\Offer;
use App\Models\Wishes\Wish;
use App\Repositories\Frontend\Offers\OffersRepository;
use App\Services\Api\ApiService;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class OffersController.
 */
class OffersController extends Controller
{
    const BODY_CLASS = 'offer';
    /**
     * Offer Status.
     */
    protected $status = [
        'Active'       => 'Active',
        'Inactive'     => 'Inactive',
        'Deleted'      => 'Deleted',
    ];

    /**
     * @var OffersRepository
     */
    protected $offer;

    /**
     * @var ApiService
     */
    protected $apiService;

    /**
     * @param \App\Repositories\Frontend\Offers\OffersRepository $offer
     */
    public function __construct(ApiService $apiService, Offer $offer)
    {
        $this->apiService = $apiService;
        $this->offer = $offer;
    }

    /**
     * @param \App\Http\Requests\Frontend\Offers\ManageOffersRequest $request
     *
     * @return mixed
     */
    public function index(string $subdomain)
    {
        try {
            $response = $this->apiService->get('/offers');

            $offers = collect($response->formatResponse('array')['data']);

            $page = request()->has('page') ? request('page') : 1;
            $perPage = request()->has('per_page') ? request('per_page') : 10;
            $offset = ($page * $perPage) - $perPage;
            $results =  new LengthAwarePaginator(
                $offers->slice($offset, $perPage),
                $offers->count(),
                $perPage,
                $page,
                ['path' => request()->url(), 'query' => request()->query()]
            );

            return view('frontend.offers.index')->with([
                'body_class'    => $this::BODY_CLASS,
                'offers'        => $results,
            ]);
        } catch (Exception $e) {
            return json_response_error($e);
        }
    }

    /**
     * @param \App\Http\Requests\Frontend\Offers\ManageOffersRequest $request
     * @param type                                                   $id
     *
     * @return mixed
     */
    public function create(string $subdomain, int $id)
    {
        return view('frontend.offers.create')->with([
            'status'         => $this->status,
            'wish_id'        => $id,
            'body_class'     => $this::BODY_CLASS,
        ]);
    }

    /**
     * @param \App\Http\Requests\Frontend\Offers\StoreOffersRequest $request
     *
     * @return mixed
     */
    public function store(string $subdomain, Request $request)
    {
        try {
            $data = $request->all();

            if($request->hasfile('file')){
                foreach ($data['file'] as &$file){
                    $temp_variable = base64_encode(file_get_contents($file->getRealPath()));
                    $fileData['content'] = json_encode($temp_variable);
                    $fileData['name'] = $file->getClientOriginalName();
                    $file = $fileData;
                }
            }

            $response = $this->apiService->post('/offers/store', $data);

            return redirect()
                ->route('frontend.offers.index', $subdomain)
                ->with('flash_success', trans('alerts.frontend.offers.created'));
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['message' => $e->getMessage()]);
        }
    }

    /**
     * @param \App\Models\Offers\Offer                               $offer
     * @param \App\Http\Requests\Frontend\Offers\ManageOffersRequest $request
     *
     * @return mixed
     */
    public function edit(string $subdomain, Offer $offer, ManageOffersRequest $request)
    {
        return view('frontend.offers.edit')->with([
            'offer'               => $offer,
            'status'              => $this->status,
            'body_class'          => $this::BODY_CLASS,
        ]);
    }

    /**
     * @param \App\Models\Offers\Offer                               $offer
     * @param \App\Http\Requests\Frontend\Offers\UpdateOffersRequest $request
     *
     * @return mixed
     */
    public function update(string $subdomain, Offer $offer, UpdateOffersRequest $request)
    {
        $input = $request->all();

        $this->offer->update($offer, $request->except(['_token', '_method']));

        return redirect()
            ->route('admin.offers.index')
            ->with('flash_success', trans('alerts.frontend.offers.updated'));
    }

    /**
     * @param \App\Models\Offers\Offer                               $offer
     * @param \App\Http\Requests\Frontend\Offers\ManageOffersRequest $request
     *
     * @return mixed
     */
    public function destroy(string $subdomain, Offer $offer, ManageOffersRequest $request)
    {
        $this->offer->delete($offer);

        return redirect()
            ->route('admin.offers.index')
            ->with('flash_success', trans('alerts.frontend.offers.deleted'));
    }

    /**
     * @param \App\Models\Wishes\Wish                                $wish
     * @param \App\Http\Requests\Frontend\Offers\ManageOffersRequest $request
     *
     * @return mixed
     */
    public function getWishOffers(string $subdomain, Wish $wish, ManageOffersRequest $request)
    {
        return view('frontend.offers.wishoffers')->with([
            'status'     => $this->status,
            'wish'       => $wish,
            'body_class' => $this::BODY_CLASS,
        ]);
    }
}
