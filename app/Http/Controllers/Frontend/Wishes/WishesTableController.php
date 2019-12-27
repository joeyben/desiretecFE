<?php

namespace App\Http\Controllers\Frontend\Wishes;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Wishes\ManageWishesRequest;
use App\Repositories\Frontend\Wishes\WishesRepository;
use Yajra\DataTables\Facades\DataTables;

/**
 * Class WishesTableController.
 */
class WishesTableController extends Controller
{
    protected $wishes;

    /**
     * @param \App\Repositories\Frontend\Wishes\WishesRepository $cmspages
     */
    public function __construct(WishesRepository $wishes)
    {
        $this->wishes = $wishes;
    }

    /**
     * @param \App\Http\Requests\Frontend\Wishes\ManageWishesRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManageWishesRequest $request)
    {
        return Datatables::of($this->wishes->getForDataTable())
            ->escapeColumns(['title'])
            ->addColumn('status', function ($wishes) {
                return $wishes->status;
            })
            ->addColumn('airport', function ($wishes) {
                return $wishes->airport;
            })
            ->addColumn('destination', function ($wishes) {
                return $wishes->destination;
            })
            ->addColumn('earliest_start', function ($wishes) {
                return $wishes->earliest_start;
            })
            ->addColumn('latest_return', function ($wishes) {
                return $wishes->latest_return;
            })
            ->addColumn('destination', function ($wishes) {
                return $wishes->destination;
            })
            ->addColumn('created_by', function ($wishes) {
                return $wishes->first_name . ' ' . $wishes->last_name;
            })
            ->addColumn('created_at', function ($wishes) {
                return $wishes->created_at->toDateString();
            })
            ->addColumn('add_offer', function ($wishes) {
                if (access()->user()->hasRole('Seller')) {
                    return '<a href="' . route('frontend.offers.create', $wishes->id) . '" class="btn btn-flat btn-primary">' . trans('buttons.wishes.frontend.create_offer') . '</a>';
                }

                return $wishes->action_buttons_user;
            })
            ->addColumn('offer_count', function ($wishes) {
                if ($wishes->total_offers > 0) {
                    return $wishes->action_wish_offers;
                }

                return $wishes->total_offers;
            })
            ->make(true);
    }
}
