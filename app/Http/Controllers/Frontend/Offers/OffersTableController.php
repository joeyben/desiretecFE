<?php

namespace App\Http\Controllers\Frontend\Offers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Offers\ManageOffersRequest;
use App\Repositories\Frontend\Offers\OffersRepository;
use Yajra\DataTables\Facades\DataTables;

/**
 * Class OffersTableController.
 */
class OffersTableController extends Controller
{
    protected $offers;

    /**
     * @param \App\Repositories\Frontend\Offers\OffersRepository $cmspages
     */
    public function __construct(OffersRepository $offers)
    {
        $this->offers = $offers;
    }

    /**
     * @param \App\Http\Requests\Frontend\Offers\ManageOffersRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManageOffersRequest $request)
    {
        return Datatables::of($this->offers->getForDataTable())
            ->addColumn('title', function ($offers) {
                return '<a href="' . route('frontend.wishes.show', [$offers->wish_id])
                    . '">' . $offers->title . '</a>';
            })
            ->addColumn('created_by', function ($offers) {
                return $offers->first_name . ' ' . $offers->last_name;
            })
            ->addColumn('created_at', function ($offers) {
                return $offers->created_at->format('d.m.Y') . ' ' . $offers->created_at->toTimeString();
            })
            ->addColumn('status', function ($offers) {
                return $offers->status;
            })
            ->addColumn('actions', function ($offers) {
                return $offers->action_buttons;
            })
            ->rawColumns(['title'])
            ->make(true);
    }

    /**
     * @param \App\Http\Requests\Frontend\Offers\ManageOffersRequest $request
     *
     * @return mixed
     */
    public function showOffersForWish(ManageOffersRequest $request)
    {
        return Datatables::of($this->offers->getForDataTableForWish($request->get('id')))
            ->escapeColumns(['title'])

            ->addColumn('created_by', function ($offers) {
                return $offers->first_name . ' ' . $offers->last_name;
            })
            ->addColumn('created_at', function ($offers) {
                return $offers->created_at->toFormattedDateString() . ' ' . $offers->created_at->toTimeString();
            })
            ->addColumn('status', function ($offers) {
                return $offers->status;
            })
            ->addColumn('actions', function ($offers) {
                return $offers->action_buttons;
            })
            ->make(true);
    }
}
