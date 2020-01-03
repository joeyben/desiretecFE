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
    public function __construct()
    {
    }

    /**
     * @param \App\Http\Requests\Frontend\Offers\ManageOffersRequest $request
     *
     * @return mixed
     */
    public function __invoke()
    {
//        dd('asd');
//        return Datatables::of($this->offers->getForDataTable())
//            ->addColumn('title', function ($offers) {
//                return '<a href="' . route('frontend.wishes.show', [$offers->wish_id])
//                    . '">' . $offers->title . '</a>';
//            })
//            ->addColumn('created_by', function ($offers) {
//                return $offers->first_name . ' ' . $offers->last_name;
//            })
//            ->addColumn('created_at', function ($offers) {
//                return $offers->created_at->format('d.m.Y') . ' ' . $offers->created_at->toTimeString();
//            })
//            ->addColumn('status', function ($offers) {
//                return $offers->status;
//            })
//            ->addColumn('actions', function ($offers) {
//                return $offers->action_buttons;
//            })
//            ->rawColumns(['title'])
//            ->make(true);
        return [
        "draw" => 1,
  "recordsTotal" => 3,
  "recordsFiltered" => 3,
  "data" => [
        0 => [
        "id" => "63",
      "title" => "<a href='http://tui.com:8000/wish/1139'>iug</a>",
      "status" => "Active",
      "created_by" => "Tui Seller",
      "created_at" => "31.12.2019 10:05:41",
      "first_name" => "Tui",
      "last_name" => "Seller",
      "wish_id" => "1139",
      "wish_title" => "-",
      "actions" => "",
    ],
    1 => [
        "id" => "62",
      "title" => "<a href='http://tui.com:8000/wish/1140'>kuhj</a>",
      "status" => "Active",
      "created_by" => "Tui Seller",
      "created_at" => "31.12.2019 10:05:11",
      "first_name" => "Tui",
      "last_name" => "Seller",
      "wish_id" => "1140",
      "wish_title" => "-",
      "actions" => "",
    ],
    2 => [
        "id" => "61",
      "title" => "<a href='http://tui.com:8000/wish/1140'>tyfyfh</a>",
      "status" => "Active",
      "created_by" => "Tui Seller",
      "created_at" => "31.12.2019 10:04:39",
      "first_name" => "Tui",
      "last_name" => "Seller",
      "wish_id" => "1140",
      "wish_title" => "-",
      "actions" => "",
    ],
  ],
  "queries" => [
        0 => [
        "query" => "select count(*) as aggregate from (select `offers`.`id`, `offers`.`title`, `offers`.`status`, `offers`.`created_by`, `offers`,.`created_at`, `users`.`first_name` as `first_name`, `users`.`last_name` as `last_name`, `wishes`.`id` as `wish_id`, `wishes`.`title` as `wish_title` from `offers` left join `users` on `users`.`id` = `offers`.`created_by` left join `wishes` on `wishes`.`id` = `offers`.`wish_id` where `offers`.`created_by` = ? and `offers`.`deleted_at` is null order by `offers`.`id` desc) count_row_table",
      "bindings" => [
        0 => 6
    ],
      "time" => 0.79,
    ],
    1 => [
        "query" => "select `offers`.`id`, `offers`.`title`, `offers`.`status`, `offers`.`created_by`, `offers`.`created_at`, `users`.`first_name`, as `first_name`, `users`.`last_name` as `last_name`, `wishes`.`id` as `wish_id`, `wishes`.`title` as `wish_title` from `offers` left join `users` on `users`.`id` = `offers`.`created_by` left join `wishes` on `wishes`.`id` = `offers`.`wish_id` where `offers`.`created_by` = ? and `offers`.`deleted_at` is null order by `offers`.`id` desc, `offers`.`status` asc limit 10 offset 0",
      "bindings" => [
        0 => 6,
    ],
      "time" => 0.7,
    ],
    2 => [
        "query" => "select `id` from `whitelabels` where (`domain` = ? or `domain` = ?) and `whitelabels`.`deleted_at` is null limit 1",
      "bindings" => [
        0 => "https://tui.com",
        1 => "http://tui.com",
      ],
      "time" => 0.67,
    ],
    3 => [
        "query" => "select `name` from `whitelabels` where (`domain` = ? or `domain` = ?) and `whitelabels`.`deleted_at` is null limit 1",
      "bindings" => [
        0 => "https://tui.com",
        1 => "http://tui.com",
      ],
      "time" => 0.64,
    ],
    4 => [
        "query" => "select `id` from `whitelabels` where (`domain` = ? or `domain` = ?) and `whitelabels`.`deleted_at` is null limit 1",
      "bindings" => [
        0 => "https://tui.com",
        1 => "http://tui.com",
      ],
      "time" => 0.58,
    ],
    5 => [
        "query" => "select `name` from `whitelabels` where (`domain` = ? or `domain` = ?) and `whitelabels`.`deleted_at` is null limit 1",
      "bindings" => [
        0 => "https://tui.com",
        1 => "http://tui.com",
      ],
      "time" => 0.7,
    ],
  ],
  "input" => [
        "draw" => "1",
    "columns" => [
        0 => [
        "data" => "title",
        "name" => "offers.title",
        "searchable" => "true",
        "orderable" => "true",
        "search" => [
        "value" => null,
          "regex" => "false",
        ],
      ],
      1 => [
        "data" => "created_by",
        "name" => "offers.created_by",
        "searchable" => "true",
        "orderable" => "true",
        "search" => [
        "value" => null,
          "regex" => "false",
        ],
      ],
      2 => [
        "data" => "created_at",
        "name" => "offers.created_at",
        "searchable" => "true",
        "orderable" => "true",
        "search" => [
        "value" => null,
          "regex" => "false",
        ],
      ],
      3 => [
        "data" => "status",
        "name" => "offers.status",
        "searchable" => "true",
        "orderable" => "true",
        "search" => [
        "value" => null,
          "regex" => "false",
        ],
      ],
    ],
    "order" => [
        0 => [
        "column" => "3",
        "dir" => "asc",
      ],
    ],
    "start" => "0",
    "length" => "10",
    "search" => [
        "value" => null,
      "regex" => "false",
    ],
  ],
];
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
