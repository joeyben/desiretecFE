@extends('frontend.layouts.app')

@section('title')
    {{ ucfirst(getWhitelabelInfo()['name']) }} {{ trans('wish.list.tab_title') }}
@endsection

@section('before-scripts')
    <script type="application/javascript">
        var brandColor = {!! json_encode(getWhitelabelInfo()['color']) !!};
    </script>
@endsection

@section('content')
    <div class="list-container row">
        <div class="col col-lg-12">
            <div class="filter">
                <div class="count">
                    <span v-if="total === 1" v-cloak>@{{ total }} {{ trans_choice('labels.frontend.wishes.wishes', 1 ) }}</span>
                    <span v-else v-cloak>@{{ total }} {{ trans_choice('labels.frontend.wishes.wishes', 999 ) }}</span>
                </div>
                @if($logged_in_user['role'] === "Seller")
                    <div class="filter-action">
                        <select class="selectpicker" id="filter-status" v-model="status" @change="fetchWishes()">
                            @foreach ($status as $st)
                                <option value="{{ $st }}">
                                    {{ trans('menus.list.status.'.strtolower($st)) }}
                                </option>
                            @endforeach
                        </select>
                        <input type="search" class="id-filter" placeholder="{{ trans('strings.wishlist.search') }}" v-model="filter" @input="fetchWishes()">
                    </div>
                @endif
            </div>
            <div class="skeleton" v-if="loading"></div>
            <div class="list wishlist" v-cloak>
                <div class="list-element" v-for="wish in data">
                    <div class="image">
                        <a href="#" class="img" :style="{ 'background-image' : 'url(https://www.matthewwilliams-ellis.com/wp-content/uploads/2014/02/Italy-panoramic-landscape-photography-showing-Isola-Bella-Beach-in-Taormina-Sicily-Italy-panoramic-landscape-photography-by-landscape-photographer-Matthew-Williams-Ellis.jpg)' }">
                            <span class="caption"></span>
                        </a>
                    </div>
                    <div class="main-info">
                        <ul class="info">
                            <li><i class="icon_pin"></i><span class="value">@{{ wish.destination }}</span></li>
                            @if(getWhitelabelInfo()['id'] != env('DK_FERIEN_ID', 77))
                                <li><i class="fa fa-plane"></i><span class="value">@{{ wish.airport }}</span></li>
                            @endif
                            <li><i class="icon_calendar"></i><span class="value">@{{ wish.earliest_start | moment("DD.MM.YYYY") }}</span> bis <span class="value">@{{ wish.latest_return | moment("DD.MM.YYYY") }}</span></li>
                            <li><i class="icon_hourglass"></i><span class="value">@{{ wish.duration }}</span></li>
                            <li><i class="icon_group"></i><span class="value">@{{ wish.adults }}</span></li>
                            @if(getWhitelabelInfo()['id'] == env('DK_FERIEN_ID', 77))
                                <li><i class="fal fa-dog-leashed"></i><span class="value">@{{ wish.pets }}</span></li>
                            @endif
                            <li v-if="wish.senderEmail"><i class="fal fa-at"></i><span class="value">@{{ wish.senderEmail }}</span></li>
                            <li>{{ trans('labels.frontend.wishes.created_at') }} <span class="value">@{{ wish['created_at'] | moment("DD.MM.YYYY") }}</span></li>
                        </ul>
                    </div>
                    <div class="action">
                        <div class="wish-top-infos">
                            <span class="wish-id">@{{ wish.id }}</span>
                            @if($logged_in_user['role'] === "Seller")
                                <span v-if="wish.wlRule == 'mix'" class="wish-classification btn-secondary">
                                    <span v-if="wish.manuelFlag"><i class="fal fa-user"></i></span>
                                    <span v-else><i class="fal fa-robot"></i></span>
                                </span>
                                <span v-if="wish.messageSentFlag" class="message-sent btn-secondary">
                                    <i class="fal fa-envelope"></i>
                                </span>
                                <span id="{{ trans('strings.wishlist.offer_ex') }}" v-if="wish.offers > 0" class="offer-count btn-secondary">
                                    @{{ wish.offers }}
                                </span>
                            @endif
                        </div>
                        <div class="budget">@{{ formatPrice(wish.budget) }}{{ trans('general.currency') }}</div>
                        <a v-if="wish.manuelFlag" class="primary-btn" :href="'/wishes/'+wish.id">{{ trans('labels.frontend.wishes.goto') }}</a>
                        <a v-if="!wish.manuelFlag" class="primary-btn" :href="'/offer/list/'+wish.id">{{ trans('labels.frontend.wishes.goto') }}</a>
                        @if($logged_in_user['role'] === "Seller")
                            <div class="status-change-action">
                                <select class="selectpicker" id="change-status" v-bind:value="wish.status" v-model="status" @change="changeStatus(wish.id)">
                                    @foreach ($status as $st)
                                        <option value="{{ $st }}">
                                            {{ trans('menus.list.status.'.strtolower($st)) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <pagination v-if="pagination.last_page > 1" :pagination="pagination" :offset="10" @paginate="fetchWishes()"></pagination>
        </div>
    </div>
@endsection

@section('footer')
    @include('frontend.whitelabel.footer')
@endsection

@section('after-scripts')
    <script>
        $(document).ready(function() {
            $('.selectpicker').selectpicker();
        });
    </script>
@endsection
